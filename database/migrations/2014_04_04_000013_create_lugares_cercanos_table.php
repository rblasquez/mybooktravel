<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLugaresCercanosTable extends Migration
{
    public function up()
    {   
        /*
        Schema::create('lugares_cercanos', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('lugar');
            $table->string('distancia');
            $table->string('distancia_caminando');
            $table->string('distancia_vehiculo');
            $table->bigInteger('propiedad_ubicacion_id')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::table('lugares_cercanos', function($table) {
            $table->foreign('propiedad_ubicacion_id')->references('id')->on('propiedades_ubicaciones')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
        */
    }

    public function down()
    {
        Schema::dropIfExists('lugares_cercanos');
    }
}
