<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Express\Services\ExpressService;
use Express\Services\TrackingService;
use Logistics\Services\LogisticsService;
use Package\Repositories\PackageRepository;

class LogisticsController extends Controller
{
    protected $packageRepository;

    protected $logisticsService;

    protected $expressService;

    protected $trackingService;

    public function __construct(
        PackageRepository $packageRepository,
        LogisticsService $logisticsService,
        ExpressService $expressService,
        TrackingService $trackingService)
    {
        $this->packageRepository = $packageRepository;
        $this->logisticsService = $logisticsService;
        $this->expressService = $expressService;
        $this->trackingService = $trackingService;
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
        $this->expressService->trackInfo($tracking_code);
    }

    /**
     * 创建物流订单（获取运单号）
     * 
     * @param Reqeust $request
     * @param array
     */
    public function create(Request $request)
    {
        // 获取package
        $packages = $this->packageRepository->listByPackage(
            json_decode($request->input('package_sn'))
        );

        // 请求物流接口
        $orders = $this->trackingService->buildOrders($packages);
        $express = $this->expressService->createOrder($orders);

        // 物流信息入库
        $this->logisticsService->create($express);

        $receipt_ids = [];
        foreach ($packages as $package) {
            $receipt_ids[] = $package->item->receipt_id;
        }

        // 更改订单状态
        $receit = $this->stateMachine->operation('delivery', [
            'receipt_id' => $receipt_ids
        ]);

        // 给订单增加额外数据（物流追踪号）

        // 通知Etsy
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

        $data = $this->expressService->labels($tracking_codes);

        return $this->response->array(['data' => $data]);
    }
}
