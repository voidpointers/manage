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

    public function store($logistics)
    {
        $data = [];

        foreach ($logistics as $value) {
            $data[] = [
                'order_sn' => $value['CustomerOrderNumber'],
                'tracking_code' => $value['WayBillNumber'],
            ];
        }

        return Logistics::insert($data);
    }
}
