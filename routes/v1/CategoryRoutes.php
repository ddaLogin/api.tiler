<?php

Route::get('/categories', ['as' => 'categories.index', 'uses' => 'CategoryController@index']);