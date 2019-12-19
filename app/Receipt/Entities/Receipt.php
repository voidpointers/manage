<?php

namespace Receipt\Entties;

use Illuminate\Database\Eloquent\Model;

/**
 * 收据模型
 * 
 * @author bryan <voidpointers@hotmail.com>
 */
class Receipt extends Model
{
    public function transaction()
    {
        return $this->hasMany('Receipt\Entities\Transaction', 'receipt_id', 'receipt_id');
    }

    public function consignee()
    {
        return $this->hasOne('Receipt\Entities\Consignee', 'receipt_id', 'receipt_id');
    }
}
