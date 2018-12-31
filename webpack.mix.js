let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js').extract(['vue'])
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.sass('resources/assets/sass/dark.scss', 'public/css');

mix.js('resources/assets/js/calendar.js', 'public/js')
    .sass('resources/assets/sass/calendar.scss', 'public/css');

// TODO: 未使用
//mix.js('resources/assets/js/messagebox.js', 'public/js');

mix.js('resources/assets/js/modal.js', 'public/js');
mix.js('resources/assets/js/tag.js', 'public/js');
mix.js('resources/assets/js/lang.js', 'public/js');

mix.js('resources/assets/js/select.js', 'public/js')
     .sass('resources/assets/sass/select.scss', 'public/css');

mix.js('resources/assets/js/chart.js', 'public/js')
    .sass('resources/assets/sass/chart.scss', 'public/css');

//mix.js('resources/assets/js/i18n.js', 'public/js');

// develop環境の時にソースマップを表示
// if (!mix.inProduction()) {
//     mix.webpackConfig({
//         devtool: 'source-map'
//     }).sourceMaps()
// }
