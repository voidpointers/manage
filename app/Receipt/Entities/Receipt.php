<?php

namespace Receipt\Entties;

use App\Model;

/**
 * 收据模型
 * 
 * @author bryan <voidpointers@hotmail.com>
 */
class Receipt extends Model
{
    public function transaction()
    {
        return $this->hasMany('Receipt\Entities\Transaction', 'receipt_sn', 'receipt_sn');
    }

    public function consignee()
    {
        return $this->hasOne('Receipt\Entities\Consignee', 'receipt_sn', 'receipt_sn');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreationTsz($query, $creation_tsz)
    {
        return $query->whereBetween('creation_tsz', $creation_tsz);
    }
}
