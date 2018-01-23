<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasDetallesTable extends Migration
{
    public function up()
    {
        Schema::create('reservas_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('monto_anfitrion', 10, 2); # Monto que solicito el anfitrion por su propiedad para cada noche
            $table->decimal('monto_mbt', 10, 2); # Porcentaje de publicación
            $table->decimal('monto_huesped', 10, 2); # Suma del monto_anfitrion + monto_mbt para mostrar al huesped
            $table->date('fecha');
            $table->bigInteger('reservas_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('reservas_detalles', function($table) {
            $table->foreign('reservas_id')->references('id')->on('reservas')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas_detalles');
    }
}