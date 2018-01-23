<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDPropiedadesCaracteristicasComentariosTable extends Migration
{
    public function up()
    {   
        
        Schema::create('d_propiedades_caracteristicas_comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('propiedad_id')->unsigned();
			$table->integer('n_grupo_caracteristicas_propiedades_id')->unsigned();
            $table->string('comentario');
            $table->timestamps();
        });

        Schema::table('d_propiedades_caracteristicas_comentarios', function($table) {
			
            $table->foreign('propiedad_id')
				->references('id')->on('propiedades')
				->onDelete('CASCADE')->onUpdate('CASCADE');
			
            $table->foreign('n_grupo_caracteristicas_propiedades_id')
				->references('id')->on('n_grupo_caracteristicas_propiedades')
				->onDelete('CASCADE')->onUpdate('CASCADE');				
				
        });
       
    }

    public function down()
    {
        Schema::dropIfExists('d_propiedades_caracteristicas_comentarios');
    }
}