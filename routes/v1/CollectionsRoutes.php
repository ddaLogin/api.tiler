<?php

Route::post('/users/{user}/collections', ['as' => 'collections.create', 'uses' => 'CollectionController@create'])->middleware('auth:api');
Route::put('/users/{user}/collections/{collection}', ['as' => 'collections.update', 'uses' => 'CollectionController@update'])->middleware('auth:api');
Route::get('/users/{user}/collections', ['as' => 'collections.byUser', 'uses' => 'CollectionController@byUser']);