const elixir = require('laravel-elixir');
const Elixir = require('laravel-elixir-webpack-official');
const webpack = require('webpack');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */
elixir.webpack.mergeConfig({
    module: {
        noParse: [/moment.js/]
    }
    // ,plugins: [new webpack.ContextReplacementPlugin(/\.\/locale$/, null, false, /js$/)]
});

elixir((mix) => {
    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/fonts/bootstrap');
    mix.copy('resources/assets/images/','public/images');
    mix.sass('app.scss');
    mix.webpack('app.js');
    mix.scripts([
        '../../../node_modules/moment/min/moment.min.js',
        '../../../node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
    ], 'public/js/datetime.js');
    mix.scripts(['chores/add.js'], 'public/js/chores/add.js');
    mix.scripts(['chores/schedule.today.js'], 'public/js/chores/schedule.today.js');
});
