<?php

namespace App\Mail\Reservas\Huesped;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Reserva;

class EsperarConfirmacion extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;

    public function __construct(Reserva $reserva)
    {
        return $this->reserva = $reserva;
    }

    public function build()
    {
        return $this->markdown('emails.reservas.huesped.esperarconfirmacion');
    }
}
