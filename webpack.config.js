const path = require("path");

module.exports = {
	entry: "./assets/js/public.js",
	externals: {
		jquery: "jQuery"
	},
	output: {
		filename: "public.js",
		path: path.resolve(__dirname, "assets/js")
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: {
					loader: "babel-loader"
				}
			}
		]
	}
};
