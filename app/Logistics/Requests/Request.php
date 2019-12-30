<?php

namespace Logistics\Requests;

class Request
{
    public function instance($provider = 'yuntu')
    {
        switch($provider) {
            case 'yuntu':
                $instance = new YunexpressRequest;
            break;
        }

        return $instance;
    }
}
