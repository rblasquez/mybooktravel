<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;
use App\Reserva;

class DCuponDescuento extends Model
{
  protected $table = "d_cupon_descuento";

  protected $guarded = [];

  public function campania()
  {
    return $this->belongsTo('App\Models\Administracion\DCampaniaCuponDescuento','d_campania_cupon_descuento_id');
  }

  public function estatus()
  {
    return $this->belongsTo('App\Models\Administracion\NEstatusCuponDescuento','n_estatus_cupon_descuento_id');
  }

  public function scopeByCodigo($query,$codigo)
  {
    return $query->where('codigo','ilike',$codigo);
  }

  public function getCodigoFormateadoAttribute()
  {
    return implode("-", str_split($this->codigo, 4));
  }

  public function aplicarEnReserva(Reserva $reserva)
  {
    $this->n_estatus_cupon_descuento_id = 3;
    $this->reserva_id = $reserva->id;
    $this->fecha_uso = date('Y-m-d H:i:s');
    $this->save();
  }

}
