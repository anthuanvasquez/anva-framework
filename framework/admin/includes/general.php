<?php

/**
 * Remove trailing char.
 *
 * @return string
 */
function of_remove_trailing_char( $string, $char = ' ' ) {

	if ( ! $string ) {
		return null;
	}

	$offset = strlen( $string ) - 1;

	$trailing_char = strpos( $string, $char, $offset );
	if ( $trailing_char ) {
		$string = substr( $string, 0, -1 );
	}

	return $string;
}

/**
 * Get font stacks.
 *
 * @return array
 */
function of_get_font_stacks() {
	$stacks = array(
		'default'			=> 'Arial, sans-serif', // Used to chain onto end of google font
		'arial'     	=> 'Arial, "Helvetica Neue", Helvetica, sans-serif',
		'baskerville'	=> 'Baskerville, "Baskerville Old Face", "Hoefler Text", Garamond, "Times New Roman", serif',
		'georgia'   	=> 'Georgia, Times, "Times New Roman", serif',
		'helvetica' 	=> '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'lucida'  		=> '"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif',
		'palatino'  	=> 'Palatino, "Palatino Linotype", "Palatino LT STD", "Book Antiqua", Georgia, serif',
		'tahoma'    	=> 'Tahoma, Verdana, Segoe, sans-serif',
		'times'     	=> 'TimesNewRoman, "Times New Roman", Times, Baskerville, Georgia, serif',
		'trebuchet' 	=> '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif',
		'verdana'   	=> 'Verdana, Geneva, sans-serif',
		'google'			=> 'Google Font'
	);
	return apply_filters( 'of_get_font_stacks', $stacks );
}

/**
 * Get font face.
 *
 * @return font face name
 */
function of_get_font_face( $option ) {

	$stack = '';
	$stacks = of_get_font_stacks();

	if ( isset( $option['face'] ) && $option['face'] == 'google'  ) {

		// Grab font face, making sure they didn't do the
		// super, sneaky trick of including font weight or type.
		$name = explode( ':', $option['google'] );

		// Check for accidental space at end
		$name = of_remove_trailing_char( $name[0] );

		// Add the deafult font stack to the end of the google font.
		$stack = $name .', ' . $stacks['default'];

	} else {
		$stack = $stacks[$option['face']];
	}

	return apply_filters( 'of_get_font_face', $stack, $option, $stacks );
}

/**
 * Get font size and set the default value.
 *
 * @return string
 */
function of_get_font_size( $option ) {

	$size = '13px'; // defuault font size

	if ( isset( $option['size'] ) ) {
		$size = $option['size'];
	}

	return apply_filters( 'of_get_font_size', $size, $option );
}

/**
 * Get font style and set the default value.
 *
 * @return string font style
 */
function of_get_font_style( $option ) {

	$style = 'normal';

	if ( isset( $option['style'] ) && ( $option['style'] == 'italic' || $option['style'] == 'bold-italic' ) ) {
		$style = 'italic';
	}

	return apply_filters( 'of_get_font_style', $style, $option );
}

/**
 * Get font weight and set the default value.
 *
 * @return string font weight
 */
function of_get_font_weight( $option ) {

	$weight = 'normal';

	if ( isset( $option['style'] ) && ( $option['style'] == 'bold' || $option['style'] == 'bold-italic' ) ) {
		$weight = 'bold';
	}

	return apply_filters( 'of_get_font_weight', $weight, $option );
}

/**
 * Get background patterns.
 *
 * @return image url
 */
function of_get_background_pattern( $option ) {
	$output = esc_url( get_template_directory_uri() . '/assets/images/patterns/' . $option . '.png' );
	return $output;
}

/**
 * Include font from google. Accepts unlimited
 * amount of font arguments.
 *
 * @return stylesheet link
 */
function of_enqueue_google_fonts() {

	$fonts = func_get_args();
	$used = array();

	if ( ! empty( $fonts ) ) {

		// Before including files, determine if SSL is being
		// on a secure server, they'll get an error.
		$protocol = is_ssl() ? 'https://' : 'http://';

		// Include each font file from google.
		foreach ( $fonts as $font ) {
			if ( isset( $font['face'] ) && $font['face'] == 'google' && $font['google'] ) {

				if ( in_array( $font['google'], $used ) ) {
					// Skip duplicate
					continue;
				}

				$used[] = $font['google'];
				$name = of_remove_trailing_char( $font['google'] );
				$name = str_replace( ' ', '+', $name );

				$handle = strtolower( $name );
				$handle = str_replace( '+', '-', $handle );

				wp_enqueue_style( $handle, $protocol .'fonts.googleapis.com/css?family='.$name, array(), false, 'all' );
			}
		}
	}
}

/**
 * Get social media sources and their respective names.
 *
 * @return array $profiles
 */
function of_get_social_media_profiles() {
	$profiles = array(
		'digg' 				=> 'Digg',
		'dribbble' 		=> 'Dribbble',
		'facebook' 		=> 'Facebook',
		'flickr' 			=> 'Flickr',
		'github' 			=> 'Github',
		'google' 			=> 'Google+',
		'instagram' 	=> 'Instagram',
		'linkedin' 		=> 'Linkedin',
		'pinterest' 	=> 'Pinterest',
		'tumblr' 			=> 'Tumblr',
		'twitter' 		=> 'Twitter',
		'vimeo' 			=> 'Vimeo',
		'youtube' 		=> 'YouTube',
		'rss' 				=> 'RSS'
	);

	// Backwards compat filter
	$profiles = apply_filters( 'of_get_social_media_profiles', $profiles );
	return $profiles;
}

/**
 * Generates option to edit social media buttons.
 *
 * This has been moved to a separate function
 * because it's a custom addition to the optionframework
 * module and it's pretty lengthy.
 */
function of_social_media_fields( $id, $name, $val ) {

	$profiles = of_get_social_media_profiles();

	$counter = 1;
	$divider = round( count( $profiles ) / 2 );

	$output = '<div class="social-media column-1">';

	foreach ( $profiles as $key => $profile ) {

		// Setup
		$checked = false;
		if ( is_array( $val ) && array_key_exists( $key, $val ) ) {
			$checked = true;
		}

		if ( ! empty( $val ) && ! empty( $val[$key] ) ) {
			$value = $val[$key];
		} else {

			$value = '#';
			if ( $key == 'email' ) {
				$value = 'mailto:';
			}
		}

		// Add to output
		$output .= '<div class="social-media-item">';
		$output .= '<span>'. $profile .'</span>';
		$output .= sprintf( '<input class="of-input social_media-input" value="%s" type="text" name="%s" />', esc_attr( $value ), esc_attr( $name.'['.$id.'][profiles]['.$key.']' ) );
		$output .= '</div><!-- .social-media-item (end) -->';

		if ( $counter == $divider ) {
			// Separate options into two columns
			$output .= '</div><!-- .column-1 (end) -->';
			$output .= '<div class="social-media column-2">';
		}

		$counter++;
	}
	$output .= '</div><!-- .column-2 (end) -->';

	return $output;
}