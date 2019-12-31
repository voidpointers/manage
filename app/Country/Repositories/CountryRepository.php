<?php

namespace Country\Repositories;

use App\Repository;
use Country\Entities\Country;

class CountryRepository extends Repository
{
    public function model()
    {
        return Country::class;
    }
}
