<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registro extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;

    public function __construct($usuario)
    {
        return $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Finalizar registro')
                    ->view('emails.usuarios.registro');
    }
}
