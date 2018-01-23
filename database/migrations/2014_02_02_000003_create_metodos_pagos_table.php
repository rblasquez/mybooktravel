<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodosPagosTable extends Migration
{
    public function up()
    {
        Schema::create('metodos_pagos', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('descripcion');
            $table->string('view');
            $table->boolean('estatus');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metodos_pagos');
    }
}
