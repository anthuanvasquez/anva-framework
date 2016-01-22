<?php

/**
 * Styles for WordPress customizer
 *
 * @since 1.0.0
 */
function anva_customizer_styles() {
	wp_register_style( 'anva_customizer', anva_get_core_uri() . '/assets/css/admin/customizer.min.css', false, ANVA_FRAMEWORK_VERSION );
	wp_enqueue_style( 'anva_customizer' );
}

/**
 * Scripts for WordPress customizer
 *
 * @since 1.0.0
 */
function anva_customizer_scripts() {
	wp_register_script( 'anva_customizer', anva_get_core_uri() . '/assets/js/admin/customizer.min.js', array( 'jquery' ), ANVA_FRAMEWORK_VERSION );
	wp_enqueue_script( 'anva_customizer' );
	wp_localize_script( 'anva_customizer', 'anvaJs', anva_get_admin_locals( 'customizer_js' ) );
}

/**
 * Logo Customizer Preview is core option
 *
 * @since 1.0.0
 */
function anva_customizer_preview_logo() {

	// Global option name
	$option_name = anva_get_option_name();

	// Setup for logo
	$logo_options = anva_get_option('logo');
	$logo_atts = array(
		'type' 				=> '',
		'site_url'			=> home_url(),
		'title'				=> get_bloginfo('name'),
		'tagline'			=> get_bloginfo('description'),
		'custom' 			=> '',
		'custom_tagline' 	=> '',
		'image' 			=> '',
	);

	foreach ( $logo_atts as $key => $value ) {
		if ( isset($logo_options[$key]) ) {
			$logo_atts[$key] = $logo_options[$key];
		}
	}

	// Begin output
	?>
	// Logo atts object
	Logo = <?php echo json_encode($logo_atts); ?>;

	/* Logo - Type */
	wp.customize('<?php echo $option_name; ?>[logo][type]',function( value ) {
		value.bind(function(value) {
			// Set global marker. This allows us to
			// know the currently selected logo type
			// from any other option.
			Logo.type = value;

			// Remove classes specific to type so we
			// can add tehm again depending on new type.
			$('#branding .header_logo').removeClass('header_logo_title header_logo_title_tagline header_logo_custom header_logo_image header_logo_has_tagline');

			// Display markup depending on type of
			// logo selected.
			if ( value == 'title' )
			{
				$('#branding .header_logo').addClass('header_logo_title');
				$('#branding .header_logo').html('<h1 class="tb-text-logo"><a href="'+Logo.site_url+'" title="'+Logo.title+'">'+Logo.title+'</a></h1>');
			}
			else if ( value == 'title_tagline' )
			{
				$('#branding .header_logo').addClass('header_logo_title_tagline');
				$('#branding .header_logo').addClass('header_logo_has_tagline');
				$('#branding .header_logo').html('<h1 class="tb-text-logo"><a href="'+Logo.site_url+'" title="'+Logo.title+'">'+Logo.title+'</a></h1><span class="tagline">'+Logo.tagline+'</span>');
			}
			else if ( value == 'custom' )
			{
				var html = '<h1 class="tb-text-logo"><a href="'+Logo.site_url+'" title="'+Logo.custom+'">'+Logo.custom+'</a></h1>';
				if (Logo.custom_tagline)
				{
					$('#branding .header_logo').addClass('header_logo_has_tagline');
					html = html+'<span class="tagline">'+Logo.custom_tagline+'</span>';
				}
				$('#branding .header_logo').addClass('header_logo_custom');
				$('#branding .header_logo').html(html);
			}
			else if ( value == 'image' )
			{
				var html;
				if (Logo.image)
				{
					html = '<a href="'+Logo.site_url+'" title="'+Logo.title+'" class="tb-image-logo"><img src="'+Logo.image+'" alt="'+Logo.title+'" /></a>';
				}
				else
				{
					html = '<strong>Oops! You still need to upload an image.</strong>';
				}
				$('#branding .header_logo').addClass('header_logo_image');
				$('#branding .header_logo').html(html);
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
				$('#branding .header_logo h1 a').text(value);
			}
		});
	});

	/* Logo - Custom Tagline */
	wp.customize('<?php echo $option_name; ?>[logo][custom_tagline]',function( value ) {
		value.bind(function(value) {
			// Set global marker
			Logo.custom_tagline = value;

			// Remove previous tagline if needed.
			$('#branding .header_logo').removeClass('header_logo_has_tagline');
			$('#branding .header_logo .tagline').remove();

			// Only do if anything if the proper logo
			// type is currently selected.
			if ( Logo.type == 'custom' ) {
				if (value)
				{
					$('#branding .header_logo').addClass('header_logo_has_tagline');
					$('#branding .header_logo').append('<span class="tagline">'+value+'</span>');
				}
			}
		});
	});

	/* Logo - Image */
	wp.customize('<?php echo $option_name; ?>[logo][image]',function( value ) {
		value.bind(function(value) {
			// Set global marker
			Logo.image = value;

			// Only do if anything if the proper logo
			// type is currently selected.
			if ( Logo.type == 'image' ) {
				var html;
				if (value)
				{
					html = '<a href="'+Logo.site_url+'" title="'+Logo.title+'" class="tb-image-logo"><img src="'+Logo.image+'" alt="'+Logo.title+'" /></a>';
				}
				else
				{
					html = '<strong>Oops! You still need to upload an image.</strong>';
				}
				$('#branding .header_logo').addClass('header_logo_image');
				$('#branding .header_logo').html(html);
			}
		});
	});
	<?php
}

