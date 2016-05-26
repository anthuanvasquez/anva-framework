<?php

/**
 * Show message when the theme is activated.
 *
 * @since  1.0.0
 * @return void
 */
function anva_admin_theme_activate() {
	if ( isset( $_GET['activated'] ) && true == $_GET['activated'] ) {
		
		$option_name = anva_get_option_name();
		$admin_url   = admin_url( 'themes.php?page=' . $option_name );
		
		printf(
			'<div class="updated updated fade settings-error notice is-dismissible"><p>%s %s</p></div>',
			__( 'Anva theme is activated.', 'anva' ),
			sprintf(
				__( 'Go to %s', 'anva' ),
				'<a href="'. esc_url( $admin_url ) .'">' . __( 'Theme Options Page', 'anva' ) . '</a>'
			)
		);
	}
}

/**
 * Check if seetings exists in the database.
 * 
 * @since 1.0.0
 */
function anva_admin_check_settings() {
	$option_name = anva_get_option_name();
	if ( ! get_option( $option_name ) ) {
		printf( '<div class="error fade settings-error notice is-dismissible"><p>%s</p></div>', __( 'Options don\'t exists in the database. Please configure and save your theme options page.', 'anva' ) );
	}
}

/**
 * Show flash message after update/reset settings.
 *
 * @since  1.0.0.
 * @return void
 */
function anva_add_settings_flash() {
	return;
	if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ) : ?>
		<script type="text/javascript">
		window.onload = function() {
			swal({
				title: "<?php echo esc_js( __( 'Done!', 'anva' ) ); ?>",
				text: "<?php echo esc_js( __( 'Options has been updated.', 'anva' ) ); ?>",
				type: "success",
				timer: 2000,
				showConfirmButton: false
			});
		};
		</script>
	<?php endif;
}

/**
 * Show notice whan settings change in options page.
 * 
 * @since 1.0.0
 */
function anva_add_settings_change() {
	printf( '<div id="anva-framework-change" class="section-info">%s</div>', __( 'Settings has changed.', 'anva' ) );
}

/**
 * Log option.
 * 
 * @since 1.0.0
 */
function anva_admin_settings_log() {
	
	$html = '';

	// Get current info
	$option_name = anva_get_option_name();
	$option_log  = get_option( $option_name . '_log' );

	// Check if field exists
	if ( $option_log ) {
		$time = strtotime( $option_log );
		$time = date( 'M d, Y @ g:i A', $time );
		printf( '<div class="log"><span class="dashicons dashicons-clock"></span> <strong>%s:</strong> %s</div>', __( 'Last changed', 'anva' ), $time );
		return;
	}
	
	printf( '<div class="log"><span class="dashicons dashicons-clock"></span> %s</div>', __( 'Your settings has not changed.', 'anva' ) );
	
}

/**
 * Display framework and theme credits
 *
 * @since 1.0.0
 */
function anva_admin_footer_credits() {
	$theme_info 	= ANVA_THEME_NAME . ' ' . ANVA_THEME_VERSION;
	$framework_info = ANVA_FRAMEWORK_NAME . ' ' . ANVA_FRAMEWORK_VERSION;
	$author_info 	= '<a href="' . esc_url( 'http://anthuanvasquez.net/' ) . '">Anthuan Vasquez</a>';

	printf(
		'<div id="anva-options-page-credit">%s %s<div class="clear"></div></div>',
		sprintf(
			'<span class="alignleft">%2$s %1$s %3$s</span>',
			__( 'powered by', 'anva' ),
			$theme_info,
			$framework_info
		),
		sprintf(
			'<span class="alignright">%1$s %2$s</span>',
			__( 'Develop by', 'anva' ),
			$author_info
		)
	);
}

/**
 * Display footer links
 *
 * @since 1.0.0
 */
function anva_admin_footer_links() {
	printf(
		'<div id="anva-options-page-links">%s %s %s</div>',
		sprintf( '<a href="%s"><span class="dashicons dashicons-megaphone"></span> %s</a>', esc_url( 'https://themefores/user/oidoperfecto/porfolio' ), __( 'Support', 'anva' ) ),
		sprintf( '<a href="%s"><span class="dashicons dashicons-book"></span> %s</a>', esc_url( 'http://anthuanvasquez.net/#' ), __( 'Theme Documentation', 'anva' ) ),
		sprintf( '<a href="%s"><span class="dashicons dashicons-cart"></span> %s</a>', esc_url( 'https://themefores/user/oidoperfecto/porfolio' ), __( 'Buy Themes', 'anva' ) )
	);
}

/**
 * Generates option to edit social media buttons
 */
