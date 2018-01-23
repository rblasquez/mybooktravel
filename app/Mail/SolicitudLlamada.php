<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudLlamada extends Mailable
{
    use Queueable, SerializesModels;

    public $contacto;

    public function __construct($contacto)
    {
        return $this->contacto = $contacto;
    }

    public function build()
    {
        return $this->markdown('emails.contacto.llamada');
    }
}
