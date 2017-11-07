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
    
    $router->get('/findme', [
        'roles' => ['admin', 'employee', 'moderator'],
        'uses' => 'UserController@findme'
    ]);
    
    $router->post('/users', [
        'roles' => ['admin', 'moderator'],
        'uses' => 'UserController@create'
    ]);
    
    $router->delete('/users/{id}', [
        'roles' => ['admin'],
        'uses' => 'UserController@delete'
    ]);
    
    $router->put('/users/{id}', [
        'roles' => ['admin', 'moderator'],
        'uses' => 'UserController@update'
    ]);
    
     $router->get('/users', [
        'roles' => ['admin', 'employee', 'moderator'],
        'uses' => 'UserController@findall'
    ]);

    $router->get('/users/{id}', [
        'roles' => ['admin', 'employee', 'moderator'],
        'uses' => 'UserController@findone'
    ]);
    
    $router->put('/addrole/{id}', [
        'roles' => ['admin'],
        'uses' => 'UserController@addrole'
    ]);
    
      $router->put('/removerole/{id}', [
        'roles' => ['admin'],
        'uses' => 'UserController@removerole'
    ]);
    
    $router->get('/logout', [
        'roles' => ['admin', 'employee', 'moderator'],
        'uses' => 'UserController@logoutuser'
    ]);
    
});

    $router->get('/', 'AuthUserController@index');

    $router->post('/login', 'AuthUserController@authenticate');
    
    
    
    //aplikacija/views

    $router->get('/welcome', 'Frontend\ViewController@welcome');
    
    $router->post('/loginuser', 'Frontend\AuthController@loginuser');
   
    
   
    
