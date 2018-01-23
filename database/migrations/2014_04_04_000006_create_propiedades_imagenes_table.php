<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedades_imagenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ruta');
            $table->boolean('primaria');
            $table->bigInteger('propiedad_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('propiedades_imagenes', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propiedades_imagenes');
    }
}
