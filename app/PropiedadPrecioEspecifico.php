<?php

namespace App;

//models
use Illuminate\Database\Eloquent\Model;

//controllers
use App\Http\Controllers\HelperController;

class PropiedadPrecioEspecifico extends Model
{
    //
    protected $table = "propiedades_precios_especificos";
    protected $guarded = [];

    public function propiedad()
    {
        return $this->belongsTo('App\Propiedad');
    }
	
    public function scopeByPropiedad($query, $propiedad)
    {
        return $query->where('propiedad_id',$propiedad);
    }
	
	public function scopeByIntervalo($query,$fecha_inicio,$fecha_fin)
	{
		$overlap = HelperController::verifyOverlapSqlIntervals(
					"propiedades_precios_especificos.fecha_inicio",
					"propiedades_precios_especificos.fecha_fin",
					"'".$fecha_inicio."'",
					"'".$fecha_fin."'"
				);
				
		return $query->whereRaw(" ( $overlap ) = true ");
	}
}
