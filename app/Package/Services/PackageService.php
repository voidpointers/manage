<?php

namespace Package\Services;

use Package\Entities\Item;
use Package\Entities\Logistics;
use Package\Entities\Package;
use Package\Filters\Filter;

class PackageService
{
    protected const STATUS = [
        'new' => 1, // 待获取物流跟踪号
        'tracked' => 2, // 已获取物流跟踪号，待打单
        'printed' => 3, // 已打单，待发货
        'shipped' => 8, // 已发货
        'closed' => 7,
    ];

    /**
     * 构造搜索语句
     * 
     * @param Request $request
     * @return 
     */
    public function query($request, $models = [])
    {
        $filter = new Filter($request);

        if (!$models) {
            $models = ['base' => 'package', 'with' => [
                    'logistics',
                    'item' => function ($query) {
                        return $query->with('transaction');
                    },
                    'consignee'
                ]
            ];
        }

        $query = $filter->filter(
            $models['base'],
            ('Package\\Entities\\' . ucfirst($models['base']))::query()
        );

        foreach ($models['with'] as $key => $model) {
            if (!$request->has('channel_id') && 'logistics' == $model) {
                continue;
            }
            if (!is_string($model)) {
                continue;
            }
            $query->whereHas($model, function ($query) use ($filter, $model) {
                return $filter->filter($model, $query);
            });
        }
        $query->with($models['with']);

        return $query;
    }

    public function create($receipts)
    {
        $packages = $items = [];

        foreach ($receipts as $receipt) {
            $package_sn = generate_package_sn();
            $packages[] = [
                'package_sn' => $package_sn,
                'receipt_sn' => $receipt->receipt_sn,
                'status' => self::STATUS['new'],
                'create_time' => time(),
                'update_time' => time(),
            ];
            foreach ($receipt->transaction as $value) {
                $items[] = [
                    'package_sn' => $package_sn,
                    'receipt_id' => $receipt->receipt_id,
                    'receipt_sn' => $receipt->receipt_sn,
                    'transaction_sn' => $value->id,
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

        return $items;
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
