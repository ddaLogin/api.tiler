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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Auth::routes();

Route::get('/socialite/{driver}', ['as' => 'auth.redirect', 'uses' => 'SocialiteController@redirect'])->where('driver', 'google');
Route::get('/socialite/{driver}/callback', ['as' => 'auth.callback', 'uses' => 'SocialiteController@callback'])->where('driver', 'google');

require_once ('admin.php');