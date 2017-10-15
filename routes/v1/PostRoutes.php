<?php

Route::post('/users/{user}/posts', ['as' => 'posts.create', 'uses' => 'PostController@create'])->middleware('auth:api');
Route::get('/users/{user}/posts', ['as' => 'posts.byUser', 'uses' => 'PostController@byUser']);

Route::get('/posts', ['as' => 'posts.index', 'uses' => 'PostController@index']);
Route::get('/posts/{post}', ['as' => 'posts.show', 'uses' => 'PostController@show']);
