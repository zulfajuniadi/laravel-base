var gulp       = require('gulp');
var include    = require('gulp-include');
var less       = require('gulp-less');
var watch      = require('gulp-watch');
var uglify     = require('gulp-uglify');
var cssmin     = require('gulp-cssmin');
var rename     = require('gulp-rename');
var notify     = require("gulp-notify");
var livereload = require("gulp-livereload");
var changed    = require("gulp-changed");
var plumber    = require("gulp-plumber");
var sass       = require("gulp-sass");
var coffee     = require('gulp-coffee');

gulp.task("stylesheets", function(){
    gulp.src('app/assets/stylesheets/**/*.css')
        .pipe(plumber())
        .pipe(changed('public/assets/stylesheets'))
        .pipe(include())
        .pipe(gulp.dest("public/assets/stylesheets"))
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest("public/assets/stylesheets"))
        .pipe(notify('Stylesheets Processed.'))
        .pipe(livereload());
});

gulp.task("less", function(){
    gulp.src('app/assets/stylesheets/**/*.less')
        .pipe(plumber())
        .pipe(changed('public/assets/stylesheets'))
        .pipe(include())
        .pipe(less())
        .pipe(gulp.dest("public/assets/stylesheets"))
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest("public/assets/stylesheets"))
        .pipe(notify('LESS Processed.'))
        .pipe(livereload());
});

gulp.task("scss", function(){
    gulp.src('app/assets/stylesheets/**/*.scss')
        .pipe(plumber())
        .pipe(changed('public/assets/stylesheets'))
        .pipe(include())
        .pipe(sass())
        .pipe(gulp.dest("public/assets/stylesheets"))
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest("public/assets/stylesheets"))
        .pipe(notify('SCSS Processed.'))
        .pipe(livereload());
});

gulp.task("javascripts", function(){
    gulp.src('app/assets/javascripts/**/*.js')
        .pipe(plumber())
        .pipe(changed('public/assets/javascripts'))
        .pipe(include())
        .pipe(gulp.dest("public/assets/javascripts"))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest("public/assets/javascripts"))
        .pipe(notify('Javascripts Processed.'))
        .pipe(livereload());
});

gulp.task("coffee", function(){
    gulp.src('app/assets/javascripts/**/*.coffee')
        .pipe(plumber())
        .pipe(changed('public/assets/javascripts'))
        .pipe(include())
        .pipe(coffee({bare: true}))
        .pipe(gulp.dest("public/assets/javascripts"))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest("public/assets/javascripts"))
        .pipe(notify('Coffeescripts Processed.'))
        .pipe(livereload());
});

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch('app/assets/javascripts/**/*.js', ['javascripts']);
  gulp.watch('app/assets/stylesheets/**/*.css', ['stylesheets']);
  gulp.watch('app/assets/javascripts/**/*.coffee', ['coffee']);
  gulp.watch('app/assets/stylesheets/**/*.less', ['less']);
  gulp.watch('app/assets/stylesheets/**/*.scss', ['scss']);
});

gulp.task("default", ["watch"]);