/**
 * This is the config file fot the gulp tasks, see gulpfile.js dir
 * to view each tasks.
 *
 * Project Information
 *
 * theme:   The parent theme assets.
 * core:    The framework assets.
 * admin:   The framework admin assets.
 * build:   The build theme without require files for development.
 * dist:    The released theme ready for deployment.
 * bower:   Bower components, required for theme development.
 * modules: The node packages, required for theme development.
 * vendor:  All required vendor plugins for use in the theme.
 */

'use_strict';

// Project `Paths`
var project = 'anva',
    version = '1.0.0',
    release = project + '-' + version,
    proxy   = 'anva.dev',
    src     = '../',
    theme   = src + 'assets/',
    core    = src + 'framework/assets/',
    admin   = src + 'framework/admin/assets/',
    build   = './build/',
    dist    = './dist/' + release + '/',
    bower   = './bower_components/',
    modules = './node_modules/',
    parent  = '../../'
;

// Vendor Scripts `Plugins`
var vendor = [
    core  + 'js/vendor/twitterfeedfetcher.js',
    core  + 'js/vendor/smoothscroll-modified.min.js',
    core  + 'js/vendor/swiper.min.js',
    core  + 'js/vendor/jquery.flickrfeed.min.js',
    core  + 'js/vendor/jquery.plugin.min.js',
    core  + 'js/vendor/jquery.countdown.min.js',
    core  + 'js/vendor/jquery.flexslider-modified.min.js',
    core  + 'js/vendor/jquery.paginate.min.js',
    core  + 'js/vendor/jquery.ui.1.11.4.min.js',
    bower + 'jquery.easing/js/jquery.easing.min.js',
    bower + 'jquery.fitvids/jquery.fitvids.js',
    bower + 'jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js',
    bower + 'jquery.cookie/jquery.cookie.js',
    bower + 'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
    bower + 'jquery.appear/jquery.appear.js',
    bower + 'jquery.stellar/jquery.stellar.min.js',
    bower + 'jquery-countTo/jquery.countTo.js',
    bower + 'jquery-bbq/jquery.ba-bbq.min.js',
    bower + 'jquery-color/jquery.color.js',
    bower + 'jquery-form/jquery.form.js',
    bower + 'jquery-infinite-scroll/jquery.infinitescroll.min.js',
    bower + 'jquery-validation/dist/jquery.validate.min.js',
    bower + 'superfish/dist/js/superfish.min.js',
    bower + 'superfish/dist/js/hoverIntent.js',
    bower + 'instafeed.js/js/instafeed.min.js',
    bower + 'jribbble/dist/jribbble.min.js',
    bower + 'animsition/dist/js/animsition.min.js',
    bower + 'owl.carousel/dist/owl.carousel.min.js',
    bower + 'Morphext/dist/morphext.min.js',
    bower + 'isotope/dist/isotope.pkgd.min.js',
    bower + 'imagesloaded/imagesloaded.pkgd.min.js',
    bower + 'toastr/toastr.min.js',
    bower + 'jrespond/js/jRespond.min.js',
    bower + 'Chart.js/dist/Chart.min.js',
    bower + 'magnific-popup/dist/jquery.magnific-popup.min.js',
    bower + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
];

