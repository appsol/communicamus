/**
 * Communicamus Template Gruntfile
 * This file is not intended to be used within the Communicamus template
 * Instead, copy this file into any child themes and run "grunt" there
 *
 * @version 0.2.1
 * @author Stuart Laverick http://www.appropriatesolutions.co.uk/
 */
module.exports = function(grunt) {
 
 var pngQuant = require('imagemin-pngquant');

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
					cleancss: true,
					compress: true,
					optimization: 1
				},
				files: {
					'dist/css/style.min.css': 'less/style.less'
				}
			}
		},

		sprite: {
			all: {
				src: 'images/sprite/*.{png,jpg,gif}',
				dest: 'dist/img/sprite.png',
				destCss: 'less/sprite.less',
				imgPath: '../img/sprite.png',
				algorithm: 'diagonal',
				padding: 1
			}
		},

		imagemin: {
			development: {
				options: {
					optimizationLevel: 1,
					use: [pngQuant()]
				},
				files: [{
					expand: true,                  // Enable dynamic expansion
					cwd: 'images/',                // Src matches are relative to this path
					src: ['*.{png,jpg,gif}'],   // Actual patterns to match
					dest: 'dist/img/'              // Destination path prefix
				}]
			},
			production: {
				options: {
					optimizationLevel: 7,
					use: [pngQuant()]
				},
				files: [{
					expand: true,                  // Enable dynamic expansion
					cwd: 'images/',                // Src matches are relative to this path
					src: ['*.{png,jpg,gif}'],   // Actual patterns to match
					dest: 'dist/img/'              // Destination path prefix
				}]
			},
			sprite: {
				options: {
					optimizationLevel: 7,
					use: [pngQuant()]
				},
				files: {
					'dist/img/sprite.png': 'dist/img/sprite.png'
				}
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
				expand: true,       	// Enable dynamic expansion
				cwd: 'images/',         // Src matches are relative to this path
				src: ['*.svg}'],		// Actual patterns to match
				dest: 'dist/img/'       // Destination path prefix
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
				files: [ 'images/*.{png,jpg,gif}'],
				tasks: [ 'imagemin:development' ]
			},
			sprite: {
				files: ['images/sprite/*'],
				tasks: ['sprite', 'imagemin:sprite', 'less:production']
			},
			svg: {
				files: ['images/*.svg'],
				tasks: ['copy:images']
			}
		}

	});

	// load the tasks
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-spritesmith');

	// define the tasks
	// Development build task
	grunt.registerTask(
		'build',
		'Creates a development version of the files',
		['clean', 'sprite', 'css', 'buildScripts', 'imagemin:development', 'imagemin:sprite', 'copy:bowerfonts', 'copy:fonts', 'copy:images']
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

	// Default task, run if no other task specified
	grunt.registerTask(
		'default',
		'Watches the project for changes and automatically builds the dist components.',
		[ 'build', 'watch' ]
	);
};