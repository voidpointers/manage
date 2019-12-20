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
            $table->bigInteger('receipt_id')->default(0)->comment('收据ID');
            $table->bigInteger('consignee_id')->default()->comment('收货人');
            $table->string('provider', 32)->default('')->comment('物流商');
            $table->string('channel', 64)->default('')->comment('物流商渠道');
            $table->string('tacking_code')->default('')->comment('运单号');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->integer('create_time')->default(0)->comment('创建时间');
            $table->integer('update_time')->default(0)->comment('更新时间');
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
        Schema::dropIfExists('logistics');
    }
}
