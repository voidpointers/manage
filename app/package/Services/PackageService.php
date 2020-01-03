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
            $packages[] = [
                'package_sn' => generate_package_sn(),
                'consignee_id' => $receipt->consignee->id,
                'status' => self::STATUS['pending'],
                'create_time' => time(),
                'update_time' => time(),
            ];
            foreach ($receipt->transaction as $value) {
                $items[] = [
                    'receipt_id' => $receipt->receipt_id,
                    'transaction_id' => $value->id,
                    'title' => '桌游用品',
                    'en' => 'Table Game',
                    'price' => '1.98',
                    'weight' => '0.198',
                    'quantity' => $value->quantity,
                    'relations' => '',
                ];
            }
        }
        Package::insert($packages);
        Item::insert($items);
    }
}
