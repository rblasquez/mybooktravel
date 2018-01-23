<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNMotivoBloqueoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('n_motivo_bloqueo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',50);
            $table->string('siglas',50);
            $table->string('color',10);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('n_motivo_bloqueo');
    }
}
