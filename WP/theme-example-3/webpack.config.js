const path = require('path');
const fs = require('fs');
const webpack = require('webpack');
const merge = require('webpack-merge');
const autoprefixer = require('autoprefixer');

const VueLoaderPlugin = require('vue-loader/lib/plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const WebpackAssetsManifest = require('webpack-assets-manifest');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');

let CustomConfig = {};

if (fs.existsSync('./webpack.custom.js')) {
    CustomConfig = require('./webpack.custom');
}

const isDev = process.env.NODE_ENV === 'development';

const BaseConfig = {
    entry: {
        app: './assets/index.js'
    },
    output: {
        filename: 'js/[name].[contenthash].js',
        chunkFilename: 'js/[name].[contenthash].chunk.js',
        path: path.resolve('dist'),
        publicPath: '/app/themes/theme.wp.theme/dist/'
    },
    mode: isDev ? 'development' : 'production',
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: [{
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            'scss': 'vue-style-loader!css-loader!sass-loader',
                            'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
                        }
                    }
                }]
            },
            {
                test: /\.js$/,
                use: [{
                    loader: 'babel-loader'
                }],
                //exclude: /node_modules/
                exclude: /node_modules\/(?!(dom7|ssr-window|swiper)\/).*/
            },
            {
                test: /\.scss$/,
                use: [
                    isDev ? 'vue-style-loader' : MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                            sourceMap: isDev
                        }
                    },
                    'postcss-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            url: false,
                            sourceMap: isDev,
                            data: '@import "@/sass/_vue-globals.scss";'
                        }
                    }
                ]
            },
            {
                test: /\.css$/,
                include: /node_modules/,
                use: [
                    isDev ? 'vue-style-loader' : MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                            sourceMap: isDev
                        }
                    },
                    'postcss-loader'
                ]
            },
            {
                test: /\.(png|jpe?g|gif|svg|ttf|woff|woff2)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[path][hash].[ext]'
                        }
                    }
                ]
            }
        ]
    },
    resolve: {
        alias: {
            '@': path.join(__dirname, './assets'),
            vue$: isDev ? 'vue/dist/vue.js' : 'vue/dist/vue.min.js',
            jquery: 'jquery/dist/jquery.min',
            'materialize-css': 'materialize-css/dist/js/materialize.min'
        },
        extensions: ['*', '.js', '.vue', '.json']
    },
    plugins: [
        // make sure to include the plugin!
        new VueLoaderPlugin(),
        new webpack.LoaderOptionsPlugin({
            options: {
                postcss: [
                    autoprefixer()
                ]
            }
        }),
        new WebpackAssetsManifest({
            output: 'asset-manifest.json'
        })
    ]
};

const DevConfig = {
    devServer: {
        historyApiFallback: true,
        overlay: true,
        writeToDisk: true,
        host: 'jordibelp.incms.net',
        port: 3000,
        hot: true,
        disableHostCheck: true
    },
    output: {
        filename: 'js/[name].js',
        chunkFilename: 'js/[name].js'
    },
    plugins: [
        new FriendlyErrorsWebpackPlugin()
    ],
    devtool: 'cheap-module-eval-source-map'
};

if (fs.existsSync('/usr/local/nginx/conf/ssl.key/incms.net.key')) {
    DevConfig.devServer.https = {
        key: fs.readFileSync('/usr/local/nginx/conf/ssl.key/incms.net.key'),
        cert: fs.readFileSync('/usr/local/nginx/conf/ssl.crt/incms.net.crt')
    };
}
const ProdConfig = {
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].[contenthash].css'
        }),
        new FixStyleOnlyEntriesPlugin({extensions: ['less', 'scss', 'css', 'sass']}),
        new webpack.HashedModuleIdsPlugin() // so that file hashes don't change unexpectedly
    ],
    optimization: {
        runtimeChunk: 'single',
        splitChunks: {
            chunks: 'all'
        },
        namedModules: true,
        namedChunks: true,
        minimizer: [
            new OptimizeCssAssetsPlugin({
                cssProcessorPluginOptions: {
                    preset: [
                        'default',
                        {
                            discardComments: {removeAll: true}
                        }
                    ]
                }
            }),
            new TerserPlugin({
                cache: true,
                parallel: true,
                sourceMap: false, // Must be set to true if using source-maps in production
                terserOptions: {
                    // https://github.com/webpack-contrib/terser-webpack-plugin#terseroptions
                }
            })
        ]
    }
};

module.exports = isDev ? merge(BaseConfig, DevConfig, CustomConfig) : merge(BaseConfig, ProdConfig, CustomConfig);
