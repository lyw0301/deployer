const mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
  .extract(['vue', 'admin-lte', 'select2'])
  .sass('resources/assets/sass/app.scss', 'public/css')
  .version();
