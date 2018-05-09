<?php

/**
 * Social icons UI.
 *
 * @since 1.0.0
 */
class Anva_Options_UI_Type_Social {

	/**
	 * Generates option to edit social media buttons.
	 *
	 * @since  1.0.0
	 */
	public static function option( $id, $name, $val ) {

		$profiles = anva_get_social_icons_profiles();
		$counter  = 1;
		$divider  = round( count( $profiles ) / 2 );
		$output   = '<div class="column-1">';

		foreach ( $profiles as $key => $profile ) {

			$checked = false;
			if ( is_array( $val ) && array_key_exists( $key, $val ) ) {
				$checked = true;
			}

			if ( ! empty( $val ) && ! empty( $val[ $key ] ) ) {
				$value = $val[ $key ];
			} else {

				// Determine if SSL is being on a secure server.
				$value = is_ssl() ? 'https://' : 'http://';

				if ( 'email3' == $key ) {
					$value = 'mailto:';
				}

				if ( 'skype' == $key ) {
					$value = 'skype:username?call';
				}

				if ( 'call' == $key ) {
					$value = 'tel:';
				}
			}

			$output .= '<div class="item">';
			$output .= '<span>';
			$output .= sprintf( '<input id="%s" class="checkbox anva-input anva-checkbox checkbox-style" value="%s" type="checkbox" %s name="%s" />', 'social-' . $key, $key, checked( $checked, true, false ), esc_attr( $name . '[' . $id . '][includes][]' ) );
			$output .= '<label for="' . 'social-' . $key . '" class="checkbox-style-1-label checkbox-small">' . esc_html( $profile ) . '</label>';
			$output .= '</span>';
			$output .= sprintf( '<input class="anva-input social_media-input" value="%s" type="text" name="%s" />', esc_attr( $value ), esc_attr( $name . '[' . $id . '][profiles][' . $key . ']' ) );
			$output .= '</div>';

			if ( $counter == $divider ) {
				$output .= '</div><!-- .column-1 (end) -->';
				$output .= '<div class="column-2">';
			}

			$counter++;
		}// End foreach().

		$output .= '</div><!-- .column-2 (end) -->';

		return $output;
	}
}

/**
 * Generates option to edit a logo.
 *
 * @since  1.0.0
 * @param  string $id
 * @param  string $name
 * @param  array  $val
 * @return string $output
 */
