<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesMensajesTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades_mensajes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('propiedad_id')->unsigned();
            $table->string('mensaje');
            $table->boolean('leido')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('propiedades_mensajes', function($table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades_mensajes');
    }
}
