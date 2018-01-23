<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DistribucionHabitaciones extends Model
{
	// use SoftDeletes;
	
    protected $table = 'distribucion_habitaciones';

    protected $guarded = [];
	
	// protected $dates = ['deleted_at'];
}
