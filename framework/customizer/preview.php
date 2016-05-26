<?php

/**
 * Styles for WordPress customizer.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_styles() {
	wp_register_style( 'anva_customizer', anva_get_core_admin_uri() . 'assets/css/customizer.min.css', false, ANVA_FRAMEWORK_VERSION );
	wp_enqueue_style( 'anva_customizer' );
}

/**
 * Scripts for WordPress customizer.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_scripts() {
	wp_register_script( 'anva_customizer', anva_get_core_admin_uri() . 'assets/js/customizer.min.js', array( 'jquery' ), ANVA_FRAMEWORK_VERSION );
	wp_enqueue_script( 'anva_customizer' );
	wp_localize_script( 'anva_customizer', 'anvaJs', anva_get_admin_locals( 'customizer_js' ) );
}

/**
 * Logo for customizer preview.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview_logo() {

	// Global option name
	$option_name = anva_get_option_name();

	// Setup for logo
	$logo_options = anva_get_option('logo');
	
	$logo_atts = array(
		'type' 						=> '',
		'site_url'				=> home_url(),
		'title'						=> get_bloginfo( 'name' ),
		'tagline'					=> get_bloginfo( 'description' ),
		'custom' 					=> '',
		'custom_tagline' 	=> '',
		'image' 					=> '',
	);

	foreach ( $logo_atts as $key => $value ) {
		if ( isset( $logo_options[ $key ] ) ) {
			$logo_atts[ $key ] = $logo_options[ $key ];
		}
	}

	// Begin output
	?>
	// Logo atts object
	Logo = <?php echo json_encode( $logo_atts ); ?>;

	/* Logo - Type */
	wp.customize('<?php echo $option_name; ?>[logo][type]', function( value ) {
		value.bind( function( value ) {
			// Set global marker. This allows us to
			// know the currently selected logo type
			// from any other option.
			Logo.type = value;

			// Remove classes specific to type so we
			// can add tehm again depending on new type.
			$('#logo').removeAttr('class');

			// Display markup depending on type of logo selected.
			if ( value == 'title' )
			{
				$('#logo').addClass('logo-text');
				$('#logo').html('<h1 class="text-logo"><a href="'+Logo.site_url+'" title="'+Logo.title+'">'+Logo.title+'</a></h1>');
			}
			else if ( value == 'title_tagline' )
			{
				$('#logo').addClass('logo-tagline');
				$('#logo').addClass('logo-has-tagline');
				$('#logo').html('<h1 class="text-logo"><a href="'+Logo.site_url+'" title="'+Logo.title+'">'+Logo.title+'</a></h1><span class="logo-tagline">'+Logo.tagline+'</span>');
			}
			else if ( value == 'custom' )
			{
				var html = '<h1 class="text-logo"><a href="'+Logo.site_url+'" title="'+Logo.custom+'">'+Logo.custom+'</a></h1>';
				if (Logo.custom_tagline)
				{
					$('#logo').addClass('logo-has-tagline');
					html = html+'<span class="logo-tagline">'+Logo.custom_tagline+'</span>';
				}
				$('#logo').addClass('logo-text');
				$('#logo').html(html);
			}
			else if ( value == 'image' )
			{
				var html;
				if (Logo.image)
				{
					html = '<a href="'+Logo.site_url+'" title="'+Logo.title+'"><img src="'+Logo.image+'" alt="'+Logo.title+'" /></a>';
				}
				else
				{
					html = '<strong>Oops! You still need to upload an image.</strong>';
				}
				$('#logo').addClass('logo-image logo-has-image');
				$('#logo').html(html);
			}
		});
	});

	/* Logo - Custom Title */
	wp.customize('<?php echo $option_name; ?>[logo][custom]',function( value ) {
		value.bind(function(value) {
			// Set global marker
			Logo.custom = value;

			// Only do if anything if the proper logo
			// type is currently selected.
			if ( Logo.type == 'custom' ) {
				$('#logo h1 a').text( value );
			}
		});
	});

	/* Logo - Custom Tagline */
	wp.customize('<?php echo $option_name; ?>[logo][custom_tagline]',function( value ) {
		value.bind(function(value) {
			// Set global marker
			Logo.custom_tagline = value;

			// Remove previous tagline if needed.
			$('#logo').removeAttr('class');
			$('#logo .logo-tagline').remove();

			// Only do if anything if the proper logo
			// type is currently selected.
			if ( Logo.type == 'custom' ) {
				if (value)
				{
					$('#logo').addClass('logo-has-tagline');
					$('#logo').append('<span class="logo-tagline">'+value+'</span>');
				}
			}
		});
	});

	/* Logo - Image */
	wp.customize('<?php echo $option_name; ?>[logo][image]',function( value ) {
		value.bind( function( value ) {
			// Set global marker
			Logo.image = value;

			// Only do if anything if the proper logo
			// type is currently selected.
			if ( Logo.type == 'image' ) {
				var html;
				if ( value )
				{
					html = '<a href="'+Logo.site_url+'" title="'+Logo.title+'"><img src="'+Logo.image+'" alt="'+Logo.title+'" /></a>';
				}
				else
				{
					html = '<strong>Oops! You still need to upload an image.</strong>';
				}
				$('#logo').removeAttr('class');
				$('#logo').addClass('logo-image logo-has-image');
				$('#logo').html(html);
			}
		});
	});
	<?php
}

