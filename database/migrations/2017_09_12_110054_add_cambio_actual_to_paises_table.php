<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCambioActualToPaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paises', function (Blueprint $table) {
            //
			$table->double('cambio_actual', 15, 8)->default(0);
			$table->timestamp('fecha_cambio_actual')->default('2017-03-08 14:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paises', function (Blueprint $table) {
            //
			$table->dropColumn(['cambio_actual', 'fecha_cambio_actual']);
        });
    }
}
