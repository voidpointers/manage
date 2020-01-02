<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Logistics\Services\LogisticsService;
use Package\Repositories\PackageRepository;

class LogisticsController extends Controller
{
    protected $packageRepository;

    protected $logisticsService;

    public function __construct(
        PackageRepository $packageRepository,
        LogisticsService $logisticsService)
    {
        $this->packageRepository = $packageRepository;
        $this->logisticsService = $logisticsService;
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
        $packages = $this->packageRepository
            ->with(['consignee', 'item'])
            ->findWhere($request->get('package_id', []));

        $logistics = $this->logisticsService->createOrder($packages);

        $this->logisticsRepo->create();
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

        $data = $this->logisticsService->labels($tracking_codes);

        return $this->response->array(['data' => $data]);
    }
}
