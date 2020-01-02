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

    public function listByPackage($pacakge_sn)
    {
        return Package::whereIn('package_sn', $pacakge_sn)->with(['consignee', 'item'])->get();
    }
}
