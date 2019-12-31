<?php

namespace Logistics\Transformers;

class OrderTransformer
{
    public function transform($order)
    {
        return [
            'CustomerOrderNumber' => $orderId, //订单号
            'ShippingMethodCode' => $packageRow->logisticsChannels->code, //物流渠道代码
            'PackageCount' => '1', //包裹件数
            'Weight' => $allWeight, //包裹重量
            'Receiver' => [
                    
                ],
        ];
    }
}
