jQuery(document).ready(function($) {

	"use strict";
	
	// Settings
	var s;
	
	// Anva Meta Object
	var AnvaMeta = {

		// Default Settings
		settings: {
			template: 			$('#page_template'),
			layout: 				$('#sidebar_layout'),
			grid: 					$('#section-grid_column'),
			sidebar: 				$('#section-sidebar_layout'),
			locationRight: 	$('.sidebar-layout .item-right'),
			locationLeft: 	$('.sidebar-layout .item-left')
		},

		init: function() {

			// Set Settings
			s = this.settings;

			AnvaMeta.pageTemplate();
			AnvaMeta.sidebarLayout();
			AnvaMeta.tabs();
			AnvaMeta.datePicker();
			AnvaMeta.spinner();
			AnvaMeta.extras();
		},

		sidebarLayout: function() {
			if ( s.layout.length > 0 ) {
				s.layout.on( 'change', function() {
					AnvaMeta.checkLayout( s.layout.val() );
				}).trigger('change');
			}
		},

		checkLayout: function( val ) {
			switch ( val ) {
				case 'double':
				case 'double_right':
				case 'double_left':
					s.locationRight.show();
					s.locationLeft.show();
					break;
				
				case 'right':
					s.locationRight.show();
					s.locationLeft.hide();
					break;

				case 'left':
					s.locationRight.hide();
					s.locationLeft.show();
					break;

				case '':
				case 'fullwidth':
					s.locationRight.hide();
					s.locationLeft.hide();
					break;
			}
		},

		pageTemplate: function() {
			if ( s.template.length > 0 ) {
				s.template.on( 'change', function() {
					AnvaMeta.checkTemplate( s.template.val() );
				}).trigger('change');
			}
		},

		checkTemplate: function( val ) {

			var templates = [
				'default', // Default template
				'template_archives.php',
				'template_list.php'
			];

			// Show grid option
			if ( 'template_grid.php' == val ) {
				s.grid.show();
			} else {
				s.grid.hide();
			}

			// Show sidebar layout option
			if ( -1 != $.inArray( val, templates ) ) {
				s.sidebar.show();
			} else {
				s.sidebar.hide();
			}
		},

		tabs: function() {
			if ( $('.nav-tab-wrapper').length > 0 ) {
				AnvaMeta.navTabs();
			}
		},

		spinner: function() {
			if ( $('.anva-spinner').length > 0 ) {
				$('.anva-spinner').spinner();
			}
		},

		datePicker: function() {
			if ( $('.anva-datepicker').length > 0 ) {
				$('.anva-datepicker').datepicker({
					showAnim: 'slideDown',
					dateFormat: 'd MM, yy'
				});
			}
		},

		extras: function() {
			if ( $('.anva-meta-box .nav-tab-wrapper > a').length == 1 ) {
				$('.anva-meta-box .nav-tab-wrapper').hide();
			}
		},

		navTabs: function() {
			var $group = $('.group'),
				$navtabs = $('.nav-tab-wrapper a'),
				active_tab = '';

			// Hides all the .meta-group sections to start
			$group.hide();

			// Find if a selected tab is saved in localStorage
			if ( typeof(localStorage) != 'undefined' ) {
				active_tab = localStorage.getItem('meta_active_tab');
			}

			// If active tab is saved and exists, load it's .meta-group
			if ( active_tab != '' && $(active_tab).length ) {
				$(active_tab).fadeIn();
				$(active_tab + '-tab').addClass('nav-tab-active');
			} else {
				$('.group:first').fadeIn();
				$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
			}

			// Bind tabs clicks
			$navtabs.click(function(e) {
				e.preventDefault();

				// Remove active class from all tabs
				$navtabs.removeClass('nav-tab-active');

				$(this).addClass('nav-tab-active').blur();

				if (typeof(localStorage) != 'undefined' ) {
					localStorage.setItem('meta_active_tab', $(this).attr('href') );
				}

				var selected = $(this).attr('href');

				$group.hide();
				$(selected).fadeIn();
			});
		}
	};

	AnvaMeta.init();

});