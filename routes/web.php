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

Route::prefix('/api/v1')->name('v1.')->group(function () {
    Route::post('/auth', ['as' => 'auth', 'uses' => 'UserController@auth']);
    Route::get('/auth/{driver}', ['as' => 'auth.redirect', 'uses' => 'SocialiteController@redirect'])->where('driver', 'google');
    Route::get('/auth/{driver}/callback', ['as' => 'auth.callback', 'uses' => 'SocialiteController@callback'])->where('driver', 'google');

    Route::prefix('users')->name('users.')->group(function () {
        Route::post('/', ['as' => 'create', 'uses' => 'UserController@create']);

        Route::middleware('jwt.auth')->group(function () {
            Route::get('/{user}', ['as' => 'show', 'uses' => 'UserController@show']);
        });
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', ['as' => 'index', 'uses' => 'PostController@index']);

        Route::middleware('jwt.auth')->group(function () {
            Route::post('/', ['as' => 'create', 'uses' => 'PostController@create']);
        });
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', ['as' => 'index', 'uses' => 'CategoryController@index']);
    });
});