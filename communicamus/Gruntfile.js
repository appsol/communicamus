/**
 * Communicamus Template Gruntfile
 * This file is not intended to be used within the Communicamus template
 * Instead, copy this file into any child themes and run "grunt" there
 *
 * @version 0.2.0
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
          sourceMap: true,
          optimization: 1
        },
        files: {
          'dist/css/style.css': 'less/style.less'
        }
      },
      production: {
        options: {
          paths: 'less',
          cleancss: true,
          compress: true,
          optimization: 1
        },
        files: {
          'dist/css/style.css': 'less/style.less'
        }
      }
    },

    autoprefixer: {
      build: {
        expand: true,
        cwd: 'dist',
        src: [ 'css/*.css' ],
        dest: 'dist'
      }
    },

    cssmin: {
      build: {
        files: {
          'dist/css/style.css': [ 'dist/css/*.css' ]
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
          'bower_components/bootstrap/js/collapse.js',
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
          'bower_components/bootstrap/js/collapse.js',
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
          'dist/js/script.js': [
          'bower_components/modernizr/modernizr.js',
          'bower_components/jquery/dist/jquery.js',
          // 'bower_components/bootstrap/js/transition.js',
          'bower_components/bootstrap/js/collapse.js',
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
      build: {
        cwd: 'source',
        src: [ '**' ],
        dest: 'build',
        expand: true
      },
    },

    watch: {
      less: {
        files: 'less/*.less',
        tasks: 'less'
      },
      scripts: {
        files: ['js/main.js','js/**/*.js'],
        tasks: [ 'build' ]
      },
      images: {
        files: [ 'images/*.png','images/*.jpg','images/*.jpeg','images/*.gif','images/*.svg'],
        tasks: [ 'imagemin' ]
      }
    }
 
  });
 
  // load the tasks
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // define the tasks
  grunt.registerTask(
    'build',
    'Creates a development version of the files',
    ['clean', 'css', 'buildScripts', 'imagemin:development']
  );

  grunt.registerTask(
    'deploy',
    'Creates a production version of the files',
    ['clean', 'less:production', 'autoprefixer', 'cssmin', 'deployScripts', 'imagemin:production']
  );

  grunt.registerTask(
    'css',
    'Process template.less into compiled.css',
    [ 'less:development' ]
    // [ 'less:development', 'autoprefixer' ]
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