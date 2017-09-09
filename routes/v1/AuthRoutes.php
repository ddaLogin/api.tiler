<?php

Route::post('/auth', ['as' => 'auth', 'uses' => 'UserController@auth']);
Route::get('/auth/{driver}', ['as' => 'auth.redirect', 'uses' => 'SocialiteController@redirect'])->where('driver', 'google');
Route::get('/auth/{driver}/callback', ['as' => 'auth.callback', 'uses' => 'SocialiteController@callback'])->where('driver', 'google');