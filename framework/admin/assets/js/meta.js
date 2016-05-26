jQuery( document ).ready( function( $ ) {

	'use strict';

	// Anva Meta Object
	var ANVA_META = {

		init: function() {
			ANVA_META.sidebarLayout();
		},

		sidebarLayout: function() {
			var $layout = $('#sidebar_layout');
			if ( $layout.length > 0 ) {
				$layout.on( 'change', function() {
					ANVA_META.checkLayout( $layout.val() );
				}).trigger('change');
			}
		},

		checkLayout: function( val ) {
			switch ( val ) {
				case 'double':
				case 'double_right':
				case 'double_left':
					$('.sidebar-layout .item-right').show();
					$('.sidebar-layout .item-left').show();
					break;

				case 'right':
					$('.sidebar-layout .item-right').show();
					$('.sidebar-layout .item-left').hide();
					break;

				case 'left':
					$('.sidebar-layout .item-right').hide();
					$('.sidebar-layout .item-left').show();
					break;

				case '':
				case 'fullwidth':
					$('.sidebar-layout .item-right').hide();
					$('.sidebar-layout .item-left').hide();
					break;
			}
		}
	};

	ANVA_META.init();

});
