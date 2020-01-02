<?php

namespace System\Repositories;

use App\Repository;
use System\Entities\Country;

class CountryRepository extends Repository
{
    public function model()
    {
        return Country::class;
    }
}
