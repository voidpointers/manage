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
        return true;
    }
}
