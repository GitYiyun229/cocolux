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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
    public function boot(SettingInterface $settingRepository, MenuInterface $menuRepository)
    {
        $menu_top = null;
        $menu_footer = null;
        $cat_products = null;
        $setting = null;
        $settings = null;
        $currentUrl = URL::current(); // Lấy URL hiện tại
        $currentDomain = parse_url($currentUrl, PHP_URL_HOST);
        $expectedUrls = [
            "https://cocolux:8890", // URL bạn đã cấu hình
            "https://cocolux.com"   // URL bạn đã cấu hình
        ];
        $expectedDomains = [
            "cocolux:8890", // Domain bạn đã cấu hình
            "cocolux.com"   // Domain bạn đã cấu hình
        ];
        $valid = false;
        foreach ($expectedUrls as $expectedUrl) {
            if (Str::startsWith($currentUrl, $expectedUrl)) {
                $valid = true;
                break;
            }
        }
        $valida = in_array($currentDomain, $expectedDomains);

        if (!$valida) {
            dd(); // Hiển thị và dừng thực thi để kiểm tra $currentUrl và $expectedDomains
        }
        if (!$valid) {
            dd(); // Hiển thị và dừng thực thi để kiểm tra $currentUrl và $expectedUrls
        }

        $referer = request()->headers->get('referer');
        $refererDomain = $referer ? parse_url($referer, PHP_URL_HOST) : null;
        $currentDomain = request()->getHost(); // Lấy domain hiện tại

        // Kiểm tra domain hiện tại có hợp lệ không
        $validCurrentDomain = in_array($currentDomain, $expectedDomains);
        // Kiểm tra referer (nếu có)
        $validRefererDomain = !$refererDomain || in_array($refererDomain, $expectedDomains);

        // Tổng hợp điều kiện hợp lệ
        if (!$validCurrentDomain || !$validRefererDomain) {
            dd();
        }


        if (!Request::is('admin/*')) {
            if (Schema::hasTable('setting')) {
                // $setting = $settingRepository->getActive('active',1)->pluck('value', 'key');
                $all = $settingRepository->getAll()->toArray();
                $settings = array_reduce($all, function ($carry, $setting) {
                    $carry[$setting['key']] = $setting['active'] == 1 ? $setting['value'] : '';
                    return $carry;
                }, []);
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
        View::share('setting', $settings);
        View::composer(['web.partials._header', 'web.partials._footer', 'web.layouts.web', 'web.home'], function ($view) use ($menu_top, $menu_footer, $cat_products) {
            $view->with('menus', $menu_top);
            $view->with('menus_footer', $menu_footer);
            $view->with('cat_products', $cat_products);
        });

        $detect = new MobileDetect();
        $isMobile = $detect->isMobile();
        View::share('isMobile', $isMobile);
    }
}
