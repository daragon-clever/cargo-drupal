const path = require('path')
const globImporter = require('node-sass-glob-importer')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const StylelintWebpackPlugin = require('stylelint-webpack-plugin')

module.exports = (env, argv) => [{
  name: 'styles',
  entry: {
    'main': './src/styles/styles.scss',
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
      {
        test: /\.svg$/,
        use: [
          {
            loader: '@svgr/webpack',
          },
        ],
      }
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[name].css'
    }),
    new StylelintWebpackPlugin({
      emitWarning: true,
      files: '**/*.scss'
    }),
  ],
}, {
  name: 'js',
  entry: './src/js/index.js',
  output: {
    filename: 'script.js',
    path: path.resolve(__dirname, 'public/js'),
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
  }
}]
// }, {
//   name: 'assets',
//   plugins: [
//     new CopyWebpackPlugin({
//       patterns: [
//         {
//           from: path.resolve(__dirname, "src/assets/"),
//           to: path.resolve(__dirname, "public/assets"),
//           globOptions: {
//             ignore: path.resolve(__dirname, "src/assets/svg")
//           }
//         },
//       ]
//     }),
//   ]
// }]
