<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCacheTable extends Migration
{
    public function up()
    {
        Schema::create('cache', function (Blueprint $table) {
            /*
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');
            */
        });
    }

    public function down()
    {
        Schema::dropIfExists('cache');
    }
}
