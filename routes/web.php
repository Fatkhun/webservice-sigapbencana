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

# Android and Web #

// user
$app->post('/user/login', 'UserController@login');
$app->post('/user/update/password', ['middleware' => 'auth', 'uses' =>  'UserController@updatePassword']);

# Android only #
$app->get('/user/{id}', 'UserController@showUser');
// Bencana
$app->post('/bencana/create/lapor', 'BencanaController@create');
$app->post('/bencana/update/lapor/{id}', 'BencanaController@update');
$app->get('/bencana/delete/lapor/{id}', 'BencanaController@delete');
// Kategori Bencana
$app->post('/bencana/create/kategori', 'KategoriBencanaController@create');
$app->post('/bencana/update/kategori/{id}', 'KategoriBencanaController@update');
$app->get('/bencana/delete/kategori/{id}', 'KategoriBencanaController@delete');
// Kondisi Bencana
$app->post('/bencana/create/kondisi', 'KondisiBencanaController@create');
$app->post('/bencana/update/kondisi/{id}', 'KondisiBencanaController@update');
$app->get('/bencana/delete/kondisi/{id}', 'KondisiBencanaController@delete');
// Status Bencana
$app->post('/bencana/create/status', 'StatusBencanaController@create');
$app->post('/bencana/update/status/{id}', 'StatusBencanaController@update');
$app->post('/bencana/delete/status/{id}', 'StatusBencanaController@delete');

# Web only #

// user
$app->post('/user/register', 'UserController@register');
$app->get('/user/index', 'UserController@showAllUser');
$app->get('/user/destroy/{id}', 'UserController@destroyUser');
$app->post('/user/update/profile/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@updateUserProfile']);






