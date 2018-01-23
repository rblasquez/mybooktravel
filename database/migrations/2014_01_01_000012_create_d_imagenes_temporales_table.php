<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDImagenesTemporalesTable extends Migration
{
    public function up()
    {
        Schema::create('d_imagenes_temporales', function (Blueprint $table) {
            $table->bigInteger('usuarios_id')->unsigned();
            $table->string('ruta');
            $table->string('token', 100);
            $table->timestamps();
        });

        Schema::table('d_imagenes_temporales', function($table) {
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('d_imagenes_temporales');
    }
}
