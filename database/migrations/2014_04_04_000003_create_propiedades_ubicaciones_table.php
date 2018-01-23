<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesUbicacionesTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades_ubicaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pais', 120);
            $table->string('distrito', 120)->nullable();
            $table->string('localidad', 120)->nullable();
            $table->string('provincia', 120)->nullable();
            $table->string('direccion', 140);
            $table->double('longitud', 15, 8);
            $table->double('latitud', 15, 8);
            $table->string('zona_descripcion')->nullable();
            $table->string('como_llegar')->nullable();
            $table->integer('pais_id')->unsigned();
            $table->bigInteger('propiedad_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('propiedades_ubicaciones', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades_ubicaciones');
    }
}
