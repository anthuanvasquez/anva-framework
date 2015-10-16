<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

add_filter( 'anva_sanitize_text', 'sanitize_text_field' );
add_filter( 'anva_sanitize_number', 'anva_sanitize_number' );
add_filter( 'anva_sanitize_password', 'sanitize_text_field' );
add_filter( 'anva_sanitize_range', 'sanitize_text_field' );
add_filter( 'anva_sanitize_date', 'sanitize_text_field' );
add_filter( 'anva_sanitize_select', 'anva_sanitize_enum', 10, 2 );
add_filter( 'anva_sanitize_radio', 'anva_sanitize_enum', 10, 2 );
add_filter( 'anva_sanitize_images', 'anva_sanitize_enum', 10, 2 );
add_filter( 'anva_sanitize_textarea', 'anva_sanitize_textarea' );
add_filter( 'anva_sanitize_checkbox', 'anva_sanitize_checkbox' );
add_filter( 'anva_sanitize_multicheck', 'anva_sanitize_multicheck', 10, 2 );
add_filter( 'anva_sanitize_upload', 'anva_sanitize_upload' );
add_filter( 'anva_sanitize_editor', 'anva_sanitize_editor' );
add_filter( 'anva_sanitize_background', 'anva_sanitize_background' );
add_filter( 'anva_background_position', 'anva_sanitize_background_position' );
add_filter( 'anva_background_attachment', 'anva_sanitize_background_attachment' );
add_filter( 'anva_font_size', 'anva_sanitize_font_size' );
add_filter( 'anva_sanitize_typography', 'anva_sanitize_typography', 10, 2 );
add_filter( 'anva_font_style', 'anva_sanitize_font_style' );
add_filter( 'anva_font_face', 'anva_sanitize_font_face' );
add_filter( 'anva_sanitize_color', 'anva_sanitize_hex' );
add_filter( 'anva_sanitize_social_media', 'anva_sanitize_social_media' );
add_filter( 'anva_sanitize_logo', 'anva_sanitize_logo' );
add_filter( 'anva_sanitize_columns', 'anva_sanitize_columns' );
add_filter( 'anva_sanitize_sidebar', 'anva_sanitize_sidebar' );
add_filter( 'anva_sanitize_layout', 'anva_sanitize_layout' );

/**
 * Sanitization for textarea field
 *
 * @param $input string
 * @return $output sanitized string
 */
function anva_sanitize_textarea( $input ) {
	global $allowedposttags;
	$output = wp_kses( $input, $allowedposttags );
	return $output;
}

/**
 * Sanitization for checkbox input
 *
 * @param $input string (1 or empty) checkbox state
 * @return $output '1' or false
 */
function anva_sanitize_checkbox( $input ) {
	if ( $input ) {
		$output = '1';
	} else {
		$output = false;
	}
	return $output;
}

/**
 * Sanitization for multicheck
 *
 * @param array of checkbox values
 * @return array of sanitized values ('1' or false)
 */
function anva_sanitize_multicheck( $input, $option ) {
	$output = '';
	if ( is_array( $input ) ) {
		foreach( $option['options'] as $key => $value ) {
			$output[$key] = false;
		}
		foreach( $input as $key => $value ) {
			if ( array_key_exists( $key, $option['options'] ) && $value ) {
				$output[$key] = '1';
			}
		}
	}
	return $output;
}

/**
 * File upload sanitization.
 *
 * Returns a sanitized filepath if it has a valid extension.
 *
 * @param string $input filepath
 * @returns string $output filepath
 */
function anva_sanitize_upload( $input ) {
	$output = '';
	$filetype = wp_check_filetype( $input );
	if ( $filetype["ext"] ) {
		$output = esc_url( $input );
	}
	return $output;
}

/**
 * Sanitization for editor input.
 *
 * Returns unfiltered HTML if user has permissions.
 *
 * @param string $input
 * @returns string $output
 */
function anva_sanitize_editor( $input ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedposttags;
		$output = wpautop( wp_kses( $input, $allowedposttags ) );
	}
	return $output;
}

/**
 * Sanitization of input with allowed tags and wpautotop.
 *
 * Allows allowed tags in html input and ensures tags close properly.
 *
 * @param string $input
 * @returns string $output
 */
function anva_sanitize_allowedtags( $input ) {
	global $allowedtags;
	$output = wpautop( wp_kses( $input, $allowedtags ) );
	return $output;
}

/**
 * Sanitization of input with allowed post tags and wpautotop.
 *
 * Allows allowed post tags in html input and ensures tags close properly.
 *
 * @param string $input
 * @returns string $output
 */
function anva_sanitize_allowedposttags( $input ) {
	global $allowedposttags;
	$output = wpautop( wp_kses( $input, $allowedposttags) );
	return $output;
}

