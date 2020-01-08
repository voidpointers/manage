<?php

namespace Package\Filters;

use Dingo\Api\Http\Request;

class LogisticsFilter
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;   
    }

    public function filter(Request $request)
    {
        if ($request->has('provider_id')) {
            $this->query->where('provider_id', $request->get('provider_id'));
        }
        if ($request->has('channel_id')) {
            $this->query->where('channel_id', $request->get('channel_id'));
        }

        return $this->query;
    }
}
