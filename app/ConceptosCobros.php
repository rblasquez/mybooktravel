<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConceptosCobros extends Model
{
	use SoftDeletes;
	
    protected $table = 'conceptos_cobros';

    protected $guarded = [];
	
    protected $dates = ['deleted_at'];
}
