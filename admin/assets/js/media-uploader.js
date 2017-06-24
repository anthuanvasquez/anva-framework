jQuery( document ).ready( function( $ ) {

	'use strict';

	// Global variables
	var mediaUpload, mediaSelector;

	//
	var AnvaUploaderManager = {

		init: function() {
			$('.remove-image, .remove-file').on( 'click', function() {
				AnvaUploaderManager.mediaRemoveFile( $(this).closest('.section') );
			});

			$('.upload-button').click( function( e ) {
				AnvaUploaderManager.mediaAddFile( e, $(this).closest('.section') );
			});

			// Check if each section upload has image
			$('.section-upload, .section-background').each(function() {
				var el 	 	= $(this),
					screen  = el.find('.screenshot'),
					image   = screen.find('img');

				if ( image.length > 0 ) {
					screen.addClass('has-image');
				}
			});
		},

		mediaAddFile: function( e, selector ) {

			var el = $(this),
				upload = $('.uploaded-file'),
				frame;

			mediaSelector = selector;

			e.preventDefault();

			// If the media frame already exists, reopen it.
			if ( mediaUpload ) {
				mediaUpload.open();
			} else {
				// Create the media frame.
				mediaUpload = wp.media.frames.mediaUpload =  wp.media({
					// Set the title of the modal.
					title: el.data('choose'),

					// Customize the submit button.
					button: {
						// Set the text of the button.
						text: el.data('update'),
						// Tell the button not to close the modal, since we're
						// going to refresh the page when the image is selected.
						close: false
					}
				});

				// When an image is selected, run a callback.
				mediaUpload.on( 'select', function() {

					// Grab the selected attachment.
					var attachment = mediaUpload.state().get('selection').first();

					mediaUpload.close();
					mediaSelector.find('.upload').val( attachment.attributes.url );

					if ( attachment.attributes.type === 'image' ) {
						mediaSelector.find('.screenshot').empty().hide().append( '<img src="' + attachment.attributes.url + '"><a class="remove-image">X</a>' ).slideDown('fast').addClass('has-image');
					}

					mediaSelector.find('.upload-button').unbind().addClass('remove-file').removeClass('upload-button').val( anvaMediaJs.remove );
					mediaSelector.find('.anva-background-properties').slideDown();
					mediaSelector.find('.remove-image, .remove-file').on( 'click', function() {
						AnvaUploaderManager.mediaRemoveFile( $(this).parents('.section') );
					});
				});
			}

			// Finally, open the modal
			mediaUpload.open();
		},

		mediaRemoveFile: function( selector ) {

			selector.find('.remove-image').hide();
			selector.find('.upload').val('');
			selector.find('.anva-background-properties').hide();
			selector.find('.screenshot').slideUp().removeClass('has-image');
			selector.find('.remove-file').unbind().addClass('upload-button').removeClass('remove-file').val( anvaMediaJs.upload);

			// We don't display the upload button if .upload-notice is present
			// This means the user doesn't have the WordPress 3.5 Media Library Support
			if ( $('.section-upload .upload-notice').length > 0 ) {
				$('.upload-button').remove();
			}

			selector.find('.upload-button').on( 'click', function( e ) {
				AnvaUploaderManager.mediaAddFile( e, $(this).closest('.section') );
			});
		}

	};

	AnvaUploaderManager.init();

});
