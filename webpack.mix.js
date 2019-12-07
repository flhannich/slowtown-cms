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
   .sass('resources/sass/app.scss', 'public/css');



// http://channingdefoe.com/vuejs-code-splitting-in-laravel-webpack/
//
// Vue.component('example-component', () => import(/* webpackChunkName:"example-component" */ './components/ExampleComponent.vue'));
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
//
// mix.webpackConfig({
//     output: {
//         // Chunks in webpack
//         publicPath: '/',
//         chunkFilename: 'js/components/[name].js',
//     },
// });
