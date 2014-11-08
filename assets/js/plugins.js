/* Avoid `console` errors in browsers that lack a console */
(function() {
	var method;
	var noop = function () {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = ( window.console = window.console || {} );

	while ( length-- ) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}
}());

//@prepros-append vendor/jquery.flexslider.js
//@prepros-append vendor/jquery.validate.js
//@prepros-append vendor/jquery.fitvids.js
//@prepros-append vendor/lightbox.js
//@prepros-append vendor/hoverIntent.js
//@prepros-append vendor/superfish.js