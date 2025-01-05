/**
 * 	This is a learner template , intended to be very easy to use
 * 	Only two simple tasks are done right now
 * 	1 ) Take .scss file from /resources/scss/ can be changed via let stylesSource. Compile it, generate sourcemap and generate a non-minified and minified version and save it in /assets/css/ folder in the root of the project
 * 	2 ) Take .js files located in resources/js/vendor/ and /resources/js/custom/ and
 * 		i ) concat (join ) all js files
 * 		ii ) minify them (see note for problems with minification )
 * 		iii ) save them to /assets/js/ folder in the root of the project
 *
 * @todo  Browser Sync
 * Currently browser sync is very slow. And not useful for use in development.
 * All online blogs says its a good tool but I am not sure right now
 * 
 *  * eslint-disable no-undef
 *  * cspell:ignore cssnano, Unminified
 * 
 * @format
*/

const { src, dest, watch, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass')); // compiles SASS to CSS
const sourcemaps = require('gulp-sourcemaps'); // generate css source maps
const notify = require('gulp-notify'); // provides notification to use once task is complete
const uglify = require('gulp-uglify'); // minifies js files
const concat = require('gulp-concat'); //concatenates multiple js files
const rename = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const autoprefixer = require('autoprefixer');
const babel = require('gulp-babel');

const stylesSource = './resources/scss/**/*.scss';
const stylesDestination = './assets/css';
const jsVendorSource = './resources/js/vendor/*.js';
const jsVendorDestination = './assets/js';
const jsVendorFile = 'vendor';

const jsCustomSource = './resources/js/custom/*.js';
const jsCustomDestination = './assets/js';
const jsCustomFile = 'main';

/**
 * Compiles the SCSS files to generate minified CSS with sourcemaps.
 */
function compileMinifiedStyles() {
	return src(stylesSource)
		.pipe(plumber({ inherit: false, errorHandler: notify.onError('Error: <%= error.message %>') }))
		.pipe(
			sass({
				includePaths: ['node_modules/bootstrap/scss/'],
			})
		)
		.pipe(postcss([autoprefixer, cssnano({ preset: ['default', { calc: false }] })]))
		.pipe(rename({ suffix: '.min' }))
		.pipe(dest(stylesDestination))
		.pipe(notify({ message: 'TASK: "styles" Completed! 💯', onLast: true }));
}

/**
 * Compiles the SCSS files to generate unminified CSS with sourcemaps.
 */
function compileUnminifiedStyles() {
	return src(stylesSource)
		.pipe(plumber({ inherit: false, errorHandler: notify.onError('Error: <%= error.message %>') }))
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				includePaths: ['node_modules/bootstrap/scss/'],
				outputStyle: 'expanded',
			})
		)
		.pipe(postcss([autoprefixer]))
		.pipe(sourcemaps.write('./maps'))
		.pipe(dest(stylesDestination))
		.pipe(notify({ message: 'TASK: "styles" Completed! 💯', onLast: true }));
}

/**
 * Compile Files in js/vendor intended for vendor scripts example bootstrap, meanmenu, etc
 */
function compileVendorJS() {
	return src(jsVendorSource)
		.pipe(plumber({ inherit: false, errorHandler: notify.onError('Error: <%= error.message %>') }))
		.pipe(concat(jsVendorFile + '.js'))
		.pipe(dest(jsVendorDestination))
		.pipe(
			rename({
				basename: jsVendorFile,
				suffix: '.min',
			})
		)
		.pipe(uglify())
		.pipe(dest(jsVendorDestination))
		.pipe(notify({ message: 'TASK: "compileVendorJS" Completed! 💯', onLast: true }));
}

/**
 * Compile Files in Custom JS intended for non-vendor scripts
 */
function compileCustomJS() {
	return src(jsCustomSource)
		.pipe(plumber({ inherit: false, errorHandler: notify.onError('Error: <%= error.message %>') }))
		.pipe(concat(jsCustomFile + '.js'))
		.pipe(
			babel({
				presets: [
					[
						'@babel/preset-env',
						{
							modules: false,
						},
					],
				],
			})
		)
		.pipe(dest(jsCustomDestination))
		.pipe(
			rename({
				basename: jsCustomFile,
				suffix: '.min',
			})
		)
		.pipe(uglify())
		.pipe(dest(jsCustomDestination))
		.pipe(notify({ message: 'TASK: "compileCustomJS" Completed! 💯', onLast: true }));
}


// Watch and Compile SCSS and JS (default).
// Command: gulp
exports.default = parallel(compileUnminifiedStyles, compileMinifiedStyles, compileVendorJS, compileCustomJS, (done) => {
	watch(stylesSource, parallel(compileUnminifiedStyles, compileMinifiedStyles));
	watch(jsVendorSource, compileVendorJS);
	watch(jsCustomSource, compileCustomJS);
	done();
});


// Watch and Compile SCSS only.
// Command: gulp scss
exports.scss = parallel(compileUnminifiedStyles, compileMinifiedStyles, (done) => {
	watch(stylesSource, parallel(compileUnminifiedStyles, compileMinifiedStyles));
	done();
});


// Watch and Compile JS only (vendor and custom).
// Command: gulp js
exports.js = parallel(compileVendorJS, compileCustomJS, (done) => {
	watch(jsVendorSource, compileVendorJS);
	watch(jsCustomSource, compileCustomJS);
	done();
});


// Watch and Compile JS only (custom JS only).
// Command: gulp customJS
exports.customJS = parallel(compileCustomJS, (done) => {
	watch(jsCustomSource, compileCustomJS);
	done();
});


// Compile only Vendor JS (not watch)
// Command: gulp compileVendorJS
exports.compileVendorJS = compileVendorJS;


// Compile only custom JS (not watch)
// Command: gulp compileCustomJS
exports.compileCustomJS = compileCustomJS;