/**
 * Validates that the $input is one of the avilable choices
 * for that specific option.
 *
 * @param string $input
 * @returns string $output
 */
function anva_sanitize_enum( $input, $option ) {
	$output = '';
	if ( array_key_exists( $input, $option['options'] ) ) {
		$output = $input;
	}
	return $output;
}

/**
 * Validates that the $input is a integer number
 *
 * @param string $input
 * @returns string $output
 */
function anva_sanitize_number( $input ) {
	$output = 0;
	if ( 0 != absint( $input ) ) {
		$output = $input;
	}
	return $output;
}

/**
 * Sanitization for background option.
 *
 * @returns array $output
 */
function anva_sanitize_background( $input ) {

	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );

	if ( isset( $input['color'] ) ) {
		$output['color'] = apply_filters( 'anva_sanitize_hex', $input['color'] );
	}
	
	$output['image'] = apply_filters( 'anva_sanitize_upload', $input['image'] );
	$output['repeat'] = apply_filters( 'anva_background_repeat', $input['repeat'] );
	$output['position'] = apply_filters( 'anva_background_position', $input['position'] );
	$output['attachment'] = apply_filters( 'anva_background_attachment', $input['attachment'] );

	return $output;
}

/**
 * Sanitization for background repeat
 *
 * @returns string $value if it is valid
 */
function anva_sanitize_background_repeat( $value ) {
	$recognized = anva_recognized_background_repeat();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'anva_default_background_repeat', current( $recognized ) );
}
add_filter( 'anva_background_repeat', 'anva_sanitize_background_repeat' );

/**
 * Sanitization for background position
 *
 * @returns string $value if it is valid
 */
function anva_sanitize_background_position( $value ) {
	$recognized = anva_recognized_background_position();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'anva_default_background_position', current( $recognized ) );
}

/**
 * Sanitization for background attachment
 *
 * @returns string $value if it is valid
 */
function anva_sanitize_background_attachment( $value ) {
	$recognized = anva_recognized_background_attachment();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'anva_default_background_attachment', current( $recognized ) );
}

/**
 * Sanitization for typography option.
 */
function anva_sanitize_typography( $input, $option ) {

	$output = wp_parse_args( $input, array(
		'size'  => '',
		'face'  => '',
		'style' => '',
		'color' => ''
	) );

	if ( isset( $option['options']['faces'] ) && isset( $input['face'] ) ) {
		if ( !( array_key_exists( $input['face'], $option['options']['faces'] ) ) ) {
			$output['face'] = '';
		}
	}
	else {
		$output['face']  = apply_filters( 'anva_font_face', $output['face'] );
	}

	$output['size']  = apply_filters( 'anva_font_size', $output['size'] );
	$output['style'] = apply_filters( 'anva_font_style', $output['style'] );
	$output['color'] = apply_filters( 'anva_sanitize_color', $output['color'] );
	return $output;
}

/**
 * Sanitization for font size
 */
function anva_sanitize_font_size( $value ) {
	$recognized = anva_recognized_font_sizes();
	$value_check = preg_replace('/px/','', $value);
	if ( in_array( (int) $value_check, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'anva_default_font_size', $recognized );
}

/**
 * Sanitization for font style
 */
function anva_sanitize_font_style( $value ) {
	$recognized = anva_recognized_font_styles();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'anva_default_font_style', current( $recognized ) );
}

/**
 * Sanitization for font face
 */
function anva_sanitize_font_face( $value ) {
	$recognized = anva_recognized_font_faces();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'anva_default_font_face', current( $recognized ) );
}

/**
 * Get recognized background repeat settings
 *
 * @return   array
 */
function anva_recognized_background_repeat() {
	$default = array(
		'no-repeat' => __( 'No Repeat', 'anva' ),
		'repeat-x'  => __( 'Repeat Horizontally', 'anva' ),
		'repeat-y'  => __( 'Repeat Vertically', 'anva' ),
		'repeat'    => __( 'Repeat All', 'anva' ),
	);
	return apply_filters( 'anva_recognized_background_repeat', $default );
}

/**
 * Get recognized background positions
 *
 * @return   array
 */
function anva_recognized_background_position() {
	$default = array(
		'top left'      => __( 'Top Left', 'anva' ),
		'top center'    => __( 'Top Center', 'anva' ),
		'top right'     => __( 'Top Right', 'anva' ),
		'center left'   => __( 'Middle Left', 'anva' ),
		'center center' => __( 'Middle Center', 'anva' ),
		'center right'  => __( 'Middle Right', 'anva' ),
		'bottom left'   => __( 'Bottom Left', 'anva' ),
		'bottom center' => __( 'Bottom Center', 'anva' ),
		'bottom right'  => __( 'Bottom Right', 'anva')
	);
	return apply_filters( 'anva_recognized_background_position', $default );
}

