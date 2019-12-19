<?php

namespace Api\Receipt\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Receipt\Entties\Receipt;

class ReceiptTransformer extends TransformerAbstract
{
    public function transform(Receipt $receipt)
    {
        return $receipt->attributesToArray();
    }
}
