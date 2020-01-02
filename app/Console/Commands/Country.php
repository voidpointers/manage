<?php

namespace App\Console\Commands;

use Country\Entities\Country as EntitiesCountry;
use Country\Repositories\CountryRepository;
use Illuminate\Console\Command;
use Logistics\Requests\Request as LogisticsRequest;

class Country extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉取国家列表';

    protected $request;

    protected $countryRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        LogisticsRequest $request,
        CountryRepository $countryRepository) 
    {
        $this->request = $request;
        $this->countryRepository = $countryRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countries = $this->request->instance()->country();

        $data = [];
        foreach ($countries as $country) {
            $data[] = [
                'code' => $country['CountryCode'],
                'name' => $country['CName'],
                'en' => $country['EName'],
            ];
        }

        EntitiesCountry::insert($data);
    }
}