/**
 * Get recognized background attachment
 *
 * @return   array
 */
function anva_recognized_background_attachment() {
	$default = array(
		'scroll' => __( 'Scroll Normally', 'anva' ),
		'fixed'  => __( 'Fixed in Place', 'anva')
	);
	return apply_filters( 'anva_recognized_background_attachment', $default );
}

/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param    string    The value that this function should return if it cannot be recognized as a color.
 * @return   string
 */

function anva_sanitize_hex( $hex, $default = '' ) {
	if ( anva_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 * Get recognized font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return   array
 */

function anva_recognized_font_sizes() {
	$sizes = range( 9, 71 );
	$sizes = apply_filters( 'anva_recognized_font_sizes', $sizes );
	$sizes = array_map( 'absint', $sizes );
	return $sizes;
}

/**
 * Get recognized font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 */
function anva_recognized_font_faces() {
	$default = anva_get_font_stacks();
	return apply_filters( 'anva_recognized_font_faces', $default );
}

/**
 * Get recognized font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 */
function anva_recognized_font_styles() {
	$default = array(
		'normal'      => __( 'Normal', 'anva' ),
		'italic'      => __( 'Italic', 'anva' ),
		'bold'        => __( 'Bold', 'anva' ),
		'bold-italic' => __( 'Bold Italic', 'anva' )
	);
	return apply_filters( 'anva_recognized_font_styles', $default );
}

/**
 * Is a given string a color formatted in hexidecimal notation?
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return   bool
 */
function anva_validate_hex( $hex ) {
	$hex = trim( $hex );
	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	}
	elseif ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	}
	else {
		return true;
	}
}

/**
 * Social Media Buttons
 */
function anva_sanitize_social_media( $input ) {
	if ( ! empty( $input ) && ! empty( $input['profiles'] ) ) {
		// The option is being sent from the actual
		// Theme Options page and so it hasn't been
		// formatted yet.
		$output = array();
		if ( ! empty( $input['includes'] ) ) {
			foreach ( $input['includes'] as $include ) {
				if ( isset( $input['profiles'][$include] ) ) {
					$output[$include] = $input['profiles'][$include];
				}
			}
		}
	} else {
		// The option has already been formatted,
		// so let it on through.
		$output = $input;
	}
	return $output;
}

function anva_sanitize_layout( $input ) {

	$output = array();

	// Layout
	if ( is_array( $input ) && isset( $input['layout'] ) ) {
		$output['layout'] = $input['layout'];
	}

	// Right
	if ( isset( $input['right'] ) ) {
		$output['right'] = $input['right'];
	}

	// Left
	if ( isset( $input['left'] ) ) {
		$output['left'] = $input['left'];
	}

	return $output;
}

/**
 * Logo
 */
function anva_sanitize_logo( $input ) {

	$output = array();

	// Type
	if ( is_array( $input ) && isset( $input['type'] ) ) {
		$output['type'] = $input['type'];
	}

	// Custom
	if ( isset( $input['custom'] ) ) {
		$output['custom'] = sanitize_text_field( $input['custom'] );
	}

	if ( isset( $input['custom_tagline'] ) ) {
		$output['custom_tagline'] = sanitize_text_field( $input['custom_tagline'] );
	}

	// Image (standard)
	if ( isset( $input['image'] ) ) {
		$filetype = wp_check_filetype( $input['image'] );
		if ( $filetype["ext"] ) {
			$output['image'] = $input['image'];
		} else {
			$output['image'] = null;
		}
	}

	// Image (for retina)
	if ( isset( $input['image_2x'] ) ) {
		$filetype = wp_check_filetype( $input['image_2x'] );
		if ( $filetype["ext"] ) {
			$output['image_2x'] = $input['image_2x'];
		} else {
			$output['image_2x'] = null;
		}
	}

	return $output;
}

function anva_sanitize_sidebar( $input ) {
	
	$output = array();
	
	if ( ! is_array( $input ) ) {
		return;	
	}
	
	foreach ( $input as $sidebar ) {
		$title = sanitize_text_field( $sidebar );
		$output[] = esc_html( $title );
	}
	
	return $output;
}

/**
 * Columns
 */
function anva_sanitize_columns( $input ) {

	$width_options = anva_column_widths();
	$output = array();

	// Verify number of columns is an integer
	if ( is_numeric( $input['num'] ) ) {
		$output['num'] = $input['num'];
	} else {
		$output['num'] = null;
	}

	// Verify widths
	foreach ( $input['width'] as $key => $width ) {

		$valid = false;

		foreach ( $width_options[$key.'-col'] as $width_option ) {
			if ( $width == $width_option['value'] ) {
				$valid = true;
			}
		}

		if ( $valid ) {
			$output['width'][$key] = $width;
		} else {
			$output['width'][$key] = null;
		}
	}

	return $output;
}