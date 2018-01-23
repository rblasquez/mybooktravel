<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->dateTimeTz('fecha_entrada');
            $table->dateTimeTz('fecha_salida');
            $table->tinyInteger('total_adultos')->default(1);
            $table->tinyInteger('total_ninos')->default(0);
            $table->tinyInteger('total_bebes')->default(0);

            $table->tinyInteger('dias_estadia'); # Se refiere a las noches de estadia

            $table->decimal('precio_noche', 10, 2); # Precio promedio de cada noche
            $table->decimal('precio_base', 10, 2); # Multiplicación dias_estadia * precio_noche
            $table->decimal('gastos_limpieza', 10, 2);
            $table->decimal('tarifa_servicio', 10, 2)->default(0); # El valor que queda a Mybooktravel
            $table->decimal('total_pago', 10, 2)->default(0); # Suma de precio_base + tarifa_servicio
            
            $table->bigInteger('usuarios_id')->unsigned(); # HUESPED DE LA PROPIEDAD
            $table->bigInteger('propiedad_id')->unsigned();
            $table->tinyInteger('estatus_reservas_id')->unsigned()->nullable();
            $table->tinyInteger('metodo_pago_id')->unsigned()->nullable();
            $table->tinyInteger('notificaciones')->default(3);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('reservas', function($table) {
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('estatus_reservas_id')->references('id')->on('estatus_reservas')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('metodo_pago_id')->references('id')->on('metodos_pagos')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
