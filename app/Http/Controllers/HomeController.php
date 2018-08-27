<?php

namespace App\Http\Controllers;

use App\Notifications\Notificaciones;
use App\Notifications\sugerencias;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function cliente()
    {
        if (Auth::check()) {
            if (Auth::user()->type != 6) {
                return Redirect::back();
            }
        }
        session('cliente');
        return view('cliente');
    }

    public function clienteescaner()
    {
        try {
            $codigo = explode('$$', Input::get('codigo'));
            $mensaje = "";
            if (count($codigo) > 1) {
                $mesa = $codigo[0];
                $user = $codigo[1];
                $mesero = $codigo[2];
                $nombremesa = $codigo[3];
                $existe = DB::select("select m.id from mesa m WHERE m.id=$mesa AND m.usuario=$user;");
                if (count($existe)) {
                    session(['cliente' => ['mesa' => $mesa, 'user' => $user, "mesero" => $mesero, "mesanombre" => $nombremesa]]);
                    $mensaje = "OK";
                } else {
                    $mensaje = "EL codigo QR escaneado no existe, por favor vuelta a escanear nuevamente.";
                }
            } else {
                $mensaje = "El codigo QR es incorrecto.";
            }

            return response()->json(["mensaje" => $mensaje, "datos" => session()->get('cliente')]);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function guardarpedidocliente(Request $request)
    {
        try {
            $operacion = Input::get('operacion');
            if (!empty($operacion)) {
                if ($operacion == "cliente") {
                    $datos = Input::get('datos');
                    $datos1 = array();
                    $usuario = session()->get('cliente')['user'];
                    $mesero = session()->get('cliente')['mesero'];
                    $xml = "";
                    $xml = "<?mxl version=\"1.0\" encoding=\"UTF-8\"?>";
                    $mesageneral = "";
                    $cliente = Auth::user()->id;
                    foreach ($datos as $item) {
                        $plato = $item["plato"];
                        $bebida = $item["bebida"];
                        $mesa = $item["mesa"];
                        $mesanombre = $item["mesanombre"];
                        $mesageneral = $mesa;
                        $comentario = $item["comentario"];

                        $xml = $xml . "<datos><plato>$plato</plato>" .
                            "<bebida>$bebida</bebida>" .
                            "<mesa>$mesa</mesa> <comentario>$comentario</comentario></datos>";
                        //$datos1[] = array(["plato" => $item["plato"], "bebida" => $item["bebida"], "mesa" => $item["mesa"], "usuario" => $usuario]);
                    }
                    //$con = new convertixmlController();
                    //$xml = $con->array_to_xml($datos1, new \SimpleXMLElement('<datos/>'))->asXML();
                    $fecha = date('Y-m-d H:i:s');
                    $guardar = DB::insert("call sp_guardarpedidomesero('$xml',$usuario,$mesero,$cliente,'$fecha')");
                    $usuario1 = User::where('type', 2)->where('user', $usuario)->get();
                    $noti = (["titulo" => 'Nuevo pedido', "mensaje" => "Pedido mesa: " . $mesanombre, "url" => "127.0.0.1"]);
                    Notification::send($usuario1, new Notificaciones($noti));
                    $respuesta = true;
                }
            }
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function enviarcorreosugerencia(Request $request)
    {
        try {
            $nombre = Input::get('name');
            $email = Input::get('emailcontacto');
            $asunto = Input::get('subject');
            $mensaje = Input::get('message');
            $validar = $this->validate($request, ["name" => "required", "emailcontacto" => "required", "subject" => "required", "message" => "required"]);
            $user = new User();
            $user->email = 'desarrollador2@willitad.com';
            Mail::to($user)
                ->queue(new \App\Mail\sugerencias($asunto, $mensaje, $nombre, $email));
            //$user->notify(new sugerencias($asunto, "Mensaje: " . $mensaje, "Nombres: " . $nombre, "Email: " . $email));
            return Redirect::back()->with("mensaje", "Su mensaje se ha enviado con exito, gracias por sus sugerencias o comentarios. Si quiere ver nuestros servicios ingrese a www.willitad.com");
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function PolicticaPrivacidad()
    {
        return view('PolicticaPrivacidad');
    }

    public function pedidolisto()
    {
        return view('pedidolisto');
    }

    public function landingpage()
    {
        return view('landingpage.landingpage');
    }

    public function postprueba(Request $request)
    {
        try {
            $correo = Input::get('inputcorreo');
            $telefono = Input::get('inputtelefono');
            $nombre = Input::get('inputnombre');
            $razonsocial = Input::get('inputrazonsocial');
            $sucursales = Input::get('selectsucursales');
            $negocio = Input::get('textareanegocio');

            $validar = $this->validate($request, ["inputcorreo" => "required", "inputtelefono" => "required",
                "inputnombre" => "required", "inputrazonsocial" => "required",
                "selectsucursales" => "required", "textareanegocio" => "required"]);

            $inser = DB::insert("call sp_guardardatoscliente('$correo','$telefono','$nombre','$razonsocial','$sucursales','$negocio')");
            $to = explode(',', env('ADMIN_EMAILS'));

            Mail::to($to)
                ->queue(new \App\Mail\sugerencias('Persona solicitando información sobre la plataforma WAITER', 'La persona ' . $nombre . ', solicita información sobre WAITER, su número de telefono es ' . $telefono . ', de razón social ' . $razonsocial . ', la cúal consta de ' . $sucursales . ' sucursal(es).', $nombre, $correo));
            Mail::to($correo)
                ->queue(new \App\Mail\gracias());
            //return Redirect::back()->with("mensaje", 'OK');
            return response()->json(["msj" => "OK"]);
        } catch (Excepcion $es) {
            throw $es;
        }
    }

    public function datospersona()
    {
        $datos = DB::select('select * from datoscliente');
        return view('datoscliente')->with('datos', $datos);
    }

    public function gracias()
    {
        return view('emails.gracias');
    }

    public function appcliente()
    {
        return view('appcliente');
    }
}
