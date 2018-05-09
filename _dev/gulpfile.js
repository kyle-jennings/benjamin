var autoprefixer = require('autoprefixer');
var browserify = require('browserify');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var del = require('del');
var fs = require('fs');
var gulp = require('gulp');
var gulpif = require('gulp-if');
var util = require('gulp-util');
var imagemin = require('gulp-imagemin');
var notify = require('gulp-notify');
var minify = require('gulp-minify');
var plumber = require('gulp-plumber');
var postcss = require('gulp-postcss');
var pngquant = require('imagemin-pngquant');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var transform = require('vinyl-transform');
var watch = require('gulp-watch');
var wpPot = require('gulp-wp-pot');


function swallowError(error){
  this.emit('end');
}

var config = {
  production: true
};

// dir paths
var paths = {
  srcPath: './src',
  adminSrcPath: './admin-src',

  assetsPath: '../assets/frontend',
  adminAssetsPath: '../assets/admin',
  
  npmPath : './node_modules',
  bowerPath: './bower_components',
  vendorPath: './js/vendor'
};
paths.scssGlob = paths.srcPath + '/scss/**/*.scss';
paths.jsGlob = paths.srcPath + '/js/**/*.js';

paths.adminScssGlob = paths.adminSrcPath + '/scss/**/*.scss';
paths.adminJSGlob = paths.adminSrcPath + '/js/**/*.js';
paths.adminImgGlob = paths.adminSrcPath + '/img/**/*';



// ---------------------------------------------------------------------------
//  The frontend assets
// ---------------------------------------------------------------------------

gulp.task('front-js',['clean:front-js'], function(){

  var browserified = transform(function(filename) {
    var b = browserify(filename);
    return b.bundle();
  });

  return gulp.src([
    paths.srcPath + '/js/audio.js',
    paths.srcPath + '/js/uswds.js',
    paths.srcPath + '/js/_benjamin-previewer.js',
  ] )
  .pipe(plumber({ errorHandler: handleErrors }))
  .pipe(browserified)
  .pipe(minify())
  .pipe(gulp.dest( paths.assetsPath + '/js' ));
  // .pipe(notify({message: 'JS complete'}));

});


gulp.task('clean:front-js', function() {
  return del(
    [ paths.assetsPath + '/js' ],
    {read:false, force: true});
});


// CSS
/**
 * Minify and optimize style.css.
 */
