<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DPagoReservasDeposito extends Model
{
    protected $table = 'd_pago_reservas_depositos';

    protected $guarded = [];

    public function reserva()
	{
		return $this->belongsTo('App\Reserva');
	}
}
