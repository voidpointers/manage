<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Receipt\Entties\Receipt;
use Receipt\Repositories\ReceiptRepository;

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
        return Receipt::with('transaction')->get();
    }

    public function headings(): array
    {
        return [
            '订单号',
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
            [
                $receipt->etsy_receipt_id,
                // Date::dateTimeToExcel($receipt->creation_tsz),
                $receipt->creation_tsz
            ],
            [
                $receipt->transaction->first()->etsy_sku,
            ],
        ];
    }
}
