<?php

namespace Api\Package\V1\Controllers;

use Dingo\Api\Http\Request;
use Package\Repositories\PackageRepository;
use Voidpointers\Yunexpress\Waybill;

class LogisticsController
{
    protected $client;

    protected $packageRepository;

    public function __construct(
        PackageRepository $packageRepository
    )
    {
        $this->client = new \Voidpointers\Yunexpress\Client();
        $this->receiptRepository = $receiptRepository;
    }

    public function createOrder(Request $request)
    {
        // 获取收据或包裹
        $receipts = $this->receiptRepository->findWhere($request->get('receipt_ids'));

        // 转换为Waybill
        $order->customerOrderNumber = '';

        return $this->client->createOrder([]);
    }

    public function trackInfo($order_number)
    {
        return $this->client->getTrackInfo($order_number);
    }

    public function transform()
    {
        $waybill = new Waybill;

        $waybill->CustomerOrderNumber = '';
        $waybill->ShippingMethodCode = '';
        $waybill->PackageCount = '';
        $waybill->Weight = '';
        $waybill->Receiver = '';
        $waybill->Parcels = '';

        return $waybill;
    }
}
