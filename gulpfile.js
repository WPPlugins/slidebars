/**
 * WK Slidebars
 * Combines JavaScript files for the Slidebars settings page
 */

var gulp    = require('gulp');
var concat  = require('gulp-concat');
var uglify  = require('gulp-uglify');
var argv   = require('yargs').argv;
var gulpif = require('gulp-if');

gulp.task('js', function() {
  gulp
    .src(['includes/js/admin/src/*.js', 'includes/js/admin/deps/*.js'])
    .pipe(concat( argv.production ? 'wksl-slidebars-admin.min.js' : 'wksl-slidebars-admin.js' ))
    .pipe( gulpif( argv.production, uglify()))
    .pipe(gulp.dest('includes/js/'));
});

gulp.task('default', function() {

  gulp.watch(['includes/js/admin/src/*.js', 'includes/js/admin/deps/*.js'], ['js']);

});
