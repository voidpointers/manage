<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;
use Receipt\Entities\Transaction;

class ReceiptsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'receipts.xlsx';

    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;

    // protected $receiptRepository;

    public function __construct()
    {

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::with('receipt')->get();
    }

    public function headings(): array
    {
        return [
            'Etsy订单号',
            'Etsy SKU',
            '库存属性',
            '库存SKU',
            '购买数量',
            '订单状态',
            '下单时间'
        ];
    }

    /**
    * @var Receipt $receipt
    */
    public function map($receipt): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
            $receipt->etsy_receipt_id,
            $receipt->etsy_sku,
            $receipt->attributes,
            $receipt->local_sku,
            $receipt->quantity,
            $receipt->receipt->status,
            $receipt->receipt->creation_tsz
            // Date::dateTimeToExcel($receipt->creation_tsz),
        ];
    }
}
