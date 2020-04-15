let mix = require('laravel-mix')

mix.setPublicPath('public/assets')
    .js('assets/js/laravel.js', 'js')
    .sass('assets/sass/laravel.scss', 'css')

