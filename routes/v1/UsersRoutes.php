<?php

Route::post('/users', ['as' => 'users.create', 'uses' => 'UserController@create']);
Route::get('/users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
Route::put('/users/{user}', ['as' => 'users.update', 'uses' => 'UserController@update'])->middleware('jwt.refresh', 'jwt.auth');