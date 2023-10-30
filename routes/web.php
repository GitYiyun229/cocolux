<?php
# @Author: Manh Linh
# @Date:   2023-01-01T17:33:09+07:00
# @Email:  lemanhlinh209@gmail.com
# @Last modified by:   Manh Linh
# @Last modified time: 2023-01-01T16:49:02+07:00
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
//lay dữ liệu cũ
//Route::get('/save-city-from-api', 'ApiController@saveCityFromApi');
//Route::get('/save-attribute-from-api', 'ApiController@saveAttributeFromApi');
//Route::get('/save-attribute-value-from-api', 'ApiController@saveAttributeValueFromApi');
//Route::get('/save-product-category-from-api', 'ApiController@saveProductCategoryFromApi');
//Route::get('/save-product-rating-from-api', 'ApiController@saveProductRatingFromApi');
//Route::get('/save-product-comment-from-api', 'ApiController@saveProductCommentFromApi');
//Route::get('/save-article-category-from-api', 'ApiController@saveArticleCategoryFromApi');
//Route::get('/save-article-from-api', 'ApiController@saveArticleFromApi');
//Route::get('/save-store-from-api', 'ApiController@saveStoreFromApi');
//Route::get('/save-products-from-api', 'ApiController@saveProductsFromApi');
//Route::get('/save-product-options-from-api', 'ApiController@saveProductOptionsFromApi');
//Route::get('/save-promotions-from-api', 'ApiController@savePromotionsFromApi');
//Route::get('/update-promotions-from-api', 'ApiController@updatePromotionsTypeFromApi');
//Route::get('/save-banners-from-api', 'ApiController@saveBannersFromApi');
//Route::get('/save-page-author-from-api', 'ApiController@savePageAuthorFromApi');

Route::group(['namespace' => 'Web'], function (){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/blog', 'ArticleController@index')->name('homeArticle');
    Route::get('/thuong-hieu', 'AttributeController@attributeBrand')->name('homeBrand');
    Route::get('/chuyen-muc/{slug}-i.{id}', 'ArticleController@cat')
        ->where(['slug' => '[-a-zA-Z0-9]+', 'id' => '[0-9]+'])
        ->name('catArticle');
    Route::get('/blog/{slug}-i.{id}', 'ArticleController@detail')
        ->where(['slug' => '[-a-zA-Z0-9]+', 'id' => '[0-9]+'])
        ->name('detailArticle');
    Route::get('/thuong-hieu/{slug}-i.{id}', 'ProductController@brand')
        ->where(['slug' => '[-a-zA-Z0-9]+', 'id' => '[0-9]+'])
        ->name('detailBrand');
    Route::get('/danh-muc/{slug}-i.{id}', 'ProductController@cat')
        ->where(['slug' => '[-a-zA-Z0-9]+', 'id' => '[0-9]+'])
        ->name('catProduct');
    Route::get('/{slug}-i.{sku}', 'ProductController@detail')
        ->where(['slug' => '[-a-zA-Z0-9]+', 'sku' => '[0-9]+'])
        ->name('detailProduct');
    Route::get('/hang-moi-ve', 'ProductController@is_new')->name('newProducts');
    Route::get('/deal-hot', 'ProductController@deal_hot')->name('dealHotProducts');
    Route::get('/deal-hot/{id}', 'ProductController@deal_hot_detail')->name('dealHotDetailProducts');
    Route::post('/them-vao-gio-hang', 'ProductController@addToCart')->name('addToCart');
    Route::post('/them-vao-gio-hang-ngay', 'ProductController@addToCartNow')->name('addToCartNow');
    Route::post('/update-gio-hang', 'ProductController@updateCart')->name('updateCart');
    Route::get('/checkout', 'ProductController@showCart')->name('showCart');
    Route::get('/checkout/payment', 'ProductController@payment')->name('payment');
    Route::get('/xoa-san-pham/{id}', 'ProductController@removeItem')->name('removeItem');
    Route::post('/order', 'ProductController@order')->name('order');
    Route::get('dat-hang-thanh-cong/{id}', 'ProductController@success')->name('orderProductSuccess');
    Route::get('/thong-tin/{slug}', 'PageController@index')->name('detailPage');
    Route::get('/hoi-dap/{slug}', 'PageController@index')->name('detailPageQa');
    Route::post('/load-district', 'ProductController@load_district')->name('loadDistrict');
    Route::post('/load-ward', 'ProductController@load_ward')->name('loadWard');
    Route::get('/search', 'ProductController@search')->name('search');
});

//Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
//    ->name('ckfinder_connector');
//
//Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
//    ->name('ckfinder_browser');

//Route::any('/ckfinder/examples/{example?}', '\CKSource\CKFinderBridge\Controller\CKFinderController@examplesAction')
//    ->name('ckfinder_examples');

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/change-profile', 'UserController@getProfile')->name('getProfile');
    Route::post('/change-profile', 'UserController@changeProfile')->name('changeProfile');
    Route::get('/change-password', 'UserController@changePassword')->name('changePassword');
    Route::post('/update-password', 'UserController@updatePassword')->name('updatePassword');

    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['permission:view_user']], function () {
        Route::get('', 'UserController@index')->name('index');
        Route::get('/create', 'UserController@create')->name('create')->middleware('permission:create_user');
        Route::post('/store', 'UserController@store')->name('store')->middleware('permission:create_user');
        Route::get('/edit/{id}', 'UserController@edit')->name('edit')->middleware('permission:edit_user');
        Route::post('/update/{id}', 'UserController@update')->name('update')->middleware('permission:edit_user');
        Route::post('/destroy/{id}', 'UserController@destroy')->name('destroy')->middleware('permission:delete_user');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.', 'middleware' => ['can:view_role']], function () {
        Route::get('', 'RoleController@index')->name('index');
        Route::get('/create', 'RoleController@create')->name('create')->middleware('permission:create_role');
        Route::post('/store', 'RoleController@store')->name('store')->middleware('permission:create_role');
        Route::get('/edit/{id}', 'RoleController@edit')->name('edit')->middleware('permission:edit_role');
        Route::post('/update/{id}', 'RoleController@update')->name('update')->middleware('permission:edit_role');
        Route::post('/destroy/{id}', 'RoleController@destroy')->name('destroy')->middleware('permission:delete_role');
    });

    Route::group(['prefix' => 'setting', 'as' => 'setting.', 'middleware' => ['permission:view_setting']], function () {
        Route::get('', 'SettingController@index')->name('index');
        Route::get('/create', 'SettingController@create')->name('create')->middleware('permission:create_setting');
        Route::post('/store', 'SettingController@store')->name('store')->middleware('permission:create_setting');
        Route::get('/edit/{id}', 'SettingController@edit')->name('edit')->middleware('permission:edit_setting');
        Route::post('/update/{id}', 'SettingController@update')->name('update')->middleware('permission:edit_setting');
        Route::post('/destroy/{id}', 'SettingController@destroy')->name('destroy')->middleware('permission:delete_setting');
        Route::post('/change-active-setting/{id}', 'SettingController@changeActive')->name('changeActive')->middleware('permission:edit_setting');});

    Route::group(['prefix' => 'menu-category', 'as' => 'menu-category.', 'middleware' => ['permission:view_menu_categories']], function () {
        Route::get('', 'MenuCategoryController@index')->name('index');
        Route::get('/create', 'MenuCategoryController@create')->name('create')->middleware('permission:create_menu_categories');
        Route::post('/store', 'MenuCategoryController@store')->name('store')->middleware('permission:create_menu_categories');
        Route::get('/edit/{id}', 'MenuCategoryController@edit')->name('edit')->middleware('permission:edit_menu_categories');        Route::post('/update/{id}', 'MenuCategoryController@update')->name('update')->middleware('permission:edit_menu_categories');
        Route::post('/destroy/{id}', 'MenuCategoryController@destroy')->name('destroy')->middleware('permission:delete_menu_categories');
        Route::post('/update-tree', 'MenuCategoryController@updateTree')->name('updateTree')->middleware('permission:edit_menu_categories');
    });


    Route::group(['prefix' => 'menu', 'as' => 'menu.', 'middleware' => ['permission:view_menu']], function () {
        Route::get('', 'MenuController@index')->name('index');
//        Route::get('/create', 'MenuController@create')->name('create')->middleware('permission:create_menu');
        Route::post('/store', 'MenuController@store')->name('store')->middleware('permission:create_menu');
//        Route::get('/edit/{id}', 'MenuController@edit')->name('edit')->middleware('permission:edit_menu');
        Route::post('/update/{id}', 'MenuController@update')->name('update')->middleware('permission:edit_menu');
        Route::post('/destroy/{id}', 'MenuController@destroy')->name('destroy')->middleware('permission:delete_menu');
        Route::post('/update-tree', 'MenuController@updateTree')->name('updateTree')->middleware('permission:edit_menu');
    });

    Route::group(['prefix' => 'page-category', 'as' => 'page-category.', 'middleware' => ['permission:view_page_categories']], function () {
        Route::get('', 'PageCategoriesController@index')->name('index');
        Route::get('/sort', 'PageCategoriesController@sort')->name('sort')->middleware('permission:create_page_categories');
        Route::get('/create', 'PageCategoriesController@create')->name('create')->middleware('permission:create_page_categories');
        Route::post('/store', 'PageCategoriesController@store')->name('store')->middleware('permission:create_page_categories');
        Route::get('/edit/{id}', 'PageCategoriesController@edit')->name('edit')->middleware('permission:edit_page_categories');
        Route::post('/update/{id}', 'PageCategoriesController@update')->name('update')->middleware('permission:edit_page_categories');
        Route::post('/destroy/{id}', 'PageCategoriesController@destroy')->name('destroy')->middleware('permission:delete_page_categories');
        Route::post('/change-active-page-cat/{id}', 'PageCategoriesController@changeActive')->name('changeActive')->middleware('permission:edit_page_categories');
    });

    Route::group(['prefix' => 'page', 'as' => 'page.', 'middleware' => ['permission:view_page']], function () {
        Route::get('', 'PageController@index')->name('index');
        Route::get('/create', 'PageController@create')->name('create')->middleware('permission:create_page');
        Route::post('/store', 'PageController@store')->name('store')->middleware('permission:create_page');
        Route::get('/edit/{id}', 'PageController@edit')->name('edit')->middleware('permission:edit_page');
        Route::post('/update/{id}', 'PageController@update')->name('update')->middleware('permission:edit_page');
        Route::post('/destroy/{id}', 'PageController@destroy')->name('destroy')->middleware('permission:delete_page');
        Route::post('/change-active-page/{id}', 'PageController@changeActive')->name('changeActive')->middleware('permission:edit_page');
    });

    Route::group(['prefix' => 'contact', 'as' => 'contact.', 'middleware' => ['permission:view_contact']], function () {
        Route::get('', 'ContactController@index')->name('index');
    });

    Route::group(['prefix' => 'article-category', 'as' => 'article-category.', 'middleware' => ['permission:view_article_categories']], function () {
        Route::get('', 'ArticlesCategoriesController@index')->name('index');
        Route::get('/sort', 'ArticlesCategoriesController@sort')->name('sort')->middleware('permission:create_article_categories');
        Route::get('/create', 'ArticlesCategoriesController@create')->name('create')->middleware('permission:create_article_categories');
        Route::post('/store', 'ArticlesCategoriesController@store')->name('store')->middleware('permission:create_article_categories');
        Route::get('/edit/{id}', 'ArticlesCategoriesController@edit')->name('edit')->middleware('permission:edit_article_categories');
        Route::post('/update/{id}', 'ArticlesCategoriesController@update')->name('update')->middleware('permission:edit_article_categories');
        Route::post('/destroy/{id}', 'ArticlesCategoriesController@destroy')->name('destroy')->middleware('permission:delete_article_categories');
        Route::post('/change-active-article-cat/{id}', 'ArticlesCategoriesController@changeActive')->name('changeActive')->middleware('permission:edit_article_categories');
        Route::post('/update-tree-article', 'ArticlesCategoriesController@updateTree')->name('updateTree')->middleware('permission:edit_article_categories');
    });

    Route::group(['prefix' => 'articles', 'as' => 'article.', 'middleware' => ['permission:view_article']], function () {
        Route::get('', 'ArticleController@index')->name('index');
        Route::get('/create', 'ArticleController@create')->name('create')->middleware('permission:create_article');
        Route::post('/store', 'ArticleController@store')->name('store')->middleware('permission:create_article');
        Route::get('/edit/{id}', 'ArticleController@edit')->name('edit')->middleware('permission:edit_article');
        Route::post('/update/{id}', 'ArticleController@update')->name('update')->middleware('permission:edit_article');
        Route::post('/destroy/{id}', 'ArticleController@destroy')->name('destroy')->middleware('permission:delete_article');
        Route::post('/search', 'ArticleController@search')->name('search')->middleware('permission:edit_article');
        Route::post('/change-active-article/{id}', 'ArticleController@changeActive')->name('changeActive')->middleware('permission:edit_article');
        Route::post('/change-is-home-article/{id}', 'ArticleController@changeIsHome')->name('changeIsHome')->middleware('permission:edit_article');
    });

    Route::group(['prefix' => 'attribute', 'as' => 'attribute.', 'middleware' => ['permission:view_attribute']], function () {
        Route::get('', 'AttributeController@index')->name('index');
        Route::get('/sort', 'AttributeController@sort')->name('sort')->middleware('permission:create_attribute');
        Route::get('/create', 'AttributeController@create')->name('create')->middleware('permission:create_attribute');
        Route::post('/store', 'AttributeController@store')->name('store')->middleware('permission:create_attribute');
        Route::get('/edit/{id}', 'AttributeController@edit')->name('edit')->middleware('permission:edit_attribute');
        Route::post('/update/{id}', 'AttributeController@update')->name('update')->middleware('permission:edit_attribute');
        Route::post('/destroy/{id}', 'AttributeController@destroy')->name('destroy')->middleware('permission:delete_attribute');
        Route::post('/change-active-attribute/{id}', 'AttributeController@changeActive')->name('changeActive')->middleware('permission:edit_attribute');
    });

    Route::group(['prefix' => 'attribute-value', 'as' => 'attribute-value.', 'middleware' => ['permission:view_attribute_value']], function () {
        Route::get('', 'AttributeValueController@index')->name('index');
        Route::get('/create', 'AttributeValueController@create')->name('create')->middleware('permission:create_attribute_value');
        Route::post('/store', 'AttributeValueController@store')->name('store')->middleware('permission:create_attribute_value');
        Route::get('/edit/{id}', 'AttributeValueController@edit')->name('edit')->middleware('permission:edit_attribute_value');
        Route::post('/update/{id}', 'AttributeValueController@update')->name('update')->middleware('permission:edit_attribute_value');
        Route::post('/destroy/{id}', 'AttributeValueController@destroy')->name('destroy')->middleware('permission:delete_attribute_value');
        Route::post('/change-active-attribute-value/{id}', 'AttributeValueController@changeActive')->name('changeActive')->middleware('permission:edit_attribute_value');
    });

    Route::group(['prefix' => 'banner', 'as' => 'banner.', 'middleware' => ['permission:view_banner']], function () {
        Route::get('', 'BannerController@index')->name('index');
        Route::get('/create', 'BannerController@create')->name('create')->middleware('permission:create_banner');
        Route::post('/store', 'BannerController@store')->name('store')->middleware('permission:create_banner');
        Route::get('/edit/{id}', 'BannerController@edit')->name('edit')->middleware('permission:edit_banner');
        Route::post('/update/{id}', 'BannerController@update')->name('update')->middleware('permission:edit_banner');
        Route::post('/destroy/{id}', 'BannerController@destroy')->name('destroy')->middleware('permission:delete_banner');
        Route::post('/change-active-banner/{id}', 'BannerController@changeActive')->name('changeActive')->middleware('permission:edit_banner');
    });

    Route::group(['prefix' => 'product-category', 'as' => 'product-category.', 'middleware' => ['permission:view_product_categories']], function () {
        Route::get('', 'ProductsCategoriesController@index')->name('index');
        Route::get('/create', 'ProductsCategoriesController@create')->name('create')->middleware('permission:create_product_categories');
        Route::post('/store', 'ProductsCategoriesController@store')->name('store')->middleware('permission:create_product_categories');
        Route::get('/sort', 'ProductsCategoriesController@sort')->name('sort')->middleware('permission:create_product_categories');
        Route::get('/edit/{id}', 'ProductsCategoriesController@edit')->name('edit')->middleware('permission:edit_product_categories');
        Route::post('/update/{id}', 'ProductsCategoriesController@update')->name('update')->middleware('permission:edit_product_categories');
        Route::post('/destroy/{id}', 'ProductsCategoriesController@destroy')->name('destroy')->middleware('permission:delete_product_categories');
        Route::post('/change-active-product-cat/{id}', 'ProductsCategoriesController@changeActive')->name('changeActive')->middleware('permission:edit_product_categories');
        Route::post('/update-tree-product', 'ProductsCategoriesController@updateTree')->name('updateTree')->middleware('permission:edit_product_categories');
    });

    Route::group(['prefix' => 'product', 'as' => 'product.', 'middleware' => ['permission:view_product']], function () {
        Route::get('', 'ProductController@index')->name('index');
//        Route::get('/create', 'ProductController@create')->name('create')->middleware('permission:create_product');
        Route::post('/store', 'ProductController@store')->name('store')->middleware('permission:create_product');
        Route::get('/edit/{id}', 'ProductController@edit')->name('edit')->middleware('permission:edit_product');
        Route::post('/update/{id}', 'ProductController@update')->name('update')->middleware('permission:edit_product');
        Route::post('/destroy/{id}', 'ProductController@destroy')->name('destroy')->middleware('permission:delete_product');
        Route::post('/change-active-product/{id}', 'ProductController@changeActive')->name('changeActive')->middleware('permission:edit_product');
        Route::post('/change-is-home-product/{id}', 'ProductController@changeIsHome')->name('changeIsHome')->middleware('permission:edit_product');
        Route::post('/change-is-hot-product/{id}', 'ProductController@changeIsHot')->name('changeIsHot')->middleware('permission:edit_product');
        Route::post('/change-is-new-product/{id}', 'ProductController@changeIsNew')->name('changeIsNew')->middleware('permission:edit_product');
    });

    Route::group(['prefix' => 'product-option', 'as' => 'product-option.', 'middleware' => ['permission:view_product']], function () {
        Route::get('', 'ProductOptionController@index')->name('index');
        Route::post('/create/{id_parent}', 'ProductOptionController@create')->name('create')->middleware('permission:create_product');
        Route::post('/store', 'ProductOptionController@store')->name('store')->middleware('permission:create_product');
        Route::post('/edit', 'ProductOptionController@edit')->name('edit')->middleware('permission:edit_product');
        Route::post('/update', 'ProductOptionController@update')->name('update')->middleware('permission:edit_product');
        Route::post('/destroy', 'ProductOptionController@destroy')->name('destroy')->middleware('permission:delete_product');
    });

    Route::group(['prefix' => 'order-product', 'as' => 'order-product.', 'middleware' => ['permission:view_product_orders']], function () {
        Route::get('', 'OrderController@index')->name('index');
        Route::get('/create', 'OrderController@create')->name('create')->middleware('permission:create_product_orders');
        Route::post('/store', 'OrderController@store')->name('store')->middleware('permission:create_product_orders');
        Route::get('/edit/{id}', 'OrderController@edit')->name('edit')->middleware('permission:edit_product_orders');
        Route::post('/update/{id}', 'OrderController@update')->name('update')->middleware('permission:edit_product_orders');
        Route::post('/destroy/{id}', 'OrderController@destroy')->name('destroy')->middleware('permission:delete_product_orders');
    });

    Route::group(['prefix' => 'slider', 'as' => 'slider.', 'middleware' => ['permission:view_slider']], function () {
        Route::get('', 'SliderController@index')->name('index');
        Route::get('/create', 'SliderController@create')->name('create')->middleware('permission:create_slider');
        Route::post('/store', 'SliderController@store')->name('store')->middleware('permission:create_slider');
        Route::get('/edit/{id}', 'SliderController@edit')->name('edit')->middleware('permission:edit_slider');
        Route::post('/update/{id}', 'SliderController@update')->name('update')->middleware('permission:edit_slider');
        Route::post('/destroy/{id}', 'SliderController@destroy')->name('destroy')->middleware('permission:delete_slider');
        Route::post('/change-active-slider/{id}', 'SliderController@changeActive')->name('changeActive')->middleware('permission:edit_slider');
    });

    Route::group(['prefix' => 'store', 'as' => 'store.', 'middleware' => ['permission:view_store']], function () {
        Route::get('', 'StoreController@index')->name('index');
        Route::get('/create', 'StoreController@create')->name('create')->middleware('permission:create_store');
        Route::post('/store', 'StoreController@store')->name('store')->middleware('permission:create_store');
        Route::get('/edit/{id}', 'StoreController@edit')->name('edit')->middleware('permission:edit_store');
        Route::post('/update/{id}', 'StoreController@update')->name('update')->middleware('permission:edit_store');
        Route::post('/destroy/{id}', 'StoreController@destroy')->name('destroy')->middleware('permission:delete_store');
        Route::post('/change-active-store/{id}', 'StoreController@changeActive')->name('changeActive')->middleware('permission:edit_store');
    });

});


