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
    
    $router->get('/findme', 'UserController@findme');
    
    $router->post('/users', 'UserController@create');
    
    $router->delete('/users/{id}', 'UserController@delete');
    
    $router->put('/users/{id}', 'UserController@update');
    
     $router->get('/users', 'UserController@findall');

    $router->get('/users/{id}', 'UserController@findone');
    
    $router->put('/changestatus/{id}', 'UserController@changestatus');
    
    $router->get('/logout', 'UserController@logoutuser');
    
});

    $router->get('/', 'AuthUserController@index');

    $router->post('/login', 'AuthUserController@authenticate');

   
    
   
    
