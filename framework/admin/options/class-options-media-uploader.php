<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

class Options_Framework_Media_Uploader {

	/**
	 * Initialize the media uploader class
	 *
	 * @since 1.7.0
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'optionsframework_media_scripts' ) );
	}

	/**
	 * Media Uploader Using the WordPress Media Library.
	 *
	 * Parameters:
	 *
	 * string $_id - A token to identify this field (the name).
	 * string $_value - The value of the field, if present.
	 * string $_desc - An optional description of the field.
	 *
	 */

	static function optionsframework_uploader( $_id, $_value, $_desc = '', $_name = '' ) {

		// Gets the unique option id
		$option_name = anva_get_option_name();

		$output = '';
		$id = '';
		$class = '';
		$int = '';
		$value = '';
		$name = '';

		$id = strip_tags( strtolower( $_id ) );

		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if ( $_value != '' && $value == '' ) {
			$value = $_value;
		}

		if ($_name != '') {
			$name = $_name;
		}
		else {
			$name = $option_name . '[' . $id . ']';
		}

		if ( $value ) {
			$class = ' has-file';
		}
		$output .= '<div class="group-button">';
		$output .= '<input id="' . esc_attr( $id ) . '" class="upload' . esc_attr( $class ) . '" type="text" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . __( 'No file chosen', 'anva' ) .'" />' . "\n";
		
		if ( function_exists( 'wp_enqueue_media' ) ) {
			if ( ( $value == '' ) ) {
				$output .= '<span>';
				$output .= '<input id="upload-' . esc_attr( $id ) . '" class="upload-button button" type="button" value="' . __( 'Browse', 'anva' ) . '" />' . "\n";
				$output .= '</span>';
			} else {
				$output .= '<span>';
				$output .= '<input id="remove-' . esc_attr( $id ) . '" class="remove-file button" type="button" value="' . __( 'Remove', 'anva' ) . '" />' . "\n";
				$output .= '</span>';
			}
		} else {
			$output .= '<p class="anva-disclaimer"><i>' . __( 'Upgrade your version of WordPress for full media support.', 'anva' ) . '</i></p>';
		}

		$output .= '</div>';

		if ( $_desc != '' ) {
			$output .= '<span class="anva-metabox-desc">' . esc_html( $_desc ) . '</span>' . "\n";
		}

		$output .= '<div class="screenshot" id="' . esc_attr( $id ) . '-image">' . "\n";

		if ( $value != '' ) {
			$remove = '<a class="remove-image">X</a>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if ( $image ) {
				$output .= '<img src="' . $value . '" alt="" />' . $remove;
			} else {
				$parts = explode( "/", $value );
				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				// No output preview if it's not an image.
				$output .= '';

				// Standard generic output if it's not an image.
				$title = __( 'View File', 'anva' );
				$output .= '<div class="no-image"><span class="file_link"><a href="' . esc_url( $value ) . '" target="_blank" rel="external">' . esc_html( $title ) . '</a></span></div>';
			}
		}
		$output .= '</div>' . "\n";
		return $output;
	}

	/**
	 * Enqueue scripts for file uploader
	 */
	function optionsframework_media_scripts( $hook ) {

		$menu = Options_Framework_Admin::menu_settings();

		if ( substr( $hook, -strlen( $menu['menu_slug'] ) ) !== $menu['menu_slug'] )
			return;

		if ( function_exists( 'wp_enqueue_media' ) )
			wp_enqueue_media();

		wp_register_script( 'anva-media-uploader', anva_get_core_uri() . '/assets/js/admin/media-uploader.js', array( 'jquery' ), ANVA_FRAMEWORK_VERSION );
		wp_enqueue_script( 'anva-media-uploader' );
		wp_localize_script( 'anva-media-uploader', 'optionsframework_l10n', array(
			'upload' => __( 'Browse', 'anva' ),
			'remove' => __( 'Remove', 'anva' )
		) );
	}
}

/**
 * Media Uploader Using the WordPress Media Library in 3.5+
 */
