<?php

namespace App\Models\Administracion;

//use Illuminate\Database\Eloquent\Model;
use App\Models\Administracion\ModeloBase;

class DCampaniaCuponDescuento extends ModeloBase
{

  protected $table = 'd_campania_cupon_descuento';

  protected $guarded = [];

  //protected $dates = ['fecha_inicio','fecha_fin'];

  //protected $dateFormat = 'U';
  //protected $dateFormat = 'Y-m-d H:i:s0';

  public function modoAplicacion()
  {
    return $this->belongsTo('App\Models\Administracion\NModoAplicacionDescuento','n_modo_aplicacion_descuento_id');
  }

  public function cupones()
  {
    return $this->hasMany('App\Models\Administracion\DCuponDescuento');
  }

  public function getFechaInicioFormatoAttribute()
  {
    return $this->formatoFechaGeneral($this->fecha_inicio);
  }

  public function getFechaFinFormatoAttribute()
  {
    return $this->formatoFechaGeneral($this->fecha_fin);
  }

  public function usuario()
  {
    return $this->belongsTo('App\User','usuario_id');
  }

  public function pais()
  {
    return $this->belongsTo('App\Pais','moneda','moneda');
  }

}