/**
 * Font prep for customizer preview.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview_font_prep() {

	// Global option name
	$option_name = anva_get_option_name();

	// Setup font stacks
	$font_stacks = anva_get_font_stacks();
	unset( $font_stacks['google'] );

	// Determine current google fonts with fake
	// booleans to be used in printed JS object.
	$types = array('body', 'heading');
	$google_fonts = array();
	
	foreach ( $types as $type ) {
		$font = anva_get_option( $type . '_font' );
		$google_fonts[ $type .'Name' ] = ! empty( $font['google'] ) && $font['google'] ? $font['google'] : '';
		$google_fonts[ $type . 'Toggle' ] = ! empty( $font['face'] ) && $font['face'] == 'google' ? 'true' : 'false';
	}
	?>
	// Font stacks
	fontStacks = <?php echo json_encode( $font_stacks ); ?>;

	// Google font toggles
	googleFonts = <?php echo json_encode( $google_fonts ); ?>;
	<?php
}

/**
 * Body font for customizer preview.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview_body_font() {

	// Global option name
	$option_name = anva_get_option_name();

	// Begin output
	?>
	// ---------------------------------------------------------
	// Body Typography
	// ---------------------------------------------------------

	/* Body Typography - Size */
	wp.customize('<?php echo $option_name; ?>[body_font][size]', function( value ) {
		value.bind( function( size ) {
			// We're doing this odd-ball way so jQuery
			// doesn't apply body font to other elements.
			$('.preview_body_font_size').remove();
			$('head').append( '<style class="preview_body_font_size">body{ font-size: ' + size + '; }</style>' );
		});
	});

	/* Body Typography - Style */
	wp.customize('<?php echo $option_name; ?>[body_font][style]', function( value ) {
		value.bind( function( style ) {

			// We're doing this odd-ball way so jQuery
			// doesn't apply body font to other elements.
			$('.preview_body_font_style').remove();

			// Possible choices: normal, bold, italic, bold-italic
			var body_font_style;

			if ( style == 'normal' )
				body_font_style = 'font-weight: normal; font-style: normal;';
			else if ( style == 'bold' )
				body_font_style = 'font-weight: bold; font-style: normal;';
			else if ( style == 'italic' )
				body_font_style = 'font-weight: normal; font-style: italic;';
			else if ( style == 'bold-italic' )
				body_font_style = 'font-weight: bold; font-style: italic;';

			$('head').append( '<style class="preview_body_font_style">body{' + body_font_style + '}</style>' );

		});
	});

	/* Body Typography - Face */
	wp.customize('<?php echo $option_name; ?>[body_font][face]', function( value ) {
		value.bind( function( face ) {
			var header_font_face = $('h1, h2, h3, h4, h5, h6').css('font-family');
			
			if ( face == 'google' ) {
				googleFonts.bodyToggle = true;
				var google_font = googleFonts.bodyName.split(":"),
					google_font = google_font[0];
				$('body').css('font-family', google_font);
				$('h1, h2, h3, h4, h5, h6').css('font-family', header_font_face); // Maintain header font when body font switches
			}
			else
			{
				googleFonts.bodyToggle = false;
				$('body').css('font-family', fontStacks[face]);
				$('h1, h2, h3, h4, h5, h6').css('font-family', header_font_face); // Maintain header font when body font switches
			}
		});
	});

	/* Body Typography - Google */
	wp.customize('<?php echo $option_name; ?>[body_font][google]', function( value ) {
		value.bind( function( google_font ) {
			// Only proceed if user has actually selected for
			// a google font to show in previous option.
			if ( googleFonts.bodyToggle )
			{
				// Set global google font for reference in
				// other options.
				googleFonts.bodyName = google_font;

				// Determine current header font so we don't
				// override it with our new body font.
				var header_font_face = $('h1, h2, h3, h4, h5, h6').css('font-family');

				// Remove previous google font to avoid clutter.
				$('.preview_google_body_font').remove();

				// Format font name for inclusion
				var include_google_font = google_font.replace(/ /g,'+');

				// Include font
				setTimeout( function() {
					$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_body_font" />');
				}, 1000 );

				// Format for CSS
				google_font = google_font.split(":");
				google_font = google_font[0];

				// Apply font in CSS
				$('body').css('font-family', google_font);
				$('h1, h2, h3, h4, h5, h6').css('font-family', header_font_face); // Maintain header font when body font switches
			}
		});
	});
	<?php
}

