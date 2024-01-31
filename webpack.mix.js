const mix = require('laravel-mix');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/admin/setting.js', 'public/js/admin');
mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/web/home.js', 'public/js/web')
    .js('resources/js/web/article-detail.js', 'public/js/web')
    .js('resources/js/web/product-brand.js', 'public/js/web')
    .js('resources/js/web/product-deal-hot.js', 'public/js/web')
    .js('resources/js/web/product-deal-now.js', 'public/js/web')
    .js('resources/js/web/product-flash-sale.js', 'public/js/web')
    .js('resources/js/web/product-new.js', 'public/js/web')
    .js('resources/js/web/product-search.js', 'public/js/web')
    .js('resources/js/web/product-detail.js', 'public/js/web')
    .js('resources/js/web/product-cat.js', 'public/js/web')
    .extract([
        'jquery',
        'bootstrap',
        'sweetalert2',
        'slick-carousel',
        '@tarekraafat/autocomplete.js',
        'vanilla-lazyload'
    ]).sourceMaps().version();

mix.sass('resources/sass/home.scss', 'public/css/web')
    .sass('resources/sass/content.scss', 'public/css/web')
    .sass('resources/sass/article-list.scss', 'public/css/web')
    .sass('resources/sass/article-detail.scss', 'public/css/web')
    .sass('resources/sass/product-cat.scss', 'public/css/web')
    .sass('resources/sass/product-detail.scss', 'public/css/web')
    .sass('resources/sass/brand-list.scss', 'public/css/web')
    .sass('resources/sass/cart-checkout.scss', 'public/css/web')
    .sass('resources/sass/cart-payment.scss', 'public/css/web')
    .sass('resources/sass/cart-success.scss', 'public/css/web')
    .sass('resources/sass/cart-detail-success.scss', 'public/css/web')
    .sass('resources/sass/sale.scss', 'public/css/web')
    .sass('resources/sass/hot-deal.scss', 'public/css/web')
    .sass('resources/sass/deal-detail.scss', 'public/css/web')
    .sass('resources/sass/login-admin.scss', 'public/css/web')
    .purgeCss()
    .sourceMaps().version();
