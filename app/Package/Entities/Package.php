<?php

namespace Package\Entities;

use App\Model;
use Receipt\Entities\Consignee;

class Package extends Model
{
    protected $appends = ['status_str', 'shop_title'];

    protected const STATUS = [
        1 => '待发货',
        2 => '待打单',
        7 => '已取消',
        8 => '已发货',
    ];

    public function consignee()
    {
        return $this->hasOne(Consignee::class, 'id', 'consignee_id');
    }

    public function item()
    {
        return $this->hasMany(Item::class, 'package_sn', 'package_sn');
    }

    public function logistics()
    {
        return $this->hasOne(Logistics::class, 'package_sn', 'package_sn');
    }

    public function getStatusStrAttribute()
    {
        return self::STATUS[$this->attributes['status']];
    }

    public function getShopTitleAttribute()
    {
        return '水晶玛姬';
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreateTime($query, $create_time)
    {
        return $query->whereBetween('create_time', $create_time);
    }
}
