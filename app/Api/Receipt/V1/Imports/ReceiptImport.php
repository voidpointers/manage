<?php

namespace Api\Receipt\V1\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Package\Entities\Logistics;
use Receipt\Entities\Receipt;

// class ReceiptImport implements ToCollection, WithHeadingRow
class ReceiptImport implements ToCollection, WithStartRow
{
    public function collection(Collection $rows)
    {
        $receipt_ids = $rows->map(function ($row) {
            return $row[0];
        });

        // 获取Receipts
        $receipts = Receipt::whereIn('receipt_id', $receipt_ids)
        ->get()
        ->pluck('package_sn', 'receipt_id');
        if ($receipts->isEmpty()) {
            throw new \RuntimeException('订单不存在');
        }
        dump($receipts);

        $logistics = [];

        foreach ($rows as $row) {
            $receipt = $receipts[$row[0]];
            if (!$receipt['package_sn']) {
                continue;
            }

            $logistics[] = [
                'tracking_code' => $row[3],
                'package_sn' => $receipt['package_sn'],
                'provider' => $row[2]
            ];
        }
        if (!$logistics) {
            throw new \RuntimeException('包裹不存在');
            return [];
        }

        Receipt::whereIn('receipt_id', $receipt_ids)->update([
            'status' => 8, 'complete_time' => time(), 'dispatch_time' => time()
        ]);

        Logistics::create($logistics);
    }

    public function startRow(): int
    {
        return 2;
    }
}
