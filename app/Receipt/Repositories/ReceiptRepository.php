<?php

namespace Receipt\Repositories;

use App\Repository;
use Receipt\Contracts\ReceiptInterface;
use Receipt\Entties\Receipt;

/**
 * 收据仓库
 * 
 * @author bryan <voidpointers@hotmail.com>
 */
class ReceiptRepository extends Repository implements ReceiptInterface
{
    protected $fieldSearchable = [
        'etsy_receipt_id',
        'creation_tsz'
    ];

    public function model()
    {
        return Receipt::class;
    }
}
