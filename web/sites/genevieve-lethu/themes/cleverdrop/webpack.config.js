const path = require('path')
const globImporter = require('node-sass-glob-importer')
const CopyPlugin = require('copy-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

module.exports = (env, argv) => [{
  name: 'styles',
  entry: {
    styles: './src/scss/styles.scss'
  },
  output: {
    path: path.resolve(__dirname, "public/css"),
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: 'css-loader',
            options: {
              url: false,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  require('autoprefixer')(),
                ]
              }
            },
          },
          {
            loader: 'sass-loader',
            options: {
              additionalData: "$env: " + argv.mode + ";",
              sassOptions: {
                importer: globImporter()
              }
            }
          },
        ],
      },
      {
        test: /\.(woff|woff2|png|jpg|gif)$/,
        use: {
          loader: 'url-loader'
        }
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[name].css'
    }),
    new SVGSpritemapPlugin(path.resolve('src/assets/svg/*.svg'), {
      output: {
        filename: '../assets/sprite.svg',
      },
      sprite: {
        prefix: false,
        generate: {
          title: false,
          symbol: true,
          use: false
        }
      }
    }),
    new CopyPlugin({
      patterns: [
        {
          from: path.resolve(__dirname, "src/assets/"),
          to: path.resolve(__dirname, "public/assets"),
          globOptions: {
            ignore: path.resolve(__dirname, "src/assets/svg")
          }
        },
      ]
    }),
  ],
}, {
  name: 'scripts',
  entry: {
    scrpits: './src/js/scripts.js'
  },
  output: {
    path: path.resolve(__dirname, 'public/js'),
    filename: '[name].js',
  },
  module: {
    rules: [
      {
        // Include ts, tsx, js, and jsx files.
        test: /\.(ts|tsx|jsx|js)?$/,
        exclude: [
          /node_modules/,
        ],
        loader: 'babel-loader',
      },
    ]
  },
}]
