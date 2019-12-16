<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/xml.xml','api\soalcontroller@index');
//Auth::routes();
Route::post('/login','Auth\LoginController@login');
Route::get('/logout','api\userController@logout');
Route::post('/register','Auth\RegisterController@register');
Route::post('/createarena','api\arenaController@createarena');
Route::post('/joinarena','api\arenaController@joinarena');
Route::post('/submitarena','api\arenaController@submitarena');
Route::get('/historiarena','api\arenaController@historiarena');
Route::post('/detailarena','api\arenaController@detailarena');
