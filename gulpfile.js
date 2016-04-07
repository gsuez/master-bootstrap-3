var gulp = require('gulp');

var config = require('./gulp-config.json');

// Dependencies
var beep        = require('beepbeep');
var browserSync = require('browser-sync');
var cleanCSS    = require('gulp-clean-css');
var concat      = require('gulp-concat');
var del         = require('del');
var fs          = require('fs');
var gutil       = require('gulp-util');
var plumber     = require('gulp-plumber');
var rename      = require('gulp-rename');
var sass        = require('gulp-sass');
var uglify      = require('gulp-uglify');
var zip         = require('gulp-zip');
var xml2js      = require('xml2js');
var parser      = new xml2js.Parser();

var extPath      = '.';
var assetsPath = '.';
var templateName = 'masterbootstrap';

var wwwPath = config.wwwDir + '/templates/' + templateName;

var templateFiles = [
	extPath + '/css/**',
	extPath + '/fonts/**',
	extPath + '/html/**',
	extPath + '/images/**',
	extPath + '/includes/**',
	extPath + '/js/**',
	extPath + '/scss/**',
	extPath + '/vendor/**',
	extPath + '/*.md',
	extPath + '/*.png',
	extPath + '/*.php',
	extPath + '/*.ico',
	extPath + '/*.xml'
];

var onError = function (err) {
    beep([0, 0, 0]);
    gutil.log(gutil.colors.green(err));
};

// Browsersync
gulp.task('browser-sync', function() {
	var browserConfig = {
		proxy : "localhost"
	}

	if (config.hasOwnProperty('browserConfig')) {
		browserConfig = config.browserConfig;
	}

    return browserSync(browserConfig);
});

// Clean
gulp.task('clean', function() {
	return del(wwwPath, {force : true});
});

// Copy
gulp.task('copy', ['clean'], function() {
	return gulp.src(templateFiles,{ base: extPath })
		.pipe(gulp.dest(wwwPath));
});

function compileSassFile(src, destinationFolder, options)
{
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sass())
		.pipe(gulp.dest(assetsPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}))
		.pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(assetsPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}));
}

// Sass
gulp.task('sass', function () {
	return compileSassFile(
		assetsPath + '/scss/template.scss',
		'css'
	);
});

function compileScripts(src, ouputFileName, destinationFolder) {
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(concat(ouputFileName))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}))
		.pipe(uglify())
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}));
}

// Minify scripts
gulp.task('scripts', function () {
	return compileScripts(
		[
			assetsPath + '/js/template.js'
		],
		'template.js',
		'js'
	);
});

// Watch
gulp.task('watch',
	[
		'watch:sass',
		'watch:scripts',
		'watch:template'
	],
	function() {
});

// Watch: template
gulp.task('watch:template',
	function() {
		var exclude = [
			'!' + extPath + '/css/**',
			'!' + extPath + '/scss/**',
			'!' + extPath + '/js/**',
		];

		gulp.watch(templateFiles.concat(exclude),['copy']);
});

// Watch: sass
gulp.task('watch:sass',
	function() {
		gulp.watch(
			extPath + '/scss/**',
			['sass']
		);
});

// Watch: scripts
gulp.task('watch:scripts',
	function() {
		gulp.watch([
			extPath + '/js/template.js'
			],
			['scripts']
		);
});

// Release
gulp.task('release', function (cb) {
	fs.readFile(extPath + '/templateDetails.xml', function(err, data) {
		parser.parseString(data, function (err, result) {
			var version = result.extension.version[0];

			var fileName = result.extension.name + '-v' + version + '.zip';

			return gulp.src(templateFiles,{ base: extPath })
				.pipe(zip(fileName))
				.pipe(gulp.dest('releases'))
				.on('end', cb);
		});
	});
});

// Default task
gulp.task('default', ['copy', 'watch', 'browser-sync'], function() {
});

