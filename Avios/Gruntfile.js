grunt.initConfig({
	bake: {
	    build: {
	        options: {
	            // Task-specific options go here.
	        },
	        files: {
	            // files go here, like so:
	            "app/index.html": "app/base.html"
	        }
	    },
	}
});


grunt.registerTask('server', function (target) {
    if (target === 'dist') {
        return grunt.task.run(['build', 'open', 'connect:dist:keepalive']);
    }
    grunt.task.run([
        'clean:server',
        'bake:build',
        'concurrent:server',
        'connect:livereload',
        'open',
        'watch'
    ]);
});



grunt.registerTask('build', [
    'clean:dist',
    'bake:build',
    'useminPrepare',
    'concurrent:dist',
    'concat',
    'cssmin',
    'uglify',
    'copy:dist',
    'rev',
    'usemin'
]);


watch: {
    compass: {
        files: ['<%= yeoman.app %>/styles/{,*/}*.{scss,sass}'],
        tasks: ['compass:server']
    },
    styles: {    
        files: ['<%= yeoman.app %>/styles/{,*/}*.css'],
        tasks: ['copy:styles']
    },
    bake: {
        files: [ "<%= yeoman.app %>/includes/**" ],
        tasks: "bake:build"
    },
    livereload: {
        options: {
            livereload: LIVERELOAD_PORT
        },
        files: [
            '<%= yeoman.app %>/*.html',
            '.tmp/styles/{,*/}*.css',
            '{.tmp,<%= yeoman.app %>}/scripts/{,*/}*.js',
            '<%= yeoman.app %>/images/{,*/}*.{png,jpg,jpeg,gif,webp,svg}'
        ]
    }
}  