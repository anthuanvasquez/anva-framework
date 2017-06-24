jQuery( document ).ready( function( $ ) {

	'use strict';

	var AnvaMeta = {

		init: function() {
			AnvaMeta.sidebarLayout();
		},

		sidebarLayout: function() {
			var layout = $( '#sidebar_layout' );
			if ( layout.length > 0 ) {
				layout.on( 'change', function() {
					AnvaMeta.checkLayout( layout.val() );
				}).trigger( 'change' );
			}
		},

		checkLayout: function( val ) {
			switch ( val ) {
				case 'double':
				case 'double_right':
				case 'double_left':
					$( '.sidebar-layout .item-right' ).show();
					$( '.sidebar-layout .item-left' ).show();
					break;

				case 'right':
					$( '.sidebar-layout .item-right' ).show();
					$( '.sidebar-layout .item-left' ).hide();
					break;

				case 'left':
					$( '.sidebar-layout .item-right' ).hide();
					$( '.sidebar-layout .item-left' ).show();
					break;

				case '':
				case 'fullwidth':
					$( '.sidebar-layout .item-right' ).hide();
					$( '.sidebar-layout .item-left' ).hide();
					break;
			}
		}
	};

	AnvaMeta.init();

});
