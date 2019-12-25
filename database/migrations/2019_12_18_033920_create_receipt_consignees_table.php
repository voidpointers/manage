<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateReceiptConsigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_consignees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('receipt_id')->unsigned()->default(0)->comment('主表ID');
            $table->integer('country_id')->unsigned()->default(0)->comment('国家ID');
            $table->string('name')->default('')->comment('收件人名');
            $table->string('state', 32)->default('')->comment('州');
            $table->string('city', 64)->default('')->comment('市');
            $table->string('zip', 24)->default('')->comment('邮编');
            $table->string('first_line')->default('')->comment('第一行地址');
            $table->string('second_line')->default('')->comment('第二行地址');
            $table->string('formatted_address')->default('')->comment('送货地址的本地格式地址');
        });

        DB::statement("ALTER TABLE `receipt_consignees` comment '收货人'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_consignees');
    }
}
