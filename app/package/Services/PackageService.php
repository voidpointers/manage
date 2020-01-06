<?php

namespace Package\Services;

use Package\Entities\Item;
use Package\Entities\Package;

class PackageService
{
    protected const STATUS = [
        'pending' => 1
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
    }

    public function lists($pacakge_sn)
    {
        return Package::whereIn('package_sn', $pacakge_sn)->with(['consignee', 'item'])->get();
    }

    public function items($pacakge_sn)
    {
        return Item::whereIn('package_sn', $pacakge_sn)->get();
    }
}
