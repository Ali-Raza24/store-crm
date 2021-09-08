const mix = require('laravel-mix');
const CaseSensitivePathsPlugin = require('case-sensitive-paths-webpack-plugin');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
var webpackConfig = {
  plugins: [
    new CaseSensitivePathsPlugin(),
    new VuetifyLoaderPlugin()
    // other plugins ...
  ]
  // other webpack config ...
};

mix.webpackConfig(webpackConfig);

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

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/business/image.js', 'public/js');
mix.js('resources/js/admin/business.js', 'public/js');
mix.js('resources/js/business/settings.js', 'public/js');
mix.js('resources/js/business/stores.js', 'public/js');
mix.vue();
mix.sass('resources/sass/app.scss', 'public/css');
mix.js('resources/js/business/areas.js', 'public/js');
mix.js('resources/js/admin/areas.js', 'public/js/admin');
mix.js('resources/js/business/product.js', 'public/js');
mix.js('resources/js/business/product-update.js', 'public/js');
mix.js('resources/js/business/discount.js', 'public/js');
mix.js('resources/js/business/customer.js', 'public/js');

mix.js('resources/js/notifications.js', 'public/js');
/*mix.copy(
  'vendor/proengsoft/laravel-jsvalidation/public',
  'public/vendor/jsvalidation'
);*/
