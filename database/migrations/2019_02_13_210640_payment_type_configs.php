<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentTypeConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_type_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->nullable(false)->comment("支付类型")->index();
            $table->string("key", 32)->nullable(false)->comment("配置键值");
            $table->string("name", 32)->nullable(false)->comment("说明");
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
        Schema::dropIfExists('payment_type_configs');
    }
}
