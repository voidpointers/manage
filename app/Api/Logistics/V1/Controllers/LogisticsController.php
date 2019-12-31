<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Logistics\Requests\Request as LogisticsRequest;
use Package\Repositories\PackageRepository;
use Voidpointers\Yunexpress\Waybill;

class LogisticsController extends Controller
{
    protected $request;

    protected $packageRepository;

    public function __construct(
        LogisticsRequest $request,
        PackageRepository $packageRepository)
    {
        $this->request = $request;
        $this->packageRepository = $packageRepository;
    }

    public function lists(Request $request)
    {

    }

    /**
     * 获取跟踪信息
     * 
     * @param string $tracking_code
     * @return array
     */
    public function trackInfo($tracking_code)
    {
        $this->request->instance()->trackInfo($tracking_code);
    }

    /**
     * 创建物流订单（获取运单号）
     * 
     * @param Reqeust $request
     * @param array
     */
    public function createOrder(Request $request)
    {
        $package_ids = $request->get('package_id', []);

        $packages = $this->packageRepository->findWhere($package_ids);

        $this->request->instance()->createOrder([]);
    }

    /**
     * 获取面单
     * 
     * @param Request $request
     * @return array
     */
    public function labels(Request $request)
    {
        $tracking_codes = $request->input('tracking_code', []);
        if (!is_array($tracking_codes)) {
            $tracking_codes = [$tracking_codes];
        }

        $data = [];

        $labels = $this->request->instance()->labelPrint($tracking_codes);
        foreach ($labels as $label) {
            $data[] = [
                'url' => $label['Url'],
                'orders' => array_column($label['OrderInfos'], 'CustomerOrderNumber'),
            ];
        }

        return $this->response->array(['data' => $data]);
    }
}
