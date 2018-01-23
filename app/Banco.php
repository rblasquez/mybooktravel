<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';

    public function scopeByActivo($query)
    {
        return $query->where('estatus',1);
    }
}