function anva_social_media_option( $id, $name, $val ) {

	$profiles = anva_get_social_icons_profiles();
	$counter  = 1;
	$divider  = round( count( $profiles ) / 2 );
	$output   = '<div class="column-1">';

	foreach ( $profiles as $key => $profile ) {

		$checked = false;
		if ( is_array( $val ) && array_key_exists( $key, $val ) ) {
			$checked = true;
		}

		if ( ! empty( $val ) && ! empty( $val[$key] ) ) {
			$value = $val[$key];
		} else {

			// Determine if SSL is being on a secure server.
			$value = is_ssl() ? 'https://' : 'http://';
			
			if ( 'email3' == $key ) {
				$value = 'mailto:';
			}

			if ( 'skype' == $key) {
				$value = 'skype:username?call';
			}

			if ( 'call' == $key ) {
				$value = 'tel:';
			}
		}

		$output .= '<div class="item">';
		$output .= '<span>';
		$output .= sprintf( '<input id="%s" class="checkbox anva-input anva-checkbox checkbox-style" value="%s" type="checkbox" %s name="%s" />', 'social-' . $key, $key, checked( $checked, true, false ), esc_attr( $name.'['.$id.'][includes][]' ) );
		$output .= '<label for="' . 'social-' . $key . '" class="checkbox-style-1-label checkbox-small">' . esc_html( $profile ) . '</label>';
		$output .= '</span>';
		$output .= sprintf( '<input class="anva-input social_media-input" value="%s" type="text" name="%s" />', esc_attr( $value ), esc_attr( $name.'['.$id.'][profiles]['.$key.']' ) );
		$output .= '</div>';

		if ( $counter == $divider ) {
			$output .= '</div><!-- .column-1 (end) -->';
			$output .= '<div class="column-2">';
		}

		$counter++;
	}
	$output .= '</div><!-- .column-2 (end) -->';

	return $output;
}

/**
 * Generates option to edit a logo.
 *
 * @since  1.0.0
 * @param  string      $id
 * @param  string      $name
 * @param  array       $val
 * @return string|html $output
 */
