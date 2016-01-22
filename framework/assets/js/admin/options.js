jQuery(document).ready(function($) {

	"use strict";

	// Anva Options Object
	var AnvaOptions = {

		// Default Settings
		settings: {
			template: $('#page_template'),
			grid: 		$('#meta-grid_column'),
			sidebar: 	$('#meta-sidebar_layout')
		},

		init: function() {
			AnvaOptions.extras();
			AnvaOptions.stickyActions();
			AnvaOptions.sections.init();
		},

		extras: function() {

			// Remove sidebar
			$(document).on( 'click', '.dynamic-sidebars .delete', function(e) {
				e.preventDefault();
				var $ele = $(this).parent();
				if ( confirm( 'You sure want delete this item?' )	) {
					$ele.fadeOut();
					setTimeout( function() {
						$ele.remove();
						if ( $('.dynamic-sidebars ul li').length == 0 ) {
							$('.dynamic-sidebars ul').addClass('empty');
						}
					}, 500 );
				}
			});

			// Add new sidebar
			$('#add-sidebar').click( function() {
				var $new = $('.sidebar').val();

				if ( '' == $new ) {
					alert( 'Enter the name for custom sidebar.' );
					return false;
				}

				$('.dynamic-sidebars ul').removeClass('empty');

				var $sidebarId = $('#dynamic_sidebar_id').val(), $sidebarName = $('#dynamic_sidebar_name').val();
				$('.dynamic-sidebars ul').append( '<li>' + $new + ' <a href="#" class="delete">Delete</a> <input type="hidden" name="' + $sidebarName + '[' + $sidebarId + '][]' + '" value="' + $new + '" /></li>' );
				$('.sidebar').val('');
			});

			// Show spinner on submit form
			$('#optionsframework-submit input.button-primary').click( function() {
				$(this).val( anvaJs.save_button );
				$('#optionsframework-submit .spinner').addClass('is-active');
			});

			$('.inner-group > h3').on( 'click', function(e) {
				e.preventDefault();
				var $collapse = $(this).parent().toggleClass('collapse-close');
			});;

			// Hide admin notices
			var $error = $('#optionsframework-wrap .settings-error');
			if ( $error.length > 0 ) {
				setTimeout( function() {
					$error.fadeOut(500);
				}, 3000);
			}

			if ( $('.nav-tab-wrapper').length > 0 ) {
				AnvaOptions.optionsFrameworkTabs();
			}

		},

		optionsFrameworkTabs: function() {
			var $group = $('.group'),
				$navtabs = $('.nav-tab-wrapper a'),
				active_tab = '';

			// Hides all the .group sections to start
			$group.hide();

			// Find if a selected tab is saved in localStorage
			if ( typeof(localStorage) != 'undefined' ) {
				active_tab = localStorage.getItem('active_tab');
			}

			// If active tab is saved and exists, load it's .group
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
					localStorage.setItem('active_tab', $(this).attr('href') );
				}

				var selected = $(this).attr('href');

				// Editor height sometimes needs adjustment when unhidden
				$('.wp-editor-wrap').each(function() {
					var editor_iframe = $(this).find('iframe');
					if ( editor_iframe.height() < 30 ) {
						editor_iframe.css({'height':'auto'});
					}
				});

				$group.hide();
				$(selected).fadeIn();
			});
		},

		stickyActions: function() {
			var $cache = $('#optionsframework .options-settings > .columns-2');
			var $postBox = $('#optionsframework .postbox-wrapper');
			if ( $(window).scrollTop() > 115 ) {
				$cache.css({
					'position': 'absolute',
					'top': 0,
					'right': 0,
					'z-index': 99
				});
				$postBox.css({
					'position': 'fixed',
					'top': '40px'
				});
			} else {
				$cache.css({
					'position': 'static'
				});
				$postBox.css({
					'position': 'static'
				});
			}
		}
	};

	AnvaOptions.sections = {

		init: function() {
			AnvaOptions.sections.colorPicker();
			AnvaOptions.sections.radioImages();
			AnvaOptions.sections.logo();
			AnvaOptions.sections.typography();
			AnvaOptions.sections.socialMedia();
			AnvaOptions.sections.columns();
			AnvaOptions.sections.slider();
		},

		colorPicker: function() {
			$('.anva-color').wpColorPicker();
		},

		radioImages: function() {
			$('.anva-radio-img-box').click( function() {
				$(this).closest('.section-images').find('.anva-radio-img-box').removeClass('anva-radio-img-selected');
				$(this).addClass('anva-radio-img-selected');
				$(this).find('.anva-radio-img-radio').prop('checked', true);
			});

			// $('.anva-radio-img-label').hide();
			$('.anva-radio-img-img').show();
			
		},

		logo: function() {
			$('.section-logo').each(function(){
				var el = $(this), value = el.find('.select-type select').val();
				el.find('.logo-item').hide();
				el.find('.' + value).show();
			});

			$('.section-logo .anva-select select').on( 'change', function() {
				var el = $(this), parent = el.closest('.section-logo'), value = el.val();
				parent.find('.logo-item').hide();
				parent.find('.' + value).show();
			});
		},

		typography: function() {
			$('.section-typography .anva-typography-face').each(function() {
				var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
				if ( value == 'google' ) {
					el.closest('.section-typography').find('.google-font').fadeIn('fast');
					text = 'Arial';
				} else {
					el.closest('.section-typography').find('.google-font').hide();
				}
				el.closest('.section-typography').find('.sample-text-font').css('font-family', text);
			});

			$('.section-typography .anva-typography-face').on( 'change', function() {
				var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
				if ( value == 'google' ) {
					text = 'Arial';
					el.closest('.section-typography').find('.google-font').fadeIn('fast');
				} else {
					el.closest('.section-typography').find('.google-font').hide();
				}
				el.closest('.section-typography').find('.sample-text-font').css('font-family', text);
			});
		},

		socialMedia: function() {
			$('.section-social_media').each(function() {
				var el = $(this);
				el.find('.social_media-input').hide();
				el.find('.checkbox').each(function() {
					var checkbox = $(this);
					if ( checkbox.is(':checked') )
						checkbox.closest('.item').addClass('active').find('.social_media-input').show();
					else
						checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
				});
			});

			$('.section-social_media .checkbox').on('click', function() {
				var checkbox = $(this);
				if ( checkbox.is(':checked') )
					checkbox.closest('.item').addClass('active').find('.social_media-input').fadeIn('fast');
				else
					checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
			});
		},

		columns: function() {
			$('.section-columns').each(function(){
				var el = $(this), i = 1, num = el.find('.column-num').val();
				el.find('.column-width').hide();
				el.find('.column-width-'+num).show();
			});

			$('.section-columns .column-num').on('change', function(){
				var el = $(this), i = 1, num = el.val(), parent = el.closest('.section-columns');
				parent.find('.column-width').hide();
				parent.find('.column-width-'+num).fadeIn('fast');
			});
		},

		slider: function() {
			$('.group-slider').each(function() {
				var el = $(this), value = el.find('#slider_id').val();
				el.find('.slider-item').hide();
				el.find('.' + value).show();
			});

			$('.group-slider #slider_id').on( 'change', function() {
				var el = $(this), parent = el.closest('.group-slider'), value = el.val();
				parent.find('.slider-item').hide();
				parent.find('.' + value).show();
			});
		},
	};

	AnvaOptions.init();

	// Window scroll change
	$(window).scroll(function() {
		AnvaOptions.stickyActions();
	});
	
});