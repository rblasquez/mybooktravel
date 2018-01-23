<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDCampaniaCuponDescuentoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('d_campania_cupon_descuento', function (Blueprint $table) {

      $table->bigIncrements('id');
      $table->string('titulo',100);
      $table->string('descripcion',500);
      $table->char('moneda', 3);
      $table->integer('n_modo_aplicacion_descuento_id')->unsigned();
      $table->bigInteger('valor');
      $table->dateTimeTz('fecha_inicio');
      $table->dateTimeTz('fecha_fin');
      $table->integer('noches_minimas');//noches minimos de estadia
      $table->integer('cantidad');//cantidad de cupones a generar
      $table->double('lat',15,8);
      $table->double('lng',15,8);
      $table->double('lat_max',15,8);
      $table->double('lat_min',15,8);
      $table->double('lng_max',15,8);
      $table->double('lng_min',15,8);
      $table->bigInteger('usuario_id')->unsigned();
      $table->timestamps();

    });

    Schema::table('d_campania_cupon_descuento', function($table) {

      $table->foreign('n_modo_aplicacion_descuento_id')
            ->references('id')->on('n_modo_aplicacion_descuento')
            ->onDelete('RESTRICT')->onUpdate('RESTRICT');

      $table->foreign('usuario_id')
            ->references('id')->on('usuarios')
            ->onDelete('RESTRICT')->onUpdate('RESTRICT');

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
