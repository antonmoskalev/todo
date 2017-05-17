require.config({
	baseUrl: '/js',
    paths:{
        'jquery': 'libs/jquery-3.2.1.min',
        'jquery.validate': 'libs/jquery.validate.min',
		'underscore': 'libs/underscore-min',
		'toastr': '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min'
    },
	shim: {
		'jquery.validate': ['jquery']
	}
});

require(['bootstrap']);