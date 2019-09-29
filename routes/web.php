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

    $router->group(['middleware' => 'auth'], function ($router) {
        /* templates */
        $router->get('/templates', 'TemplateController@index');
        $router->get('/templates/{id}', 'TemplateController@show');
        $router->post('/templates', 'TemplateController@store');
        $router->patch('/templates/{id}', 'TemplateController@update');
        $router->delete('/templates/{id}', 'TemplateController@destroy');

        /* checklist items */
        $router->get('/checklists/items', 'ItemController@index');
        $router->get('/checklists/{id}/items', 'ItemController@indexByChecklist');
        $router->get('/checklists/{id}/items/{item_id}', 'ItemController@show');
        $router->post('/checklists/{id}/items', 'ItemController@store');
        $router->patch('/checklists/{id}/items/{item_id}', 'ItemController@update');
        $router->delete('/checklists/{id}/items/{item_id}', 'ItemController@destroy');
        $router->post('/checklists/complete', 'ItemController@complete');
        $router->post('/checklists/uncomplete', 'ItemController@uncomplete');

        /* checklists */
        $router->get('/checklists', 'ChecklistController@index');
        $router->get('/checklists/{id}', 'ChecklistController@show');
        $router->post('/checklists', 'ChecklistController@store');
        $router->patch('/checklists/{id}', 'ChecklistController@update');
        $router->delete('/checklists/{id}', 'ChecklistController@destroy');
    });
});
