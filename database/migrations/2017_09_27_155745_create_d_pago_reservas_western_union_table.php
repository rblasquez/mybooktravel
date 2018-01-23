<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDPagoReservasWesternUnionTable extends Migration
{
    public function up()
    {
        Schema::create('d_pago_reservas_western_union', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mtcn');
            $table->string('remitente');
            $table->string('monto');
            $table->string('monto_aprobado')->nullable();
            $table->string('comentario')->nullable();
            $table->string('bauche');
            $table->bigInteger('usuarios_id');
            $table->bigInteger('reserva_id');
            $table->boolean('estatus')->nullable();
            $table->string('comentario_mbt')->nullable();
            $table->timestamps();
        });

        Schema::table('d_pago_reservas_western_union', function ($table) {
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('d_pago_reservas_western_union');
    }
}
