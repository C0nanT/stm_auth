module.exports = function(grunt) {
  grunt.initConfig({
    concat: {
      js: {
        src: [
          'node_modules/jquery/dist/jquery.js',
          'node_modules/bootstrap/dist/js/bootstrap.js',
          'public/assets/script.js',
        ],
        dest: 'public/dist/js/scripts.js',
      },
      css: {
        src: [
          'node_modules/bootstrap/dist/css/bootstrap.css',
          'node_modules/bootstrap-icons/font/bootstrap-icons.css',
          'node_modules/animate.css/animate.css',
          'public/assets/style.css',
        ],
        dest: 'public/dist/css/styles.css',
      },
    },
    uglify: {
      js: {
        files: {
          'public/dist/js/scripts.min.js': ['public/dist/js/scripts.js']
        }
      }
    },
    cssmin: {
      css: {
        files: {
          'public/dist/css/styles.min.css': ['public/dist/css/styles.css']
        }
      }
    },
    copy: {
      main: {
        files: [
          {
            expand: true,
            cwd: 'node_modules/bootstrap-icons/font/fonts/',
            src: '**',
            dest: 'public/dist/css/fonts/',
            flatten: true,
            filter: 'isFile',
          },
        ],
      },
    },
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('default', ['concat', 'uglify', 'cssmin', 'copy']);
};