<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Repositories\Contracts\UserInterface', 'App\Repositories\Eloquents\UserRepository');
        $this->app->bind('App\Repositories\Contracts\RoleInterface', 'App\Repositories\Eloquents\RoleRepository');
        $this->app->bind('App\Repositories\Contracts\PermissionInterface', 'App\Repositories\Eloquents\PermissionRepository');
        $this->app->bind('App\Repositories\Contracts\ArticleInterface', 'App\Repositories\Eloquents\ArticleRepository');
        $this->app->bind('App\Repositories\Contracts\ArticleCategoryInterface', 'App\Repositories\Eloquents\ArticleCategoryRepository');
        $this->app->bind('App\Repositories\Contracts\SettingInterface', 'App\Repositories\Eloquents\SettingRepository');
        $this->app->bind('App\Repositories\Contracts\MenuCategoryInterface', 'App\Repositories\Eloquents\MenuCategoryRepository');
        $this->app->bind('App\Repositories\Contracts\MenuInterface', 'App\Repositories\Eloquents\MenuRepository');
        $this->app->bind('App\Repositories\Contracts\PageInterface', 'App\Repositories\Eloquents\PageRepository');
        $this->app->bind('App\Repositories\Contracts\ProductInterface', 'App\Repositories\Eloquents\ProductRepository');
        $this->app->bind('App\Repositories\Contracts\ProductCategoryInterface', 'App\Repositories\Eloquents\ProductCategoryRepository');
        $this->app->bind('App\Repositories\Contracts\StoreInterface', 'App\Repositories\Eloquents\StoreRepository');
        $this->app->bind('App\Repositories\Contracts\SlideInterface', 'App\Repositories\Eloquents\SlideRepository');
        $this->app->bind('App\Repositories\Contracts\MediaImageInterface', 'App\Repositories\Eloquents\MediaImageRepository');
        $this->app->bind('App\Repositories\Contracts\MediaVideoInterface', 'App\Repositories\Eloquents\MediaVideoRepository');
    }
}
