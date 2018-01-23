<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email', 100)->unique();
            $table->string('telefono')->nullable();
            $table->date('fecha_naci')->nullable();
            $table->integer('pais_id')->unsigned()->nullable();
            $table->string('divisa', 3)->nullable();
            $table->string('direccion')->nullable();
            $table->string('idiomas')->nullable();
            $table->enum('sexo', ['masculino', 'femenino'])->nullable();
            $table->string('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->enum('tipo_usuario', ['C', 'A'])->default('C');
            $table->boolean('estatus')->default(false);
            $table->string('password');
            $table->string('confirm_token', 100)->nullable();
            $table->rememberToken();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('usuarios', function($table) {
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
