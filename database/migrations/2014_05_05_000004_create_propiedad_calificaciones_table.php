<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadCalificacionesTable extends Migration
{
    public function up()
    {
        Schema::create('propiedad_calificaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('puntuacion');
            $table->bigInteger('reserva_id')->unsigned();
            $table->string('comentario');
            $table->tinyInteger('aspecto')->default(1);#indica lo que se esta evaluando

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('propiedad_calificaciones', function($table) {
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedad_calificaciones');
    }
}
