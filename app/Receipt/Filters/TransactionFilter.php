<?php

namespace Receipt\Filters;

use Dingo\Api\Http\Request;

class TransactionFilter
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;       
    }

    public function filter(Request $request)
    {
        if ($request->has('etsy_sku')) {
            $this->query->where('etsy_sku', $request->get('etsy_sku'));
        }
        if ($request->has('local_sku')) {
            $this->query->where('local_sku', $request->get('local_sku'));
        }
        if ($request->has('shipped_tsz_start') || $request->has('shipped_tsz_end')) {
            $this->query->shippedTsz([
                $request->get('shipped_tsz_start'),
                $request->get('shipped_tsz_end')
            ]);
        }

        return $this->query;
    }
}
