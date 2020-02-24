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
$router->group(['middleware' => 'cors'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->group(['as' => 'user', 'prefix' => 'user'], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'UserController@index']);
        $router->post('/create', ['as' => 'create', 'uses' => 'UserController@create']);
    });

    $router->group(['as' => 'book', 'prefix' => 'book'], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'BookController@index']);
        $router->post('/create', ['as' => 'create', 'uses' => 'BookController@create']);
    });

    $router->group(['as' => 'receipt', 'prefix' => 'receipt'], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'ReceiptController@index']);
        $router->get('/fetch', ['as' => 'fetch', 'uses' => 'ReceiptController@fetch']);
        $router->post('/create', ['as' => 'create', 'uses' => 'ReceiptController@create']);
        $router->delete('/remove', ['as' => 'remove', 'uses' => 'ReceiptController@remove']);
    });
});