// Project `Settings`
module.exports = {

  // -------------------------------------------
  // BrowserSync
  // -------------------------------------------

  browsersync: {
    // files: [src + '/**', '!' + src + '.tools'],
    notify: true,
    open: true,
    proxy: {
      target: proxy
    },
    watchOptions: {
      debounceDelay: 2000
    }
  },

  // -------------------------------------------
  // Livereload
  // -------------------------------------------

  livereload: {
    port: 35729
  },

  // -------------------------------------------
  // Images
  // -------------------------------------------

  images: {
    build: {
      src: [src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)', '!' + src + '/.tools'],
      dest: build
    },
    dist: {
      src: [dist + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)', '!' + dist + 'screenshot.png'],
      imagemin: {
        optimizationLevel: 7,
        progressive: true,
        interlaced: true
      },
      dest: dist
    }
  },

  // -------------------------------------------
  // Scripts
  // -------------------------------------------

  scripts: {
    dest: build,
    src: [src + '**/*.js', '!' + src + '.tools/**'],
    lint: {
      theme: theme + 'js/**/*.js',
      core: core + 'js/**/*.js',
      admin: admin + 'js/**/*.js',
      ignore: ['*.min.js', 'plugins.js', 'vendor/**', 'components/**', 'vmap/**'],
      options: '.jshintrc'
    },
    minify: {
      theme: {
        src: theme + 'js/**/*.js',
        dest: theme + 'js/',
      },
      core: {
        src: core + 'js/**/*.js',
        dest: core + 'js/',
        vendor: {
          files: vendor,
          name: 'vendor.js'
        },
        ignore: ['*.min.js', 'plugins.js', 'vendor/**', 'components/**', 'vmap/**']
      },
      admin: {
        src: admin + 'js/**/*.js',
        dest: admin + 'js/',
      },
      uglify: {},
      rename: {
        suffix: '.min'
      }
    },
    sourcemaps: false
  },

  // -------------------------------------------
  // Styles
  // -------------------------------------------

  styles: {
    src: [src + '**/*.css', '!' + src + '.tools'],
    dest: build,
    lint: {
      theme: theme + 'css/**/*.css',
      core: core + 'css/**/*.css',
      admin: admin + 'css/**/*.css',
      ignore: ['*.min.css', 'custom.css', 'ie.css', 'calendar.css', 'camera.css', 'elastic.css', 'nivo-slider.css', 'swiper.css', 'vmap.css', 'animate.css', 'bootstrap.css', 'components/**', 'fonts/**'],
      options: '.csslintrc'
    },
    theme: {
      src: theme + 'scss/**/*.scss',
      dest: theme + 'css/'
    },
    core: {
      src: core + 'scss/**/*.scss',
      dest: core + 'css/'
    },
    admin: {
      src: admin + 'scss/**/*.scss',
      dest: admin + 'css/'
    },
    sass: {
      includePaths: [theme + 'scss', core + 'scss', admin + 'scss', bower, modules],
      precision: 6,
      outputStyle: 'expanded', // nested, expanded, compact, compressed
      onError: function(err) {
        return console.log(err);
      }
    },
    autoprefixer: {
      browsers: ['> 3%', 'last 10 versions', 'ie 9', 'ios 6', 'android 4']
    },
    minify: {
      theme: {
        src: theme + 'css/**/*.css',
        dest: build + 'assets/css/'
      },
      core: {
        src: core + 'css/**/*.css',
        dest: build + 'framework/assets/css/'
      },
      admin: {
        src: admin + 'css/**/*.css',
        dest: build + 'framework/admin/assets/css/'
      },
      dest: build,
      ignore: ['*.min.css', 'custom.css', 'ie.css', 'calendar.css', 'camera.css', 'elastic.css', 'nivo-slider.css', 'swiper.css', 'vmap.css', 'animate.css', 'bootstrap.css', 'components/**', 'fonts/**'],
      options: {
        safe: true
      }
    },
    sourcemaps: true
  },

  // -------------------------------------------
  // Theme
  // -------------------------------------------

  theme: {
    lang: {
      src: src + 'languages/**/*',
      dest: build + 'languages/',
      pot: {
        domain: project,
        destFile: project + '.pot',
        package: project,
        bugReport: 'http://anthuanvasquez.net',
        lastTranslator: 'Anthuan Vásquez <me@anthuanvasquez.net>',
        team: 'Anthuan Vásquez <me@anthuanvasquez.net>'
      }
    },
    php: {
      src: [src + '**/*.php', '!' + src + '.tools/**'],
      dest: build
    },
    readme: {
      src: src + 'readme.md',
      dest: build
    },
    textdomain: {
      text_domain: project,
      keywords: [
        '__:1,2d',
        '_e:1,2d',
        '_x:1,2c,3d',
        'esc_html__:1,2d',
        'esc_html_e:1,2d',
        'esc_html_x:1,2c,3d',
        'esc_attr__:1,2d',
        'esc_attr_e:1,2d',
        'esc_attr_x:1,2c,3d',
        '_ex:1,2c,3d',
        '_n:1,2,4d',
        '_nx:1,2,4c,5d',
        '_n_noop:1,2,3d',
        '_nx_noop:1,2,3c,4d'
      ]
    },
    // Move theme to `parent` folder to be tested before released.
    test: {
      src: build + '**/*',
      dest: parent + release
    }
  },

  // -------------------------------------------
  // Utils
  // -------------------------------------------

  utils: {
    clean: [src + '**/.DS_Store'],
    wipe: {
      dist: [dist],
      build: [build],
      test: [parent + release]
    },
    dist: {
      src: [build + '**/*', '!' + build + '**/*.map'],
      dest: './dist',
      name: release + '.zip',
    }
  },

  // -------------------------------------------
  // Watch
  // -------------------------------------------

  watch: {
    src: {
      theme: theme + 'scss/**/*.scss',
      core: core + 'scss/**/*.scss',
      admin: admin + 'scss/**/*.scss',
      scripts: [theme + 'js/**/*.js', core + 'js/**/*.js', admin + 'js/**/*.js'],
      images: src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)',
      php: src + '**/*.php',
      livereload: src + '**/*'
    },
    watcher: 'browsersync'
  }

};
