<?php

namespace Receipt\Repositories;

use App\Repository;
use Receipt\Contracts\ReceiptInterface;
use Receipt\Entties\Receipt;
use Receipt\Services\StateMachine;

/**
 * 收据仓库
 * 
 * @author bryan <voidpointers@hotmail.com>
 */
class ReceiptRepository extends Repository implements ReceiptInterface
{
    protected $stateMachine;

    public function __construct(StateMachine $stateMachine)
    {
        $this->stateMachine = $stateMachine;
    }

    protected $fieldSearchable = [
        'etsy_receipt_id',
        'creation_tsz'
    ];

    public function model()
    {
        return Receipt::class;
    }

    public function delivery(array $params)
    {

        Receipt::where([''])->update([

        ]);
    }
}
