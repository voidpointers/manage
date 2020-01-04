<?php

namespace Receipt\Entities;

use App\Model;
use Receipt\Entities\Receipt;

class Transaction extends Model
{
    protected $table = 'receipt_transactions';

    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'receipt_sn', 'receipt_sn');
    }

    public function consignee()
    {
        return $this->belongsTo(Consignee::class, 'receipt_sn', 'receipt_sn');
    }

    public function scopeShippedTsz($query, $shipped_tsz)
    {
        return $query->whereBetween('shipped_tsz', $shipped_tsz);
    }

    public function getVariationsAttribute()
    {
        return json_decode($this->attributes['variations'], true) ?? '';
    }
}
