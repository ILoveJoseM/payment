<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentAccountConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_account_configs', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->timestamps();
            $table->string("key", 64)->nullable(false)->comment("键");
            $table->text("value")->nullable(false)->comment("值");
            $table->integer("account_id")->nullable(false)->comment("所属账号");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_account_configs');
    }
}
