<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('receipt_sn')->unsigned()->default(0)->comment('收据唯一编号');
            $table->integer('shop_id')->unsigned()->default(0)->comment('店铺ID');
            $table->bigInteger('etsy_receipt_id')->unsigned()->default(0)->comment('Etsy收据ID');
            $table->tinyInteger('type')->unsigned()->default(0)->comment('类型');
            $table->bigInteger('order_id')->unsigned()->default(0)->comment('订单ID');
            $table->bigInteger('seller_user_id')->unsigned()->default(0)->comment('卖家用户ID');
            $table->bigInteger('buyer_user_id')->unsigned()->default(0)->comment('买家用户ID');
            $table->string('buyer_email', 128)->default('')->comment('买家邮箱');
            $table->string('payment_method')->default('')->comment('支付方式 pp，cc，ck，mo(Paypal，信用卡，支票，汇票)');
            $table->tinyInteger('status')->unsigned()->default(0)->comment('状态');
            $table->tinyInteger('was_paid')->unsigned()->default(0)->comment('是否已付款');
            $table->tinyInteger('was_shipped')->unsigned()->default(0)->comment('是否已发货');
            $table->string('currency_code')->default('')->comment('卖方本币ISO代码');
            $table->decimal('total_price', 12, 2)->unsigned()->default(0)->comment('总额（价格*数量）不含税或运费');
            $table->decimal('subtotal', 12, 2)->unsigned()->default(0)->comment('总额减去优惠券折扣，不含税或运费');
            $table->decimal('grandtotal', 12, 2)->unsigned()->default(0)->comment('总额减去优惠券折扣，加税金和运费');
            $table->decimal('adjusted_grandtotal', 12, 2)->unsigned()->default(0)->comment('付款调整后的总计');
            $table->decimal('total_tax_cost', 12, 2)->unsigned()->default(0)->comment('总营收额');
            $table->decimal('total_vat_cost', 12, 2)->unsigned()->default(0)->comment('总增值税');
            $table->decimal('total_shipping_cost', 12, 2)->unsigned()->default(0)->comment('总运费');
            $table->string('seller_msg')->default('')->comment('卖家消息');
            $table->string('buyer_msg')->default('')->comment('买家消息');
            $table->string('buyer_msg_zh')->default('')->comment('买家消息');
            $table->string('remark')->default('')->comment('订单备注');
            $table->integer('creation_tsz')->unsigned()->default(0)->comment('下单时间');
            $table->integer('modified_tsz')->unsigned()->default(0)->comment('修改时间');
            $table->integer('create_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('update_time')->unsigned()->default(0)->comment('更新时间');
            $table->integer('complete_time')->unsigned()->default(0)->comment('完成时间');
            $table->unique('receipt_sn', 'uk_receipt_sn');
        });

        DB::statement("ALTER TABLE `receipts` comment '订单收据'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
