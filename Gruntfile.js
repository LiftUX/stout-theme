/* global module, require */

module.exports = function( grunt ) {

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig({

		pkg: pkg,

		autoprefixer: {
			options: {
				browsers: [
					'Android >= 2.1',
					'Chrome >= 21',
					'Edge >= 12',
					'Explorer >= 7',
					'Firefox >= 17',
					'Opera >= 12.1',
					'Safari >= 6.0'
				],
				cascade: false
			},
			dist: {
				src: [ '*.css' ]
			}
		},

		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
						src: 'style.css',
						dest: 'style-rtl.css'
					},
					{
						src: 'editor-style.css',
						dest: 'editor-style-rtl.css'
					}
				]
			}
		},

		sass: {
			options: {
				precision: 5,
				sourceMap: false
			},
			dist: {
				files: [
					{
						'style.css': '.dev/sass/style.scss',
						'editor-style.css': '.dev/sass/editor-style.scss'
					}
				]
			}
		},

		jshint: {
			assets: [ 'assets/js/*.js', '!assets/js/*.min.js' ],
			gruntfile: [ 'Gruntfile.js' ]
		},

		uglify: {
			options: {
				ASCIIOnly: true
			},
			assets: {
				expand: true,
				cwd: 'assets/js/',
				src: [ '**/*.js', '!**/*.min.js' ],
				dest: 'assets/js/',
				ext: '.min.js'
			}
		},

		watch: {
			css: {
				files: '.dev/sass/**/*.scss',
				tasks: [ 'sass','autoprefixer','cssjanus' ]
			},
			js: {
				files: 'assets/js/**/*.js',
				tasks: [ 'jshint', 'uglify' ]
			},
		},

		replace: {
			version_php: {
				src: [
					'**/*.php',
					'.dev/**/*.scss',
					'**/*.css'
				],
				overwrite: true,
				replacements: [ {
					from: /Version:(\s*?)[a-zA-Z0-9\.\-\+]+$/m,
					to: 'Version:$1' + pkg.version
				}, {
					from: /@version(\s*?)[a-zA-Z0-9\.\-\+]+$/m,
					to: '@version$1' + pkg.version
				}, {
					from: /@since(.*?)NEXT/mg,
					to: '@since$1' + pkg.version
				}, {
					from: /VERSION(\s*?)=(\s*?['"])[a-zA-Z0-9\.\-\+]+/mg,
					to: 'VERSION$1=$2' + pkg.version
				}, {
					from: /'PRIMER_CHILD_VERSION', '[a-zA-Z0-9\.\-\+]+'/mg,
					to: '\'PRIMER_CHILD_VERSION\', \'' + pkg.version + '\''
				}]
			},
			version_readme: {
				src: 'readme.*',
				overwrite: true,
				replacements: [ {
					from: /^(\*\*|)Stable tag:(\*\*|)(\s*?)[a-zA-Z0-9.-]+(\s*?)$/mi,
					to: '$1Stable tag:$2$3<%= pkg.version %>$4'
				} ]
			},
			pot:{
				src: 'languages/' + pkg.name + '.pot',
				overwrite: true,
				replacements: [ {
					from: 'charset=CHARSET',
					to: 'charset=UTF-8'
				} ]
			}
		},

		wp_readme_to_markdown: {
			options: {
				post_convert: function( readme ) {
					var matches = readme.match( /\*\*Tags:\*\*(.*)\r?\n/ ),
					    tags    = matches[1].trim().split( ', ' ),
					    section = matches[0];

					for ( var i = 0; i < tags.length; i++ ) {
						section = section.replace( tags[i], '[' + tags[i] + '](https://wordpress.org/themes/tags/' + tags[i] + '/)' );
					}

					// Tag links
					readme = readme.replace( matches[0], section );

					// Badges
					readme = readme.replace( '## Description ##', grunt.template.process( pkg.badges.join( ' ' ) ) + "  \r\n\r\n## Description ##" );

					// YouTube
					readme = readme.replace( /\[youtube\s+(?:https?:\/\/www\.youtube\.com\/watch\?v=|https?:\/\/youtu\.be\/)(.+?)\]/g, '[![Play video on YouTube](https://img.youtube.com/vi/$1/maxresdefault.jpg)](https://www.youtube.com/watch?v=$1)' );

					return readme;
				}
			},
			main: {
				files: {
					'readme.md': 'readme.txt'
				}
			}
		}

	});

	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

	grunt.registerTask( 'default', [ 'sass', 'autoprefixer', 'cssjanus', 'jshint', 'uglify' ] );
	grunt.registerTask( 'readme',  [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'version', [ 'replace' ] );

};
