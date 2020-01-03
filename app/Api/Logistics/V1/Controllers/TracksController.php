<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Logistics\Services\LogisticsService;
use Logistics\Services\TrackingService;
use Package\Repositories\PackageRepository;
use Receipt\Services\StateMachine;

class TracksController extends Controller
{
    protected $packageRepository;

    protected $logisticsService;

    protected $trackingService;

    protected $stateMachine;

    public function __construct(
        PackageRepository $packageRepository,
        LogisticsService $logisticsService,
        TrackingService $trackingService,
        StateMachine $stateMachine)
    {
        $this->packageRepository = $packageRepository;
        $this->logisticsService = $logisticsService;
        $this->trackingService = $trackingService;
        $this->stateMachine = $stateMachine;
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
        $logistics = $this->logisticsService->createOrder($orders);

        // 物流信息入库
        $this->logisticsRepository->store($logistics);

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
}
