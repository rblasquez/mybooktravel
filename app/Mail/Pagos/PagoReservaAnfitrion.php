<?php

namespace App\Mail\Pagos;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Reserva;

class PagoReservaAnfitrion extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;

    public function __construct(Reserva $reserva)
    {
        return $this->reserva = $reserva;
    }

    public function build()
    {
        return $this->view('emails.pagos.reserva.anfitrion')->subject('Recepción de pago');
    }
}
