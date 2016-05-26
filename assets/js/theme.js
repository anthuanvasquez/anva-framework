(function( $ ) {

	'use strict';

	var $postReading = $('#post-reading-wrap');

	if ( $postReading.length > 0 ) {
		var getMax = function() {
			return $(document).height() - $(window).height();
		};

		var getValue = function() {
			return $(window).scrollTop();
		};

		var $indicator = $('.post-reading-indicator-bar'), max = getMax(), value, width;

		// Calculate width in percentage
		var getWidth = function() {
			value = getValue();
			width = ( value / max ) * 100;
			width = width + '%';
			return width;
		};

		var setWidth = function() {
			max = getMax();
			$indicator.css({ width: getWidth() });
		};

		$(document).on('scroll', setWidth);
		$(window).on('resize', function(){
			// Need to reset the Max attr
			max = getMax();
			setWidth();
		});

		$(document).on('scroll', function() {
			var $width = $('.post-reading-indicator-bar').width();
			var percentage = ( $width / max ) * 100;
			if ( percentage > 10 ) {
				$postReading.addClass('visible');
			} else {
				$postReading.removeClass('visible');
			}
		});
	}

})( jQuery );
