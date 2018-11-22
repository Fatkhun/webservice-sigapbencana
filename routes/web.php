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

// routes user
$app->post('/user/login', 'UserController@login');
$app->post('/user/register', 'UserController@register');
$app->get('/user/index', 'UserController@showAllUser');
$app->get('/user/destroy/{id}', 'UserController@destroyUser');
$app->post('/user/update/profile/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@updateUserProfile']);
$app->post('/user/update/password', ['middleware' => 'auth', 'uses' =>  'UserController@updatePassword']);
$app->get('/user/{id}', 'UserController@showUser');
//end routes user



