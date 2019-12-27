<?php

namespace Api\Receipt\V1\Filters;

use Dingo\Api\Http\Request;
use Receipt\Entities\Consignee;

class ConsigneeFilter
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;   
    }

    public function filter(Request $request)
    {
        if ($request->has('consignee')) {
            $this->query->where('name', $request->get('consignee'));
        }

        return $this->query;
    }
}
