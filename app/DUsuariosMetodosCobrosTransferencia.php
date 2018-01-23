<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DUsuariosMetodosCobrosTransferencia extends Model
{
    protected $table = 'd_usuarios_metodos_cobros_transferencia';

    protected $guarded = [];

    public function metodo()
    {
    	return $this->belongsTo('App\MetodoCobro', 'metodo_cobro_id');
    }
}
