<?php

namespace Receipt\Filters;

use Dingo\Api\Http\Request;

class ReceiptFilter
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function filter(Request $request)
    {
        if ($request->get('status', 0) > 0) {
            $this->query->where('status', $request->get('status'));
        }
        if ($request->has('etsy_receipt_id')) {
            $this->query->where('etsy_receipt_id', $request->get('etsy_receipt_id'));
        }
        if ($request->has('buyer_user_id')) {
            $this->query->where('buyer_user_id', $request->get('buyer_user_id'));
        }
        if ($request->has('creation_tsz_start') || $request->has('creation_tsz_end')) {
            $this->query->creationTsz([
                $request->get('creation_tsz_start'),
                $request->get('creation_tsz_end')
            ]);
        }

        return $this->query;
    }
}
