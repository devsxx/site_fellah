const 	gulp 			= require('gulp'),
		plumber 		= require('gulp-plumber'),
		sass 			= require('gulp-sass'),
		concat 			= require('gulp-concat'),
		uglify 			= require('gulp-uglify'),
		imagemin 		= require('gulp-imagemin'),
		cleanCSS 		= require('gulp-clean-css'),
		sourcemaps		= require('gulp-sourcemaps'),
		autoprefixer	= require('gulp-autoprefixer'),
		watch 			= require('gulp-watch'),
		rename 			= require("gulp-rename"),
		livereload 		= require('gulp-livereload'),
		sassdoc 		= require('sassdoc'),
		cmq          	= require('gulp-combine-media-queries'),
		ignore      	= require('gulp-ignore'), // Helps with ignoring files and directories in our run tasks
		rimraf      	= require('gulp-rimraf'), // Helps with removing files and directories in our run tasks
		zip         	= require('gulp-zip'), // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress!
		cache       	= require('gulp-cache'),
		runSequence 	= require('gulp-run-sequence');


const 	dir_sass 		= ['./js/libs/bootstrap/sass/**/*','./js/libs/font-awesome/scss/font-awesome.scss','./sass/**/*.scss'],
	 	style_sass 		= './sass/style.scss',
		dir_css 		= './',
		dir_image 		= './images/**/*', 
		images_comp		= '../../prod/imagemin'  ;



var sassOptions = {
	errLogToConsole: true,
	outputStyle: 'expanded'
};
var sassOptionsCompact = {
	errLogToConsole: true,
	outputStyle: 'compact'
};
var sassOptionsCompressed = {
	errLogToConsole: true,
	outputStyle: 'compressed'
};

 
gulp.task('generate_style', function() {
	gulp.src(style_sass)
	.pipe(sourcemaps.init())
	.pipe(sass(sassOptions).on('error', sass.logError))
	.pipe(autoprefixer())
	.pipe(plumber())
	.pipe(gulp.dest(dir_css))
	.pipe(cleanCSS())
	.pipe(rename({suffix: '.min'}))
	.pipe(sourcemaps.write('/maps'))
	.pipe(gulp.dest(dir_css))
	.pipe(livereload());
});

//Watch task
gulp.task('default',function() {
	gulp.watch( dir_sass, [ 'generate_style' ] 	); 
	livereload.listen();
});


gulp.task('imagemin', function(){
	gulp.src(dir_image)
	.pipe(imagemin())
	.pipe(plumber())
	.pipe(gulp.dest(images_comp))
});


gulp.task('uglifyJS', function () {
	gulp.src('js/global.js')
	.pipe(uglify())
	.pipe(plumber())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('js/'))
	.pipe(livereload());

});

gulp.task('uglifyJsHome', function () {
	gulp.src('home/js/script.js')
	.pipe(uglify())
	.pipe(plumber())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('home/js/'))	
	.pipe(livereload());

}); 

 