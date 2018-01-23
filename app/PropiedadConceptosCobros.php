<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropiedadConceptosCobros extends Model
{
	use SoftDeletes;
	
    protected $table = 'propiedades_conceptos_cobros';

    protected $guarded = [];
	
    protected $dates = ['deleted_at'];

    public function conceptos()
    {
    	return $this->belongsTo('App\ConceptosCobros', 'conceptos_cobros_id');
    }
}