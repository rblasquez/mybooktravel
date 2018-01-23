<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesAnfitrionesTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades_anfitriones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_anfitrion', 50)->nullable();
            $table->string('telefono_anfitrion', 20)->nullable();
            $table->string('correo_anfitrion', 60)->nullable();
            $table->bigInteger('propiedad_id')->unsigned();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('propiedades_anfitriones', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades_anfitriones');
    }
}
