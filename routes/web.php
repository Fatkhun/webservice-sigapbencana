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
	$res['result'] = "Selamat Datang di Web Service Aplikasi Sigap Bencana";
	return response($res);
});

# dummy data
# $app->get('/dummy/lurah', 'LurahController@dummy');



# Base
// role_users
$app->post('/role/create', 'UsersRoleController@store');



# Android and Web #

// user
$app->post('/user/login', 'UserController@login');
$app->post('/user/update/password', ['middleware' => 'auth', 'uses' =>  'UserController@updatePassword']);

# Android only #
$app->get('/user/{id}', 'UserController@showUser');
// Bencana
$app->post('/bencana/lapor', 'BencanaController@create');
$app->post('/bencana/monitor', 'BencanaController@update');
$app->get('/bencana/delete/{id}', 'BencanaController@delete');

// Kategori Bencana
$app->post('/bencana/create/kategori', 'KategoriBencanaController@create');
$app->post('/bencana/update/kategori/{id}', 'KategoriBencanaController@update');
$app->get('/bencana/delete/kategori/{id}', 'KategoriBencanaController@delete');
$app->get('/kategori', 'KategoriBencanaController@getAll');
// Kondisi Bencana
$app->post('/bencana/create/kondisi', 'KondisiBencanaController@create');
$app->post('/bencana/update/kondisi/{id}', 'KondisiBencanaController@update');
$app->get('/bencana/delete/kondisi/{id}', 'KondisiBencanaController@delete');
$app->get('/kondisi', 'KondisiBencanaController@getAll');
// Status Bencana
$app->post('/bencana/create/status', 'StatusBencanaController@create');
$app->post('/bencana/update/status/{id}', 'StatusBencanaController@update');
$app->post('/bencana/delete/status/{id}', 'StatusBencanaController@delete');
$app->get('/status', 'StatusBencanaController@getAll');

# Web only #

# kabupaten
$app->get('/kabupaten', 'KabupatenController@getAll');

# Desa
$app->get('/desa/{id}', 'KabupatenController@getDesa');

// user
$app->post('/user/register', 'UserController@register');
$app->get('/user/destroy/{id}', 'UserController@destroyUser');
$app->post('/user/update/profile/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@updateUserProfile']);
$app->get('/user/profile/{id}', 'UserController@showUser');

// berita
$app->post('/bencana/berita/create', 'BeritaController@create');
$app->post('/bencana/berita/update/{id}', 'BeritaController@update');
$app->get('/bencana/berita/delete/{id}', 'BeritaController@delete');
$app->get('/bencana/berita/detail/{id}', 'BeritaController@detail');

// pengumuman
$app->post('/bencana/pengumuman/create', 'PengumumanController@create');
$app->post('/bencana/pengumuman/update/{id}', 'PengumumanController@update');
$app->get('/bencana/pengumuman/delete/{id}', 'PengumumanController@delete');


// Lurah
$app->get('/user/kabupaten/{id}', 'UserController@getUserKabupaten');

