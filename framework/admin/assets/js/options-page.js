jQuery( document ).ready( function( $ ) {

	'use strict';

	// Anva Options Object
	var ANVA_OPTIONS = {

		init: function() {
			// ANVA_OPTIONS.settingsChange();
			ANVA_OPTIONS.extras();
			ANVA_OPTIONS.stickyActions();
		},

		settingsChange: function() {
			$('input, select, textarea').on( 'change', function() {
				$('#anva-framework-change').show(400);
			});
		},

		extras: function() {

			// CSS
			var $mode = $('#code_editor_mode').val();
			var code_editor = document.querySelector('.anva-code-editor');
			var editor = CodeMirror.fromTextArea( code_editor, {
				mode: $mode,
        		theme: "mdn-like",
        		lineNumbers: true
			});

			// Reset Button
			$(document).on( 'click', '.reset-button', function(e) {
				e.preventDefault();
				var $form = $(this).closest('form');
				swal({
					title: anvaJs.save_button_title,
					text: anvaJs.save_button_text,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#0085ba",
					confirmButtonText: anvaJs.save_button_confirm,
					cancelButtonText: anvaJs.save_button_cancel,
					cancelButtonColor: "#f7f7f7",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function( isConfirm ) {
					if ( isConfirm ) {
						$form.append('<input type="hidden" name="reset" value="true" />');
						$form.submit();
					}
				});
			});

			// Reset Button
			$(document).on( 'click', '.import-button', function(e) {
				e.preventDefault();
				var $form = $(this).closest('form');

				if ( '' === $('#section-import_settings textarea').val() ) {
					swal({
						title: anvaJs.import_empty_title,
						text: anvaJs.import_empty_text,
						type: "info",
						showConfirmButton: true,
						confirmButtonColor: "#0085ba",
					});
					return false;
				}

				swal({
					title: anvaJs.import_button_title,
					text: anvaJs.import_button_text,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#0085ba",
					confirmButtonText: anvaJs.import_button_confirm,
					cancelButtonText: anvaJs.import_button_cancel,
					cancelButtonColor: "#f7f7f7",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function( isConfirm ) {
					if ( isConfirm ) {
						$form.append('<input type="hidden" name="import" value="true" />');
						$form.submit();
					}
				});
			});

			// Load transition
			$('.animsition').animsition({
				inClass: 'fade-in',
				outClass: 'fade-out',
				inDuration: 1500,
				outDuration: 800,
				linkElement: '.animsition-link',
				loading: true,
				loadingParentElement: 'body',
				loadingClass: 'animsition-loading',
				loadingInner: '',
				timeout: false,
				timeoutCountdown: 5000,
				onLoadEvent: true,
				browser: [ 'animation-duration', '-webkit-animation-duration'],
				overlay : false,
				overlayClass : 'animsition-overlay-slide',
				overlayParentElement : 'body',
				transition: function( url ) { window.location.href = url; }
			});

			// Show spinner on submit form
			$('#anva-framework-submit input.button-primary').click( function() {
				$(this).val( anvaJs.save_button );
				$('#anva-framework-submit .spinner').addClass('is-active');
			});

			// Collapse sections
			$('.inner-group > h3').on( 'click', function(e) {
				e.preventDefault();
				var $collapse = $(this), $postbox = $collapse.closest('.postbox');

				// var $collapse = $(this).parent().toggleClass('collapse-close');
				if ( $postbox.hasClass('collapse-close') ) {

					// Show content
					$postbox.removeClass('collapse-close');

					// Store data
					if ( typeof( localStorage ) !== 'undefined' ) {
						localStorage.removeItem('anva-section-' + $postbox.attr('id'));
					}

					// Refresh any code editor options
					$postbox.find('.section-css').each(function() {
						var $editor = $(this).find('textarea').data('CodeMirrorInstance');
						if ( $editor ) {
							$editor.refresh();
						}
					});
				} else {
					// Hide content
					$postbox.addClass('collapse-close');

					// Store data
					if ( typeof( localStorage ) !== 'undefined' ) {
						localStorage.setItem('anva-section-' + $postbox.attr('id'), true);
					}
				}

			});

			// Show content
			$('#anva-framework .postbox').each(function() {
				var $postbox = $(this);
				if ( typeof( localStorage ) !== 'undefined' && localStorage.getItem('anva-section-' + $postbox.attr('id')) ) {
					$postbox.addClass('collapse-close');
				}
			});

			// Hide admin notices
			// var $error = $('#anva-framework-wrap .settings-error');
			// if ( $error.length > 0 ) {
			// 	setTimeout( function() {
			// 		$error.fadeOut(500);
			// 	}, 3000);
			// }

			if ( $('.nav-tab-wrapper').length > 0 ) {
				ANVA_OPTIONS.tabs();
			}

		},

		tabs: function() {
			var $group = $('.group'),
				$navtabs = $('.nav-tab-wrapper a'),
				active_tab = '';

			// Hides all the .group sections to start
			$group.hide();

			// Find if a selected tab is saved in localStorage
			if ( typeof(localStorage) !== 'undefined' ) {
				active_tab = localStorage.getItem('active_tab');
			}

			// If active tab is saved and exists, load it's .group
			if ( active_tab !== '' && $(active_tab).length ) {
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

				if (typeof(localStorage) !== 'undefined' ) {
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
			var $cache = $('#anva-framework .options-settings > .columns-2');
			var $postBox = $('#anva-framework .postbox-wrapper');
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

	ANVA_OPTIONS.init();

	// Window scroll change
	$(window).scroll( function() {
		ANVA_OPTIONS.stickyActions();
	});

});
