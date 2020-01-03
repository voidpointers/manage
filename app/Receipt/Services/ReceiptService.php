<?php

namespace Receipt\Services;

use Receipt\Entties\Receipt;

class ReceiptService
{
    public function __construct()
    {
        
    }

    public function update($data)
    {
        return Receipt::updateBatch($data);
    }
}
