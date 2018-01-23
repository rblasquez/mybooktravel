<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadCalificaciones extends Model
{
    protected $table = "propiedad_calificaciones";
    
    protected $guarded = [];
  
    public function reserva()
    {
    	return $this->belongsTo('App\Reserva');
    }
    
}
