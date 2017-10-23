<?php

Route::get('/users/{user}/collections', ['as' => 'collections.byUser', 'uses' => 'CollectionController@byUser']);
Route::post('/users/{user}/collections', ['as' => 'collections.create', 'uses' => 'CollectionController@create'])->middleware('auth:api');
Route::put('/collections/{collection}', ['as' => 'collections.update', 'uses' => 'CollectionController@update'])->middleware('auth:api');
Route::delete('/collections/{collection}', ['as' => 'collections.delete', 'uses' => 'CollectionController@delete'])->middleware('auth:api');
