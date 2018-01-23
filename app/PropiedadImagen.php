<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadImagen extends Model
{
    protected $table = "propiedades_imagenes";

    protected $guarded = [];

    public function scopeByPropiedad($query, $id)
    {
    	return $query->where('propiedad_id',$id);
    }
	
	public function propiedad()
	{
		return $this->belongsTo('App\Propiedad');
	}
}
