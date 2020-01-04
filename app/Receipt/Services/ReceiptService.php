<?php

namespace Receipt\Services;

use Receipt\Filters\Filter;
use Receipt\Entities\Receipt;
use Receipt\Entities\Transaction;
use Receipt\Entities\Consignee;

class ReceiptService
{
    public function updateReceipt($data)
    {
        return Receipt::updateBatch($data);
    }

    public function updateTransaction($data)
    {
        return Transaction::updateBatch($data);
    }

    public function updateConsignee($data)
    {
        return Consignee::updateBatch($data);
    }

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
            $models = ['base' => 'receipt', 'with' => ['transaction', 'consignee']];
        }

        $query = $filter->filter(
            $models['base'],
            ('Receipt\\Entities\\' . ucfirst($models['base']))::query()
        );

        foreach ($models['with'] as $model) {
            $query->whereHas($model, function ($query) use ($filter, $model) {
                return $filter->filter($model, $query);
            });
        }
        $query->with($models['with']);

        return $query;
    }

    public function listsByIds($ids)
    {
        return Receipt::whereIn('id', $ids)->with(['consignee', 'transaction'])->get();
    }
}
