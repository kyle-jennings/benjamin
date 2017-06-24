var autoprefixer = require('autoprefixer');
var browserify = require('browserify');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var del = require('del');
var fs = require('fs');
var gulp = require('gulp');
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
  assetsPath: '../assets',
  adminSrcPath: './admin-src',
  adminAssetsPath: '../inc/admin/assets',
  npmPath : './node_modules',
  bowerPath: './bower_components',
  vendorPath: './js/vendor'
};
paths.scssGlob = paths.srcPath + '/scss/**/*.scss';
paths.jsGlob = paths.srcPath + '/js/**/*.js';
paths.adminScssGlob = paths.adminSrcPath + '/scss/**/*.scss';
paths.adminJSGlob = paths.adminSrcPath + '/js/**/*.js';



// ---------------------------------------------------------------------------
//  The frontend assets
// ---------------------------------------------------------------------------

// gulp.task('front-js',['clean:front-js'], function(){
//
//   return gulp.src( [
//       paths.npmPath + '/uswds/dist/js/uswds.js',
//       paths.npmPath + '/uswds/dist/js/uswds.min.js',
//       paths.npmPath + '/uswds/dist/js/uswds.min.js.map'
//     ])
//     .pipe( gulp.dest(paths.assetsPath + '/js') );
// });

gulp.task('front-js',['clean:front-js'], function(){

  var browserified = transform(function(filename) {
    var b = browserify(filename);
    return b.bundle();
  });

  return gulp.src([
    paths.srcPath + '/js/uswds.js',
  ] )
  .pipe(plumber({ errorHandler: handleErrors }))
  .pipe(browserified)
  .pipe(minify())
  .pipe(gulp.dest( paths.assetsPath + '/js' ))
  .pipe(notify({message: 'JS complete'}));

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

  return gulp.src([
      paths.assetsPath + '/css/benjamin.css',
      paths.assetsPath + '/css/benjamin-classic.css',
      paths.assetsPath + '/css/benjamin-red.css'
    ])
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(cssnano({ safe: true }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest( paths.assetsPath + '/css'))
    .pipe(notify({message: 'CSS complete'}));
});


/**
 * Compile Sass and run stylesheet through PostCSS.
 */
gulp.task('front-scss', ['clean:front-css'], function() {

  return gulp.src([
      paths.srcPath+'/scss/benjamin.scss',
      paths.srcPath+'/scss/benjamin-classic.scss',
      paths.srcPath+'/scss/benjamin-red.scss'

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
gulp.task('fonts', function(){
  return gulp.src(paths.npmPath + '/uswds/dist/fonts/**.*')
    .pipe(gulp.dest(paths.assetsPath + '/fonts'));
});

gulp.task('clean:fonts', function() {
   return del(
     [ paths.assetsPath + '/fonts' ],
     {read:false, force: true});
 });


// images
// image optimization
gulp.task('img', function(){
  console.log(paths.srcPath + '/img/**/*');
  console.log(paths.assetsPath + '/img');
  return gulp.src( paths.srcPath + '/img/**/*')
    .pipe(imagemin({
      progressive: true,
    }))
    .pipe( gulp.dest( paths.assetsPath + '/img' ) );
});

gulp.task('clean:img', function(){
  return del(
    [ paths.adminAssetsPath + '/img' ],
    {read:false, force: true});
});

// ---------------------------------------------------------------------------
//  The Admin
// ---------------------------------------------------------------------------



/**
 * Minify and optimize style.css.
 */
gulp.task('admin-css', ['admin-sass'], function() {

  return gulp.src( paths.adminAssetsPath + '/css/benjamin-admin.css')
    .pipe(plumber({ errorHandler: handleErrors }))
    .pipe(cssnano({ safe: true }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest( paths.adminAssetsPath + '/css'))
    .pipe(notify({message: 'CSS complete'}));
});


/**
 * Compile Sass and run stylesheet through PostCSS.
 */
gulp.task('admin-sass', ['clean:admin-css'], function() {
  console.log(paths.adminSrcPath+'/scss/benjamin-admin.scss');
  return gulp.src(paths.adminSrcPath+'/scss/benjamin-admin.scss')
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

  return gulp.src([
    paths.adminSrcPath + '/js/_benjamin-admin.js',
    paths.adminSrcPath + '/js/_benjamin-customizer.js'
  ] )
  .pipe(plumber({ errorHandler: handleErrors }))
  .pipe(browserified)
  .pipe(minify())
  .pipe(gulp.dest( paths.adminAssetsPath + '/js' ))
  .pipe(notify({message: 'JS complete'}));
});


gulp.task('clean:admin-js', function() {

  return del(
    [ paths.adminAssetsPath + '/js' ],
    {read:false, force: true});
});

// ---------------------------------------------------------------------------
//  Utilities
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
 * Builds the JS and SASS
 * @return {[type]} [description]
 */
gulp.task('build', function(){
  // gulp.start('fonts');
  gulp.start('front-js');
  gulp.start('admin-js');
  // gulp.start('img');
  gulp.start('front-css');
  gulp.start('admin-css');
});

/**
 * Default Task, runs build and then watch
 * @return {[type]} [description]
 */
gulp.task('default', function(){
  gulp.start('build');
});


/**
 * Process tasks and reload browsers.
 */
gulp.task('watch', function() {
  gulp.start('build');
  gulp.watch(paths.adminJSGlob,['admin-js']);
  gulp.watch(paths.scssGlob, ['front-css']);
  gulp.watch(paths.jsGlob, ['front-js']);
  gulp.watch(paths.adminScssGlob, ['admin-css']);
});
