<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class Notificaciones extends Notification implements ShouldQueue
{
    use Queueable;
    public $notificacion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notificacion)
    {
        //
        $this->notificacion = $notificacion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'titulo' => $this->notificacion['titulo'],
            'mensaje' => $this->notificacion['mensaje'],
            'url' => env('APP_URL').'notifications/all',
            'creada' => Carbon::now()->toIso8601String()
        ];
    }

    /**
     * Get the web push representation of the notification.
     *
     * @param  mixed $notifiable
     * @param  mixed $notification
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        return WebPushMessage::create()
            //->id($notification->id)
            ->title( $this->notificacion['titulo'])
            ->icon('/img/WAITER50.png')
            ->body($this->notificacion['mensaje'])
            ->action('Servicio waiter.com', env('APP_URL').'notifications/all');
    }
}
