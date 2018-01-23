<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesConceptosCobrosTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades_conceptos_cobros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('propiedad_id')->unsigned();
            $table->integer('conceptos_cobros_id')->unsigned();
            $table->decimal('valor', 15, 2)->nullable();
			$table->softDeletes();
            $table->timestamps();
        });

        Schema::table('propiedades_conceptos_cobros', function($table) {
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('conceptos_cobros_id')->references('id')->on('conceptos_cobros')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades_conceptos_cobros');
    }
}
