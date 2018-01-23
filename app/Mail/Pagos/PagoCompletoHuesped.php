<?php

namespace App\Mail\Pagos;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Reserva;

class PagoCompletoHuesped extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;

    public function __construct(Reserva $reserva)
    {
        return $this->reserva = $reserva;
    }

    public function build()
    {
        return $this->subject('Reserva pagada')
                    ->view('emails.pagos.reserva.pagoCompletoHuesped');
    }
}
