<?php

namespace Express\Services;

use Express\Requests\Request;

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
            if (!$value['WayBillNumber']) {
                throw new \RuntimeException($value['Remark']);
            }
            $data[] = [
                'package_sn' => $value['CustomerOrderNumber'],
                'tracking_code' => $value['WayBillNumber'],
                'remark' => $value['Remark'],
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

    public function trackInfo()
    {

    }
}