function anva_logo_option( $id, $name, $val ) {

	/*
	------------------------------------------------------*/
	/*
	 Type of logo
	/*------------------------------------------------------*/

	$types = array(
		'title' 		=> __( 'Site Title', 'anva' ),
		'title_tagline' => __( 'Site Title + Tagline', 'anva' ),
		'custom' 		=> __( 'Custom Text', 'anva' ),
		'image' 		=> __( 'Image', 'anva' ),
	);

	$current_value = '';
	if ( ! empty( $val ) && ! empty( $val['type'] ) ) {
		$current_value = $val['type'];
	}

	$select_type  = '<div class="select-wrapper">';
	$select_type .= '<select class="anva-input anva-select" name="' . esc_attr( $name . '[' . $id . '][type]' ) . '">';

	foreach ( $types as $key => $type ) {
		$select_type .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $current_value, $key, false ), $type );
	}

	$select_type .= '</select>';
	$select_type .= '</div><!-- .anva-select (end) -->';

	/*
	------------------------------------------------------*/
	/*
	 Site Title
	/*------------------------------------------------------*/

	$site_title  = '<p class="note">';
	$site_title .= __( 'Current Site Title', 'anva' ) . ': <strong>';
	$site_title .= get_bloginfo( 'name' ) . '</strong><br>';
	$site_title .= sprintf( __( 'You can change your site title and tagline by going %1$shere%2$s.', 'anva' ), '<a href="' . esc_url( 'options-general.php' ) . '" target="_blank">', '</a>' );
	$site_title .= '</p>';

	/*
	------------------------------------------------------*/
	/*
	 Site Title + Tagline
	/*------------------------------------------------------*/

	$site_title_tagline  = '<p class="note">';
	$site_title_tagline .= __( 'Current Site Title', 'anva' ) . ': <strong>';
	$site_title_tagline .= get_bloginfo( 'name' ) . '</strong><br>';
	$site_title_tagline .= __( 'Current Tagline', 'anva' ) . ': <strong>';
	$site_title_tagline .= get_bloginfo( 'description' ) . '</strong><br>';
	$site_title_tagline .= sprintf( __( 'You can change your site title by going %1$shere%2$s.', 'anva' ), '<a href="' . esc_url( 'options-general.php' ) . '" target="_blank">', '</a>' );
	$site_title_tagline .= '</p>';

	/*
	------------------------------------------------------*/
	/*
	 Custom Text
	/*------------------------------------------------------*/

	$current_value = '';
	if ( ! empty( $val ) && ! empty( $val['custom'] ) ) {
		$current_value = $val['custom'];
	}

	$current_tagline = '';
	if ( ! empty( $val ) && ! empty( $val['custom_tagline'] ) ) {
		$current_tagline = $val['custom_tagline'];
	}

	$custom_text  = sprintf( '<p><label class="inner-label"><strong>%s</strong></label>', __( 'Title', 'anva' ) );
	$custom_text .= sprintf( '<input type="text" name="%s" value="%s" /></p>', esc_attr( $name . '[' . $id . '][custom]' ), esc_attr( $current_value ) );
	$custom_text .= sprintf( '<p><label class="inner-label"><strong>%s</strong> (%s)</label>', __( 'Tagline', 'anva' ), __( 'optional', 'anva' ) );
	$custom_text .= sprintf( '<input type="text" name="%s" value="%s" /></p>', esc_attr( $name . '[' . $id . '][custom_tagline]' ), esc_attr( $current_tagline ) );
	$custom_text .= sprintf( '<p class="note">%s</p>', __( 'Insert your custom text.', 'anva' ) );

	/*
	------------------------------------------------------*/
	/*
	 Image
	/*------------------------------------------------------*/

	$current_value = array(
		'url' => '',
	);
	if ( is_array( $val ) && isset( $val['image'] ) ) {
		$current_value = array(
			'url' => $val['image'],
		);
	}

	$current_retina = array(
		'url' => '',
	);
	if ( is_array( $val ) && isset( $val['image_2x'] ) ) {
		$current_retina = array(
			'url' => $val['image_2x'],
		);
	}

	$current_mini = array(
		'url' => '',
	);
	if ( is_array( $val ) && isset( $val['image_mini'] ) ) {
		$current_mini = array(
			'url' => $val['image_mini'],
		);
	}

	$current_dark = array(
		'url' => '',
	);
	if ( is_array( $val ) && isset( $val['image_dark'] ) ) {
		$current_dark = array(
			'url' => $val['image_dark'],
		);
	}

	// Standard Image
	$image_upload  = '<div class="section image-standard">';
	$image_upload .= '<label class="inner-label"><strong>' . __( 'Standard Image', 'anva' ) . '</strong></label>';
	$image_upload .= anva_media_uploader_option( array(
		'option_name' => $name,
		'type'        => 'logo',
		'id'          => $id,
		'value'       => $current_value['url'],
		'name'        => 'image',
	) );
	$image_upload .= '</div>';

	// Standard Image Retina (2x)
	$image_upload .= '<div class="section image-2x">';
	$image_upload .= '<label class="inner-label"><strong>' . __( '2x Standard Image (optional)', 'anva' ) . '</strong></label>';
	$image_upload .= anva_media_uploader_option( array(
		'option_name' => $name,
		'type'        => 'logo_2x',
		'id'          => $id,
		'value'       => $current_retina['url'],
		'name'        => 'image_2x',
	) );
	$image_upload .= '</div>';

	// Standard Image Mini
	$image_upload .= '<div class="section image-mini">';
	$image_upload .= '<label class="inner-label"><strong>' . __( 'Mini Standard Image (optional)', 'anva' ) . '</strong></label>';
	$image_upload .= anva_media_uploader_option( array(
		'option_name' => $name,
		'type'        => 'logo_mini',
		'id'          => $id,
		'value'       => $current_mini['url'],
		'name'        => 'image_mini',
	) );
	$image_upload .= '</div>';

	/**
	 * More will come.
	 *
	 * @todo Mini Image 2x
	 * @todo Dark Image
	 * @todo Dark Image 2x
	 */

	/*
	------------------------------------------------------*/
	/*
	 Primary Output
	/*------------------------------------------------------*/

	$output  = sprintf( '<div class="select-type">%s</div>', $select_type );
	$output .= sprintf( '<div class="logo-item title">%s</div>', $site_title );
	$output .= sprintf( '<div class="logo-item title_tagline">%s</div>', $site_title_tagline );
	$output .= sprintf( '<div class="logo-item custom">%s</div>', $custom_text );
	$output .= sprintf( '<div class="logo-item image">%s</div>', $image_upload );

	return $output;
}

/**
 * Generates option for configuring columns
 *
 * @since  1.0.0
 */
