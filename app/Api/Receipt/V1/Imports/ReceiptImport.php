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
        $receipts = Receipt::whereIn('etsy_receipt_id', $receipt_ids)
        ->get()
        ->pluck('package_sn', 'etsy_receipt_id');
        if ($receipts->isEmpty()) {
            throw new \RuntimeException('订单不存在');
        }

        $logistics = [];

        foreach ($rows as $row) {
            $receipt = $receipts[$row['etsy_receipt_id']];
            if (!$receipt['package_sn']) {
                continue;
            }

            $logistics[] = [
                'tracking_code' => $row['tracking_code'],
                'package_sn' => $receipt['package_sn'],
                'provider' => $row['provider']
            ];
        }
        if (!$logistics) {
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
