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

    public function create($logistics, $provider)
    {
        $data = [];

        $logistics = [
            'provider' => $provider->title,
            'channle' => $provider->channel->title,
        ];

        foreach ($logistics as $value) {
            $data[] = [
                'package_sn' => $value['package_sn'],
                'provider_id' => $provider->provider_id,
                'channel_id' => $provider->channel->channel_id,
                'tracking_code' => $value['tracking_code'],
                'provider' => json_encode($logistics),
                'remark' => $value['remark'] ?? '',
                'status' => 1, // 已发货
                'update_time' => 0,
                'create_time' => time(),
            ];
        }

        return Logistics::insert($data);
    }
}
