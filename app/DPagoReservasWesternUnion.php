<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DPagoReservasWesternUnion extends Model
{
	protected $table = 'd_pago_reservas_western_union';

	protected $guarded = [];

	public function reserva()
	{
		return $this->belongsTo('App\Reserva');
	}
}
