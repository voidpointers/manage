<?php

namespace Logistics\Services;

use Logistics\Entities\Logistics;
use Logistics\Requests\Request;
use Receipt\Entties\Receipt;

class LogisticsService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get()
    {

    }

    /**
     * 创建物流单，获取跟踪号
     * 
     * @params array $packags
     */
    public function createOrder($packages)
    {
        $orders = [];

        foreach ($packages as $package)
        {
           $order[] = [

           ];
        }

        // 入库
        Logistics::insert($params);

        // 更新订单状态
        Receipt::where([''])->update([

        ]);
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
