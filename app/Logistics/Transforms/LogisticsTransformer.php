<?php

namespace Logistics\Transforms;

class LogisticsTransformer
{
    public function transform()
    {
        return [
            'CustomerOrderNumber' => 'order_sn'
        ];
    }
}
