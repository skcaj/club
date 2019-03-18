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

mix.styles([
   'resources/assets/mix/css/font-awesome.min.css',
   'resources/assets/mix/css/simple-line-icons.min.css',
   'resources/assets/mix/css/pace.min.css',
   'resources/assets/mix/css/style.css',
   'resources/assets/mix/css/datepicker.css',
   //'resources/assets/mix/css/miguelAdmin.min.css'
], 'public/css/mix.css')
.scripts([
   
   'resources/assets/mix/js/jquery.min.js',
   'resources/assets/mix/js/popper.min.js',
   'resources/assets/mix/js/bootstrap.min.js',
    'resources/assets/mix/js/pace.min.js',
   'resources/assets/mix/js/coreui.min.js',
   'resources/assets/mix/js/sweetalert2.all.min.js',
   'resources/assets/mix/js/bootstrap-datepicker.min.js',
   'resources/assets/mix/js/perfect-scrollbar.min.js'
], 'public/js/mix.js')
.js(['resources/assets/js/app.js'], 'public/js/app.js');
