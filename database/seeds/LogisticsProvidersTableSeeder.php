<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogisticsProvidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('logistics_providers')->truncate();
        
        DB::table('logistics_providers')->insert([
            [
                'id' => 1,
                'title' => '云途',
                'en' => 'yuntu',
                'code' => 'YT',
            ]
        ]);
    }
}
