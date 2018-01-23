<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpligenceTable extends Migration
{
    public function up()
    {
        Schema::create('ipligence', function (Blueprint $table) {
            $table->bigInteger('ip_from')->unsigned()->default(0000000000);
            $table->bigInteger('ip_to')->unsigned()->default(0000000000);
            $table->string('country_code');
            $table->string('country_name');
            $table->string('continent_code');
            $table->string('continent_name');
        });

        Schema::table('ipligence', function($table) {
            $table->primary('ip_to');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ipligence');
    }
}
