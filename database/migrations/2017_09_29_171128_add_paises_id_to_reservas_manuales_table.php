<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaisesIdToReservasManualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservas_manuales', function (Blueprint $table) {
            //
			$table->integer('paises_id')->default(1);
			$table->string('ciudad',255)->nullable();
			
            $table->foreign('paises_id')
					->references('id')->on('paises')
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
        Schema::table('reservas_manuales', function (Blueprint $table) {
            //
			$table->dropColumn(['paises_id', 'ciudad']);
        });
    }
}
