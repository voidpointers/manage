<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Receipt\V1\Controllers',
        'prefix' => 'receipts',
    ], function ($api) {
        $api->get('lists', 'ReceiptsController@lists');
        $api->get('export', 'ReceiptsController@export');
        $api->get('packup', 'ReceiptsController@packUp');
        $api->get('delivery', 'ReceiptsController@delivery');
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
        $api->get('provider/lists', 'ProvidersController@lists');
        $api->get('channel/lists', 'ChannelsController@lists');
        $api->get('tracking/info/{order_number}', 'LogisticsController@trackInfo');
        $api->post('label/lists', 'LogisticsController@labels');
        $api->post('tracking/create', 'TracksController@create');
    });
    $api->group([
        'namespace' => 'Api\System\V1\Controllers',
        'prefix' => 'systems',
    ], function ($api) {
        $api->get('country/lists', 'CountriesController@lists');
    });
});
