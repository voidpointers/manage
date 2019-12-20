<?php

namespace Receipt\Services;

use Illuminate\Support\Arr;
use Receipt\Repositories\ReceiptRepository;

class StateMachine
{
    protected const OPERATION = [
        'create',
        'follow',
        'customize',
        'pack',
        'delivery',
        'receive',
        'complete',
    ];

    protected $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepository)
    {
        $this->receiptRepository = $receiptRepository;
    }

    /**
     * 操作
     */
    public function operation($action, $data = [])
    {
        return $this->{$action}($data);
    }

    /**
     * 跟进订单
     */
    protected function follow(array $args)
    {
        return $this->receiptRepository->updateWhere([
            'receipt_id' => Arr::get('receipt_id', $args)
        ], [
            'follow_time' => time(),
            'status' => self::OPERATION['follow']
        ]);
    }
 
    /**
     * 发货
     */
    protected function delivery(array $args)
    {
        return $this->receiptRepository->updateWhere([
            'receipt_id' => Arr::get('receipt_id', $args)
        ], [
            'delivery_time' => time(),
            'status' => self::OPERATION['delivery']
        ]);
    }
 
    /**
     * 订单完成
     */
    protected function complete(array $args)
    {
        return $this->receiptRepository->updateWhere([
            'receipt_id' => Arr::get('receipt_id', $args)
        ], [
            'complete_time' => time(),
            'status' => self::OPERATION['complete']
        ]);
    }
}
