<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDPagoReservasDepositosTable extends Migration
{
    public function up()
    {
        Schema::create('d_pago_reservas_depositos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('rut');
            $table->string('banco');
            $table->string('numero_transferencia');
            $table->string('monto');
            $table->string('monto_aprobado')->nullable();
            $table->string('comentario')->nullable();
            $table->string('bauche_img');
            $table->bigInteger('usuarios_id');
            $table->bigInteger('reserva_id');
            $table->boolean('estatus')->nullable();
            $table->string('comentario_mbt')->nullable();
            $table->timestamps();
        });

        Schema::table('d_pago_reservas_depositos', function ($table) {
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('d_pago_reservas_depositos');
    }
}
