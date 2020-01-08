<?php

namespace Package\Filters;

use Dingo\Api\Http\Request;

class PackageFilter
{
    protected $query;

    protected const STATUS = [
        'new' => 1,
        'tracked' => 2,
        'printed' => 3,
        'shipped' => 8,
        'closed' => 7,
    ];

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function filter(Request $request)
    {
        $status = self::STATUS[$request->get('status', '')] ?? '';
        if ($status) {
            $this->query->where('status', $status);
        }
        if ($request->has('create_time_start') || $request->has('create_time_end')) {
            $this->query->createTime([
                $request->get('create_time_start'),
                $request->get('create_time_end')
            ]);
        }

        return $this->query;
    }
}
