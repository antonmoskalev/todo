define(['jquery', 'components/Todo'], function($, Todo) {
	return function(url) {
		new Todo({
			place: '#todo'
		}, {
			todo: {
				id: url[1]
			},
			filter: url[3]
		});
	};
});