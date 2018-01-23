<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;

class ModeloBase extends Model
{
    //

    public static function formatoFechaGeneral($fecha)
    {
      $formato_fecha_general = 'd/m/Y';
      return \Carbon\Carbon::parse($fecha)->format($formato_fecha_general);
    }
}
