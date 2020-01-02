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
        'stockout',
        'delivery',
        'cancel',
        'receive',
        'complete',
        'close',
    ];

    protected $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepository)
    {
        $this->receiptRepository = $receiptRepository;
    }

    /**
     * 操作
     */
    public function operation($action, $where = [], $data = [])
    {
        return $this->{$action}($where, $data);
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
    protected function delivery(array $args, $data)
    {
        return $this->receiptRepository->updateWhere([
            'receipt_id' => Arr::get('receipt_id', $args)
        ], array_merge([
            'delivery_time' => time(),
            'status' => self::OPERATION['delivery']
        ], $data));
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
