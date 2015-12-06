var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  // styles
  mix
    .sass('app.scss', 'public/assets/css/app.css')
    .styles([
        'bootstrap/dist/css/bootstrap.min.css',
        'font-awesome/css/font-awesome.min.css',
        'datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.min.css',
        'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        '../public/assets/css/app.css',
    ], 'public/assets/build.css', 'node_modules/');

  mix
    .scripts([
        'jquery/dist/jquery.min.js',
        'bootstrap/dist/js/bootstrap.min.js',
        'datatables/media/js/jquery.dataTables.min.js',
        'datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js',
        'bootbox/bootbox.min.js',
        'eonasdan-bootstrap-datetimepicker/node_modules/moment/min/moment-with-locales.min.js',
        'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        '../resources/assets/scripts/app.js',
    ], 'public/assets/build.js', 'node_modules/');

  mix
    .version(['assets/build.js', 'assets/build.css']);
});
