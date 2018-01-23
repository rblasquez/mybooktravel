<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regiones';

    protected $guarded = [];

    public function comunas()
    {
    	return $this->hasMany('App\Provincia');
    }
}
