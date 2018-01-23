<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadAdministracion extends Model
{
    protected $table = 'propiedades_administracion';

    protected $guarded = [];

    public function garantia()
    {
    	return $this->hasOne('App\GarantiaReserva', 'id', 'garantia_reserva_id');
    }
}
