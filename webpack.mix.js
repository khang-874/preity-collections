var LiveReloadPlugin = require('webpack-livereload-plugin');

let mix = require('laravel-mix');

mix.js('src/app.js', 'dist').setPublicPath('dist');


//Ensure this is added at after your mix.js() code lines.
mix.webpackConfig({
    plugins: [new LiveReloadPlugin()]
});