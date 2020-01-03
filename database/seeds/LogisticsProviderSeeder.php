<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $providers = [
            [
                'title' => '云途',
                'en' => 'yuntu',
                'code' => 'YT',
            ]
        ];

        DB::table('logistics_providers')->truncate();
        DB::table('logistics_providers')->insert($providers);
    }
}
