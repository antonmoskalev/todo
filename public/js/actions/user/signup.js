define(['jquery', 'toastr', 'jquery.validate'], function($, toastr) {
	return function() {
		$('#signup-form').validate({
			rules: {
				'email': {
					required: true,
					email: true,
					remote: '/user/unique-email'
				},
				'password': {
					required: true
				},
				'same_password': {
					required: true,
					equalTo: '#password'
				}
			},
			submitHandler: function(form) {
				var $form = $(form);

				$.ajax({
					type: $form.attr('method'),
					url: $form.attr('action'),
					data: $form.serialize(),
					success: function(response) {
						location.href = response.redirect;
					},
					error: function() {
						toastr.error('Ошибка регистрации');
					}
				});
			}
		});
	};
});