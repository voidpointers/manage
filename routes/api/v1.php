<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Receipt\V1\Controllers',
        'prefix' => 'receipts',
    ], function ($api) {
        $api->get('lists', 'ReceiptsController@lists');
        $api->get('export', 'ReceiptsController@export');
    });
    $api->group([
        'namespace' => 'Api\Package\V1\Controllers',
        'prefix' => 'packages',
    ], function ($api) {
        $api->get('track/info/{order_number}', 'LogisticsController@trackInfo');
    });
    $api->group([
        'namespace' => 'Api\Logistics\V1\Controllers',
        'prefix' => 'logistics',
    ], function ($api) {
        $api->post('label/lists', 'LogisticsController@labels');
        $api->get('provider/lists', 'ProvidersController@lists');
        $api->get('track/info/{order_number}', 'LogisticsController@trackInfo');
    });
});
