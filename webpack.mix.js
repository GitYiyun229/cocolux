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
    .sass('resources/sass/home.scss', 'public/css/web')
    .sass('resources/sass/contact.scss', 'public/css/web')
    .sass('resources/sass/page-home.scss', 'public/css/web')
    .sass('resources/sass/news-home.scss', 'public/css/web')
    .sass('resources/sass/news-detail.scss', 'public/css/web')
    .sass('resources/sass/contact-detail.scss', 'public/css/web')
    .sass('resources/sass/album-home.scss', 'public/css/web')
    .sass('resources/sass/store-home.scss', 'public/css/web')
    .sass('resources/sass/products-home.scss', 'public/css/web')
    .sass('resources/sass/product-detail.scss', 'public/css/web')
    .sass('resources/sass/product-cart.scss', 'public/css/web')
    .sourceMaps();
