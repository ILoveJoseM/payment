<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentTrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_trades', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->bigInteger('payment_id')->nullable(false)->index();
            $table->string('order_id', 25)->nullable(false)->index();
            $table->integer('app_id')->nullable(false);
            $table->integer('channel_id')->nullable(false);
            $table->string('channel_name', 50)->nullable(false);
            $table->string('currency', 5)->nullable(false);
            $table->decimal('amount', 11, 2)->nullable(false);
            $table->decimal('tax_amount', 11, 2)->nullable(false);
            $table->string('out_trade_sn', 50)->nullable(false);
            $table->enum('status', [
                "ready",
                "apply",
                "expired",
                "paid",
                "partially_refund",
                "full_refund"
            ])->nullable(false);
            $table->string("extra", 255)->nullable(false);
            $table->integer("buyer_id")->nullable(false)->index();
            $table->enum("is_refund",["yes","no"])->nullable(false);
            $table->timestamp("applied_at")->nullable(false);
            $table->timestamp("completed_at")->nullable(false);
            $table->timestamps();

            $table->index(["channel_id", "out_trade_no"], "channel_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_trades');
    }
}
