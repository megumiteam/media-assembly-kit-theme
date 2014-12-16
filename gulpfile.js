var gulp           = require('gulp');
var $              = require('gulp-load-plugins')();
var mainBowerFiles = require('main-bower-files');
var runSequence    = require('run-sequence');

// default task
gulp.task( 'default', ['images', 'compass'] );

// init task
gulp.task( 'init', function() {
	runSequence( 'bower', 'lib', 'images', 'fonts', 'compass' );
});

// bower_components 
gulp.task( 'bower', function() {
	return gulp.src(mainBowerFiles())
		.pipe(gulp.dest('../../../assets/lib'))
});

// lib > assets/lib
gulp.task( 'lib', function() {
	gulp.src('lib/{,*/}{,*/}*')
		.pipe(gulp.dest('../../../assets/lib'))
});

// images
gulp.task( 'images', function() {
	gulp.src('images/{,*/}{,*/}*')
		.pipe($.imagemin())
		.pipe(gulp.dest('../../../assets/images'))
});

// fonts
gulp.task( 'fonts', function() {
	gulp.src('fonts/{,*/}{,*/}*')
		.pipe(gulp.dest('../../../assets/fonts'))
});


// javascript
/*
gulp.task( 'js', function() {
	return gulp.src('js/media-assembly-kit.js')
		.pipe($.jshint())
		.pipe($.jshint.reporter('default'))
		.pipe(gulp.dest('js'))
});
*/

// compass(sass)
gulp.task( 'compass', function() {
	// dev
	gulp.src('sass/{,*/}{,*/}*.scss')
		.pipe($.compass({
			sass:      'sass',
			css:       'css',
			image:     'images',
			style:     'expanded',
			relative:  true,
			sourcemap: true,
			comments:  true
		}))

	// dist
	gulp.src( 'sass/{,*/}{,*/}*.scss' )
		.pipe($.compass({
			sass:      'sass',
			css:       '../../../assets/css',
			image:     '../../../assets/images',
			style:     'compressed',
			relative:  true,
			sourcemap: false,
			comments:  false
		}))
});

// watch
gulp.task( 'watch', function () {
	gulp.watch( 'js/media-assembly-kit.js', ['js'] );
	gulp.watch( 'sass/{,*/}{,*/}*.scss', ['compass'] );
	gulp.watch( 'images/{,*/}{,*/}*.*', ['images'] );
});
