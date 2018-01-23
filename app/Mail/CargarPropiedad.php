<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Propiedad;

class CargarPropiedad extends Mailable
{
    use Queueable, SerializesModels;

    public $propiedad;

    public function __construct($propiedad)
    {
        return $this->propiedad = $propiedad;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function build()
    {
        return $this->subject('Publicación realizada')
                    ->view('emails.propiedades.registrar');
    }
}
