<?php

namespace Api\Package\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Package\Entities\Logistics;

class LogisticsTransformer extends TransformerAbstract
{
    public function transform($logistics)
    {
        if (is_null($logistics)) {
            return [];
        }
        return [
            'package_sn' => $logistics->package_sn,
            'tracking_code' => $logistics->tracking_code,
            'waybill_url' => $logistics->waybill_url,
            'tracking_url' => $logistics->tracking_url,
            'status' => $logistics->status,
            'provider' => '云途',
            'channel' => $logistics->channel->title ?? ''
        ];
    }
}
