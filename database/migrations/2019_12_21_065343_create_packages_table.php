<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('package_sn')->unsigned()->default(0)->comment('包裹编号');
            $table->bigInteger('consignee_id')->unsigned()->default(0)->comment('收货人');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->integer('create_time')->default(0)->comment('创建时间');
            $table->integer('update_time')->default(0)->comment('更新时间');
            $table->integer('print_time')->default(0)->comment('打单时间');
            $table->integer('dispatch_time')->default(0)->comment('发货时间');
            $table->integer('close_time')->default(0)->comment('关闭时间');
            $table->integer('complete_time')->default(0)->comment('完成时间');
            $table->unique('package_sn', 'uk_package_sn');
            $table->index('consignee_id', 'uk_consignee_id');
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
        Schema::dropIfExists('packages');
    }
}
