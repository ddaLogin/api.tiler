<?php

Route::namespace('Admin')->prefix('/admin')->name('admin.')->middleware('group:administration')->group(function () {
    Route::get('/', ['as' => 'index', 'uses' => 'AdminController@index']);

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
    });

    Route::resource('categories', 'CategoryController', ['only' => ['index', 'create', 'edit', 'store', 'update']]);
});