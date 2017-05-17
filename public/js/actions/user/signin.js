define(['jquery', 'toastr', 'jquery.validate'], function($, toastr) {
	return function() {
		$('#signin-form').validate({
			rules: {
				'email': {
					required: true,
					email: true
				},
				'password': {
					required: true
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
						toastr.error('Ошибка авторизации');
					}
				});
			}
		});
	};
});