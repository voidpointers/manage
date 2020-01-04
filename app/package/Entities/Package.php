<?php

namespace Package\Entities;

use App\Model;
use Receipt\Entities\Consignee;

class Package extends Model
{
    public function consignee()
    {
        return $this->hasOne(Consignee::class, 'id', 'consignee_id');
    }

    public function item()
    {
        return $this->hasMany(Item::class, 'package_sn', 'package_sn');
    }
}
