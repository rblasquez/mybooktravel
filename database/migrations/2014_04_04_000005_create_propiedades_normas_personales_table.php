<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesNormasPersonalesTable extends Migration
{
    public function up()
    {
        Schema::create('d_propiedades_normas_personales', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('propiedad_id')->unsigned();
            $table->string('normas');
            $table->timestamps();
        });

        Schema::table('d_propiedades_normas_personales', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });

    }

    public function down()
    {
        Schema::dropIfExists('d_propiedades_normas_personales');
    }
}
