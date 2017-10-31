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


//Moram grupirati rute zbog middleware i eventualno prefixa.



$router->post('/login', 'UserController@authenticate');

$router->get('/users', 'UserController@findall');

$router->get('/user/{id}', 'UserController@findone');

$router->get('/findme', ['middleware'=>'auth', 'uses' => 'AuthUserController@findme']);

$router->post('/createuser', ['middleware'=>'auth', 'uses' => 'AdminController@create']);

$router->delete('/deleteuser/{id}', ['middleware'=>'auth', 'uses' => 'AdminController@delete']);

$router->put('/edituser/{id}', ['middleware'=>'auth', 'uses' => 'AdminController@update']);

$router->put('/changestatus/{id}', ['middleware'=>'auth', 'uses' => 'AdminController@changestatus']);