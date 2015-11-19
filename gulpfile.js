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
    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/assets/css/abootstrap.min.css')
    .copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/assets/css/bfont-awesome.min.css')
    .copy('node_modules/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.min.css', 'public/assets/css/cdatatables-bootstrap3.min.css')
    .sass('app.scss', 'public/assets/css/zapp.css')
    .stylesIn("public/assets/css", 'public/assets/build.css')
    ;

  mix
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/assets/js/ajquery.min.js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/assets/js/bboostrap.min.js')
    .copy('node_modules/datatables/media/js/jquery.dataTables.min.js', 'public/assets/js/cjquery.dataTables.min.js')
    .copy('node_modules/datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js', 'public/assets/js/ddatatables-bootstrap3.min.js')
    .copy('node_modules/bootbox/bootbox.min.js', 'public/assets/js/ebootbox.min.js')
    .copy('resources/assets/scripts/app.js', 'public/assets/js/zapp.js')
    .scriptsIn("public/assets/js", 'public/assets/build.js')
    ;

  mix
    .version(["assets/build.js", "assets/build.css"])
    ;

});
