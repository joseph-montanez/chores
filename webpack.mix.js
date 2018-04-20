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

mix.disableNotifications();

mix.js('resources/assets/js/app2.js', 'public/js')
    .js('resources/assets/js/chores/add.js', 'public/js/chores')
    .js('resources/assets/js/chores/schedule.today.js', 'public/js/chores')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/app2.scss', 'public/css')
    .sourceMaps()
    .extract(['vue', 'axios'])
    .browserSync({
        proxy: 'localhost:8000',
        scrollRestoreTechnique: 'cookie',
        files: [
            'resources/views/**/*.blade.php'
        ]
    });

if (mix.inProduction()) {
    mix.version();
}