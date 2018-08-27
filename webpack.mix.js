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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'public/css/bootstrap.min.css',
    'public/css/ionicons.min.css'
], 'public/css/landingpage.css');

mix.styles([
    'public/css/bootstrapsocial.css',
    'public/css/fontawesome.min.css',
    'public/css/ionicons.min.css',
    'public/css/styleapp.css',
    'public/css/style.css'
], 'public/css/otrosall.css');

mix.styles([
    'public/css/select2.min.css',
    'public/css/font.googleapi.css',
    'public/css/ionicons.min.css',
    'public/css/bootstrap3.3.7.min.css',
    'public/css/materialize.min.css',
    'public/css/styleapp.css',
    'public/css/fontawesome.min.css',
    'public/css/materialize.min.css',
    'public/css/animate.css',
    'public/css/style.css',
    'public/css/bootstrapnotifications.min.css',

], 'public/css/otrosappall.css');


mix.scripts([
    'public/js/doperaciones.js'
], 'public/js/alldo.js');
mix.scripts([
    'public/js/home.js'
], 'public/js/homeapp.js');
mix.scripts([
    'public/js/appprincipal.js'
], 'public/js/appprincipalall.js');
mix.scripts([
    'public/js/funcionesgenerales.js'
], 'public/js/funcionesgeneralesall.js');
mix.scripts([
    'public/js/instascan.min.js'
], 'public/js/instascanall.js');

mix.scripts([
    'public/js/materialize.min.js',
    'public/js/jqueryui.js',
    'public/js/select2.min.js',
    'public/js/es.js',
    'public/js/timeago.js',
    'public/js/jquery.dataTables.min.js'
], 'public/js/scriptgeneral.js');

if (mix.inProduction()) {
    mix.version();
}
mix.browserSync({
        proxy: 'http://localhost:8000',
        browser:'Google chrome',
        open: false
    });
mix.disableNotifications();