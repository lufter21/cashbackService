var gulp = require('gulp'),
sass = require('gulp-sass'),
notify = require("gulp-notify"),
sourcemaps = require('gulp-sourcemaps'),
cssmin = require('gulp-cssmin'),
rename = require('gulp-rename'),
autoprefixer = require('gulp-autoprefixer'),
uglify = require('gulp-uglify'),
gulpUtil = require('gulp-util');

gulp.task('default', function() {
  // place code for your default task here
});

gulp.task('sass', function () {
	gulp.src('./sass/style.scss')
	.pipe(sourcemaps.init())
	.pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
	.pipe(sourcemaps.write('.'))
	.pipe(gulp.dest('./css'))
	.pipe(notify('CSS Compiled!'));
});

gulp.task('w', function () {

	gulp.watch('./sass/*.scss', function() {
		setTimeout(function() {
			return gulp.start('sass');
		}, 521);
	});

});

gulp.task('css', function () {
	gulp.src(['!./sass/_*.scss', './sass/*.scss'])
	.pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
	.pipe(autoprefixer(['last 121 versions', '> 1%']))
	.pipe(gulp.dest('./css'))
	.pipe(notify('CSS with Autoprefixes Compiled!'));
});

gulp.task('fincss', function () {
	gulp.src('./sass/style.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(autoprefixer(['last 121 versions', '> 1%']))
	.pipe(replace('../', ' '))
	.pipe(cssmin()) 
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('./css'));
});

gulp.task('jsmin', function () {
	gulp.src(['./js/*.js'])
	.pipe(uglify())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('./js'));
});