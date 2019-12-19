<?php

namespace Receipt\Entities;

use App\Model;

class Transaction extends Model
{
    protected $table = 'receipt_transactions';

    /**
     * Get the transaction's title.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        $attributes = json_decode($this->attributes['attributes'], true) ?? [];
        return implode(' - ', array_values($attributes));
    }
}
