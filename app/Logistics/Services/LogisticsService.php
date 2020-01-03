<?php

namespace Logistics\Services;

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
                'order_sn' => $value['CustomerOrderNumber'],
                'tracking_code' => $value['WayBillNumber'],
                'create_time' => time(),
            ];
        }

        return Logistics::insert($data);
    }
}
