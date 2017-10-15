<?php

Route::get('/socialite/{driver}', ['as' => 'auth.redirect', 'uses' => 'SocialiteController@redirect'])->where('driver', 'google');
Route::get('/socialite/{driver}/callback', ['as' => 'auth.callback', 'uses' => 'SocialiteController@callback'])->where('driver', 'google');