gulp.task('front-css', ['front-scss'], function() {

  // removing the red theme for now
  // paths.assetsPath + '/css/benjamin-red.css'
  return gulp.src([
      paths.assetsPath + '/css/benjamin.css',
      paths.assetsPath + '/css/benjamin-classic.css',
    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(cssnano({ safe: true }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest( paths.assetsPath + '/css'));
    // .pipe(notify({message: 'CSS complete'}));
});

/**
 * Compile Sass and run stylesheet through PostCSS.
 */
gulp.task('front-scss', ['clean:front-css'], function() {

  // removing the red theme for now
  // paths.srcPath+'/scss/benjamin-red.scss'
  return gulp.src([
      paths.srcPath+'/scss/benjamin.scss',
      paths.srcPath+'/scss/benjamin-classic.scss',

    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: [
        paths.npmPath + '/uswds/src/stylesheets',
        paths.scssGlob
      ],
      errLogToConsole: true,
      outputStyle: 'expanded'
    }))
    .pipe(postcss([
      autoprefixer({ browsers: ['last 2 version'] })
    ]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest( paths.assetsPath + '/css' ));
});


gulp.task('clean:front-css', function() {
  return del(
    [ paths.assetsPath + '/css' ],
    {read:false, force: true});
});

// fonts
gulp.task('front-fonts', function(){
  return gulp.src(
      [
        paths.npmPath + '/uswds/dist/fonts/**.woff',
        paths.npmPath + '/uswds/dist/fonts/**.woff2'
      ])
    .pipe(gulp.dest(paths.assetsPath + '/fonts'));
});

gulp.task('clean:fonts', function() {
   return del(
     [ paths.assetsPath + '/fonts' ],
     {read:false, force: true});
 });


// images
// image optimization
gulp.task('front-img', function(){

  return gulp.src([
    paths.srcPath + '/img/**/*',
    paths.npmPath + '/uswds/dist/img/**/*',
  ])
  .pipe(imagemin({
    progressive: true,
  }))
  .pipe( gulp.dest( paths.assetsPath + '/img' ) );
});

gulp.task('clean:img', function(){
  return del(
    [ paths.assetsPath + '/img' ],
    {read:false, force: true});
});



// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
//  The Admin
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------


/**
 * Minify and optimize style.css.
 */
gulp.task('admin-css', ['admin-sass'], function() {

  return gulp.src([
      paths.adminAssetsPath + '/css/benjamin-admin.css'
    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(cssnano({ safe: true }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest( paths.adminAssetsPath + '/css'));
    // .pipe(notify({message: 'CSS complete'}));
});


/**
 * Compile Sass and run stylesheet through PostCSS.
 */
gulp.task('admin-sass', ['clean:admin-css'], function() {

  return gulp.src([
      paths.adminSrcPath+'/scss/benjamin-admin.scss'
    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: [ paths.adminScssGlob],
      errLogToConsole: true,
      outputStyle: 'expanded'
    }))
    .pipe(postcss([
      autoprefixer({ browsers: ['last 2 version'] })
    ]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest( paths.adminAssetsPath + '/css' ));
});


gulp.task('clean:admin-css', function() {
  return del(
    [ paths.adminAssetsPath + '/css' ],
    {read:false, force: true});
});




// browserfy is easier to update and manage thn manually concatinating files
// mostly because we dont have to restart gulp when adding new files
gulp.task('admin-js',['clean:admin-js'], function () {

  var browserified = transform(function(filename) {
    var b = browserify(filename);
    return b.bundle();
  });

  var condition = function(file){

    return (file !== '_benjamin-post-formats.js') ? true : false;
  };

  return gulp.src([
    paths.adminSrcPath + '/js/_benjamin-admin.js',
    paths.adminSrcPath + '/js/_benjamin-customizer.js',
    paths.adminSrcPath + '/js/_benjamin-post-formats.js'
  ] )
  .pipe(plumber({ errorHandler: handleErrors }))
  .pipe(browserified)
  .pipe(minify())
  .pipe(gulp.dest( paths.adminAssetsPath + '/js' ));
});


gulp.task('clean:admin-js', function() {

  return del(
    [ paths.adminAssetsPath + '/js' ],
    {read:false, force: true});
});


// images
// image optimization
gulp.task('admin-img', function(){

  return gulp.src([
    paths.adminImgGlob
  ])
  .pipe(imagemin({
    progressive: true,
  }))
  .pipe( gulp.dest( paths.adminAssetsPath + '/img' ) );
});

gulp.task('clean:admin-img', function(){
  return del(
    [ paths.adminAssetsPath + '/img' ],
    {read:false, force: true});
});


// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
//  Utilities
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

gulp.task('pot', function () {

    return gulp.src('../**/*.php')
        .pipe(wpPot( {
            domain: 'benjamin',
            package: 'Example project'
        } ))
        .pipe(gulp.dest('../languages/benjamin.pot'));
});

/**
 * Handle errors.
 * plays a noise and display notification
 */
function handleErrors() {
  var args = Array.prototype.slice.call(arguments);
  notify.onError({
    title: 'Task Failed [<%= error.message %>',
    message: 'See console.',
    sound: 'Sosumi'
  }).apply(this, args);
  util.beep();
  this.emit('end');
}


// CSS
gulp.task('css', function(){
  gulp.start('front-css');
  gulp.start('admin-css');
});


/**
 * Builds the JS and CSS
 * @return {[type]} [description]
 */
gulp.task('build-front', function(){
  gulp.start('front-fonts');
  gulp.start('front-img');
  gulp.start('front-css');
  gulp.start('front-js');
});


gulp.task('build-admin', function(){
  gulp.start('admin-css');
  gulp.start('admin-css');
  gulp.start('admin-img');
});



/**
 * Builds the JS, CSS, images, and moves fonts
 * @return {[type]} [description]
 */
gulp.task('build-all', function(){
  gulp.start('front-fonts');
  gulp.start('front-img');
  gulp.start('front-css');
  gulp.start('front-js');
  
  gulp.start('admin-css');
  gulp.start('admin-js');
  gulp.start('admin-img');
});

/**
 * Default Task, runs build and then watch
 * @return {[type]} [description]
 */
gulp.task('default', function(){
  gulp.start('build-all');
});


/**
 * Process tasks and reload browsers.
 */
gulp.task('watch', function() {
  gulp.start('build-all');
  gulp.watch(paths.jsGlob, ['front-js']);
  gulp.watch(paths.scssGlob, ['front-css']);
  gulp.watch(paths.imgGlob, ['front-img']);
  gulp.watch(paths.fontGlob, ['front-font']);
  
  gulp.watch(paths.adminJSGlob,['admin-js']);
  gulp.watch(paths.adminScssGlob, ['admin-css']);
  gulp.watch(paths.adminImgGlob, ['admin-img']);
});
