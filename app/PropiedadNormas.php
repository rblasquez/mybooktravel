<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadNormas extends Model
{
    protected $table = 'r_propiedades_normas';

    protected $guarded = [];

    public $incrementing = false;

    public function norma()
    {
    	return $this->belongsTo('App\Normas', 'n_norma_id');
    }

	public function scopeByPropiedad($query, $id)
    {
    	return $query->where('propiedad_id', $id);
    }

}
