<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HTML;

class Pais extends Model
{
    protected $table = 'paises';

    protected $guarded = [];

    public function regiones()
    {
    	return $this->hasMany('App\Region');
    }

    public function getDescripcionAttribute($value)
    {
        $value = html_entity_decode($value) ;
        return $value;
    }

}
