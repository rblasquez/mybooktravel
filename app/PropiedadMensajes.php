<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropiedadMensajes extends Model
{
    protected $table = 'propiedades_mensajes';

    protected $guarded = [];

    public function usuario()
    {
    	return $this->belongsTo('App\User');
    }
}
