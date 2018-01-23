<?php

namespace App\Mail\Pagos;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Reserva;

class PagoRechazado extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $pagosRechazados;

    public function __construct(Reserva $reserva, $pagosRechazados)
    {
        $this->reserva = $reserva;
        $this->pagosRechazados = $pagosRechazados;
    }

    public function build()
    {
        return $this->subject('Pago rechazado')
                ->view('emails.pagos.reserva.pagoRechazado');
    }
}
