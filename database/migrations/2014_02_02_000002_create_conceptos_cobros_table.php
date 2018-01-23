<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosCobrosTable extends Migration
{
    public function up()
    {
        Schema::create('conceptos_cobros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto');
            $table->enum('tipo', ['fijo', 'porcentual'])->default("fijo");
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conceptos_cobros');
    }
}
