<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadDetalles extends Model
{
    protected $table = 'propiedades_detalles';

    protected $guarded = [];

    public function distribucionhabitaciones()
    {
      	return $this->hasMany('App\DistribucionHabitaciones');
    }
}
