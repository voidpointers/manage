<?php

namespace Api\Receipt\V1\Filters;

use Dingo\Api\Http\Request;
use Receipt\Entties\Receipt;

class ReceiptFilter
{
    public function filter(Request $request)
    {
        $query = Receipt::query();

        if ($request->get('status', 0) > 0) {
            $query->where('status', $request->get('status'));
        }
        if ($request->has('receipt_id')) {
            $query->where('etsy_receipt_id', $request->get('receipt_id'));
        }
        if ($request->has('creation_tsz_start') || $request->has('creation_tsz_end')) {
            $query->creationTsz([
                $request->get('creation_tsz_start'),
                $request->get('creation_tsz_end')
            ]);
        }

        if ($request->has('consignee')) {
            $consignee['name'] = $request->get('consignee');
        }

        return $query;
    }
}
