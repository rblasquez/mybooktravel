<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertasPropiedadesTable extends Migration
{
    public function up()
    {
        Schema::create('ofertas_propiedades', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('titulo');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ofertas_propiedades');
    }
}
