<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRPropiedadAdministracionTransferenciaTable extends Migration
{
    public function up()
    {   
        
        Schema::create('r_propiedad_administracion_transferencia', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('propiedad_id')->unsigned();
			$table->integer('d_usuarios_metodos_cobros_transferencia_id')->unsigned();
            // $table->string('comentario');
            $table->timestamps();
        });

        Schema::table('r_propiedad_administracion_transferencia', function($table) {
			
            $table->foreign('propiedad_id')
				->references('id')->on('propiedades')
				->onDelete('CASCADE')->onUpdate('CASCADE');
			
            $table->foreign('d_usuarios_metodos_cobros_transferencia_id')
				->references('id')->on('d_usuarios_metodos_cobros_transferencia')
				->onDelete('CASCADE')->onUpdate('CASCADE');				
				
        });
       
    }

    public function down()
    {
        Schema::dropIfExists('r_propiedad_administracion_transferencia');
    }
}
