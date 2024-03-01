<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // Users Routes 
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->post('/',  ['uses' => 'V1\UsersController@Create']);
        $router->patch('/{id}',  ['uses' => 'V1\UsersController@Edit']);
        $router->post('/edit-avatar/{id}',  ['uses' => 'V1\UsersController@EditAvatar']);
        $router->get('/',  ['uses' => 'V1\UsersController@List']);
        $router->get('/{id}',  ['uses' => 'V1\UsersController@Detail']);
        $router->delete('/{id}',  ['uses' => 'V1\UsersController@Delete']);
    });
});
