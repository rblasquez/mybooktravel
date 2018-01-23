<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPropiedad extends Model
{
    protected $table =  "tipo_propiedades";

    function scopeActivos($query){
    	return $query->where('estatus',1);
    }
}
