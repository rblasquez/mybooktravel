<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableReservasManuales extends Migration
{
    public function up()
    {
		Schema::table('reservas_manuales', function (Blueprint $table) {
			$table->dropColumn('motivo');
			$table->integer('n_motivo_bloqueo_id')->default(1);
		});
		
        Schema::table('reservas_manuales', function($table) {
            $table->foreign('n_motivo_bloqueo_id')
					->references('id')->on('n_motivo_bloqueo')
					->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        //
		Schema::table('reservas_manuales', function (Blueprint $table) {
			$table->enum('motivo', ['reserva', 'mantenimiento'])->default('reserva');
			$table->dropColumn('n_motivo_bloqueo_id');
		});
    }
}