/**
 * Headings font for cutomizer preview.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview_heading_font() {

	// Global option name
	$option_name = anva_get_option_name();

	// Begin Output
	?>
	// ---------------------------------------------------------
	// Header Typography
	// ---------------------------------------------------------

	/* Header Typography - Style */
	wp.customize('<?php echo $option_name; ?>[heading_font][style]',function( value ) {
		value.bind(function(style) {
			// Possible choices: normal, bold, italic, bold-italic
			if ( style == 'normal' ) {
				$('h1, h2, h3, h4, h5, h6').css('font-weight', 'normal');
				$('h1, h2, h3, h4, h5, h6').css('font-style', 'normal');
			} else if ( style == 'bold' ) {
				$('h1, h2, h3, h4, h5, h6').css('font-weight', 'bold');
				$('h1, h2, h3, h4, h5, h6').css('font-style', 'normal');
			} else if ( style == 'italic' ) {
				$('h1, h2, h3, h4, h5, h6').css('font-weight', 'normal');
				$('h1, h2, h3, h4, h5, h6').css('font-style', 'italic');
			} else if ( style == 'bold-italic' ) {
				$('h1, h2, h3, h4, h5, h6').css('font-weight', 'bold');
				$('h1, h2, h3, h4, h5, h6').css('font-style', 'italic');
			}
		});
	});

	/* Header Typography - Face */
	wp.customize('<?php echo $option_name; ?>[heading_font][face]', function( value ) {
		value.bind( function( face ) {
			if ( face == 'google' ) {
				googleFonts.headingToggle = true;
				var google_font = googleFonts.headingName.split(":"),
					google_font = google_font[0];
				$('h1, h2, h3, h4, h5, h6').css('font-family', google_font);
			}
			else
			{
				googleFonts.headingToggle = false;
				$('h1, h2, h3, h4, h5, h6').css('font-family', fontStacks[face]);
			}
		});
	});

	/* Header Typography - Google */
	wp.customize('<?php echo $option_name; ?>[heading_font][google]',function( value ) {
		value.bind(function(google_font) {
			// Only proceed if user has actually selected for
			// a google font to show in previous option.
			if ( googleFonts.headingToggle )
			{
				// Set global google font for reference in
				// other options.
				googleFonts.headingName = google_font;

				// Remove previous google font to avoid clutter.
				$('.preview_google_header_font').remove();

				// Format font name for inclusion
				var include_google_font = google_font.replace(/ /g,'+');

				// Include font
				setTimeout( function() {
					$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_header_font" />');
				}, 1000 );

				// Format for CSS
				google_font = google_font.split(":");
				google_font = google_font[0];

				// Apply font in CSS
				$('h1, h2, h3, h4, h5, h6').css('font-family', google_font);
			}
		});
	});
	<?php
}

