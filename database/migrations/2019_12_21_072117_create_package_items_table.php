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
            $table->increments('id');
            $table->bigInteger('package_sn')->unsigned()->default(0)->comment('包裹编号');
            $table->bigInteger('transaction_sn')->unsigned()->default(0)->comment('交易编号');
            $table->bigInteger('receipt_sn')->unsigned()->default(0)->comment('收据编号');
            $table->bigInteger('etsy_receipt_id')->unsigned()->default(0)->comment('收据ID');
            $table->string('title')->default('')->comment('申报标题');
            $table->string('en')->default('')->comment('申报英文标题');
            $table->decimal('price', 12, 2)->unsigned()->default(0)->comment('申报单价');
            $table->double('weight', 12, 3)->default(0)->comment('申报重量');
            $table->mediumInteger('quantity')->unsigned()->default(0)->comment('数量');
            $table->index('package_sn', 'idx_package_sn');
            $table->index('transaction_sn', 'idx_transaction_sn');
            $table->index('receipt_sn', 'idx_receipt_sn');
            $table->index('etsy_receipt_id', 'idx_etsy_receipt_id');
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
