<?php
/*-----------------------------------------------------------------------------------*/
/* Admin General Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Remove trailing char
 *
 * @since  1.0.0
 * @return string
 */
function anva_remove_trailing_char( $string, $char = ' ' ) {

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
 * Get font stacks
 * 
 * @since  1.0.0
 * @return array
 */
function anva_get_font_stacks() {
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
	return apply_filters( 'anva_font_stacks', $stacks );
}

/**
 * Get font face
 *
 * @since  1.0.0
 * @return font face name
 */
function anva_get_font_face( $option ) {

	$stack = '';
	$stacks = anva_get_font_stacks();
	$face = 'helvetica'; // Default font face

	if ( isset( $option['face'] ) && $option['face'] == 'google'  ) {

		// Grab font face, making sure they didn't do the
		// super, sneaky trick of including font weight or type.
		$name = explode( ':', $option['google'] );

		// Check for accidental space at end
		$name = anva_remove_trailing_char( $name[0] );

		// Add the deafult font stack to the end of the google font.
		$stack = $name .', ' . $stacks['default'];

	} elseif ( isset( $option['face'] ) && isset( $stacks[$option['face']] ) ) {
		$stack = $stacks[$option['face']];
	
	} else {
		$stack = $stacks[$face];
	}

	return apply_filters( 'anva_font_face', $stack, $option, $stacks );
}

/**
 * Get font size and set the default value
 *
 * @since  1.0.0
 * @return string
 */
function anva_get_font_size( $option ) {

	$size = '14px'; // Default font size

	if ( isset( $option['size'] ) ) {
		$size = $option['size'];
	}

	return apply_filters( 'anva_font_size', $size, $option );
}

/**
 * Get font style and set the default value.
 *
 * @since  1.0.0
 * @return string font style
 */
function anva_get_font_style( $option ) {

	$style = 'normal'; // Default font style

	if ( isset( $option['style'] ) && ( $option['style'] == 'italic' || $option['style'] == 'bold-italic' ) ) {
		$style = 'italic';
	}

	return apply_filters( 'anva_get_font_style', $style, $option );
}

/**
 * Get font weight and set the default value.
 *
 * @since  1.0.0
 * @return string font weight
 */
function anva_get_font_weight( $option ) {

	$weight = 'normal';

	if ( isset( $option['style'] ) && ( $option['style'] == 'bold' || $option['style'] == 'bold-italic' ) ) {
		$weight = 'bold';
	}

	return apply_filters( 'anva_get_font_weight', $weight, $option );
}

/**
 * Get background patterns
 *
 * @since  1.0.0
 * @return image url
 */
function anva_get_background_pattern( $option ) {
	$output = esc_url( get_template_directory_uri() . '/assets/images/patterns/' . $option . '.png' );
	return $output;
}

/**
 * Include font from google. Accepts unlimited
 * amount of font arguments.
 *
 * @since  1.0.0
 * @return stylesheet link
 */
function anva_enqueue_google_fonts() {

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
				$name = anva_remove_trailing_char( $font['google'] );
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
 * @since  1.0.0
 * @return array $profiles
 */
function anva_get_social_media_profiles() {
	$profiles = array(
		'bitbucket'		=> 'Bitbucket',
		'codepen'			=> 'Codepen',
		'delicious' 	=> 'Delicious',
		'deviantart' 	=> 'DeviantArt',
		'digg' 				=> 'Digg',
		'dribbble' 		=> 'Dribbble',
		'email' 			=> 'Email',
		'facebook' 		=> 'Facebook',
		'flickr' 			=> 'Flickr',
		'foursquare' 	=> 'Foursquare',
		'github' 			=> 'Github',
		'google-plus' => 'Google+',
		'instagram' 	=> 'Instagram',
		'linkedin' 		=> 'Linkedin',
		'paypal' 			=> 'Paypal',
		'pinterest' 	=> 'Pinterest',
		'reddit' 			=> 'Reddit',
		'skype'				=> 'Skype',
		'soundcloud' 	=> 'Soundcloud',
		'tumblr' 			=> 'Tumblr',
		'twitter' 		=> 'Twitter',
		'vimeo-square'=> 'Vimeo',
		'yahoo' 			=> 'Yahoo',
		'youtube' 		=> 'YouTube',
		'whatsapp'		=> 'Whatsapp',
		'rss' 				=> 'RSS',
	);

	// Backwards compat filter
	$profiles = apply_filters( 'anva_get_social_media_profiles', $profiles );
	return $profiles;
}
