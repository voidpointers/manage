<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(LogisticsProvidersTableSeeder::class);
        $this->call(LogisticsProviderChannelsTableSeeder::class);
    }
}
