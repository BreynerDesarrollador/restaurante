<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sugerencias extends Mailable implements  ShouldQueue
{
    use Queueable, SerializesModels;
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return (new MailMessage())
            ->greeting($this->asunto)
            ->line($this->mensaje)
            ->line($this->nombre)
            ->line($this->email);
    }
}
