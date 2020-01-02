<?php

namespace Logistics\Services;

use Package\Repositories\PackageRepository;
use Receipt\Repositories\ReceiptRepository;
use Receipt\Services\StateMachine;

class TrackingService
{
    protected $logisticsService;

    protected $stateMachine;

    protected $packageRepository;

    protected $receiptRepository;

    public function __construct(
        LogisticsService $logisticsService,
        StateMachine $stateMachine,
        PackageRepository $packageRepository,
        ReceiptRepository $receiptRepository)
    {
        $this->logisticsService = $logisticsService;
        $this->stateMachine = $stateMachine;
        $this->packageRepository = $packageRepository;
        $this->receiptRepository = $receiptRepository;
    }

    public function create($params)
    {
        // 获取package
        $packages = $this->packageRepository->listByPackage([
            array_column($params, 'package_sn')
        ]);

        // 请求物流接口
        $logistics = $this->logisticsService->createOrder([]);

        // 入库
        $this->logisticsRepository->store($logistics);

        $receipt_ids = [];
        foreach ($packages as $package) {
            $receipt_ids[] = $package->item->receipt_id;
        }

        // 更改状态
        $receit = $this->stateMachine->operation('delivery', [
            'receipt_id' => $receipt_ids
        ]);

        // 通知Etsy

        return true;
    }
}
