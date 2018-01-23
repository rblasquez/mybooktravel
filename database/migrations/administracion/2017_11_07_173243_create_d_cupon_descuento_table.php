<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDCuponDescuentoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::create('d_cupon_descuento', function (Blueprint $table) {

      $table->bigIncrements('id');
      $table->bigInteger('d_campania_cupon_descuento_id')->unsigned();
      $table->string('codigo',20);
      $table->integer('n_estatus_cupon_descuento_id')->unsigned();
      $table->dateTimeTz('fecha_uso')->nullable();
      $table->bigInteger('reserva_id')->unsigned()->nullable();
      $table->timestamps();

    });

    Schema::table('d_cupon_descuento', function($table) {

    $table->foreign('d_campania_cupon_descuento_id')
          ->references('id')->on('d_campania_cupon_descuento')
          ->onDelete('CASCADE')->onUpdate('CASCADE');

    $table->foreign('n_estatus_cupon_descuento_id')
          ->references('id')->on('n_estatus_cupon_descuento')
          ->onDelete('CASCADE')->onUpdate('CASCADE');

      $table->foreign('reserva_id')
            ->references('id')->on('reservas')
            ->onDelete('CASCADE')->onUpdate('CASCADE');

    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('d_cupon_descuento');
  }
}
