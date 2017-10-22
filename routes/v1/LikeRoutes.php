<?php

Route::put('/posts/{post}/likes', ['as' => 'likes.toggle', 'uses' => 'LikeController@toggle'])->middleware('auth:api');
