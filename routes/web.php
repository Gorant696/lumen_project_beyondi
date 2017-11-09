<?php

//API
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
        'roles' => ['admin'],
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
    
    
    
    //Aplikacija/frontend

    $router->get('/welcome', 'Frontend\ViewController@welcome');
    
    $router->get('/register', 'Frontend\ViewController@registration');
    
    $router->get('/edituser/{id}', 'Frontend\ViewController@editUser');
    
    $router->get('/addrole/{id}', 'Frontend\ViewController@addrole');
    
    $router->get('/removerole/{id}', 'Frontend\ViewController@removerole');
    
    
    
    $router->post('/loginuser', 'Frontend\AuthController@loginuser');
    
    $router->post('/registeruser', 'Frontend\AuthController@registeruser');
    
    $router->post('/edit/{id}', 'Frontend\AuthController@edit');
    
    $router->post('/addroletouser/{id}', 'Frontend\AuthController@addroletouser');
    
    $router->post('/removerolefromuser/{id}', 'Frontend\AuthController@removerolefromuser');
     
    $router->get('/deleteuser/{id}', 'Frontend\AuthController@deleteuser');
   
    $router->get('/me', 'Frontend\AuthController@findme');
    
    $router->get('/someone/{id}', 'Frontend\AuthController@findone');
    
    $router->get('/all', 'Frontend\AuthController@findall');
    
    $router->get('/logoutuser', 'Frontend\AuthController@logoutuser');
    
   
    
