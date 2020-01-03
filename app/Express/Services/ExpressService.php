<?php

namespace Express\Services;

use Logistics\Requests\Request;

class ExpressService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 创建物流单，获取跟踪号
     * 
     * @params array $packags
     */
    public function createOrder(array $orders)
    {
        $data = [];

        $response = $this->request->instance()->createOrder($orders);
        foreach ($response as $value) {
            $data[] = [
                'order_sn' => $value['CustomerOrderNumber'],
                'tracking_code' => $value['WayBillNumber'],
            ];
        }

        return $data;
    }

    public function labels($tracking_codes)
    {
        $data = [];

        $labels = $this->request->instance()->labelPrint($tracking_codes);
        foreach ($labels as $label) {
            $data[] = [
                'url' => $label['Url'],
                'orders' => array_column($label['OrderInfos'], 'CustomerOrderNumber'),
            ];
        }

        return $data;
    }
}
