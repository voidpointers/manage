<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Express\Services\ExpressService;
use Express\Services\TrackingService;
use Package\Services\LogisticsService;
use Package\Services\PackageService;
use Receipt\Services\ReceiptService;
use Receipt\Services\StateMachine;

class LogisticsController extends Controller
{
    protected $logisticsService;

    protected $expressService;

    protected $trackingService;

    protected $receiptService;

    protected $packageService;

    protected $stateMachine;

    public function __construct(
        LogisticsService $logisticsService,
        ExpressService $expressService,
        TrackingService $trackingService,
        ReceiptService $receiptService,
        PackageService $packageService,
        StateMachine $stateMachine)
    {
        $this->logisticsService = $logisticsService;
        $this->expressService = $expressService;
        $this->trackingService = $trackingService;
        $this->receiptService = $receiptService;
        $this->packageService = $packageService;
        $this->stateMachine = $stateMachine;
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
        $package_sn = json_decode($request->input('package_sn'));
        $channel = $request->input('channel', '');

        // 获取package
        $packages = $this->packageService->lists($package_sn);

        // 请求物流接口
        $orders = $this->trackingService->buildOrders($packages, $channel);
        $express = $this->expressService->createOrder($orders);

        // 物流信息入库
        $this->logisticsService->create($express);

        $receipts = array_map(function ($package) {
            return [
                'receipt_id' => $package->item->receipt_id,
            ];
        }, $packages);

        $receipt_ids = [];
        foreach ($packages as $package) {
            $receipt_ids[] = $package->item->receipt_id;
        }

        // 更改订单状态
        $status = $this->stateMachine->operation('dispatch', [
            'id' => $receipt_ids
        ]);

        // 给订单增加额外数据（物流追踪号）
        // $receipt = $this->receiptService->update();

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
