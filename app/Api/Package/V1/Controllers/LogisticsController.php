<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Express\Services\ExpressService;
use Logistics\Repositories\ProviderRepository;
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

    protected $providerRepository;

    public function __construct(
        LogisticsService $logisticsService,
        ExpressService $expressService,
        ReceiptService $receiptService,
        PackageService $packageService,
        ReceiptStateMachine $receiptStateMachine,
        PackageStateMachine $packageStateMachine,
        ProviderRepository $providerRepository)
    {
        $this->logisticsService = $logisticsService;
        $this->expressService = $expressService;
        $this->receiptService = $receiptService;
        $this->packageService = $packageService;
        $this->receiptStateMachine = $receiptStateMachine;
        $this->packageStateMachine = $packageStateMachine;
        $this->providerRepository = $providerRepository;
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
        $channel_code = $request->input('channel', '');

        // 获取物流商信息
        $provider = $this->providerRepository->whereHas('channel',
            function ($query) use ($channel_code) {
                return $query->where('channel_code', $channel_code);
            }
        )->with(['channel'])->get();
        
        if ($provider->isEmpty()) {
            return $this->response->error('当前物流不支持', 500);
        }

        // 获取package
        $packages = $this->packageService->lists([
            'in' => ['package_sn' => $package_sn],
            'where' => ['status' => 1]
        ]);
        if ($packages->isEmpty()) {
            return $this->response->error("当前没有需要获取物流单号的包裹", 500);
        }
        $package_sn = $packages->pluck('package_sn')->toArray();

        // 请求物流接口
        $express = $this->expressService->createOrder($packages, $channel_code);

        // 物流信息入库
        $this->logisticsService->create($express, $provider);

        // 更改包裹状态
        $status = $this->packageStateMachine->operation('track', [
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

        return $this->response->array(['data' => $express]);
    }

    /**
     * 获取面单
     * 
     * @param Request $request
     * @return array
     */
    public function labels(Request $request)
    {
        $tracking_codes = $request->input('tracking_code', '');
        if (!$tracking_codes) {
            return $this->response->error('', 500);
        }
        $tracking_codes = json_decode($tracking_codes);

        $data = $this->expressService->labels($tracking_codes);

        // 获取包裹列表
        $logistics = $this->packageService->logistics([
            'in' => ['tracking_code' => $tracking_codes],
            'where' => ['status' => 2]
        ]);

        if (!$logistics->isEmpty()) {
            $package_sn = ($logistics->pluck('package_sn')->toArray());
            // 更改包裹状态
            $this->packageStateMachine->operation('print', [
                'package_sn' => $package_sn
            ]);
        }

        return $this->response->array(['data' => $data]);
    }
}
