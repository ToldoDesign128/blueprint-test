// webpack.mix.js

let mix = require('laravel-mix');
let minifier = require('minifier');

mix.sass('assets/css/style.scss', 'style.css');
mix.minify(['assets/js/script.js']);

mix.webpackConfig({
  watchOptions: {
    ignored: /node_modules/
  },
  stats: {
    children: true,
},
})

mix.then(() => {
    minifier.minify('style.css')
});
