<?php

namespace Receipt\Filters;

class Filter
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function filter($models = 'receipt', $query = null)
    {
        switch ($models) {
            case 'transaction':
                $instance = new TransactionFilter($query);
            break;
            case 'consignee':
                $instance = new ConsigneeFilter($query);
            break;
            default:
                $instance = new ReceiptFilter($query);
        }

        return $instance->filter($this->request);
    }
}
