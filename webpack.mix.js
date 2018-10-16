const { mix } = require('laravel-mix');

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
 mix.webpackConfig(webpack => {
  return {
	        plugins: [
	            new webpack.ProvidePlugin({
	                $: 'jquery',
	                jQuery: 'jquery',
	                jquery: 'jquery',
	               'window.jQuery': 'jquery'
	        })
	    ]
      };
  })

mix.sass('resources/assets/sass/app.scss', 'public/css')
   .js('resources/assets/js/app.js', 'public/js')
    .extract([
      'vue',
      'vuex',
      'vue-chartjs',
      'moment',
      'axios',
      'jquery',
      'vuetable-2',
      'vue-good-table',
      'vue2-editor',
      'vue-full-calendar'
    ]);

