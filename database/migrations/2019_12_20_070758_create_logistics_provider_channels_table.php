<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLogisticsProviderChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_provider_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider')->default('')->comment('供应商');
            $table->string('code')->default('')->comment('代码');
            $table->string('title')->default('')->comment('中文名');
            $table->string('en')->default('')->comment('英文标题');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->mediumInteger('sort')->default(0)->comment('排序');
        });

        DB::statement("ALTER TABLE `logistics_provider_channels` comment '物流商渠道'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics_provider_channels');
    }
}
