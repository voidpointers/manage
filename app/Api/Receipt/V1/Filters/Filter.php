<?php

namespace Api\Receipt\V1\Filters;

class Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function filter($entities = 'receipt', $query = null)
    {
        switch ($entities) {
            case 'transaction':
                $instance = new TransactionFilter($query);
            break;
            case 'consignee':
                $instance = new ConsigneeFilter($query);
            break;
            default:
                $instance = new ReceiptFilter();
        }

        return $instance->filter($this->request);
    }
}
