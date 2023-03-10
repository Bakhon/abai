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
    resolve: {
        alias: {
            '@store': path.resolve(__dirname, 'resources/js/store/'),
            '~': path.resolve(__dirname, 'resources/js/'),
            '@ui-kit': path.resolve(__dirname, 'resources/js/components/ui-kit/'),
            '@sass': path.resolve(__dirname, 'resources/sass/'),
        }
    }
});

mix.js('resources/js/app.js', 'public/js')
    mix.sass('resources/sass/app.scss', 'public/css')
        .copyDirectory('resources/sass/font', 'public/fonts')
        .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

