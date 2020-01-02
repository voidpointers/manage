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
        if ($request->has('country_id')) {
            $this->query->where('country_id', $request->get('country_id'));
        }

        return $this->query;
    }
}
