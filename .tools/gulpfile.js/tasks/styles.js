// ==== STYLES ==== //

var gulp          = require('gulp'),
    gutil         = require('gulp-util'),
    plugins       = require('gulp-load-plugins')({ camelize: true }),
    config        = require('../../gulpconfig').styles,
    autoprefixer  = require('autoprefixer'),
    processors    = [autoprefixer(config.autoprefixer)],
    browsersync   = require('browser-sync')
;

// Error function for plumber
var onError = function(err) {
  plugins.gutil.beep();
  console.log(err);
  this.emit('end');
};

// Build SCSS source files from `theme`
gulp.task('styles-theme', function() {
  return gulp.src(config.theme.src)
  .pipe(plugins.plumber({ errorHandler: onError }))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.theme.dest))
  .pipe(browsersync.reload({ stream: true }));
});

// Build SCSS source files from `core`
gulp.task('styles-core', function() {
  return gulp.src(config.core.src)
  .pipe(plugins.plumber({ errorHandler: onError }))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.core.dest))
  .pipe(browsersync.reload({ stream: true }));
});

// Build SCSS source files from `admin`
gulp.task('styles-admin', function() {
  return gulp.src(config.admin.src)
  .pipe(plugins.plumber({ errorHandler: onError }))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.admin.dest))
  .pipe(browsersync.reload({ stream: true }));
});

// Lint CSS source files
gulp.task('styles-css-lint', function() {
  return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
  .pipe(plugins.ignore.exclude(config.lint.ignore))
  .pipe(plugins.csslint(config.lint.options))
  .pipe(plugins.csslint.reporter());
});

// Minify CSS source files and copy to `build` folder
gulp.task('styles-minify-theme', function() {
  return gulp.src(config.minify.theme.src)
  .pipe(plugins.ignore.exclude(config.minify.ignore))
  .pipe(plugins.cssnano(config.minify.options))
  .pipe(plugins.rename({ suffix: '.min' }))
  .pipe(plugins.changed(config.minify.theme.dest))
  .pipe(gulp.dest(config.minify.theme.dest));
});

gulp.task('styles-minify-core', function() {
  return gulp.src(config.minify.core.src)
  .pipe(plugins.ignore.exclude(config.minify.ignore))
  .pipe(plugins.cssnano(config.minify.options))
  .pipe(plugins.rename({ suffix: '.min' }))
  .pipe(plugins.changed(config.minify.core.dest))
  .pipe(gulp.dest(config.minify.core.dest));
});

gulp.task('styles-minify-admin', function() {
  return gulp.src(config.minify.admin.src)
  .pipe(plugins.ignore.exclude(config.minify.ignore))
  .pipe(plugins.cssnano(config.minify.options))
  .pipe(plugins.rename({ suffix: '.min' }))
  .pipe(plugins.changed(config.minify.admin.dest))
  .pipe(gulp.dest(config.minify.admin.dest));
});

// Copy CSS source files to the `build` folder
gulp.task('styles-build', function(){
  return gulp.src(config.src)
  .pipe(plugins.changed(config.dest))
  .pipe(gulp.dest(config.dest));
});

// Master styles tasks
gulp.task('styles-minify', ['styles-minify-theme', 'styles-minify-core', 'styles-minify-admin']);
gulp.task('styles-watch', ['styles-theme', 'styles-core', 'styles-admin']);
gulp.task('styles', ['styles-build', 'styles-minify']);
