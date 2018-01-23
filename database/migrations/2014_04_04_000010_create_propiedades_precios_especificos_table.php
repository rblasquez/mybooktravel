<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesPreciosEspecificosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedades_precios_especificos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');            
            $table->dateTimeTz('fecha_inicio');
            $table->dateTimeTz('fecha_fin');
            $table->decimal('precio', 15, 2);
            //$table->enum('tipo', ['temporada', 'calendario']);
            $table->bigInteger('propiedad_id')->unsigned();
            // $table->bigInteger('usuarios_id')->unsigned();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propiedades_precios_especificos');
    }
}
