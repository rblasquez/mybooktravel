<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNModoAplicacionDescuentoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('n_modo_aplicacion_descuento', function (Blueprint $table) {
      $table->increments('id');
      $table->string('descripcion');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('n_modo_aplicacion_descuento');
  }
}
