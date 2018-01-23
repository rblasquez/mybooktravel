<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactoCorreosTable extends Migration
{
    public function up()
    {
        Schema::create('contacto_correos', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('nombre', 100);
            $table->string('email', 100);
            $table->string('telefono', 50);
            $table->boolean('whatsapp')->default('false');
            $table->string('pais', 50);
            $table->string('mensaje', 255);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacto_correos');
    }
}
