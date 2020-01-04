<?php

namespace Package\Repositories;

use App\Repository;
use Package\Entities\Package;

class PackageRepository extends Repository
{
    public function model()
    {
        return Package::class;
    }
}
