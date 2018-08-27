<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sugerencias extends Mailable implements ShouldQueue
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
        return $this->subject($this->asunto)->markdown('emails.sugerencias', ['nombre' => $this->nombre, "mensaje" => $this->mensaje, "asunto" => $this->asunto, "email" => $this->email]);
    }
}
