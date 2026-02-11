const path = require('path');
const webpack = require('webpack');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  entry: path.resolve(__dirname, 'assets/js/main.js'),
  output: {
    path: path.resolve(__dirname, 'public/build'),
    filename: 'app.js',
    publicPath: '/build/'
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.scss$/,
        use: ['vue-style-loader', 'css-loader', 'sass-loader']
      },
      {
        test: /\.css$/,
        use: ['vue-style-loader', 'css-loader']
      }
    ]
  },
  resolve: {
    alias: {
      vue$: 'vue/dist/vue.esm.js'
    },
    extensions: ['.js', '.vue', '.json']
  },
  plugins: [
    new VueLoaderPlugin(),
    new webpack.DefinePlugin({
      'process.env.VUE_APP_API_BASE': JSON.stringify(process.env.VUE_APP_API_BASE || ''),
      'process.env.VUE_APP_COUNTRY': JSON.stringify(process.env.VUE_APP_COUNTRY || '')
    })
  ],
  stats: 'errors-warnings'
};
