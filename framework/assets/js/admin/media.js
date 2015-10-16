jQuery(document).ready(function($) {

	"use strict";

	var AnvaMedia = {

		init: function() {
			AnvaMedia.metaboxes();
			AnvaMedia.upload();
		},
			
		metaboxes: function() {
			// Show/Hide Metaboxes as needed
			var $galleryId = $('#anva_gallery_id').val();
			$('#_tzp_display_gallery').data('related-metabox-id', $galleryId );
			
			var metaboxes = [
				{ 
					'handle' : $('#_tzp_display_gallery'),
					'metabox' : $( '#' + $galleryId ) 
				},
				{ 
					'handle' : $('#_tzp_display_audio'),
					'metabox' : $('#tzp-portfolio-metabox-audio') 
				},
				{ 
					'handle' : $('#_tzp_display_video'),
					'metabox' : $('#tzp-portfolio-metabox-video') 
				}
			];

			for ( var i = 0 ; i < metaboxes.length ; i++ ) {
				
				if ( metaboxes[i].handle.is( ':checked' ) ) {
					metaboxes[i].metabox.css( 'display', 'block' );
				} else {
					metaboxes[i].metabox.css( 'display', 'none' );
				}

				metaboxes[i].handle.on( 'click', function() {
					var $this = $(this),
							metaboxId = '#' + $this.data('related-metabox-id');
							
					if( $this.is(':checked') ) {
						$(metaboxId).css('display', 'block');
					} else {
						$(metaboxId).css('display', 'none');
					}
				});
			}
		},

		// Media manager for image insert
		upload: function() {
			var frame;

			$('.tzp-upload-file-button').on('click', function(e) {
				e.preventDefault();

				// Set options for 1st frame render
				var $this = $(this),
					$input = $this.siblings('.file'),
					options = {
						state: 'insert',
						frame: 'post'
					};

				frame = wp.media(options).open();
				
				// Tweak views
				frame.menu.get('view').unset('gallery');
				frame.menu.get('view').unset('featured-image');
										
				frame.toolbar.get('view').set({
					insert: {
						style: 'primary',
						text: 'Select',

						click: function() {
							var models = frame.state().get('selection'),
								url = models.first().attributes.url;

							$input.val( url ); 

							frame.close();
						}
					}
				});
			});
		}
	};

	AnvaMedia.init();

});