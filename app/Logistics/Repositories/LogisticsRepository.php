<?php

namespace Logistics\Repositories;

use App\Repository;
use Logistics\Entities\Logistics;

class LogisticsRepository extends Repository
{
    public function model()
    {
        return Logistics::class;
    }
}
