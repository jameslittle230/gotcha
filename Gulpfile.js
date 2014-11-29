var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('scss', function () {
	gulp.src('./public/styles/scss/main.scss')
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(gulp.dest('./public/styles/css'));
});

gulp.task('default', ['scss']);

gulp.task('watch', function() {
	gulp.watch('./public/styles/scss/*.scss',['scss']);
});