function anva_media_uploader( $args ) {

	$defaults = array(
		'option_name' 	=> '',			// Prefix for form name attributes
		'type'			=> 'standard',	// Type of media uploader - standard, logo, logo_2x, background, slider, video
		'id'			=> '', 						// A token to identify this field, extending onto option_name. -- option_name[id]
		'value'			=> '',					// The value of the field, if present.
		'value_id'		=> '',				// Attachment ID used in slider
		'value_title'	=> '',				// Title of attachment image (used for slider)
		'name'			=> ''						// Option to extend 'id' token -- option_name[id][name]
	);

	$args = wp_parse_args( $args, $defaults );

	$output = '';
	$id = '';
	$class = '';
	$int = '';
	$value = '';
	$name = '';

	$id = strip_tags( strtolower( $args['id'] ) );
	$type = $args['type'];

	// If a value is passed and we don't have a stored value, use the value that's passed through.
	$value = '';
	if ( $args['value'] ) {
		$value = $args['value'];
	}

	// Set name formfield based on type.
	if ( $type == 'slider' ) {
		$name = $args['option_name'].'[image]';
	} else {
		$name = $args['option_name'].'['.$id.']';
	}

	// If passed name, set it.
	if ( $args['name'] ) {
		$name = $name.'['.$args['name'].']';
		$id = $id.'_'.$args['name'];
	}

	if ( $value ) {
		$class = ' has-file';
	}

	// Allow multiple upload options on the same page with
	// same ID -- This could happen in the Layout Builder, for example.
	$formfield = uniqid( $id.'_' );

	// Data passed to wp.media
	$data = array(
		'title' 	=> __( 'Select Media', 'anva' ),
		'select'	=> __( 'Select', 'anva' ),
		'upload'	=> __( 'Browse', 'anva' ),
		'remove'	=> __( 'Remove', 'anva' ),
		'class'		=> 'modal-hide-settings'
	);

	$output .= '<div class="group-button">';

	// Start output
	switch ( $type ) {

		case 'logo' :
			$data['title'] = __('Logo Image', 'anva');
			$data['select'] = __('Use for Logo', 'anva');
			$width_name = str_replace( '[image]', '[image_width]', $name );
			$output .= '<input id="'.$formfield.'" class="image-url upload'.$class.'" type="text" name="'.$name.'" value="'.$value.'" placeholder="'.__('Image URL', 'anva').'" />'."\n";
			break;

		case 'logo_2x' :
			$data['title'] = __('Logo HiDPI Image', 'anva');
			$data['select'] = __('Use for Logo', 'anva');
			$output .= '<input id="'.$formfield.'" class="image-url upload'.$class.'" type="text" name="'.$name.'" value="'.$value.'" placeholder="'.__('URL for image twice the size of standard image', 'anva') .'" />'."\n";
			break;

		case 'background' :
			$data['title'] = __('Select Background Image', 'anva');
			$output .= '<input id="'.$formfield.'" class="image-url upload'.$class.'" type="text" name="'.$name.'" value="'.$value.'" placeholder="'.__('Image URL', 'anva') .'" />'."\n";
			break;

		default :
			$output .= '<input id="'.$formfield.'" class="image-url upload'.$class.'" type="text" name="'.$name.'" value="'.$value.'" placeholder="'.__('No file chosen', 'anva') .'" />'."\n";
	}

	$data = apply_filters( 'anva_media_uploader_data', $data, $type );

	$output .= '<span>';
	$output .= '<input id="remove-'.$formfield.'" class="trigger remove-file button" type="button" data-type="'.$type.'" data-title="'.$data['title'].'" data-select="'.$data['select'].'" data-class="'.$data['class'].'" data-upload="'.$data['upload'].'" data-remove="'.$data['remove'].'" value="'.$data['remove'].'" />'."\n";
	$output .= '</span>';
	$output .= '</div>';

	$output .= '<div class="screenshot" id="' . $formfield . '-image">' . "\n";

	if ( $value && $type != 'video' ) {
		$remove = '<a class="remove-image">X</a>';
		$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );

		if ( $image ) {
			$output .= '<img src="' . $value . '" alt="" />' . $remove;
		} else {
			$parts = explode( "/", $value );
			for( $i = 0; $i < sizeof( $parts ); ++$i )
				$title = $parts[$i];

			// Standard generic output if it's not an image.
			$title = __( 'View File', 'anva' );
			$output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span></div>';
		}
	}
	$output .= '</div>' . "\n";
	return $output;
}