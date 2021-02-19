const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-vue-lang');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /resources[\\\/]lang.+\.(php)$/,
                    loader: 'php-array-loader',
                },
                {
                    test: /\.tsx?$/,
                    loader: "ts-loader",
                    options: { appendTsSuffixTo: [/\.vue$/] },
                    exclude: /node_modules/
                }
            ]
        },
        resolve: {
            alias: {
                '@lang': path.resolve('./resources/lang'),
            },
            extensions: ["*", ".js", ".jsx", ".vue", ".ts", ".tsx"]
        }
    })
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')]
    });

