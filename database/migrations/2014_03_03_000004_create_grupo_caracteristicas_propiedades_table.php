<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoCaracteristicasPropiedadesTable extends Migration
{
    public function up()
    {
		//nomenclador
		//nombres de los grupos, id, descripcion y etiquetas de idioma
		
        Schema::create('n_grupo_caracteristicas_propiedades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->string('etiqueta');
            $table->timestamps();
        });
		
    }

    public function down()
    {
        Schema::dropIfExists('n_grupo_caracteristicas_propiedades');
    }
}
