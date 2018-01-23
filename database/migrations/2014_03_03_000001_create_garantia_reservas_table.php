<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiaReservasTable extends Migration
{
    public function up()
    {
        Schema::create('garantia_reservas', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('descripcion');
            $table->tinyInteger('porcentaje_aceptado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('garantia_reservas');
    }
}
