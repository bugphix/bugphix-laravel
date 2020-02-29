const mix = require('laravel-mix');

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

const assetsPath = 'assets';
const resources = 'src/Resources';

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue'],
    alias: {
      '@': __dirname + `/${resources}/js`, // for alias imports
      '@BaseUI': __dirname + `/${resources}/js/components/BaseUI`,
      '@Pages': __dirname + `/${resources}/js/components/Pages`,
    }
  },
  module: {
    rules: [
      {
        test: /\.pug$/,
        oneOf: [
          {
            resourceQuery: /^\?vue/,
            use: ['pug-plain-loader']
          },
          {
            use: ['raw-loader', 'pug-plain-loader']
          }
        ]
      }
    ]
  }
})
.copy(`node_modules/@mdi`, `${assetsPath}/plugins/@mdi`)
.js(`${resources}/js/app.js`, `${assetsPath}/js`)
.sass(`${resources}/sass/app.scss`, `${assetsPath}/css`)
.copy(`${resources}/images`, `${assetsPath}/images`);
