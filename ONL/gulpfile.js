"use strict";

// Load plugins
const browsersync = require("browser-sync").create();
const del = require("del");
const gulp = require("gulp");
const merge = require("merge-stream");

// BrowserSync
function browserSync(done) {
  browsersync.init({
    server: {
      baseDir: "./"
    },
    port: 3000
  });
  done();
}

// BrowserSync reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

// Clean vendor files
function clean() {
  return del(["./js/vendor/"]);
}

// Bring third party dependencies from node_modules into vendor directory
function modules() {
  // Bootstrap
  var bootstrap = gulp.src([
      './node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
      './node_modules/bootstrap/dist/js/bootstrap.min.js'
    ])
    .pipe(gulp.dest('./js/vendor'));
  // jQuery
  var jquery = gulp.src([
      './node_modules/jquery/dist/jquery.min.js',
      './node_modules/jquery/dist/jquery.slim.min.js'
    ])
    .pipe(gulp.dest('./js/vendor'));
  return merge(bootstrap, jquery);
}

// Watch files
function watchFiles() {
  gulp.watch("./**/*.css", browserSyncReload);
  gulp.watch("./**/*.html", browserSyncReload);
  gulp.watch("./**/*.js", browserSyncReload);
}

// Define complex tasks
const vendor = gulp.series(clean, modules);
const build = gulp.series(vendor);
const watch = gulp.series(build, gulp.parallel(watchFiles, browserSync));

// Export tasks
exports.clean = clean;
exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;
