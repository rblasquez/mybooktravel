<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\FechasController;

use Auth;
use Carbon\Carbon;
use DB;

class Reserva extends Model
{
    protected $table =  "reservas";

    protected $guarded = [];

    public function detalles()
    {
        return $this->hasMany('App\ReservaDetalle', 'reservas_id');
    }

    public function calificaciones()
    {
        return $this->hasMany('App\PropiedadCalificaciones', 'reserva_id', 'id');
    }

    public function pagoDeposito()
    {
        return $this->hasMany('App\DPagoReservasDeposito', 'reserva_id', 'id');
    }

    public function pagoWesternUnion()
    {
        return $this->hasMany('App\DPagoReservasWesternUnion', 'reserva_id', 'id');
    }

    public function pagoWebPay()
    {
        return $this->hasMany('App\ServWebpayWebservice', 'buyorder', 'id');
    }

    public function propiedad()
    {
        return $this->belongsTo('App\Propiedad');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'usuarios_id');
    }

    public function estatusreserva()
    {
        return $this->hasOne('App\EstatusReserva', 'id', 'estatus_reservas_id');
    }

    public function scopeByPropiedad($query, $propiedad)
    {
        return $query->where('propiedad_id', $propiedad);
    }

    public function scopeByUsuario($query)
    {
        return $query->where('usuarios_id', Auth::user()->id);
        if (Auth::user()->tipo_usuario=='C') {
            return $query->where('usuarios_id', Auth::user()->id);
        }
        return $query->whereNotNull('usuarios_id');
    }

    public function scopebyActiva($query)
    {
        return $query->selectRaw('*, ADDDATE(created_at,INTERVAL 1 DAY) AS fecha_fin_pago')->where('estatus_reservas_id', '>', '0')
            ->orWhere(function ($query) {
                $query->where('estatus_reservas_id', '0')
                      ->whereRaw('created_at >= CURRENT_DATE()')
                      ->whereRaw('created_at <= ADDDATE(created_at,INTERVAL 1 DAY)');
            });
    }

    public function scopeByOcupada($query, $fecha_entrada, $fecha_salida)
    {
        return $query->whereIn('estatus_reservas_id', [2, 3, 4, 5, 6, 9])
                    ->where(function ($query) use ($fecha_entrada, $fecha_salida) {
                        $query->whereBetween('reservas.fecha_entrada', [$fecha_entrada, $fecha_salida])
                            ->orWhereBetween('reservas.fecha_salida', [$fecha_entrada, $fecha_salida])
                            ->orWhereRaw("'".$fecha_entrada."' BETWEEN reservas.fecha_entrada and reservas.fecha_salida")
                            ->orWhereRaw("'".$fecha_salida."' BETWEEN reservas.fecha_entrada and reservas.fecha_salida");
                    });
    }
}
