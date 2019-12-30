<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Logistics\Requests\Request as LogisticsRequest;

class LogisticsController extends Controller
{
    protected $request;

    public function __construct(LogisticsRequest $request)
    {
        $this->request = $request;
    }

    public function lists(Request $request)
    {

    }

    public function trackInfo($tracking_code)
    {
        $this->request->instance()->trackInfo($tracking_code);
    }

    public function createOrder(Request $request)
    {
        $this->request->instance()->createOrder([]);
    }

    public function labels(Request $request)
    {
        $tracking_codes = $request->input('tracking_code', []);
        if (!is_array($tracking_codes)) {
            $tracking_codes = [$tracking_codes];
        }

        $label = $this->request->instance()->labelPrint($tracking_codes);
        return $label[0]['Url'];
    }
}
