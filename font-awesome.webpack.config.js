const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    entry: './resources/assets/js/font-awesome.js',
    output: {
        filename: "public/js/font-awesome.js"
    },
    plugins: [
        new UglifyJSPlugin()
    ],
    resolve: {
        alias: {
            '@fortawesome/fontawesome-free-solid$': '@fortawesome/fontawesome-free-solid/shakable.es.js'
        }
    }
};