/**
 * Menu font for customizer preview.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview_menu_font() {

	// Global option name
	$option_name = anva_get_option_name();

	// Begin output
	?>
	// ---------------------------------------------------------
	// Menu Typography
	// ---------------------------------------------------------

	/* Menu Typography - Size */
	wp.customize('<?php echo $option_name; ?>[menu_font][size]', function( value ) {
		value.bind( function( size ) {
			// We're doing this odd-ball way so jQuery
			// doesn't apply body font to other elements.
			$('.preview_menu_font_size').remove();
			$('head').append( '<style class="preview_menu_font_size">#primary-menu > div > ul { font-size: ' + size + '; }</style>' );
		});
	});

	/* Menu Typography - Style */
	wp.customize('<?php echo $option_name; ?>[menu_font][style]', function( value ) {
		value.bind( function( style ) {

			// We're doing this odd-ball way so jQuery
			// doesn't apply body font to other elements.
			$('.preview_menu_font_style').remove();
			
			// Possible choices: normal, bold, italic, bold-italic
			var menu_font_style;

			if ( style == 'normal' )
				menu_font_style = 'font-weight: normal; font-style: normal;';
			else if ( style == 'bold' )
				menu_font_style = 'font-weight: bold; font-style: normal;';
			else if ( style == 'italic' )
				menu_font_style = 'font-weight: normal; font-style: italic;';
			else if ( style == 'bold-italic' )
				menu_font_style = 'font-weight: bold; font-style: italic;';

			$('head').append( '<style class="preview_menu_font_style">#primary-menu > div > ul {' + menu_font_style + '}</style>' );

		});
	});

	/* Menu Typography - Face */
	wp.customize('<?php echo $option_name; ?>[menu_font][face]', function( value ) {
		value.bind( function( face ) {
			
			if ( face == 'google' ) {
				googleFonts.menuToggle = true;
				var google_font = googleFonts.menuName.split(":"),
					google_font = google_font[0];
				$('#primary-menu > div > ul').css('font-family', google_font);
			}
			else
			{
				googleFonts.menuToggle = false;
				$('#primary-menu > div > ul').css('font-family', fontStacks[face]);
			}
		});
	});

	/* Menu Typography - Google */
	wp.customize('<?php echo $option_name; ?>[menu_font][google]', function( value ) {
		value.bind( function( google_font ) {
			// Only proceed if user has actually selected for
			// a google font to show in previous option.
			if ( googleFonts.menuToggle )
			{
				// Set global google font for reference in
				// other options.
				googleFonts.menuName = google_font;

				// Remove previous google font to avoid clutter.
				$('.preview_google_body_font').remove();

				// Format font name for inclusion
				var include_google_font = google_font.replace(/ /g,'+');

				// Include font
				setTimeout( function() {
					$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_body_font" />');
				}, 1000 );

				// Format for CSS
				google_font = google_font.split(":");
				google_font = google_font[0];

				// Apply font in CSS
				$('#primary-menu > div > ul').css('font-family', google_font);
			}
		});
	});
	<?php
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since  1.0.0.
 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function anva_customizer_register_blog( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}

/**
 * Allow "refresh" transport type settings to work right in the customizer.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview() {

	global $wp_customize;

	// Check if customizer is running.
	if ( ! is_a( $wp_customize, 'WP_Customize_Manager' ) ) {
		return;
	}

	$wp_customize->is_preview();

}