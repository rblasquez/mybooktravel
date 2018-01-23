<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPreciosEspecificosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('propiedades_precios_especificos', function (Blueprint $table) {
			$table->dropPrimary('id');
			$table->dropColumn('id');
		});
		
        Schema::table('propiedades_precios_especificos', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->foreign('propiedad_id')
					->references('id')->on('propiedades')
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
		Schema::table('propiedades_precios_especificos', function (Blueprint $table) {
			$table->dropPrimary('id');
			$table->dropColumn('id');
		});		
		
        Schema::table('propiedades_precios_especificos', function (Blueprint $table) {
			$table->increments('id');
			$table->dropForeign(['propiedad_id']);
        });
    }
}
