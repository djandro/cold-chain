const webpack = require('webpack');
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

mix.webpackConfig({
 plugins: [
  new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
 ]
});

mix.styles([
 'resources/sass/font-face.css',
 'resources/js/vendor/font-awesome-4.7/css/font-awesome.min.css',
 'resources/js/vendor/font-awesome-5/css/fontawesome-all.min.css',
 'resources/js/vendor/mdi-font/css/material-design-iconic-font.min.css'
], 'public/css/fonts.css')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
     //'resources/js/vendor/animsition/animsition.min.css',
     'resources/js/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css',
     //'resources/js/vendor/wow/animate.css',
     'resources/js/vendor/css-hamburgers/hamburgers.min.css',
     //'resources/js/vendor/dropzone/min/dropzone.min.css',
     //'resources/js/vendor/slick/slick.css',
     'resources/js/vendor/select2/select2.min.css',
     'resources/js/vendor/perfect-scrollbar/perfect-scrollbar.css',
     'node_modules/bootstrap-table/dist/bootstrap-table.css'
    ], 'public/css/vendor.css')
    .styles([
     'resources/sass/theme.css'
    ], 'public/css/theme.css')
//    .js('resources/js/vendor/jquery-3.2.1.min.js', 'public/js/jquery.js')
    .js([
     //'resources/js/vendor/bootstrap-4.1/popper.min.js',
     //'resources/js/vendor/bootstrap-4.1/bootstrap.min.js',
     //'resources/js/vendor/slick/slick.min.js',
     //'resources/js/vendor/wow/wow.min.js',
     //'resources/js/vendor/animsition/animsition.min.js',
     'resources/js/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js',
     'resources/js/vendor/counter-up/jquery.waypoints.min.js',
     'resources/js/vendor/counter-up/jquery.counterup.min.js',
     'resources/js/vendor/circle-progress/circle-progress.min.js',
     'resources/js/vendor/perfect-scrollbar/perfect-scrollbar.js',
     //'resources/js/vendor/dropzone/min/dropzone.min.js',
     //'resources/js/vendor/chartjs/Chart.bundle.min.js',
     'resources/js/vendor/select2/select2.min.js',
     //'node_modules/bootstrap-table/dist/bootstrap-table.js'
     //'node_modules/highcharts/highcharts.js'
     //'resources/js/vendor/countdown/moment.min.js'
    ], 'public/js/vendor.js')
    .js('resources/js/app.js', 'public/js')
    .copy('resources/js/main.js', 'public/js');