function anva_columns_option( $id, $name, $val ) {

	/*
	------------------------------------------------------*/
	/*
	 Setup Internal Options
	/*------------------------------------------------------*/

	// Dropdown for number of columns selection
	$data_num = array(
		array(
			'name' 	=> __( 'Hide Columns', 'anva' ),
			'value' => 0,
		),
		array(
			'name' 	=> '1 ' . __( 'Column', 'anva' ),
			'value' => 1,
		),
		array(
			'name' 	=> '2 ' . __( 'Columns', 'anva' ),
			'value' => 2,
		),
		array(
			'name' 	=> '3 ' . __( 'Columns', 'anva' ),
			'value' => 3,
		),
		array(
			'name' 	=> '4 ' . __( 'Columns', 'anva' ),
			'value' => 4,
		),
		array(
			'name' 	=> '5 ' . __( 'Columns', 'anva' ),
			'value' => 5,
		),
	);

	// Dropdowns for column width configuration
	$data_widths = anva_column_widths();

	/*
	------------------------------------------------------*/
	/*
	 Construct <select> Menus
	/*------------------------------------------------------*/

	// Select number of columns
	$select_number  = '<div class="select-wrapper">';
	$select_number .= '<select class="column-num anva-input anva-select" name="' . esc_attr( $name . '[' . $id . '][num]' ) . '">';

	$current_value = '';
	if ( ! empty( $val ) && ! empty( $val['num'] ) ) {
		$current_value = $val['num'];
	}

	foreach ( $data_num as $num ) {
		$select_number .= '<option value="' . $num['value'] . '" ' . selected( $current_value, $num['value'], false ) . '>' . $num['name'] . '</option>';
	}

	$select_number .= '</select>';
	$select_number .= '</div>';

	// Select column widths
	$i = 1;
	$select_widths = '<div class="column-width column-width-0"><p class="inactive">' . __( 'Columns will be hidden.', 'anva' ) . '</p></div>';
	foreach ( $data_widths as $widths ) {

		$select_widths .= '<div class="select-wrapper column-width column-width-' . $i . '">';
		$select_widths .= '<select class="anva-input anva-select" name= "' . esc_attr( $name . '[' . $id . '][width][' . $i . ']' ) . '">';

		$current_value = '';
		if ( ! empty( $val ) && ! empty( $val['width'][ $i ] ) ) {
			$current_value = $val['width'][ $i ];
		}

		foreach ( $widths as $width ) {
			$select_widths .= '<option value="' . $width['value'] . '" ' . selected( $current_value, $width['value'], false ) . '>' . $width['name'] . '</option>';
		}

		$select_widths .= '</select>';
		$select_widths .= '</div>';
		$i++;
	}

	/*
	------------------------------------------------------*/
	/*
	 Primary Output
	/*------------------------------------------------------*/

	$output  = sprintf( '<div class="select-wrap alignleft">%s</div>', $select_number );
	$output .= sprintf( '<div class="select-wrap alignleft last">%s</div>', $select_widths );
	$output .= '<div class="clear"></div>';

	return $output;
}

/**
 * Generates option to edit slider areas and groups.
 *
 * @since  1.0.0
 */
function anva_slider_group_area_option( $id, $name, $val ) {

	$areas  = anva_get_default_slider_areas();
	$groups = get_terms( array(
		'taxonomy'   => 'slideshow_group',
		'hide_empty' => false,
	) );

	$options = '';

	foreach ( $groups as $key => $group ) {
		$options .= sprintf( '<option value="%s">%s</option>', $group->slug, $group->name );
	}

	$output = '<div class="anva-slider-wrap">';

	foreach ( $areas as $key => $area ) {

		$checked = false;
		if ( is_array( $val ) && array_key_exists( $key, $val ) ) {
			$checked = true;
		}

		$value = '';

		if ( ! empty( $val ) && ! empty( $val[ $key ] ) ) {
			$value = $val[ $key ];
		}

		$output .= '<div class="anva-slider-cat-item">';
		$output .= '<span class="anva-slider-cat-checkbox">';
		$output .= sprintf( '<input id="%s" class="anva-input anva-checkbox checkbox checkbox-style" value="%s" type="checkbox" %s name="%s" />', 'slider-cat-' . $key, $key, checked( $checked, true, false ), esc_attr( $name . '[' . $id . '][includes][]' ) );
		$output .= '<label for="' . 'slider-cat-' . $key . '" class="checkbox-style-1-label checkbox-small">' . esc_html( $area ) . '</label>';
		$output .= '</span>';
		$output .= sprintf( '<select class="anva-input anva-slider-cat-input" name="%s">%s</select>', esc_attr( $name . '[' . $id . '][categories][' . $key . ']' ), $options, $value );
		$output .= '</div>';
	}

	$output .= '</div><!-- .anva-slider-wrap (end) -->';

	return $output;
}

