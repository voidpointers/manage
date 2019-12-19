<?php

namespace App;

use Illuminate\Database\Eloquent\Model as IlluminateModel;

/**
 * 模型基类
 *
 * @author bryan <voidpointers@hotmail.com>
 */
class Model extends IlluminateModel
{
    /**
     * 时间格式
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'create_time' => 'int',
        'update_time' => 'int',
    ];

    /**
     * 限制批量更新字段
     */
    protected $guarded = [];

    /**
     * 创建时间
     */
    const CREATED_AT = 'create_time';

    /**
     * 更新时间
     */
    const UPDATED_AT = 'update_time';
}
