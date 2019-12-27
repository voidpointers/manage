<?php

namespace Api\Receipt\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Receipt\Entties\Receipt;

class ReceiptTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'consignee', 'transaction'
    ];

    public function transform(Receipt $receipt)
    {
        return $receipt->attributesToArray();
    }

    /**
     * Include Consignee
     *
     * @param Receipt $receipt
     * @return \League\Fractal\Resource\Item
     */
    public function includeConsignee(Receipt $receipt)
    {
        return $this->item(
            $receipt->consignee,
            new ConsigneeTransformer,
            'include'
        );
    }

    /**
     * Include Transaction
     *
     * @param Receipt $receipt
     * @return \League\Fractal\Resource\Item
     */
    public function includeTransaction(Receipt $receipt)
    {
        return $this->collection(
            $receipt->transaction,
            new TransactionTransformer,
            'include'
        );
    }
}
