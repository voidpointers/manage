<?php

namespace Receipt\Filters;

use App\QueryFilter;

trait ReceiptFilter
{
    use QueryFilter;

    public function receiptSn($receipt_sn)
    {
        return $this->builder->where('receipt_sn', $receipt_sn);
    }

    public function etsyReceiptId($etsy_receipt_id)
    {
        return $this->builder->where('etsy_receipt_id', $etsy_receipt_id);
    }

    public function status($status)
    {
        return $this->builder->where('status', $status);
    }

    public function isFollow($is_follow)
    {
        return $this->builder->where('is_follow', $is_follow);
    }

    public function buyerUserId($user_id)
    {
        return $this->builder->where('buyer_user_id', $user_id);
    }

    public function createionTsz()
    {
        return $this->builder->where();
    }

    public function transactions()
    {

    }

    public function consignee($name)
    {
        return $this->builder->whereHas('consignee', function ($query) use ($name) {
            return $query->where('name', $name);
        });
    }

    public function countryId($country_id)
    {
        return $this->builder->whereHas('consignee', function ($query) use ($country_id) {
            return $query->where('country_id', $country_id);
        });
    }

    public function etsySku($params)
    {
        return $this->builder->whereHas('transaction', function ($query) use ($params) {
            return $query->where('etsy_sku', $params);
        });
    }

    public function localSku($local_sku)
    {
        return $this->builder->whereHas('transaction', function ($query) use ($local_sku) {
            return $query->where('local_sku', $$params);
        });
    }
}
