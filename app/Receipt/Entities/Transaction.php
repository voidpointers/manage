<?php

namespace Receipt\Entities;

use App\Model;
use Receipt\Entties\Receipt;

class Transaction extends Model
{
    protected $table = 'receipt_transactions';

    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'receipt_sn', 'receipt_sn');
    }

    public function scopeShippedTsz($query, $shipped_tsz)
    {
        return $query->whereBetween('shipped_tsz', $shipped_tsz);
    }

    /**
     * Get the transaction's title.
     *
     * @return string
     */
    // public function getTitleAttribute()
    // {
    //     $attributes = json_decode($this->attributes['attributes'], true) ?? [];
    //     return implode(' - ', array_values($attributes));
    // }

    public function getVariationsAttribute()
    {
        return json_decode($this->attributes['variations'], true) ?? '';
    }
}
