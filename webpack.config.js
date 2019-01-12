const path = require('path');

module.exports = (env, argv) => {
  let production = argv.mode === 'production'

  return {
    watch: true,
    entry: [
        './react/admin.js',
        './react/sass/main.scss'
    ],

    output: {
        filename: 'js/[name].js',
        path: path.resolve(__dirname, 'assets'),
    },

    devtool: production ? '' : 'source-map',
  
    // resolve: {
    //     extensions: [".js", ".jsx", ".json" ],
    // },
  
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'css/[name].css',
                        }
                    },
                    {
                        loader: 'extract-loader'
                    },
                    {
                        loader: 'css-loader', options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'postcss-loader', options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'sass-loader', options: {
                            sourceMap: true,
                            outFile: './assets/css/[name].css'
                        }
                    }
                ],
            }
        ]
    },
  };
}
