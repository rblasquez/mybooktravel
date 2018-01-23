<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaPropiedad extends Model
{
    protected $table = "n_caracteristicas_propiedades";

    protected $guarded = [];

    public function grupo()
    {
        return $this->hasOne('App\NGrupoCaracteristicasPropiedades');
    }

    // public function scopeByPropiedad($query, $id)
    // {
    	// return $query->where('propiedades_id',$id);
    // }
}
