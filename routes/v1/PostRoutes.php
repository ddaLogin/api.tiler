<?php

Route::get('/posts', ['as' => 'posts.index', 'uses' => 'PostController@index']);
Route::get('/posts/{post}', ['as' => 'posts.show', 'uses' => 'PostController@show']);
Route::post('/posts', ['as' => 'posts.create', 'uses' => 'PostController@create'])->middleware('jwt.auth');