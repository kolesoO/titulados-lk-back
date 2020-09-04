<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(["namespace" => "Api\V1", "prefix" => "/v1",], function() {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'RegisterController@register');
});

Route::middleware('auth:api')
    ->group(static function () {
        Route::group(["namespace" => "Api\V1", "prefix" => "/v1",], function() {
            Route::get('me', 'UserController@me');
            Route::post('me', 'UserController@updateMe');
            Route::post('change-password', 'UserController@changePassword');

            Route::group(['prefix' => 'subject-group'], function (Router $router) {
                $router->get('', 'SubjectGroupController@index');
                $router->post('', 'SubjectGroupController@store');
                $router->group(['prefix' => '{groupId}'], function (Router $router) {
                    $router->get('', 'SubjectGroupController@show');

                    $router->group(['prefix' => 'subject'], function (Router $router) {
                        $router->get('', 'SubjectController@index');
                        $router->post('', 'SubjectController@store');
                    });
                });
            });

            Route::group(['prefix' => 'my', 'as' => 'my.'], function (Router $router) {
                $router->get('orders', 'OrderController@my');
                $router->post('orders', 'OrderController@storeMy');
                $router->group(['prefix' => 'orders/{orderId}'], function (Router $router) {
                    $router->get('', 'OrderController@showMy');
                    $router->post('', 'OrderController@updateMy');
                    $router->group(['prefix' => 'parts'], function (Router $router) {
                        $router->group(['prefix' => '{orderPartId}'], function (Router $router) {
                            $router->get('docs', 'OrderDocController@my');
                            $router->post('docs', 'OrderDocController@storeMy');
                        });
                    });
                    $router->group(['prefix' => 'messages'], function (Router $router) {
                        $router->post('', 'MessageController@store');
                    });
                });
            });
        });
    });
