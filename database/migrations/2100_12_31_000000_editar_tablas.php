<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarTablas extends Migration
{
    public function up()
    {
        /*
        Schema::table('estatus_propiedades', function (Blueprint $table) {
            # $table->dropColumn(['created_at', 'updated_at']);
            $table->tinyInteger('order')->nullable();
            $table->string('etiqueta')->nullable();
        });
        
        Schema::table('estatus_propiedades', function (Blueprint $table) {
            $table->timeStamps();
        });

        Schema::table('estatus_reservas', function (Blueprint $table) {
            # $table->dropColumn(['created_at', 'updated_at']);
            $table->tinyInteger('order')->nullable();
            $table->string('etiqueta')->nullable();
            $table->string('color')->nullable();
        });
        
        Schema::table('estatus_reservas', function (Blueprint $table) {
            $table->timeStamps();
        });
        */
    }

    public function down()
    {
    }
}
