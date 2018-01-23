<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadUbicacion extends Model
{
    protected $table = 'propiedades_ubicaciones';

    protected $guarded = [];

    public function propiedad()
    {
    	return $this->belongsTo('App\Propiedad');
    }

    public function datosPais()
    {
    	return $this->hasOne('App\Pais', 'id', 'pais_id');
    }
}
