<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoCamasTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_camas', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('descripcion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_camas');
    }
}
