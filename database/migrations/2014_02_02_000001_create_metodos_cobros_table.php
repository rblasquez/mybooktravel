<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodosCobrosTable extends Migration
{
    public function up()
    {
        Schema::create('metodos_cobros', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('descripcion');
            $table->boolean('estatus');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metodos_cobros');
    }
}
