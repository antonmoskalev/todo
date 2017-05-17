define(['jquery', 'components/Todo'], function($, Todo) {
	return function(url) {
		new Todo({
			place: '#todo'
		}, {
			filter: url[2]
		});
	};
});