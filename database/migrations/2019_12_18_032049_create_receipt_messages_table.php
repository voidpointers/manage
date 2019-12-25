<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateReceiptMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('receipt_id')->default(0)->unsigned()->comment('收据ID');
            $table->string('seller_msg')->default('')->comment('卖家消息');
            $table->string('seller_msg_zh')->default('')->comment('卖家消息');
            $table->string('buyer_msg')->default('')->comment('买家消息');
            $table->string('remark')->default('')->comment('订单备注');
            $table->unique('receipt_id', 'uk_receipt_id');
        });

        DB::statement("ALTER TABLE `receipt_messages` comment '收据相关消息'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_messages');
    }
}
