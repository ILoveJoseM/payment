<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 64)->nullable(false)->comment("名称");
            $table->integer("account_id")->nullable(false)->comment("所属账号")->index();
            $table->integer("app_id")->nullable(false)->comment("所属应用")->index();
            $table->tinyInteger("status")->nullable(false)->default(1)->comment("状态");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_channels');
    }
}
