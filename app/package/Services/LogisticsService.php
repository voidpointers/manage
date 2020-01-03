<?php

namespace Package\Services;

use Logistics\Entities\Logistics;
use Logistics\Repositories\LogisticsRepository;

class LogisticsService
{
    protected $logisticsRepository;

    public function __construct(LogisticsRepository $logisticsRepository)
    {
        $this->logisticsRepository = $logisticsRepository;
    }

    public function create($logistics)
    {
        $data = [];

        foreach ($logistics as $value) {
            $data[] = [
                'package_sn' => $value['CustomerOrderNumber'],
                'tracking_code' => $value['WayBillNumber'],
                'remark' => $value['Remak'],
                'update_time' => 0,
                'create_time' => time(),
            ];
        }

        return Logistics::insert($data);
    }
}
