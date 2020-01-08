<?php

namespace Package\Filters;

class Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function filter($models = 'package', $query = null)
    {
        switch ($models) {
            case 'logistics':
                $instance = new LogisticsFilter($query);
            break;
            case 'consignee':
                $instance = new ConsigneeFilter($query);
            break;
            default:
                $instance = new PackageFilter($query);
        }

        return $instance->filter($this->request);
    }
}
