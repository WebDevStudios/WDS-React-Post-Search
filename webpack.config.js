const path = require( 'path' );

module.exports = {
    entry: './assets/js/public.js',
    externals: {
        jquery: 'jQuery'
    },
    output: {
        filename: 'public.min.js',
        path: path.resolve( __dirname, 'assets/js' )
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [ 'babel-preset-env', 'babel-preset-react' ]
                    }
                }
            }
        ]
    }
};