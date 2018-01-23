<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribucionHabitacionesTable extends Migration
{
    public function up()
    {
        Schema::create('distribucion_habitaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->tinyInteger('tipo_habitacion_id')->unsigned();
            //$table->string('tipo_cama_id')->unsigned();
            $table->string('camas');
            $table->boolean('tiene_banio')->default(false);
            $table->boolean('tiene_tv')->default(false);
            $table->boolean('tiene_calefaccion')->default(false);
            $table->string('descripcion', 140)->nullable();
            $table->bigInteger('propiedad_detalles_id')->unsigned();
			// $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('distribucion_habitaciones', function($table) {
            //$table->foreign('tipo_habitacion_id')->references('id')->on('tipo_habitaciones')->onDelete('CASCADE')->onUpdate('CASCADE');
            //$table->foreign('tipo_cama_id')->references('id')->on('tipo_camas')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('propiedad_detalles_id')->references('id')->on('propiedades_detalles')->onDelete('CASCADE')->onUpdate('CASCADE');

        });
    }

    public function down()
    {
        Schema::dropIfExists('distribucion_habitaciones');
    }
}
