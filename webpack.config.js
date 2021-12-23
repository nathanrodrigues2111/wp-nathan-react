const path = require( 'path' )
module.exports = {
    entry: "./src/index.js",
    resolve: {
		alias: {
			'@Path': path.resolve( __dirname, 'src/' ),
		},
	},
    output: {
        path: __dirname,
        filename: "./dist/bundle.js"
    },
    module: {
        loaders: [
        {
            test: /.js$/,
            loader: "babel-loader",
            exclude: /node_modules/,
            options: {
            presets: [["env", "react"]],
            plugins: ["transform-class-properties"]
            }
        }
        ]
    }
};