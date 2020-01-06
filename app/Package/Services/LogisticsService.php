<?php

namespace Package\Services;

use Package\Entities\Logistics;
use Package\Repositories\LogisticsRepository;

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
                'package_sn' => $value['package_sn'],
                'tracking_code' => $value['tracking_code'],
                'remark' => $value['remark'] ?? '',
                'status' => 1, // 已发货
                'update_time' => 0,
                'create_time' => time(),
            ];
        }

        return Logistics::insert($data);
    }
}
