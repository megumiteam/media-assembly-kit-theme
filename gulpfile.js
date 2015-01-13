var gulp           = require('gulp');
var $              = require('gulp-load-plugins')();
var mainBowerFiles = require('main-bower-files');
var runSequence    = require('run-sequence');

// default task
gulp.task( 'default', ['images', 'compass', 'js', 'jade'] );

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
	// wpjson
	gulp.src( 'js/wpjson.js' )
		.pipe($.jshint())
		.pipe($.jshint.reporter('default'))
		.pipe($.concat('wpjson.min.js'))
		.pipe($.uglify())
		.pipe(gulp.dest('../../../assets/js'))

	// PC
	gulp.src(['js/mak_pc.js', 'js/functions_common/*.js', 'js/functions_pc/*.js', '! js/wpjson.js' ])
		.pipe($.jshint())
		.pipe($.jshint.reporter('default'))
		.pipe($.concat('pc.js'))
		.pipe(gulp.dest('js'))
		.pipe($.concat('pc.min.js'))
		.pipe($.uglify())
		.pipe(gulp.dest('../../../assets/js'))

	// Mobile
	gulp.src(['js/mak_mobile.js', 'js/functions_common/*.js', 'js/functions_mobile/*.js', '! js/wpjson.js' ])
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

// jade
gulp.task('jade', function() {
  // PC
  gulp.src(['json-template/pc/{,*/}{,*/}*.jade', '!json-template/{,*/}{,*/}_*.jade'])
    .pipe($.jade({
	    'pretty': true
    }))
    .pipe(gulp.dest('../../../json-template-pc/'))
  // Mobile
  gulp.src(['json-template/mobile/{,*/}{,*/}*.jade', '!json-template/{,*/}{,*/}_*.jade'])
    .pipe($.jade({
	    'pretty': true
    }))
    .pipe(gulp.dest('../../../json-template-mobile/'))
});

// watch
gulp.task( 'watch', function () {
	gulp.watch( 'js/*.js', ['js'] );
	gulp.watch( 'sass/{,*/}{,*/}*.scss', ['compass'] );
	gulp.watch( 'images/{,*/}{,*/}*.*', ['images'] );
});


// Test
gulp.task('test', function() {
  // PC
  gulp.src(['../../../json-template-pc/search.html', '../../../json-template-pc/404.html'])
    .pipe(gulp.dest('../../../test/pc/'))
  gulp.src('../../../json-template-pc/index.html')
    .pipe(gulp.dest('../../../test/pc/'))
    .pipe(gulp.dest('../../../test/pc/page/2'))
  gulp.src('../../../json-template-pc/archive.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/pc/category/money/'))
    .pipe(gulp.dest('../../../test/pc/category/money/page/2'))
    .pipe(gulp.dest('../../../test/pc/author/digitalcube/'))
  gulp.src('../../../json-template-pc/summary.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/pc/summary/2014/12/19/51589/'))
  gulp.src('../../../json-template-pc/post.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/pc/2014/12/19/51589/'))
  gulp.src('../../../json-template-pc/page.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/pc/contact/'))

  // Mobile
  gulp.src(['../../../json-template-mobile/search.html', '../../../json-template-mobile/404.html'])
    .pipe(gulp.dest('../../../test/mobile/'))
  gulp.src('../../../json-template-mobile/index.html')
    .pipe(gulp.dest('../../../test/mobile/'))
    .pipe(gulp.dest('../../../test/mobile/page/2'))
  gulp.src('../../../json-template-mobile/archive.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/mobile/category/money/'))
    .pipe(gulp.dest('../../../test/mobile/category/money/page/2'))
    .pipe(gulp.dest('../../../test/mobile/author/digitalcube/'))
  gulp.src('../../../json-template-mobile/summary.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/mobile/summary/2014/12/19/51589/'))
  gulp.src('../../../json-template-mobile/post.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/mobile/2014/12/19/51589/'))
  gulp.src('../../../json-template-mobile/page.html')
    .pipe($.concat('index.html'))
    .pipe(gulp.dest('../../../test/mobile/contact/'))
});

