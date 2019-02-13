<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string("name", 64)->nullable(false)->comment("支付账号名");
            $table->string("title", 64)->nullable(false)->comment("描述");
            $table->string("company", 64)->nullable(false)->comment("所属公司");
            $table->integer("type")->nullable(false)->comment("支付类型")->index();
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
        Schema::dropIfExists('payment_accounts');
    }
}