/**
 * Font Prep for customizer preview
 *
 * @since 1.0.0
 */
function anva_customizer_preview_font_prep() {

	// Global option name
	$option_name = anva_get_option_name();

	// Setup font stacks
	$font_stacks = anva_get_font_stacks();
	unset( $font_stacks['google'] );

	// Determine current google fonts with fake
	// booleans to be used in printed JS object.
	$types = array('body', 'header', 'special');
	$google_fonts = array();
	foreach ( $types as $type ) {
		$font = anva_get_option('typography_'.$type);
		$google_fonts[$type.'Name'] = !empty($font['google']) && $font['google'] ? $font['google'] : '';
		$google_fonts[$type.'Toggle'] = !empty($font['face']) && $font['face'] == 'google' ? 'true' : 'false';
	}
	?>
	// Font stacks
	fontStacks = <?php echo json_encode($font_stacks); ?>;

	// Google font toggles
	googleFonts = <?php echo json_encode($google_fonts); ?>;
	<?php
}

/**
 * Body Font Customizer Preview is a Core Option
 *
 * @since 1.0.0
 */
function anva_customizer_preview_primary_font() {

	// Global option name
	$option_name = anva_get_option_name();

	// Begin output
	?>
	// ---------------------------------------------------------
	// Body Typography
	// ---------------------------------------------------------

	/* Body Typography - Size */
	wp.customize('<?php echo $option_name; ?>[typography_body][size]',function( value ) {
		value.bind(function(size) {
			// We're doing this odd-ball way so jQuery
			// doesn't apply body font to other elements.
			$('.preview_body_font_size').remove();
			$('head').append('<style class="preview_body_font_size">body{ font-size: '+size+'; }</style>');
		});
	});

	/* Body Typography - Style */
	wp.customize('<?php echo $option_name; ?>[typography_body][style]',function( value ) {
		value.bind(function(style) {

			// We're doing this odd-ball way so jQuery
			// doesn't apply body font to other elements.
			$('.preview_body_font_style').remove();

			// Possible choices: normal, bold, italic, bold-italic
			var body_css_props;
			if ( style == 'normal' )
				body_css_props = 'font-weight: normal; font-style: normal;';
			else if ( style == 'bold' )
				body_css_props = 'font-weight: bold; font-style: normal;';
			else if ( style == 'italic' )
				body_css_props = 'font-weight: normal; font-style: italic;';
			else if ( style == 'bold-italic' )
				body_css_props = 'font-weight: bold; font-style: italic;';

			$('head').append('<style class="preview_body_font_style">body{'+body_css_props+'}</style>');

		});
	});

	/* Body Typography - Face */
	wp.customize('<?php echo $option_name; ?>[typography_body][face]',function( value ) {
		value.bind(function(face) {
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
	wp.customize('<?php echo $option_name; ?>[typography_body][google]',function( value ) {
		value.bind(function(google_font) {
			// Only proceed if user has actually selected for
			// a google font to show in previous option.
			if (googleFonts.bodyToggle)
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
				$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_body_font" />');

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
 * Headings Font Customizer Preview is a Core Option
 *
 * @since 1.0.0
 */
function anva_customizer_preview_header_font() {

	// Global option name
	$option_name = anva_get_option_name();

	// Begin Output
	?>
	// ---------------------------------------------------------
	// Header Typography
	// ---------------------------------------------------------

	/* Header Typography - Style */
	wp.customize('<?php echo $option_name; ?>[typography_header][style]',function( value ) {
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
	wp.customize('<?php echo $option_name; ?>[typography_header][face]',function( value ) {
		value.bind(function(face) {
			if ( face == 'google' ) {
				googleFonts.headerToggle = true;
				var google_font = googleFonts.headerName.split(":"),
					google_font = google_font[0];
				$('h1, h2, h3, h4, h5, h6').css('font-family', google_font);
			}
			else
			{
				googleFonts.headerToggle = false;
				$('h1, h2, h3, h4, h5, h6').css('font-family', fontStacks[face]);
			}
		});
	});

	/* Header Typography - Google */
	wp.customize('<?php echo $option_name; ?>[typography_header][google]',function( value ) {
		value.bind(function(google_font) {
			// Only proceed if user has actually selected for
			// a google font to show in previous option.
			if (googleFonts.headerToggle)
			{
				// Set global google font for reference in
				// other options.
				googleFonts.headerName = google_font;

				// Remove previous google font to avoid clutter.
				$('.preview_google_header_font').remove();

				// Format font name for inclusion
				var include_google_font = google_font.replace(/ /g,'+');

				// Include font
				$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_header_font" />');

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
 * Allow "refresh" transport type settings to work right in the Customizer
 *
 * @since 1.0.0
 */
function anva_customizer_preview() {

	global $wp_customize;

	// Check if customizer is running.
	if ( ! is_a( $wp_customize, 'WP_Customize_Manager' ) ) {
		return;
	}

	// Reset settings after Customizer
	// has applied filters.
	if ( $wp_customize->is_preview() ) {
		$api = Anva_Options_API::instance();
		// $api->set_settings();
	}

}