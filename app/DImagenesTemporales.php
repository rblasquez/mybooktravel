<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DImagenesTemporales extends Model
{
    protected $table = 'd_imagenes_temporales';

    protected $guarded = [];

    public $primaryKey = false;
    public $incrementing = false;
}
