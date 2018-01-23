<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDPropiedadesNochesMinimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_propiedades_noches_minimas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');            
            $table->dateTimeTz('fecha_inicio');
            $table->dateTimeTz('fecha_fin');
            $table->integer('noches');
            $table->bigInteger('propiedad_id')->unsigned();           
            $table->timestamps();
        });
		
        Schema::table('d_propiedades_noches_minimas', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_propiedades_noches_minimas');
    }
}
