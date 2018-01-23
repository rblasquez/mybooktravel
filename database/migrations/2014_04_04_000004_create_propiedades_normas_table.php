<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesNormasTable extends Migration
{
    public function up()
    {
        Schema::create('r_propiedades_normas', function (Blueprint $table) {
            $table->bigInteger('propiedad_id')->unsigned();
            $table->integer('n_norma_id')->unsigned();
        });

        Schema::table('r_propiedades_normas', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('n_norma_id')->references('id')->on('n_normas')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('r_propiedades_normas');
    }
}
