<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePackageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('receipt_id')->unsigned()->default(0)->comment('收据ID');
            $table->bigInteger('transaction_id')->unsigned()->default(0)->comment('交易ID');
            $table->string('title')->default('')->comment('申报标题');
            $table->string('en')->default('')->comment('申报英文标题');
            $table->decimal('price', 12, 2)->unsigned()->default(0)->comment('申报单价');
            $table->double('weight', 12, 3)->default(0)->comment('申报重量');
            $table->mediumInteger('quantity')->unsigned()->default(0)->comment('数量');
            $table->json('relations')->comment('存储第三方平台关联ID');
        });

        DB::statement("ALTER TABLE `packages` comment '包裹明细'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_items');
    }
}
