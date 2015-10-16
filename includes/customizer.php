<?php

/**
 * Setup theme options for customizer
 */
function eren_customizer_options() {

	$background_options = array(
		'background_color' => array(
			'name' 			=> __( 'Background Color', 'anva' ),
			'id' 				=> 'background_color',
			'type' 			=> 'color',
			'transport'	=> 'postMessage',
			'priority'	=> 1
		),
		'background_image' => array(
			'name' 			=> __( 'Background Image', 'anva' ),
			'id' 				=> 'background_image',
			'type' 			=> 'image',
			'transport'	=> 'postMessage',
			'priority'	=> 2
		),
		'background_pattern' => array(
			'name' 			=> __( 'Background Patterns', 'anva' ),
			'id' 				=> 'background_pattern',
			'type' 			=> 'select',
			'options' => array(
				'' 										 => __( 'None', 'anva' ),
				'binding_light' 			 => 'Binding Light',
				'dimension_@2X' 			 => 'Dimension',
				'hoffman_@2X' 				 => 'Hoffman',
				'knitting250px' 			 => 'Knitting',
				'noisy_grid' 					 => 'Noisy Grid',
				'pixel_weave_@2X' 		 => 'Pixel Weave',
				'struckaxiom' 				 => 'Struckaxiom',
				'subtle_stripes' 			 => 'Subtle Stripes',
				'white_brick_wall_@2X' => 'White Brick Wall'
			),
			'transport'	=> 'postMessage',
			'priority'	=> 3
		),
	);
	anva_add_customizer_section( 'background', __( 'Background', 'anva' ), $background_options, 1 );

	// Setup logo options
	$header_options = array(
		'logo' => array(
			'name' 			=> __( 'Logo', 'anva' ),
			'id' 				=> 'logo',
			'type' 			=> 'logo',
			'transport'	=> 'postMessage',
			'priority'	=> 1
		),
		'social_media_style' => array(
			'name' 			=> __( 'Socia Media Buttons Style', 'anva' ),
			'id'				=> 'social_media_style',
			'type' 			=> 'select',
			'options'		=> array(
				'light' 	=> __( 'Light', 'anva' ),
				'colored' => __( 'Colored', 'anva' ),
				'dark' 		=> __( 'Dark', 'anva' )
			),
			'transport'	=> 'postMessage',
			'priority'	=> 21
		)
	);
	anva_add_customizer_section( 'header', __( 'Header', 'anva' ), $header_options, 2 );

	$main_styles_options = array(
		'layout_style' 	=> array(
			'name' 				=> __( 'Layout Style', 'anva' ),
			'id'					=> 'layout_style',
			'type' 				=> 'select',
			'options'			=> array(
				'boxed' 		=> __( 'Boxed', 'anva' ),
				'stretched' => __( 'Stretched', 'anva' )
			),
			'transport'		=> 'postMessage',
			'priority'		=> 1
		),
		'base_color' 		=> array(
			'name' 				=> __( 'Base Color Scheme', 'anva' ),
			'id'					=> 'base_color',
			'type' 				=> 'select',
			'options'			=> array(
				'black' 		=> __( 'Black', 'anva' ),
				'blue' 			=> __( 'Blue', 'anva' ),
				'brown' 		=> __( 'Brown', 'anva' ),
				'green' 		=> __( 'Green', 'anva' ),
				'navy' 			=> __( 'Navy', 'anva' ),
				'orange' 		=> __( 'Orange', 'anva' ),
				'pink' 			=> __( 'Pink', 'anva' ),
				'purple' 		=> __( 'Purple', 'anva' ),
				'red' 			=> __( 'Red', 'anva' ),
				'slate' 		=> __( 'Slate Grey', 'anva' ),
				'teal' 			=> __( 'Teal', 'anva' )
			),
			'transport'		=> 'postMessage',
			'priority'		=> 2
		),
		'footer_color' 	=> array(
			'name' 				=> __( 'Footer Color Scheme', 'anva' ),
			'id'					=> 'footer_color',
			'type' 				=> 'select',
			'options'			=> array(
				'light' 		=> __( 'Light', 'anva' ),
				'dark' 			=> __( 'Dark', 'anva' )
			),
			'transport'		=> 'postMessage',
			'priority'		=> 3
		),
	);
	anva_add_customizer_section( 'main_styles', __( 'Main Styles', 'anva' ), $main_styles_options, 101 );

	//  Font options
	$font_options 		= array(
		'body_font' 		=> array(
			'name' 				=> __( 'Body Font', 'anva' ),
			'id' 					=> 'body_font',
			'atts'				=> array( 'size', 'style', 'face' ),
			'type' 				=> 'typography',
			'transport'		=> 'postMessage'
		),
		'heading_font' 	=> array(
			'name' 				=> __( 'Headings Font', 'anva' ),
			'id' 					=> 'heading_font',
			'atts'				=> array('style', 'face'),
			'type' 				=> 'typography',
			'transport'		=> 'postMessage'
		),
		'menu_font' 		=> array(
			'name' 				=> __( 'Menu Font', 'anva' ),
			'id' 					=> 'menu_font',
			'atts'				=> array( 'style', 'face' ),
			'type' 				=> 'typography',
			'transport'		=> 'postMessage'
		)
	);
	anva_add_customizer_section( 'typography', __( 'Typography', 'anva' ), $font_options, 102 );

	// Link options
	$link_options = array(
		'link_color' => array(
			'name' 		=> __( 'Link Color', 'anva' ),
			'id' 		=> 'link_color',
			'type' 		=> 'color',
			'priority'	=> 1
		),
		'link_hover_color' => array(
			'name' 		=> __( 'Link Hover Color', 'anva' ),
			'id' 		=> 'link_hover_color',
			'type' 		=> 'color',
			'priority'	=> 2
		),
		'footer_link_color' => array(
			'name' 		=> __( 'Footer Link Color', 'anva' ),
			'id' 		=> 'footer_link_color',
			'type' 		=> 'color',
			'priority'	=> 3
		),
		'footer_link_hover_color' => array(
			'name' 		=> __( 'Footer Link Hover Color', 'anva' ),
			'id' 		=> 'footer_link_hover_color',
			'type' 		=> 'color',
			'priority'	=> 4
		)
	);
	anva_add_customizer_section( 'links', __( 'Links', 'anva' ), $link_options, 103 );

	// Setup custom styles option
	$custom_css_options = array(
		'custom_css' 	=> array(
			'name' 			=> __( 'Enter styles to preview their results.', 'anva' ),
			'id' 				=> 'custom_css',
			'type' 			=> 'textarea',
			'transport'	=> 'postMessage'
		)
	);
	anva_add_customizer_section( 'custom_css', __( 'Custom CSS', 'anva' ), $custom_css_options, 121 );

}
add_action( 'after_setup_theme', 'eren_customizer_options' );

