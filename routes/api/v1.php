<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Receipt\V1\Controllers',
        'prefix' => 'receipts',
    ], function ($api) {
        $api->get('lists', 'ReceiptsController@lists');
        $api->get('export', 'ReceiptsController@export');
        $api->post('packup', 'ReceiptsController@packUp');
        $api->post('dispatch', 'ReceiptsController@delivery');
        $api->post('close', 'ReceiptsController@close');
    });
    $api->group([
        'namespace' => 'Api\Package\V1\Controllers',
        'prefix' => 'packages',
    ], function ($api) {
        $api->get('tracking/info/{order_number}', 'LogisticsController@trackInfo');
        $api->post('label/lists', 'LogisticsController@labels');
        $api->post('logistics/create', 'LogisticsController@create');
    });
    $api->group([
        'namespace' => 'Api\Logistics\V1\Controllers',
        'prefix' => 'logistics',
    ], function ($api) {
        $api->get('provider/lists', 'ProvidersController@lists');
        $api->get('channel/lists', 'ChannelsController@lists');
    });
    $api->group([
        'namespace' => 'Api\System\V1\Controllers',
        'prefix' => 'systems',
    ], function ($api) {
        $api->get('country/lists', 'CountriesController@lists');
    });
});
