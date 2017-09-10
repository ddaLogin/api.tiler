<?php

Route::post('/users/{user}/collections', ['as' => 'collections.create', 'uses' => 'CollectionController@create'])->middleware('jwt.auth');
Route::get('/users/{user}/collections', ['as' => 'collections.byUser', 'uses' => 'CollectionController@byUser']);