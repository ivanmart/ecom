const { mix } = require('laravel-mix');

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

mix
    .js('resources/assets/js/app.js', 'public/js')
    .scripts([
        'resources/assets/js/imslider.jquery.js',
        'resources/assets/js/jquery.fancybox.min.js',
        'resources/assets/js/common.js',
    ], 'public/js/all.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/imslider.css', 'public/css')
    .sass('resources/assets/sass/jquery.fancybox.min.css', 'public/css')
    .options({processCssUrls: false})
    // .version();

// mix.browserSync('ecom.local');
