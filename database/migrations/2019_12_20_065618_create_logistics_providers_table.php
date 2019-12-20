<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLogisticsProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 64)->default('')->comment('物流商');
            $table->string('name')->default('')->comment('英文或拼音名');
            $table->string('code', 32)->default('')->comment('代号');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `logistics_providers` comment '物流商'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics_providers');
    }
}
