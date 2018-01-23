<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadesAdministracionTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades_administracion', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('precio', 15, 2);
            $table->enum('anfitrion', ['usuario', 'otro', 'mybooktravel'])->default("usuario");
            $table->decimal('aseo_unico', 15, 2)->nullable();
            $table->decimal('comision', 15, 2);
            $table->decimal('ingreso_total', 15, 2);
            $table->char('moneda', 3);
            $table->integer('dias_intervalo');
            $table->integer('noches_minimas');
            $table->boolean('reserva_automatica')->default(0);
            $table->integer('garantia_reserva_id')->unsigned()->nullable();
            $table->tinyInteger('oferta_propiedad_id')->unsigned()->nullable();
            // $table->integer('usuario_metodo_cobro_id')->unsigned()->nullable();
            $table->tinyInteger('metodo_cobro_id')->unsigned()->nullable();

            $table->bigInteger('propiedad_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('propiedades_administracion', function($table) {
            // $table->foreign('usuario_metodo_cobro_id')->references('id')->on('usuarios_metodos_cobros')->onDelete('SET NULL')->onUpdate('CASCADE');
			$table->foreign('metodo_cobro_id')->references('id')->on('metodos_cobros')->onDelete('CASCADE')->onUpdate('CASCADE');

			$table->foreign('oferta_propiedad_id')->references('id')->on('ofertas_propiedades')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('garantia_reserva_id')->references('id')->on('garantia_reservas')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('propiedad_id')->references('id')->on('propiedades')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades_administracion');
    }
}
