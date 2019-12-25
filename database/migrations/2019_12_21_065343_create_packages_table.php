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
            $table->string('package_sn')->default(0)->comment('包裹编号');
            $table->bigInteger('consignee_id')->default()->comment('收货人');
            $table->string('provider', 32)->default('')->comment('物流商');
            $table->string('channel', 64)->default('')->comment('物流商渠道');
            $table->string('tacking_code')->default('')->comment('运单号');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->integer('create_time')->default(0)->comment('创建时间');
            $table->integer('update_time')->default(0)->comment('更新时间');
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
