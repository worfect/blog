const mix = require('laravel-mix');

mix.webpackConfig({
    stats: {
        children: true,
    },
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.browserSync({
    open: false,
    proxy: 'webserver:3000' // replace with your web server container
})
