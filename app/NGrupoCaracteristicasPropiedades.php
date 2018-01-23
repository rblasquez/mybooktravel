<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NGrupoCaracteristicasPropiedades extends Model
{
    // protected $table = '';

    protected $guarded = [];
	

    public function caracteristicas()
    {
        return $this->hasMany('App\CaracteristicaPropiedad');
    }
	
}
