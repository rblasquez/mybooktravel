<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormasTable extends Migration
{
    public function up()
    {
        Schema::create('n_normas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('n_normas');
    }
}
