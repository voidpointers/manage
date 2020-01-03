<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpressChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = [
            [
                'provider' => 'yuntu',
                'code' => 'EUB-SZ',
                'title' => '省内EUB',
                'en' => 'Guangdong EUB',
                'status' => 1
            ]
        ];

        DB::table('logistics_provider_channels')->truncate();
        DB::table('logistics_provider_channels')->insert($channels);
    }
}
