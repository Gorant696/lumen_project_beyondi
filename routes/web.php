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
$router->group(['middleware' => 'auth'], function () use ($router) {
    
    $router->get('/findme', 'AuthUserController@findme');
    
    $router->post('/createuser', 'AdminController@create');
    
    $router->delete('/deleteuser/{id}', 'AdminController@delete');
    
    $router->put('/edituser/{id}', 'AdminController@update');
    
    $router->put('/changestatus/{id}', 'AdminController@changestatus');
});

    $router->get('/', 'UserController@index');

    $router->post('/login', 'UserController@authenticate');

    $router->get('/users', 'UserController@findall');

    $router->get('/user/{id}', 'UserController@findone');

