<?php

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

/* root */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function ($router) {
    /* login & register */
    $router->post('/login', 'UserController@login');
    $router->post('/register', 'UserController@store');

    $router->group(['middleware' => 'auth'], function ($router) {
        /* templates */
        $router->get('/templates', 'TemplateController@index');
        $router->get('/templates/{id}', 'TemplateController@show');
        $router->post('/templates', 'TemplateController@store');
        $router->patch('/templates/{id}', 'TemplateController@update');
        $router->delete('/templates/{id}', 'TemplateController@destroy');
    });
});
