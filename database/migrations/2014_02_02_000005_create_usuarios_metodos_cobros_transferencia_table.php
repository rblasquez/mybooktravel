<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosMetodosCobrosTransferenciaTable extends Migration
{
    public function up()
    {
        Schema::create('d_usuarios_metodos_cobros_transferencia', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('metodo_cobro_id')->unsigned();
            // $table->string('info_pago');
			
            $table->string('titular');
            $table->string('tipo_cuenta');
            $table->string('email_beneficiario');
            $table->string('identificacion');
            $table->string('nro_cuenta');
            $table->string('banco');
            $table->bigInteger('pais_id');
			
            $table->bigInteger('usuarios_id')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('d_usuarios_metodos_cobros_transferencia', function($table) {
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('metodo_cobro_id')->references('id')->on('metodos_cobros')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('d_usuarios_metodos_cobros_transferencia');
    }
}
