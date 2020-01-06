<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Express\Services\ExpressService;
use Express\Services\TrackingService;
use Package\Services\LogisticsService;
use Package\Services\PackageService;
use Receipt\Services\ReceiptService;
use Receipt\Services\StateMachine as ReceiptStateMachine;
use Package\Services\StateMachine as PackageStateMachine;

class LogisticsController extends Controller
{
    protected $logisticsService;

    protected $expressService;

    protected $trackingService;

    protected $receiptService;

    protected $packageService;

    protected $receiptStateMachine;

    protected $packageStateMachine;

    public function __construct(
        LogisticsService $logisticsService,
        ExpressService $expressService,
        TrackingService $trackingService,
        ReceiptService $receiptService,
        PackageService $packageService,
        ReceiptStateMachine $receiptStateMachine,
        PackageStateMachine $packageStateMachine)
    {
        $this->logisticsService = $logisticsService;
        $this->expressService = $expressService;
        $this->trackingService = $trackingService;
        $this->receiptService = $receiptService;
        $this->packageService = $packageService;
        $this->receiptStateMachine = $receiptStateMachine;
        $this->packageStateMachine = $packageStateMachine;
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

        // 更改包裹状态
        $status = $this->packageStateMachine->operation('dispatch', [
            'package_sn' => $package_sn
        ]);

        $items = array_map(function ($package) {
            $data = [];
            foreach ($package['item'] as $item) {
                $data[] = ['receipt_id' => $item['receipt_id'],];
            }
            return $data;
        }, $packages->toArray());
        
        $receipt_ids = [];
        foreach ($items as $item) {
            foreach ($item as $val) {
                $receipt_ids[] = $val['receipt_id'];
            }
        }

        // 更改订单状态
        $status = $this->receiptStateMachine->operation('dispatch', [
            'id' => array_unique($receipt_ids)
        ]);

        // 通知Etsy
        return ['msg' => 'success'];
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
