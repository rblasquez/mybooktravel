<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisesTable extends Migration
{
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('name', 45);
            $table->string('nom', 45);
            $table->char('iso2', 2);
            $table->char('iso3', 3);
            $table->string('prefijo_telefono');
            $table->char('moneda', 3);
            $table->char('continente', 2);
            $table->string('continente_nombre', 15);
            $table->string('idiomas', 100);


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paises');
    }
}