function anva_logo_option( $id, $name, $val ) {

	/*------------------------------------------------------*/
	/* Type of logo
	/*------------------------------------------------------*/

	$types = array(
		'title' 		=> __( 'Site Title', 'anva' ),
		'title_tagline' => __( 'Site Title + Tagline', 'anva' ),
		'custom' 		=> __( 'Custom Text', 'anva' ),
		'image' 		=> __( 'Image', 'anva' )
	);

	$current_value = '';
	if ( ! empty( $val ) && ! empty( $val['type'] ) ) {
		$current_value = $val['type'];
	}

	$select_type  = '<label for="' . $id . '" class="anva-select-label anva-select">';
	$select_type .= '<span></span>';
	$select_type .= '<select name="'.esc_attr( $name.'['.$id.'][type]' ).'">';

	foreach ( $types as $key => $type ) {
		$select_type .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $current_value, $key, false ), $type );
	}

	$select_type .= '</select>';
	$select_type .= '</label><!-- .anva-select (end) -->';

	/*------------------------------------------------------*/
	/* Site Title
	/*------------------------------------------------------*/

	$site_title  = '<p class="note">';
	$site_title .= __( 'Current Site Title', 'anva' ) . ': <strong>';
	$site_title .= get_bloginfo( 'name' ).'</strong><br>';
	$site_title .= sprintf( __( 'You can change your site title and tagline by going %shere%s.', 'anva' ), '<a href="' . esc_url( 'options-general.php' ) . '" target="_blank">', '</a>' );
	$site_title .= '</p>';

	/*------------------------------------------------------*/
	/* Site Title + Tagline
	/*------------------------------------------------------*/

	$site_title_tagline  = '<p class="note">';
	$site_title_tagline .= __( 'Current Site Title', 'anva' ).': <strong>';
	$site_title_tagline .= get_bloginfo( 'name' ).'</strong><br>';
	$site_title_tagline .= __( 'Current Tagline', 'anva' ).': <strong>';
	$site_title_tagline .= get_bloginfo( 'description' ).'</strong><br>';
	$site_title_tagline .= sprintf( __( 'You can change your site title by going %shere%s.', 'anva' ), '<a href="' . esc_url( 'options-general.php' ) . '" target="_blank">', '</a>' );
	$site_title_tagline .= '</p>';

	/*------------------------------------------------------*/
	/* Custom Text
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
	$custom_text .= sprintf( '<input type="text" name="%s" value="%s" /></p>', esc_attr( $name.'['.$id.'][custom]' ), esc_attr( $current_value ) );
	$custom_text .= sprintf( '<p><label class="inner-label"><strong>%s</strong> (%s)</label>', __( 'Tagline', 'anva' ), __( 'optional', 'anva' ) );
	$custom_text .= sprintf( '<input type="text" name="%s" value="%s" /></p>', esc_attr( $name.'['.$id.'][custom_tagline]' ), esc_attr( $current_tagline ) );
	$custom_text .= sprintf( '<p class="note">%s</p>', __( 'Insert your custom text.', 'anva' ) );

	/*------------------------------------------------------*/
	/* Image
	/*------------------------------------------------------*/

	$current_value = array( 'url' => '' );
	if ( is_array( $val ) && isset( $val['image'] ) ) {
		$current_value = array( 'url' => $val['image'] );
	}

	$current_retina = array( 'url' => '' );
	if ( is_array( $val ) && isset( $val['image_2x'] ) ) {
		$current_retina = array( 'url' => $val['image_2x'] );
	}

	$current_alternate = array( 'url' => '' );
	if ( is_array( $val ) && isset( $val['image_alternate'] ) ) {
		$current_alternate = array( 'url' => $val['image_alternate'] );
	}

	// Standard Image
	$image_upload  = '<div class="section image-standard">';
	$image_upload .= '<label class="inner-label"><strong>'.__( 'Standard Image', 'anva' ).'</strong></label>';
	$image_upload .= anva_media_uploader( array(
		'option_name' => $name,
		'type'        => 'logo',
		'id'          => $id,
		'value'       => $current_value['url'],
		'name'        => 'image'
	) );
	$image_upload .= '</div>';

	// Standard Image Retina (2x)
	$image_upload .= '<div class="section image-2x">';
	$image_upload .= '<label class="inner-label"><strong>'.__( '2x Standard Image (optional)', 'anva' ).'</strong></label>';
	$image_upload .= anva_media_uploader( array(
		'option_name' => $name, 
		'type'        => 'logo_2x', 
		'id'          => $id, 
		'value'       => $current_retina['url'], 
		'name'        => 'image_2x'
	) );
	$image_upload .= '</div>';

	// Standard Image Alternate
	$image_upload .= '<div class="section image-alternate">';
	$image_upload .= '<label class="inner-label"><strong>'.__( 'Alternate Standard Image (optional)', 'anva' ).'</strong></label>';
	$image_upload .= anva_media_uploader( array(
		'option_name' => $name,
		'type'        => 'logo_alternate',
		'id'          => $id,
		'value'       => $current_alternate['url'],
		'name'        => 'image_alternate'
	) );
	$image_upload .= '</div>';

	/**
	 * More will come.
	 * 
	 * @todo Alternate Image 2x
	 * @todo Dark Image
	 * @todo Dark Image 2x
	 */

	/*------------------------------------------------------*/
	/* Primary Output
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

	/*------------------------------------------------------*/
	/* Setup Internal Options
	/*------------------------------------------------------*/

	// Dropdown for number of columns selection
	$data_num = array(
		array(
			'name' 	=> __( 'Hide Columns', 'anva' ),
			'value' => 0,
		),
		array(
			'name' 	=> '1 '. __( 'Column', 'anva' ),
			'value' => 1,
		),
		array(
			'name' 	=> '2 '. __( 'Columns', 'anva' ),
			'value' => 2,
		),
		array(
			'name' 	=> '3 '. __( 'Columns', 'anva' ),
			'value' => 3,
		),
		array(
			'name' 	=> '4 '. __( 'Columns', 'anva' ),
			'value' => 4,
		),
		array(
			'name' 	=> '5 '. __( 'Columns', 'anva' ),
			'value' => 5,
		)
	);

	// Dropdowns for column width configuration
	$data_widths = anva_column_widths();

	/*------------------------------------------------------*/
	/* Construct <select> Menus
	/*------------------------------------------------------*/

	// Select number of columns
	$select_number  = '<label for="' . $id . '" class="anva-select-label">';
	$select_number .= '<span></span>';
	$select_number .= '<select class="column-num" name="'.esc_attr( $name.'['.$id.'][num]' ).'">';

	$current_value = '';
	if ( ! empty( $val ) && ! empty( $val['num'] ) ) {
		$current_value = $val['num'];
	}

	foreach ( $data_num as $num ) {
		$select_number .= '<option value="'.$num['value'].'" '.selected( $current_value, $num['value'], false ).'>'.$num['name'].'</option>';
	}

	$select_number .= '</select>';
	$select_number .= '</label>';

	// Select column widths
	$i = 1;
	$select_widths = '<div class="column-width column-width-0"><p class="inactive">'.__( 'Columns will be hidden.', 'anva' ).'</p></div>';
	foreach ( $data_widths as $widths ) {

		$select_widths .= '<label for="' . $id . '" class="anva-select-label column-width column-width-' . $i . '">';
		$select_widths .= '<span></span>';
		$select_widths .= '<select name= "'.esc_attr( $name.'['.$id.'][width]['.$i.']' ).'">';
		
		$current_value = '';
		if ( ! empty( $val ) && ! empty( $val['width'][$i] ) ) {
			$current_value = $val['width'][$i];
		}

		foreach ( $widths as $width ) {
			$select_widths .= '<option value="'.$width['value'].'" '.selected( $current_value, $width['value'], false ).'>'.$width['name'].'</option>';
		}

		$select_widths .= '</select>';
		$select_widths .= '</label>';
		$i++;
	}

	/*------------------------------------------------------*/
	/* Primary Output
	/*------------------------------------------------------*/

	$output  = sprintf( '<div class="select-wrap alignleft">%s</div>', $select_number );
	$output .= sprintf( '<div class="select-wrap alignleft last">%s</div>', $select_widths );
	$output .= '<div class="clear"></div>';

	return $output;
}
