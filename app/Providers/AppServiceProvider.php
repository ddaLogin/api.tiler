<?php

namespace App\Providers;

use App\Interfaces;
use App\Repositories;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Interfaces\UserRepositoryInterface::class, Repositories\MySQLUserRepository::class);
        $this->app->bind(Interfaces\PostRepositoryInterface::class, Repositories\MySQLPostRepository::class);
        $this->app->bind(Interfaces\CategoryRepositoryInterface::class, Repositories\MySQLCategoryRepository::class);
        $this->app->bind(Interfaces\CollectionRepositoryInterface::class, Repositories\MySQLCollectionRepository::class);
        $this->app->bind(Interfaces\LikeRepositoryInterface::class, Repositories\MySQLLikeRepository::class);
    }
}
