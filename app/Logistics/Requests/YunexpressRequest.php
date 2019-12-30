<?php

namespace Logistics\Requests;

class YunexpressRequest
{
    protected $client;

    public function __construct()
    {
        $this->client = new \Voidpointers\Yunexpress\Client();
    }

    public function trackInfo($order_number)
    {
        return $this->client->getTrackInfo($order_number);
    }

    public function createOrder(Request $request)
    {

        // 转换为Waybill
        $order->customerOrderNumber = '';

        return $this->client->createOrder([]);
    }
}
