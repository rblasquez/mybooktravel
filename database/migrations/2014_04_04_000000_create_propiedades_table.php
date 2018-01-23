<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesTable extends Migration
{

    public function up()
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('id_publicacion', '16')->nullable();
            $table->string('nombre', 120);
            $table->longText('descripcion');
            $table->integer('tipo_propiedades_id')->unsigned()->nullable();
            $table->tinyInteger('estatus_propiedad_id')->unsigned()->nullable()->default(2);
            $table->bigInteger('usuarios_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('propiedades', function($table) {
            $table->foreign('estatus_propiedad_id')->references('id')->on('estatus_propiedades')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('tipo_propiedades_id')->references('id')->on('tipo_propiedades')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades');
    }
}
