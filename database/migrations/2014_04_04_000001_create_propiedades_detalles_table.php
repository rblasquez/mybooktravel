<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesDetallesTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades_detalles', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->time('checkin')->default(Carbon\Carbon::parse('14:00:00')->format('H:i'));
            $table->time('checkin_estricto')->nullable();
            $table->time('checkout')->default(Carbon\Carbon::parse('11:00:00')->format('H:i'));
            $table->integer('superficie')->default(0);
            $table->tinyInteger('nhabitaciones');
            $table->tinyInteger('nbanios');
            $table->tinyInteger('estacionamientos');
            $table->tinyInteger('capacidad');
            //$table->tinyInteger('noches_min')->default(1);
            $table->bigInteger('propiedad_id')->unsigned();
            $table->timestamps();

        });

        Schema::table('propiedades_detalles', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });

    }

    public function down()
    {
        Schema::dropIfExists('propiedades_detalles');
    }
}
