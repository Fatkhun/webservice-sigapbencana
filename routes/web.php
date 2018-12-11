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
$app->get('/dummy/bencana', 'BencanaController@dummy');


### Master ###

# role_users
$app->post('/role/create', 'UsersRoleController@store');

# kabupaten
$app->get('/kabupaten', 'KabupatenController@getAll');

# Desa
$app->get('/desa/{id}', 'KabupatenController@getDesa');

# Kategori Bencana
$app->post('/kategori/create', 'KategoriBencanaController@create');
$app->post('/kategori/update/{id}', 'KategoriBencanaController@update');
$app->get('/kategori/delete/{id}', 'KategoriBencanaController@delete');
$app->get('/kategori', 'KategoriBencanaController@getAll');

# Kondisi Bencana
$app->post('/kondisi/create', 'KondisiBencanaController@create');
$app->post('/kondisi/update/{id}', 'KondisiBencanaController@update');
$app->get('/kondisi/delete/{id}', 'KondisiBencanaController@delete');
$app->get('/kondisi', 'KondisiBencanaController@getAll');

# Status Bencana
$app->post('/status/create', 'StatusBencanaController@create');
$app->post('/status/update/{id}', 'StatusBencanaController@update');
$app->get('/status/delete/{id}', 'StatusBencanaController@delete');
$app->get('/status', 'StatusBencanaController@getAll');



// user
$app->post('/user/login', 'UserController@login');
$app->post('/user/update/password', ['middleware' => 'auth', 'uses' =>  'UserController@updatePassword']);
$app->get('/user/detail/{id}', 'UserController@showUser');
$app->post('/user/register', 'UserController@register');
$app->get('/user/delete/{id}', 'UserController@destroyUser');
$app->post('/user/update/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@updateUserProfile']);

// Bencana
$app->post('/bencana/lapor', 'BencanaController@create');
$app->post('/bencana/monitor/{id}', 'BencanaController@update');
$app->get('/bencana/delete/{id}', 'BencanaController@delete');
$app->get('/bencana/detail/{id}', 'BencanaController@getDetail');
$app->get('/bencana/all', 'BencanaController@getAll');
$app->get('/bencana/terbaru', 'BencanaController@getLaporanTerbaru');
$app->get('/bencana/statistik/bulan', 'BencanaController@getStatistikBulan');
$app->get('/bencana/statistik/tahun', 'BencanaController@getStatistikTahun');
$app->get('/bencana/data/tahun', 'BencanaController@getDataBencanaTahun');
$app->get('/bencana/jumlah/{kategori}/{kabupaten}/{tahun}', 'BencanaController@jumlahBencana');
$app->get('/bencana/rekap/{kabupaten}/{tahun}', 'BencanaController@rekap');

// berita
$app->post('/berita/create', 'BeritaController@create');
$app->post('/berita/update/{id}', 'BeritaController@update');
$app->get('/berita/delete/{id}', 'BeritaController@delete');
$app->get('/berita/detail/{id}', 'BeritaController@detail');
$app->get('/berita', 'BeritaController@getAll');

// pengumuman
$app->post('/pengumuman/create', 'PengumumanController@create');
$app->post('/pengumuman/update/{id}', 'PengumumanController@update');
$app->get('/pengumuman/delete/{id}', 'PengumumanController@delete');

// Lurah
$app->get('/user/kabupaten/{id}', 'UserController@getUserKabupaten');

