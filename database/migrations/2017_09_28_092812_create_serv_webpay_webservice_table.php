<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServWebpayWebserviceTable extends Migration
{
    public function up()
    {
        Schema::create('serv_webpay_webservice', function (Blueprint $table) {
            $table->string('token', 200)->nullable();
            $table->string('accountingdate', 4)->nullable();
            $table->string('buyorder', 100)->nullable();
            $table->integer('cardnumber', 11)->unsigned();
            $table->dropPrimary('cardnumber');
            $table->integer('cardnumber', 11)->nullable()->change();
        });

        Schema::table('serv_webpay_webservice', function($table) {
            $table->integer('cardexpirationdate', 11);
            $table->dropPrimary('cardexpirationdate');
        });

        Schema::table('serv_webpay_webservice', function($table) {
            $table->integer('authorizationcode', 11);
            $table->dropPrimary('authorizationcode');
        });

        Schema::table('serv_webpay_webservice', function($table) {
            $table->string('paymenttypecode', 2)->nullable();
            $table->string('responsecode', 80)->nullable();
            $table->string('sharesnumber', 80)->nullable();
            $table->integer('amount', 11);
            $table->dropPrimary('amount');
        });

        Schema::table('serv_webpay_webservice', function($table) {
            $table->string('commercecode', 12)->nullable();
            $table->string('sessionid', 100)->nullable();
            $table->string('transactiondate', 80)->nullable();
            $table->string('VCI', 3)->nullable();
            $table->string('estado', 10)->nullable();
            $table->timestamp('actualizado')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::table('serv_webpay_webservice', function($table) {
            $table->integer('user_id', 11);
            $table->dropPrimary('user_id');
        });

        
        Schema::table('serv_webpay_webservice', function($table) {
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('descripcion', 1000)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serv_webpay_webservice');
    }
}
