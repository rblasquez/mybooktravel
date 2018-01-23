<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ReservaManual;

class ComprobanteReservaManual extends Mailable
{
    use Queueable, SerializesModels;
	
    public $reserva;
    
    public function __construct(ReservaManual $reserva)
    {
        return $this->reserva = $reserva;
    }

    public function build()
    {
        // return $this->markdown('emails.reservas.huesped.comprobantereservamanual');
        return $this->subject('Comprobante Reserva Manual')
				->view('emails.reservas.huesped.comprobantereservamanual');
    }
}
