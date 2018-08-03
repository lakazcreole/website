let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

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
   .js('resources/assets/js/dashboard.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/dashboard.scss', 'public/css')
   // Necessary because processCssUrls is false
   .copy('resources/assets/images', 'public/images', true)
   .copy('resources/assets/images/icons', 'public/images/icons', true)
   .options({
      processCssUrls: false, // necessary to enable tailwindcss because of unresolved issue in laravel-mix
      purifyCss: true,
      postCss: [ tailwindcss('./tailwind.js') ],
    });
