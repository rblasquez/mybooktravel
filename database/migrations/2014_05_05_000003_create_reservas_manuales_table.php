<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasManualesTable extends Migration
{
    public function up()
    {
        Schema::create('reservas_manuales', function (Blueprint $table) {
            $table->increments('id');

            $table->dateTimeTz('fecha_inicio');
            $table->dateTimeTz('fecha_fin');
            $table->string('descripcion')->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('telefono')->nullable();
            $table->decimal('precio', 15, 2)->nullable();
            $table->decimal('costos_adicionales', 15, 2)->nullable();
            $table->integer('noches')->nullable();
            $table->decimal('monto_total', 15, 2)->nullable();
            $table->decimal('monto_anticipo', 15, 2)->nullable();
            $table->decimal('monto_deuda_actual', 15, 2)->nullable();
			$table->boolean('comprobante');
            $table->string('email')->nullable();
            $table->enum('motivo', ['reserva', 'mantenimiento']);
            $table->bigInteger('propiedad_id')->unsigned();
            $table->bigInteger('usuarios_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('reservas_manuales', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas_manuales');
    }
}
