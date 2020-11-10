<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/task', 'TaskController@index');
        $router->get('/task/{id}', 'TaskController@show');
        $router->post('/task', 'TaskController@store');
        $router->put('/task/{id}', 'TaskController@update');
        $router->delete('/task/{id}', 'TaskController@destroy');

        $router->get('/user/me', 'UserController@me');
    });

});
