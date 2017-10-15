<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$loader = function ($routeFolder){
    $directoryIterator = new DirectoryIterator($routeFolder);
    foreach ($directoryIterator as $directory) {
        if ($directory->isFile()) {
            require $routeFolder . $directory->getFilename();
        }
    }
};

Route::namespace('Api\v1')->prefix('/v1')->name('v1.')->group(function () use($loader) {
    $loader(__DIR__ . '/v1/');
});
