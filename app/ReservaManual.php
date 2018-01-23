<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\FechasController;

use Auth;
use DB;

class ReservaManual extends Model
{
    protected $table =  "reservas_manuales";

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function propiedad()
    {
        return $this->hasOne('App\Propiedad', 'id', 'propiedad_id');
    }

    public function scopeByReserva($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeByPropiedad($query, $propiedad)
    {
        return $query->where('propiedad_id', $propiedad);
    }

    public function scopeByUsuario($query)
    {
        if (Auth::user()->tipo_usuario=='C') {
            return $query->where('usuarios_id', Auth::user()->id);
        }
        return $query->whereNotNull('usuario_id');
    }

    public function scopeByOcupada($query, $fecha_entrada, $fecha_salida)
    {
        return $query->where(function ($query) use ($fecha_entrada, $fecha_salida) {
            $query->whereBetween('reservas_manuales.fecha_inicio', [$fecha_entrada, $fecha_salida])
                            ->orWhereBetween('reservas_manuales.fecha_fin', [$fecha_entrada, $fecha_salida])
                            ->orWhereRaw("'".$fecha_entrada."' BETWEEN reservas_manuales.fecha_inicio and reservas_manuales.fecha_fin")
                            ->orWhereRaw("'".$fecha_salida."' BETWEEN reservas_manuales.fecha_inicio and reservas_manuales.fecha_fin");
        });
    }
}
