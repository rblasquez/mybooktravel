<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPropiedadesTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_propiedades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->boolean('estatus');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_propiedades');
    }
}
