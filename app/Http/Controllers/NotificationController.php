<?php

namespace App\Http\Controllers;

use App\Events\EnviarNotificacion;
use App\Notifications\Notificacionescelular;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Nexmo\Laravel\Facade\Nexmo;
use NotificationChannels\WebPush\PushSubscription;

use App\Events\NotificationRead;
use App\Events\NotificationReadAll;
use App\Notifications\Notificaciones;
use Pusher;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth')->except('last', 'dismiss');
    }

    /**
     * Get user's notifications.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Limit the number of returned notifications, or return all
        $query = $user->unreadNotifications();
        $limit = Input::get('limit') != "" ? Input::get('limit') : 5;
        if ($limit) {
            $query = $query->limit($limit);
        }

        $notifications = $query->get()->each(function ($n) {
            $n->created = $n->created_at->toIso8601String();
        });

        $total = $user->unreadNotifications->count();
        return compact('notifications', 'total');
    }

    /**
     * Create a new notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            Auth::user()->notify(new Notificaciones);
            event(new \App\Events\EnviarNotificacion(Auth::user()));
            return response()->json('Notification sent.', 201);
        } catch (Excepcion $e) {
            throw $e;
        }
    }

    /**
     * Mark user's notification as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->unreadNotifications()
            ->where('id', $id)
            ->first();

        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }

        $notification->markAsRead();

        event(new NotificationRead($request->user()->id, $id));
    }

    /**
     * Mark all user's notifications as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAllRead(Request $request)
    {
        Auth::user()
            ->unreadNotifications()
            ->get()->each(function ($n) {
                $n->markAsRead();
            });

        event(new NotificationReadAll($request->user()->id));
    }

    /**
     * Get user's last notification from database.
     *
     * This method will be accessed by the service worker
     * so the user is not authenticated and it requires an endpoint.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function last(Request $request)
    {
        if (empty($request->endpoint)) {
            return response()->json('Endpoint missing.', 403);
        }

        $subscription = PushSubscription::findByEndpoint($request->endpoint);
        if (is_null($subscription)) {
            return response()->json('Subscription not found.', 404);
        }

        $notification = Auth::user()->unreadNotifications()->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }

        return $this->payload($notification);
    }

    /**
     * Mark the notification as read and dismiss it from other devices.
     *
     * This method will be accessed by the service worker
     * so the user is not authenticated and it requires an endpoint.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function dismiss(Request $request, $id)
    {
        if (empty($request->endpoint)) {
            return response()->json('Endpoint missing.', 403);
        }

        $subscription = PushSubscription::findByEndpoint($request->endpoint);
        if (is_null($subscription)) {
            return response()->json('Subscription not found.', 404);
        }

        $notification = $subscription->user->notifications()->where('id', $id)->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }

        $notification->markAsRead();

        event(new NotificationRead($subscription->user->id, $id));
    }

    /**
     * Get the payload for the given notification.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification $notification
     * @return string
     */
    protected function payload($notification)
    {
        $payload = [
            'title' => isset($notification->intro[0]) ? $notification->intro[0] : null,
            'body' => $this->format($notification),
            'actionText' => $notification->action_text ?: null,
            'actionUrl' => $notification->action_url ?: null,
            'id' => isset($notification->id) ? $notification->id : null,
        ];

        return json_encode($payload);
    }

    /**
     * Format the given notification.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification $notification
     * @return string
     */
    protected function format($notification)
    {
        $message = trim(implode(PHP_EOL . PHP_EOL, $notification->intro));
        $message .= PHP_EOL . PHP_EOL . trim(implode(PHP_EOL . PHP_EOL, $notification->outro));

        return trim($message);
    }

//Enviar notificaciones.
    public function enviarnotificaciones()
    {
        $ofertaid = Input::get('oferta');
        $cargo = Input::get('cargo');
        $area = Input::get('area');
        $departamento = Input::get('departamento');
        $usuario = Auth::user()->id;
        $info = DB::select("call sp_infooferta($ofertaid,$usuario);");
        try {
            $datos = \App\User::where('users.type', 0)
                ->where("alertas_persona.area", $area)
                ->where("alertas_persona.departamento", $departamento)
                ->orWhere("alertas_persona.cargo", "like", "%$cargo%")
                ->join("alertas_persona", "alertas_persona.usuario", "=", "users.id")
                ->select('users.id', 'users.phone')
                ->get();
            if ($datos->count())
                foreach ($datos as $item) {
                    $noti = (['titulo' => $cargo . " - " . $info[0]->departamento . '/' . $info[0]->ciudad, 'mensaje' => $info[0]->descripcion, 'url' => \Illuminate\Support\Facades\Request::root() . "/oferta/" . $ofertaid]);
                    $item->notify(new Notificaciones($noti));
                    /*Notification::route('nexmo', $item->phone)
                        ->notify(new Notificacionescelular($item));*/
                }
            return response()->json(collect($datos) . '$$' . "oferta:" . $ofertaid . ",cargo:" . $cargo . ",area:" . $area . ",departa:" . $departamento . ' $$ ' . collect($info[0]));
        } catch (Exception $es) {
            throw $es;
        }
    }

    public function notificacionall(Request $request)
    {
        return view('home.notificaciones');
    }

    public function notificacionpostall()
    {
        try {
            $user = Auth::user();

            // Limit the number of returned notifications, or return all
            $query = $user->unreadNotifications();
            $limit = 3000;
            if ($limit) {
                $query = $query->limit($limit);
            }

            $datos = $query->get()->each(function ($n) {
                $n->created = $n->created_at->toIso8601String();
            });

            $total = $user->unreadNotifications->count();
            return compact('datos', 'total');
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function notificaciondelete()
    {
        try {
            $id = Input::get('id');
            $user = Auth::user()->id;
            $notification = Auth::user()
                ->unreadNotifications()
                ->where('id', $id)
                ->first();

            if (is_null($notification)) {
                return response()->json('No existe el id.', 404);
            } else {
                $notification->delete();
            }
            return response()->json(true);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function notificaciondeleteall()
    {
        try {
            $user = User::find(Auth::user()->id);
            $user->notifications()->delete();

            return response()->json(true);
        } catch (Excepcion $es) {
            throw $es;
        }
    }
}
