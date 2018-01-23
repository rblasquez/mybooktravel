<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosTable extends Migration
{
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('atributo');
            $table->string('valor');
            $table->string('descripcion')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parametros');
    }
}
