<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicasPropiedadesTable extends Migration
{
    public function up()
    {
        Schema::create('n_caracteristicas_propiedades', function (Blueprint $table) {
            //nomenclador
			//la relacion entre el grupo y las caracteristicas que pertenecen a ese grupo
            $table->increments('id');
            $table->integer('n_grupo_caracteristicas_propiedades_id')->unsigned();
            // $table->enum('tipo_caracteristica', ['exteriores', 'cocina', 'living_comedor', 'servicios', 'seguridad'])->nullable();
            $table->string('descripcion');
            // $table->boolean('prioritario')->default(false);
            //$table->boolean('permite_cantidad')->default(false);
            $table->timestamps();
        });
		
        Schema::table('n_caracteristicas_propiedades', function($table) {
			
            $table->foreign('n_grupo_caracteristicas_propiedades_id')
				->references('id')->on('n_grupo_caracteristicas_propiedades')
				->onDelete('CASCADE')->onUpdate('CASCADE');
				
        });
		
    }
    
    public function down()
    {
        Schema::dropIfExists('n_caracteristicas_propiedades');
    }
}
