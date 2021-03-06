<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class sugerencias extends Notification
{
    use Queueable;
    private $asunto, $mensaje, $nombre, $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($asunto, $mensaje, $nombre, $email)
    {
        //
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting($this->asunto)
            ->line($this->mensaje)
            ->line($this->nombre)
            ->line($this->email);
        //->action('Notification Action', url('/'))
        //->line('Thank you for using our application!');
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
            //
        ];
    }
}
