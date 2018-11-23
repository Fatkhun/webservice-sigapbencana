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

$app->get('/', function (){
	$res['success'] = true;
	$res['result'] = "Hello there welcome to web api using lumen 5.3.x!";
	return response($res);
});

# Base
// role_users
$app->post('/role/create', 'UsersRoleController@store');



# Android and Web #

// user
$app->post('/user/login', 'UserController@login');
$app->post('/user/update/password', ['middleware' => 'auth', 'uses' =>  'UserController@updatePassword']);

# Android only #
$app->get('/user/{id}', 'UserController@showUser');

# Web only #

// user
$app->post('/user/register', 'UserController@register');
$app->get('/user/index', 'UserController@showAllUser');
$app->get('/user/destroy/{id}', 'UserController@destroyUser');
$app->post('/user/update/profile/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@updateUserProfile']);








