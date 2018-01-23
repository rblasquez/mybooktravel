<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodos_pagos';

    public function scopeByActivo($query)
    {
        return $query->where('estatus',1);
    }
}
