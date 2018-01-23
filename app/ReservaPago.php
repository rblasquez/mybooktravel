<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class ReservaPago extends Model
{
    protected $table =  "reservas_informes_pagos";

    protected $fillable = ['usuarios_id','fecha_pago','metodo_pagos_id','bancos_id','monto','num_operacion','reservas_id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_pago',
    ];

    public function getFechaPagoAttribute($value)
    {
        $value = Carbon::createFromFormat('Y-m-d', substr($value,0,10));
        return $value->format('d-m-Y');
    }

    public function scopeByUsuario($query)
    {
        if(Auth::user()->tipo_usuario=='C'){
            return $query->where('usuarios_id',Auth::user()->id);
        } 
        return $query->whereNotNull('usuario_id');
    }
}
