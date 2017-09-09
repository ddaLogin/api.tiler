<?php

Route::get('/users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
Route::post('/users', ['as' => 'users.create', 'uses' => 'UserController@create']);
Route::put('/users/{user}', ['as' => 'users.update', 'uses' => 'UserController@update'])->middleware('jwt.auth');