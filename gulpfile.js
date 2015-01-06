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
gulp.task( 'js', function() {
	// PC
	gulp.src(['js/mak_pc.js', 'js/functions_common/*.js', 'js/functions_pc/*.js' ])
		.pipe($.jshint())
		.pipe($.jshint.reporter('default'))
		.pipe($.concat('pc.js'))
		.pipe(gulp.dest('js'))
		.pipe($.concat('pc.min.js'))
		.pipe($.uglify())
		.pipe(gulp.dest('../../../assets/js'))

	// Mobile
	gulp.src(['js/mak_mobile.js', 'js/functions_common/*.js', 'js/functions_mobile/*.js' ])
		.pipe($.jshint())
		.pipe($.jshint.reporter('default'))
		.pipe($.concat('mobile.js'))
		.pipe(gulp.dest('js'))
		.pipe($.concat('mobile.min.js'))
		.pipe($.uglify())
		.pipe(gulp.dest('../../../assets/js'))
});

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
			comments:  true,
			force:     true
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
			comments:  false,
			force:     true
		}))
});

// watch
gulp.task( 'watch', function () {
	gulp.watch( 'js/*.js', ['js'] );
	gulp.watch( 'sass/{,*/}{,*/}*.scss', ['compass'] );
	gulp.watch( 'images/{,*/}{,*/}*.*', ['images'] );
});
