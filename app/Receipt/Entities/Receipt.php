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
        return $this->hasMany('Receipt\Entities\Transaction', 'receipt_sn', 'receipt_sn');
    }

    public function consignee()
    {
        return $this->hasOne('Receipt\Entities\Consignee', 'receipt_sn', 'receipt_sn');
    }
}
