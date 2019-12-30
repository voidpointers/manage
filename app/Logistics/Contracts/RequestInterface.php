<?php

namespace Logistics\Contracts;

interface RequestInterface
{
    public function trackInfo($tracking_code = '');

    public function createOrder($params = []);
}
