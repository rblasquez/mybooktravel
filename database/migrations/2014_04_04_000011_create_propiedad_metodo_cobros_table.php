<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadMetodoCobrosTable extends Migration
{
    public function up()
    {
        Schema::create('propiedad_metodo_cobros', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('propiedad_metodo_cobros');
    }
}