/**
 * Add specific theme elements to customizer
 */
function eren_customizer_init( $wp_customize ) {

	// Remove custom background options
	// $wp_customize->remove_section( 'colors' );
	// $wp_customize->remove_section( 'background_image' );

	// Add real-time option edits
	if ( $wp_customize->is_preview() ) {
		add_action( 'wp_footer', 'eren_customizer_preview', 21 );
	}

}
add_action( 'customize_register', 'eren_customizer_init' );

/**
 * Add real-time option edits for this theme in customizer
 */
function eren_customizer_preview() {

	// Global option name
	$option_name = anva_get_option_name();

	?>
	<script type="text/javascript">
	// window.onload for silly IE9 bug fix
	window.onload = function() {
		(function($) {

			// Variables
			var template_url = "<?php echo get_template_directory_uri(); ?>";
			var framework_url = '<?php echo anva_get_core_uri(); ?>';

			// ---------------------------------------------------------
			// Background
			// ---------------------------------------------------------

			/* Body BG Color */
			wp.customize('<?php echo $option_name; ?>[background_color]',function( value ) {
				value.bind(function( color ) {
					$('body').css('background-color', color );
				});
			});

			/* Body BG Image */
			wp.customize('<?php echo $option_name; ?>[background_image]',function( value ) {
				value.bind(function( image ) {
					$('body').css('background', 'url(' + image + ') center center no-repeat fixed');
				});
			});

			/* Body BG Pattern */
			wp.customize('<?php echo $option_name; ?>[background_pattern]',function( value ) {
				value.bind(function( pattern ) {
					if ( '' != pattern ) {
						$('body').css('background', 'url(' + template_url + '/assets/images/patterns/' + pattern + '.png) repeat');
					} else {
						$('body').css('background-image', 'none');
					}
				});
			});

			// ---------------------------------------------------------
			// Header
			// ---------------------------------------------------------

			<?php anva_customizer_preview_logo(); ?>

			/* Social Media Style */
			wp.customize('<?php echo $option_name; ?>[social_media_style]',function( value ) {
				value.bind(function( style ) {
					$('#top-bar .social-icons a').removeClass('social-light social-dark social-colored');
					$('#top-bar .social-icons a').addClass( 'social-' + style );
				});
			});

			// ---------------------------------------------------------
			// Main Styles
			// ---------------------------------------------------------

			/* Layout Style */
			wp.customize('<?php echo $option_name; ?>[layout_style]',function( value ) {
				value.bind(function( value ) {
					$('body').removeClass('boxed stretched');
					$('body').addClass( value );
				});
			});

			/* Base Color Scheme */
			wp.customize('<?php echo $option_name; ?>[base_color]',function( value ) {
				value.bind(function( color ) {
					$('body').removeClass('base-color-black base-color-blue base-color-brown base-color-dark_purple base-color-dark base-color-green base-color-light_blue base-color-light base-color-navy base-color-orange base-color-pink base-color-purple base-color-red base-color-slate base-color-teal');
					$('body').addClass( 'base-color-' + color );
				});
			});

			/* Footer Color Scheme */
			wp.customize('<?php echo $option_name; ?>[footer_color]',function( value ) {
				value.bind(function( color ) {
					$('#footer').removeClass('dark');
					$('#footer').addClass( color );
				});
			});

			// ---------------------------------------------------------
			// Typography
			// ---------------------------------------------------------

			<?php anva_customizer_preview_font_prep(); ?>
			<?php anva_customizer_preview_primary_font(); ?>
			<?php anva_customizer_preview_header_font(); ?>

			// ---------------------------------------------------------
			// Special Typography
			// ---------------------------------------------------------

			var special_font_selectors = '#branding .header_logo .tb-text-logo, #content .media-full .slide-title, #featured_below .media-full .slide-title, .element-slogan .slogan .slogan-text, .element-tweet';

			/* Special Typography - Style */
			wp.customize('<?php echo $option_name; ?>[typography_special][style]',function( value ) {
				value.bind(function(style) {
					// Possible choices: normal, bold, italic, bold-italic
					if ( style == 'normal' ) {
						$(special_font_selectors).css('font-weight', 'normal');
						$(special_font_selectors).css('font-style', 'normal');

					} else if ( style == 'bold' ) {
						$(special_font_selectors).css('font-weight', 'bold');
						$(special_font_selectors).css('font-style', 'normal');

					} else if ( style == 'italic' ) {
						$(special_font_selectors).css('font-weight', 'normal');
						$(special_font_selectors).css('font-style', 'italic');

					} else if ( style == 'bold-italic' ) {
						$(special_font_selectors).css('font-weight', 'bold');
						$(special_font_selectors).css('font-style', 'italic');
					}
				});
			});

			/* Special Typography - Face */
			wp.customize('<?php echo $option_name; ?>[typography_special][face]',function( value ) {
				value.bind(function(face) {
					if( face == 'google' ){
						googleFonts.specialToggle = true;
						var google_font = googleFonts.specialName.split(":"),
							google_font = google_font[0];
						$(special_font_selectors).css('font-family', google_font);
					}
					else
					{
						googleFonts.specialToggle = false;
						$(special_font_selectors).css('font-family', fontStacks[face]);
					}
				});
			});

			/* Special Typography - Google */
			wp.customize('<?php echo $option_name; ?>[typography_special][google]',function( value ) {
				value.bind(function(google_font) {
					// Only proceed if user has actually selected for
					// a google font to show in previous option.
					if(googleFonts.specialToggle)
					{
						// Set global google font for reference in
						// other options.
						googleFonts.specialName = google_font;

						// Remove previous google font to avoid clutter.
						$('.preview_google_special_font').remove();

						// Format font name for inclusion
						var include_google_font = google_font.replace(/ /g,'+');

						// Include font
						$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_special_font" />');

						// Format for CSS
						google_font = google_font.split(":");
						google_font = google_font[0];

						// Apply font in CSS
						$(special_font_selectors).css('font-family', google_font);
					}
				});
			});

			// ---------------------------------------------------------
			// Custom CSS
			// ---------------------------------------------------------

			wp.customize( '<?php echo $option_name; ?>[custom_css]', function( value ) {
				value.bind( function( css ) {
					$('.preview_custom_css').remove();
					$('head').append( '<style class="preview_custom_css">' + css + '</style>' );
				});
			});

		})(jQuery);
	} // End window.onload for silly IE9 bug
	</script>
	<?php
}