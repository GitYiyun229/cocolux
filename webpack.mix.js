const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/web/main.js', 'public/js/web')
    .js('resources/js/admin/setting.js', 'public/js/admin')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/style.scss', 'public/css/web')
    .sass('resources/sass/template.scss', 'public/css/web')
    .sass('resources/sass/home.scss', 'public/css/web')
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
    .sourceMaps();
