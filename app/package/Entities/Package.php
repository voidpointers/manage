<?php

namespace Package\Entities;

use App\Model;
use Receipt\Entities\Consignee;

class Package extends Model
{
    public function consignee()
    {
        return Consignee::class;
    }
}
