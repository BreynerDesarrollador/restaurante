<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class Notificacionescelular extends Notification implements ShouldQueue
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
        return $notifiable ? ['nexmo'] : ['mail', 'database'];
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Your unicode message Breyner Prueba')
            ->unicode();
    }
}
