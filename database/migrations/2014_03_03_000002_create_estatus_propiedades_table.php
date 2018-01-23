<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstatusPropiedadesTable extends Migration
{
    public function up()
    {
        Schema::create('estatus_propiedades', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('descripcion');
            $table->tinyInteger('order')->nullable();
            $table->string('etiqueta')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estatus_propiedades');
    }
}
