<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesCaracteristicasTable extends Migration
{
    public function up()
    {
        Schema::create('r_propiedades_caracteristicas', function (Blueprint $table) {
            //tabla de relacion
			//asocia las caracteristicas a una propiedad

            // $table->bigIncrements('id');
            $table->integer('n_caracteristicas_propiedades_id');
            // $table->enum('tipo', ['exteriores', 'cocina', 'living_comedor', 'servicios', 'seguridad'])->nullable();
            $table->bigInteger('propiedad_id')->unsigned();
            // $table->string('caracteristicas');
            // $table->string('descripcion', 140)->nullable();
            //$table->integer('caracteristica_propiedad_id')->unsigned();
            //$table->tinyInteger('valor')->nullable();

			// $table->softDeletes();
            // $table->timestamps();
        });

        Schema::table('r_propiedades_caracteristicas', function($table) {
			
            $table->foreign('propiedad_id')
				->references('id')->on('propiedades')
				->onDelete('CASCADE')->onUpdate('CASCADE');
				
            $table->foreign('n_caracteristicas_propiedades_id')
				->references('id')->on('n_caracteristicas_propiedades')
				->onDelete('CASCADE')->onUpdate('CASCADE');
				
            //$table->foreign('caracteristica_propiedad_id')->references('id')->on('caracteristicas_propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
            // $table->primary(['tipo', 'propiedad_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('r_propiedades_caracteristicas');
    }
}
