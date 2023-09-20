<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\SettingInterface;
use App\Repositories\Contracts\MenuInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SettingInterface $settingRepository,MenuInterface $menuRepository)
    {
        $menu = null;
        $setting = null;
        if (!Request::is('admin/*')) {
            if (Schema::hasTable('setting')) {
                $setting = $settingRepository->getAll()->pluck('value', 'key');
            }
            if (Schema::hasTable('menu')) {
                $menu = $menuRepository->getMenusByCategoryId(1)->toTree();
            }
//            View::composer(['web.partials._header', 'web.partials._footer'], function ($view) {
//                $config = Setting::all();
//                $view->with('menus', $config);
//            });
        }
        View::share('setting', $setting);
        View::composer(['web.partials._header', 'web.partials._footer','web.layouts.web'], function ($view) use ($menu) {
            $view->with('menus', $menu);
        });

    }
}
