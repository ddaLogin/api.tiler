<?php

Route::post('/users', ['as' => 'users.create', 'uses' => 'UserController@create']);
Route::get('/users', ['as' => 'users.index', 'uses' => 'UserController@index']);
Route::get('/users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
Route::put('/users/{user}', ['as' => 'users.update', 'uses' => 'UserController@update'])->middleware('auth:api');