<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePackageLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_logistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('package_sn')->default(0)->comment('包裹编号');
            $table->string('order_sn', 64)->default('')->comment('物流订单号');
            $table->string('provider', 32)->default('')->comment('物流商');
            $table->string('channel', 64)->default('')->comment('物流商渠道');
            $table->string('tacking_code', 128)->default('')->comment('运单号');
            $table->string('remark')->default('')->comment('运单请求失败反馈失败原因');
            $table->integer('create_time')->default(0)->comment('创建时间');
            $table->integer('update_time')->default(0)->comment('更新时间');
            $table->unique('package_sn', 'uk_package_sn');
        });

        DB::statement("ALTER TABLE `packages` comment '物流包裹'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_logistics');
    }
}
