<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('package_sn')->default(0)->comment('包裹编号');
            $table->bigInteger('shipping_id')->default(0)->comment('配送ID');
            $table->string('order_sn', 64)->default('')->comment('物流订单号');
            $table->string('provider', 32)->default('')->comment('物流商');
            $table->string('channel', 64)->default('')->comment('物流商渠道');
            $table->string('tracking_code', 128)->default('')->comment('运单号');
            $table->string('tracking_url', 128)->default('')->comment('跟踪url');
            $table->string('waybill_url')->default('')->comment('面单');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->string('remark')->default('')->comment('备注');
            $table->integer('create_time')->default(0)->comment('创建时间');
            $table->integer('update_time')->default(0)->comment('更新时间');
            $table->integer('notification_time')->default(0)->comment('通知时间');
            $table->unique('package_sn', 'uk_package_sn');
        });

        DB::statement("ALTER TABLE `logistics` comment '物流'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics');
    }
}
