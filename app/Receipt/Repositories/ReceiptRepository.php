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
    public function model()
    {
        return Receipt::class;
    }
}
