<?php

namespace Api\Receipt\V1\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Package\Entities\Logistics;
use Receipt\Entities\Receipt;

class ReceiptImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $receipt_ids = $rows->pluck('etsy_receipt_id');

        // 获取Receipts
        $receipts = Receipt::whereIn('etsy_receipt_id', $receipt_ids)
        ->get()
        ->pluck('package_sn', 'etsy_receipt_id');

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
}
