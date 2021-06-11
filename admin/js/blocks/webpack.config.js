module.exports = {
	entry: './firstblock/block.js',
	output: {
		path: __dirname,
		filename: 'firtst-block.js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader'
				},
			},
		],
	}
}
