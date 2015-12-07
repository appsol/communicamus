/**
 * Communicamus Template Gruntfile
 * This file is not intended to be used within the Communicamus template
 * Instead, copy this file into any child themes and run "grunt" there
 *
 * @version 0.2.1
 * @author Stuart Laverick http://www.appropriatesolutions.co.uk/
 */
module.exports = function(grunt) {
 
  // configure the tasks
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    clean: {
      build: {
        src: [ 'dist' ]
      },
    },

    less: {
      development: {
        options: {
          paths: 'less',
          plugins: [
            new (require('less-plugin-autoprefix'))({browsers: ["last 2 versions"]})
          ],
          sourceMap: true,
          sourceMapFileInline: true,
          optimization: 9
        },
        files: {
          'dist/css/style.css': 'less/style.less'
        }
      },
      production: {
        options: {
          paths: 'less',
          plugins: [
            new (require('less-plugin-autoprefix'))({browsers: ["last 2 versions"]}),
            new (require('less-plugin-clean-css'))({advanced: true})
          ],
          cleancss: true,
          compress: true,
          optimization: 1
        },
        files: {
          'dist/css/style.min.css': 'less/style.less'
        }
      }
    },

    imagemin: {
      development: {
        options: {
          optimizationLevel: 1
        },
        files: [{
          expand: true,                  // Enable dynamic expansion
          cwd: 'images/',                // Src matches are relative to this path
          src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
          dest: 'dist/img/'              // Destination path prefix
        }]
      },
      production: {
        options: {
          optimizationLevel: 7
        },
        files: [{
          expand: true,                  // Enable dynamic expansion
          cwd: 'images/',                // Src matches are relative to this path
          src: ['**/*.{png,jpg,gif}'],   // Actual patterns to match
          dest: 'dist/img/'              // Destination path prefix
        }]
      }
    },

    jshint: {
      build: ['Gruntfile.js', 'js/main.js', 'js/**/*.js']
    },

    concat: {
      options: {
        // separator: ';',
          // sourceMap: true,
        nonull: true
      },
      dist: {
        src: [
          'bower_components/modernizr/modernizr.js',
          'bower_components/jquery/dist/jquery.js',
          // 'bower_components/bootstrap/js/transition.js',
          // 'bower_components/bootstrap/js/collapse.js',
          // 'bower_components/bootstrap/js/tab.js',
          // 'bower_components/bootstrap/js/dropdown.js',
          // 'bower_components/bootstrap/js/carousel.js',
          // 'bower_components/bootstrap/js/modal.js',
          // 'bower_components/flexslider/jquery.flexslider.js',
          'js/main.js',
          'js/**/*.js'
          ],
        dest: 'dist/js/script.js'
      }
    },

    uglify: {
      development: {
        options: {
          mangle: false
        },
        files: {
          'dist/js/script.js': [
          'bower_components/modernizr/modernizr.js',
          'bower_components/jquery/dist/jquery.js',
          // 'bower_components/bootstrap/js/transition.js',
          // 'bower_components/bootstrap/js/collapse.js',
          // 'bower_components/bootstrap/js/tab.js',
          // 'bower_components/bootstrap/js/dropdown.js',
          // 'bower_components/bootstrap/js/carousel.js',
          // 'bower_components/bootstrap/js/modal.js',
          // 'bower_components/flexslider/jquery.flexslider.js',
          'js/main.js',
          'js/**/*.js'
          ]
        }
      },
      production: {
        options: {
          mangle: false
        },
        files: {
          'dist/js/script.min.js': [
          'bower_components/modernizr/modernizr.js',
          'bower_components/jquery/dist/jquery.js',
          // 'bower_components/bootstrap/js/transition.js',
          // 'bower_components/bootstrap/js/collapse.js',
          // 'bower_components/bootstrap/js/tab.js',
          // 'bower_components/bootstrap/js/dropdown.js',
          // 'bower_components/bootstrap/js/carousel.js',
          // 'bower_components/bootstrap/js/modal.js',
          // 'bower_components/flexslider/jquery.flexslider.js',
          'js/main.js',
          'js/**/*.js'
          ]
        }
      }
    },
 
    copy: {
      bowerfonts: {
        cwd: 'bower_components/',
        src: [ 'fontawesome/fonts/**', 'bootstrap/fonts/**' ],
        dest: 'dist/fonts',
        expand: true
      },
      fonts: {
        cwd: 'fonts/',
        src: [ '**' ],
        dest: 'dist/fonts',
        expand: true
      },
      images: {
        expand: true,                 // Enable dynamic expansion
        cwd: 'images/',             // Src matches are relative to this path
        src: ['**/*.{png,jpg,gif}'],  // Actual patterns to match
        dest: 'dist/img/'           // Destination path prefix
      }
    },

    watch: {
      less: {
        files: 'less/*.less',
        tasks: 'css'
      },
      scripts: {
        files: ['js/main.js','js/**/*.js'],
        tasks: [ 'buildScripts' ]
      },
      images: {
        files: [ 'images/**/*'],
        tasks: [ 'copy:images' ]
      }
    }
 
  });
 
  // load the tasks
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // define the tasks
  grunt.registerTask(
    'build',
    'Creates a development version of the files',
    ['clean', 'css', 'buildScripts', 'copy:images', 'copy:bowerfonts', 'copy:fonts']
    // ['clean', 'css', 'buildScripts', 'imagemin:development']
  );

  grunt.registerTask(
    'deploy',
    'Creates a production version of the files',
    ['clean', 'less:production', 'deployScripts', 'copy:images', 'copy:bowerfonts', 'copy:fonts']
    // ['clean', 'less:production', 'deployScripts', 'imagemin:production']
  );

  grunt.registerTask(
    'css',
    'Process template.less into compiled.css',
    [ 'less:development' ]
  );

  grunt.registerTask(
    'buildScripts',
    'Checks and concatenates the JavaScript files.',
    [ 'jshint', 'concat' ]
  );

  grunt.registerTask(
    'deployScripts',
    'Checks and compiles the JavaScript files.',
    [ 'jshint', 'uglify:production' ]
  );

  grunt.registerTask(
    'default',
    'Watches the project for changes and automatically builds the dist components.',
    [ 'build', 'watch' ]
  );
};
