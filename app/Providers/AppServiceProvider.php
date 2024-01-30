<?php

namespace App\Providers;

use App\Models\ProductsCategories;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\SettingInterface;
use App\Repositories\Contracts\MenuInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Detection\MobileDetect;

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
        $menu_top = null;
        $menu_footer = null;
        $cat_products = null;
        $setting = null;
        if (!Request::is('admin/*')) {
            if (Schema::hasTable('setting')) {
                $setting = $settingRepository->getAll()->pluck('value', 'key');
            }
            if (Schema::hasTable('menu')) {
                $menu_top = $menuRepository->getMenusByCategoryId(3)->toTree();
                $menu_footer = $menuRepository->getMenusByCategoryId(4)->toTree();
            }
            if (Schema::hasTable('products_categories')) {
                $cat_products = ProductsCategories::where(['is_visible' => 1])->withDepth()->defaultOrder()->get()->toTree();
            }
//            View::composer(['web.partials._header', 'web.partials._footer'], function ($view) {
//                $config = Setting::all();
//                $view->with('menus', $config);
//            });
        }
        View::share('setting', $setting);
        View::composer(['web.partials._header', 'web.partials._footer', 'web.layouts.web', 'web.home'], function ($view) use ($menu_top,$menu_footer , $cat_products) {
            $view->with('menus', $menu_top);
            $view->with('menus_footer', $menu_footer);
            $view->with('cat_products', $cat_products);
        });

        $detect = new MobileDetect();
        $isMobile = $detect->isMobile();
        View::share('isMobile', $isMobile);
    }
}
