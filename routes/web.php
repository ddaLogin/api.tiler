<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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

Route::prefix('/api/v1')->name('v1.')->group(function () use($loader) {
    $loader(__DIR__ . '/v1/');
});