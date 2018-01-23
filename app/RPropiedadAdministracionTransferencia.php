<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RPropiedadAdministracionTransferencia extends Model
{
    protected $table = 'r_propiedad_administracion_transferencia';

    protected $guarded = [];

    public function propiedad()
    {
    	return $this->belongsTo('App\Propiedad', 'propiedad_id');
    }
	
    public function datos()
    {
    	return $this->belongsTo('App\DUsuariosMetodosCobrosTransferencia', 'd_usuarios_metodos_cobros_transferencia_id');
    }
	
}
