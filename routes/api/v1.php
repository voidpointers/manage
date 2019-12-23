<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Receipt\V1\Controllers',
        'prefix' => 'receipts',
    ], function ($api) {
        $api->get('lists', 'ReceiptsController@lists');
        $api->group([
            'middleware' => 'api.auth'
        ], function ($api) {
            $api->get('info', 'UsersController@info');
            $api->get('refresh', 'UsersController@refresh');
            $api->get('logout', 'AuthorizationsController@logout');
        });
    });
    $api->group([
        'namespace' => 'Api\Package\V1\Controllers',
        'prefix' => 'packages',
    ], function ($api) {
        $api->get('track/info/{order_number}', 'LogisticsController@trackInfo');
    });
});
