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
            $table->bigInteger('receipt_id')->default(0)->comment('Etsy收据ID');
            $table->bigInteger('tansaction_id')->default(0)->comment('Etsy交易ID');
            $table->string('title')->default('')->comment('申报标题');
            $table->string('en')->default('')->comment('申报英文标题');
            $table->decimal('price', 12, 2)->default(0)->comment('申报单价');
            $table->double('weight', 12, 3)->default(0)->comment('申报重量');
            $table->mediumInteger('quantity')->default(0)->comment('数量');
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
