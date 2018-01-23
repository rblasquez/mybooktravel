<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class PropiedadCaracteristica extends Model
{
	//use SoftDeletes;
    protected $table = "r_propiedades_caracteristicas";

    protected $guarded = [];
	
	// protected $dates = ['deleted_at'];

    public function caracteristica()
    {
        return $this->hasOne('App\CaracteristicaPropiedad','id', 'caracteristica_propiedad_id');
    }

    public function scopeActivo($query)		
    {
    	return $query->where('valor',1);
    }

    public function scopeByPropiedad($query, $id)
    {
    	return $query->where('propiedad_id',$id);
    }
}
