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

if (mix.inProduction()) {
   mix.version()
}

mix
   // Necessary because processCssUrls is false
   .copy('resources/images', 'public/images', true)
   .copy('resources/images/icons', 'public/images/icons', true)
   .js('resources/js/app.js', 'public/js')
   .js('resources/js/dashboard.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/dashboard.scss', 'public/css')
   .options({
      processCssUrls: false, // necessary to enable tailwindcss because of unresolved issue in laravel-mix
      purifyCss: true,
      postCss: [ tailwindcss('./tailwind.js') ],
    });
