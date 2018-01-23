<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropiedadAnfitrion extends Model
{
	use SoftDeletes;
	
    protected $table = 'propiedades_anfitriones';

    protected $guarded = [];
    
    protected $dates = ['deleted_at'];
}
