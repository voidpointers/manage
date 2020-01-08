<?php

namespace Package\Services;

use Package\Entities\Item;
use Package\Entities\Logistics;
use Package\Entities\Package;

class PackageService
{
    protected const STATUS = [
        'new' => 1, // 待获取物流跟踪号
        'tracked' => 2, // 已获取物流跟踪号，待打单
        'printed' => 3, // 已打单，待发货
        'shipped' => 8, // 已发货
        'closed' => 7,
    ];

    public function create($receipts)
    {
        $packages = $items = [];

        foreach ($receipts as $receipt) {
            $pacakge_sn = generate_package_sn();
            $packages[] = [
                'package_sn' => $pacakge_sn,
                'consignee_id' => $receipt->consignee->id,
                'status' => self::STATUS['pending'],
                'create_time' => time(),
                'update_time' => time(),
            ];
            foreach ($receipt->transaction as $value) {
                $items[] = [
                    'package_sn' => $pacakge_sn,
                    'etsy_receipt_id' => $receipt->etsy_receipt_id,
                    'receipt_id' => $receipt->id,
                    'transaction_id' => $value->id,
                    'title' => '桌游用品',
                    'en' => 'Table Game',
                    'price' => '1.98',
                    'weight' => '0.198',
                    'quantity' => $value->quantity,
                ];
            }
        }
        Package::insert($packages);
        Item::insert($items);

        return $packages;
    }

    public function logistics($where)
    {
        $query = Logistics::query();

        foreach ($where as $key => $value) {
            if ('in' == $key) {
                foreach ($value as $k => $val) {
                    $query->whereIn($k, $val);
                }
            }
        }

        return $query->whereHas('package', function ($query) use ($where) {
            return $query->where($where['where']);
        })->with(['package'])->get();
    }

    public function lists($where)
    {
        $query = Package::query();

        foreach ($where as $key => $value) {
            if ('in' == $key) {
                foreach ($value as $k => $val) {
                    $query->whereIn($k, $val);
                }
            } else {
                $query->where($value);
            }
        }

        return $query->with(['consignee', 'item'])->get();
    }

    public function items($pacakge_sn)
    {
        return Item::whereIn('package_sn', $pacakge_sn)->get();
    }
}
