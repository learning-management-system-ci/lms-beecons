// REQUIREMENTS
const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const sourcemaps = require('gulp-sourcemaps');
const php = require('gulp-connect-php');
const browserSync = require('browser-sync').create();

// PATHS
const paths = {
    scss: {
        src: './public/argon-dashboard/assets/scss/*.scss',
        dest: './build/css/'
    },
    css: {
        src: './public/argon-dashboard/assets/css/*.css',
        dest: './build/css/'
    },
    js: {
        src: './public/argon-dashboard/assets/js/*.js',
        dest: './build/js/'
    }
};

// BROWSER SYNC WITH PHP INSIDE SERVER
function sync() {
    // PS.You need to activate your PHP Path
    php.server({
        base: './',
        port: 3000,
        keepalive: true,
        // suppress all the logging into console of the php server process.
        stdio: 'ignore',
    });
    browserSync.init({
        proxy: "localhost:3000",
        baseDir: "./",
        notify: false,
    });
}

// TASKS
function compileSass() {
    return src(paths.scss.src)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(rename({ extname: ".min.css" }))
        .pipe(sourcemaps.write())
        .pipe(dest(paths.scss.dest))
        .pipe(browserSync.stream());
}

function compileJs() {
    return src(paths.js.src)
        .pipe(sourcemaps.init())
        .pipe(concat('all.js'))
        .pipe(sourcemaps.write())
        .pipe(dest(paths.js.dest))
        .pipe(browserSync.stream());
}

// WATCH
function watchSass() {
    watch(paths.scss.src, compileSass)
}

function watchJs() {
    watch(paths.js.src, compileJs)
}

function watchPhp() {
    watch(['./public/argon-dashboard/**/*.html', './public/argon-dashboard/**/*.php']).on('change', browserSync.reload);
}

// DEFAULT TASK
exports.default = series(compileSass, compileJs, parallel(sync, watchSass, watchJs, watchPhp))