/**
 * Media uploader using the WordPress Media Library in 3.5+ tp handle the logo section.
 *
 * @since  1.0.0
 * @param  array $args
 * @return string $output
 */
function anva_media_uploader_option( $args ) {

	$defaults = array(
		'option_name' 	=> '',			// Prefix for form name attributes
		'type'			=> 'standard',	// Type of media uploader - standard, logo, logo_2x, background, slider, video
		'id'			=> '', 			// A token to identify this field, extending onto option_name. -- option_name[id]
		'value'			=> '',			// The value of the field, if present.
		'value_id'		=> '',			// Attachment ID used in slider
		'value_title'	=> '',			// Title of attachment image (used for slider)
		'name'			=> '',// Option to extend 'id' token -- option_name[id][name]
	);

	$args = wp_parse_args( $args, $defaults );

	$output = '';
	$id     = '';
	$class  = '';
	$int    = '';
	$value  = '';
	$name   = '';

	$id   = strip_tags( strtolower( $args['id'] ) );
	$type = $args['type'];

	// If a value is passed and we don't have a stored value, use the value that's passed through.
	$value = '';
	if ( $args['value'] ) {
		$value = $args['value'];
	}

	// Set name formfield based on type.
	if ( $type == 'slider' ) {
		$name = $args['option_name'] . '[image]';
	} else {
		$name = $args['option_name'] . '[' . $id . ']';
	}

	// If passed name, set it.
	if ( $args['name'] ) {
		$name = $name . '[' . $args['name'] . ']';
		$id = $id . '_' . $args['name'];
	}

	if ( $value ) {
		$class = ' has-file';
	}

	// Allow multiple upload options on the same page with
	// same ID -- This could happen in the Layout Builder, for example.
	$formfield = uniqid( $id . '_' );

	// Data passed to wp.media
	$data = array(
		'title' 	=> __( 'Select Media', 'anva' ),
		'select'	=> __( 'Select', 'anva' ),
		'upload'	=> __( 'Browse', 'anva' ),
		'remove'	=> __( 'Remove', 'anva' ),
		'class'		=> 'modal-hide-settings',
	);

	$output .= '<div class="group-button">';

	// Start output
	switch ( $type ) {

		case 'logo' :
			$data['title'] = __( 'Logo Image', 'anva' );
			$data['select'] = __( 'Use for Logo', 'anva' );
			$output .= '<input id="' . $formfield . '" class="image-url upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __( 'Standard image URL', 'anva' ) . '" />' . "\n";
			break;

		case 'logo_2x' :
			$data['title'] = __( 'Logo 2x Image', 'anva' );
			$data['select'] = __( 'Use for Logo', 'anva' );
			$output .= '<input id="' . $formfield . '" class="image-url upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __( '2x size of standard image', 'anva' ) . '" />' . "\n";
			break;

		case 'logo_mini' :
			$data['title'] = __( 'Logo Mini Image', 'anva' );
			$data['select'] = __( 'Use for Logo', 'anva' );
			$output .= '<input id="' . $formfield . '" class="image-url upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __( 'Mini standard image', 'anva' ) . '" />' . "\n";
			break;

		/**
		 * More will come.
		 *
		 * @todo Mini Image 2x
		 * @todo Dark Image
		 * @todo Dark Image 2x
		 */

		default :
			$output .= '<input id="' . $formfield . '" class="image-url upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __( 'No file chosen', 'anva' ) . '" />' . "\n";
	}

	$data = apply_filters( 'anva_media_uploader_data', $data, $type );

	$output .= '<span>';
	$output .= '<input id="remove-' . $formfield . '" class="trigger remove-file button" type="button" data-type="' . $type . '" data-title="' . $data['title'] . '" data-select="' . $data['select'] . '" data-class="' . $data['class'] . '" data-upload="' . $data['upload'] . '" data-remove="' . $data['remove'] . '" value="' . $data['remove'] . '" />' . "\n";
	$output .= '</span>';
	$output .= '</div>';

	$output .= '<div class="screenshot" id="' . $formfield . '-image">' . "\n";

	if ( $value && $type != 'video' ) {
		$remove = '<a class="remove-image">X</a>';
		$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );

		if ( $image ) {
			$output .= '<img src="' . $value . '" alt="" />' . $remove;
		} else {
			$parts = explode( '/', $value );
			for ( $i = 0; $i < sizeof( $parts ); ++$i ) {
				$title = $parts[ $i ];
			}

			// Standard generic output if it's not an image.
			$title = __( 'View File', 'anva' );
			$output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">' . $title . '</a></span></div>';
		}
	}

	$output .= '</div>' . "\n";

	return $output;
}
