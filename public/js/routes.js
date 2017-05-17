define({
	'/signin': 'user/signin',
	'/signup': 'user/signup',
	'/todos/create(/\#/([a-z]+)|)': 'todo/create',
	'/todos/update/([0-9]+)(/\#/([a-z]+)|)': 'todo/update'
});