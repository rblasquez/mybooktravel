<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FechasController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function formato($fecha)
    {
        if (isset($fecha)) {
            $fecha = Carbon::parse($fecha)->tz($this->timezone);
        } else {
            $fecha = Carbon::today()->tz($this->timezone);
        }

        return $fecha;
    }

    public function formatoHora($hora)
    {
        return Carbon::parse($hora)->tz($this->timezone)->format('h:i a');
    }

    public function formatoFechaHora($fecha, $hora)
    {
        $horas = Carbon::parse($hora)->tz($this->timezone);
        $fecha_actual = Carbon::createFromTime(00, 00, 01, $this->timezone);
        $horas = $fecha_actual->diffInHours($horas);

        return $fecha = Carbon::parse($fecha)->addHours($horas);
    }

    public function diasDiferencia($fecha_ini, $fecha_fin)
    {
        $fecha_ini = Carbon::parse($fecha_ini);
        $fecha_fin = Carbon::parse($fecha_fin);

        return $fecha_ini->diffInDays($fecha_fin);
    }

    public function formatoLetras($fecha)
    {
        $fecha = Carbon::parse($fecha);
        return $fecha->formatLocalized('%A %d  de %B del %Y');
    }
}
