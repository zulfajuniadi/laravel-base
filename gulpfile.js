var gulp    = require('gulp');
var include = require('gulp-include');
var less    = require('gulp-less');
var watch   = require('gulp-watch');
var uglify  = require('gulp-uglify');

gulp.task("javascripts", function(){
    gulp.src('frontend/assets/javascripts/*.js')
        .pipe(watch('frontend/assets/javascripts/*.js'))
        .pipe(include())
        // .pipe(uglify())
        .pipe(gulp.dest("public/javascripts"))
});


gulp.task("stylesheets", function(){
    gulp.src('frontend/assets/stylesheets/*.less')
        .pipe(watch('frontend/assets/stylesheets/*.less'))
        .pipe(include())
        .pipe(less())
        .pipe(gulp.dest("public/stylesheets"))
});

gulp.task("default", ["javascripts", "stylesheets"]);