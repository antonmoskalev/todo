define(['jquery', 'routes'], function($, routes) {
	$.each(routes, function(pattern, action) {
		var url = location.pathname+location.hash;
		var match = url.match(new RegExp(pattern));
		
		if (match !== null) {
			require(['actions/'+action], function(action) {
				action(match);
			});
			
			return false;
		}
	});
});