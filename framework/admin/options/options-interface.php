<?php

/**
 * Generates the tabs that are used in the options menu.
 *
 * Based on "Options Framework" by Devin Price.
 * @link http://wptheming.com
 *
 * @since  1.0.0
 * @param  array $options
 * @return array $menu
 */
function anva_get_options_tabs( $options ) {
	
	$counter = 0;
	$menu    = '';
	
	foreach ( $options as $value ) {
		
		// Heading for Navigation
		if ( $value['type'] == 'heading' ) {
			
			// Add icon to group
			$icon = '';
			if ( isset( $value['icon'] ) && ! empty( $value['icon'] ) ) {
				$icon = '<span class="dashicons dashicons-'. esc_attr( $value['icon'] ) .'"></span> ';
			}

			$counter++;
			
			$class = '';
			$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
			$class = 'tab-' . preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) );

			$menu .= sprintf(
				'<a id="options-group-%s-tab" class="nav-tab %s" title="%s" href="%s">%s</a>',
				$counter,
				$class,
				esc_attr( $value['name'] ),
				esc_attr( '#options-group-'.  $counter ),
				$icon . esc_html( $value['name'] )
			);
		}
	}
	return $menu;
}


/**
 * Generates the options fields that are used in the theme options,
 * meta boxes and content builder.
 *
 * Based on "Options Framework" by Devin Price.
 * @link http://wptheming.com
 *
 * @global $allowedtags
 *
 * @since  1.0.0
 * @param  string $option_name
 * @param  array  $settings
 * @param  array  $options
 * @return string $output
 */
function anva_get_options_fields( $option_name, $settings, $options ) {
	
	global $allowedtags;

	$counter = 0;
	$menu = '';

	// Read options array
	foreach ( $options as $value ) :

		$val          = '';
		$output       = '';
		$select_value = '';

		if ( $value['type'] == 'group_start' ) {

			$class = '';

			$name = ! empty( $value['name'] ) ? esc_html( $value['name'] ) : '';

			if ( isset( $value['class'] ) && ! empty( $value['class'] ) ) {
				$class = ' ' . $value['class'];
			}

			if ( ! $name ) {
				$class .= ' no-name';
			}
			
			$group = trim( $class );

			$output .= '<div id="' . esc_attr( $group ) . '" class="postbox inner-group' . esc_attr( $class ) . '">';

			if ( $name ) {
				$output .= '<h3><span>' . esc_html( $name ) . '</span></h3>';
			}

			if ( ! empty( $value['desc'] ) ) {
				$output .= '<div id="section-' . esc_attr( $value['id'] ) . '" class="section section-description">' . esc_html( $value['desc'] ) . '</div><!-- .section (end) -->';
			}

		}

		if ( $value['type'] == 'group_end' ) {
			$output .= '</div><!-- .inner-group (end) -->';
		}

		// Wrap all options
		if ( ( $value['type'] != "group_start" ) && ( $value['type'] != "group_end" ) ) {
			if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

				// Keep all ids lowercase with no spaces
				$value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower( $value['id'] ) );

				$id = 'section-' . $value['id'];

				$class = 'section';
				if ( isset( $value['type'] ) ) {
					$class .= ' section-' . $value['type'];
				}
				
				if ( isset( $value['class'] ) ) {
					$class .= ' ' . $value['class'];
				}

				// Value to trigger show-hide sections
				$trigger = '';
				if ( isset( $value['trigger'] ) ) {
					$trigger = 'data-trigger="' . esc_attr( $value['trigger'] ) . '"';
				}

				// Receivers show-hide section
				$receivers = '';
				if ( isset( $value['receivers'] ) ) {
					$receivers = 'data-receivers="' . esc_attr( $value['receivers'] ) . '"';
				}

				if ( ! empty( $trigger ) && ! empty( $receivers ) ) {
					$class .= ' show-hide';
				}

				$output .= sprintf(
					'<div id="%s" class="%s" %s>' . "\n",
					esc_attr( $id ),
					esc_attr( $class ),
					$trigger . $receivers
				);
				
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}

				if ( $value['type'] != 'editor' ) {
					$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
				} else {
					$output .= '<div class="option">' . "\n" . '<div>' . "\n";
				}
			}
		}

		// Set default value to $val
		if ( isset( $value['std'] ) ) {
			$val = $value['std'];
		}

		// If the option is already saved, override $val
		if ( ( $value['type'] != "group_start" ) && ( $value['type'] != "group_end" ) ) {
			if ( ( $value['type'] != 'heading' ) && ( $value['type'] != 'info') ) {
				if ( isset( $settings[ ( $value['id'] ) ] ) ) {
					$val = $settings[ ( $value['id'] ) ];
					
					// Striping slashes of non-array options
					if ( ! is_array( $val ) ) {
						$val = stripslashes( $val );
					}
				}
			}
		}

		// If there is a description save it for labels
		$explain_value = '';
		if ( isset( $value['desc'] ) ) {
			$explain_value = $value['desc'];
		}

		// Set the placeholder if one exists
		$placeholder = '';
		if ( isset( $value['placeholder'] ) ) {
			$placeholder = ' placeholder="' . esc_attr( $value['placeholder'] ) . '"';
		}

		// Generate options type
		switch ( $value['type'] ) :

			/* ------------------------------------- */
			/*  Text Input
			/* ------------------------------------- */

			case 'text':
				$output .= sprintf( '<input id="%s" class="anva-input anva-input-text" name="%s" type="text" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/*  Number Input
			/* ------------------------------------- */

			case 'number':
				$output .= sprintf( '<input id="%s" class="anva-input anva-input-number" name="%s" type="number" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/*  Password Input
			/* ------------------------------------- */

			case 'password':
				$output .= sprintf( '<input id="%s" class="anva-input anva-input-password" name="%s" type="password" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/* Date Picker Input
			/* ------------------------------------- */

			case 'date':
				$output .= sprintf( '<input id="%s" class="anva-input anva-date-picker" name="%s" type="text" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/* URL Input
			/* ------------------------------------- */

			case 'url':
				$output .= sprintf( '<input id="%s" class="anva-input anva-input-url" name="%s" type="url" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/* URL Input
			/* ------------------------------------- */

			case 'tel':
				$output .= sprintf( '<input id="%s" class="anva-input anva-input-tel" name="%s" type="tel" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/* URL Input
			/* ------------------------------------- */

			case 'email':
				$output .= sprintf( '<input id="%s" class="anva-input anva-input-email" name="%s" type="email" value="%s" %s />', esc_attr( $value['id'] ), esc_attr( $option_name . '[' . $value['id'] . ']' ), esc_attr( $val ), $placeholder );
				break;

			/* ------------------------------------- */
			/* Double Text
			/* ------------------------------------- */

			case 'double_text':
				$val_1 = '';
				$val_2 = '';
				if ( isset( $val[ 0 ] ) ) {
					$val_1 = $val[ 0 ];
				}
				if ( isset( $val[ 1 ] ) ) {
					$val_2 = $val[ 1 ];
				}
				$output .= '<div class="double-inputs">';
				$output .= '<div class="input-col">';
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input anva-text" name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" type="text" value="' . esc_attr( $val_1 ) . '" />';
				$output .= '</div>';
				$output .= '<div class="input-col last">';
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input anva-text" name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" type="text" value="' . esc_attr( $val_2 ) . '" />';
				$output .= '</div>';
				$output .= '</div>';
				break;

			/* ------------------------------------- */
			/* Textarea
			/* ------------------------------------- */

			case 'textarea':
				$rows = '8';

				if ( isset( $value['settings']['rows'] ) ) {
					$custom_rows = $value['settings']['rows'];
					if ( is_numeric( $custom_rows ) ) {
						$rows = $custom_rows;
					}
				}

				$val = stripslashes( $val );
				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="anva-input anva-textarea" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '"' . $placeholder . '>' . esc_textarea( $val ) . '</textarea>';
				break;

			/* ------------------------------------- */
			/* Select
			/* ------------------------------------- */

			case 'select':
				$output .= '<label class="anva-select-label" for="' . esc_attr( $value['id'] ) . '">';
				$output .= '<span></span>';
				$output .= '<select class="anva-input anva-select" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				foreach ($value['options'] as $key => $option ) {
					$output .= '<option'. selected( $val, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';

				break;
			
			/* ------------------------------------- */
			/* Radio
			/* ------------------------------------- */

			case "radio":
				$name = $option_name .'['. $value['id'] .']';
				foreach ( $value['options'] as $key => $option ) {
					$id = $option_name . '-' . $value['id'] .'-'. $key;
					$output .= '<div class="anva-radio-input-group">';
					$output .= '<input class="anva-input anva-radio radio-style" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" ' . checked( $val, $key, false) . ' /><label for="' . esc_attr( $id ) . '" class="radio-style-1-label radio-small">' . esc_html( $option ) . '</label>';
					$output .= '</div>';
				}
				break;

			/* ------------------------------------- */
			/* Radio Images
			/* ------------------------------------- */

			case "images":
				$name = $option_name .'['. $value['id'] .']';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( $val != '' && ($val == $key) ) {
						$selected = ' anva-radio-img-selected';
					}
					
					$slug = str_replace( '_', ' ', $key );

					$output .= '<div class="anva-radio-img-box ' . esc_attr( $selected ) . '">';
					$output .= '<span>';
					$output .= '<img src="' . esc_url( $option ) . '" alt="' . esc_attr( $key ) .'" class="anva-radio-img-img" onclick="document.getElementById(\''. esc_attr ($value['id'] .'_'. $key ) .'\').checked=true;" />';
					$output .= '</span>';
					$output .= '<div class="anva-radio-img-label">' . esc_html( $slug ) . '</div>';
					$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="anva-input anva-radio anva-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. checked( $val, $key, false ) .' />';
					$output .= '</div>';
				}
				$output .= '<div class="clear"></div>';
				break;

			/* ------------------------------------- */
			/* Checkbox
			/* ------------------------------------- */

			case 'checkbox':
				$output .= '<div class="anva-checkbox-input-group">';
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input anva-checkbox checkbox-style" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
				$output .= '<label class="explain checkbox-style-1-label checkbox-small" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags) . '</label>';
				$output .= '</div>';
				break;

			/* ------------------------------------- */
			/* Multicheck
			/* ------------------------------------- */

			case "multicheck":
				foreach ( $value['options'] as $key => $option ) {
					$checked = '';
					$label = $option;
					$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower( $key ) );

					$id = $option_name . '-' . $value['id'] . '-'. $option;
					$name = $option_name . '[' . $value['id'] . '][' . $option .']';

					if ( isset( $val[$option] ) ) {
						$checked = checked($val[$option], 1, false);
					}
					$output .= '<div class="anva-checkbox-input-group">';
					$output .= '<input id="' . esc_attr( $id ) . '" class="anva-input anva-checkbox checkbox-style" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '" class="checkbox-style-1-label checkbox-small">' . esc_html( $label ) . '</label>';
					$output .= '</div>';
				}
				break;

			/* ------------------------------------- */
			/* Switch
			/* ------------------------------------- */

			case 'switch':
				// Mini toggle
				if ( isset( $value['mini'] ) ) {
					$class = 'switch-rounded-mini';
				}

				$output .= '<div class="switch">';
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input switch-toggle switch-toggle-round" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .'>';
				$output .= '<label for="' . esc_attr( $value['id'] ) . '"></label>';
				$output .= '</div>';
				break;

			/* ------------------------------------- */
			/* Logo
			/* ------------------------------------- */

			case 'logo' :
				$output .= anva_logo_option( $value['id'], $option_name, $val );
				break;

			/* ------------------------------------- */
			/* Social Icons
			/* ------------------------------------- */

			case 'social_media':
				$output .= anva_social_media_option( $value['id'], $option_name, $val );
				break;

			/* ------------------------------------- */
			/* Columns
			/* ------------------------------------- */

			case 'columns' :
				$output .= anva_columns_option( $value['id'], $option_name, $val );
				break;

			/* ------------------------------------- */
			/* Custom Sidebars
			/* ------------------------------------- */

			case 'sidebar':

				$class = '';
				if ( ! $val ) {
					$class = 'class="empty"';
				}

				$output .= '<div class="group-button">';
				$output .= '<input type="text" class="sidebar" placeholder="' . __( 'Enter the sidebar name', 'anva' ) . '" />';
				$output .= '<span>';
				$output .= '<input type="button" class="button" id="add-sidebar" value="' . __( 'Add', 'anva' ) . '" />';
				$output .= '</span>';
				$output .= '</div>';
				$output .= '<input type="hidden" id="dynamic_sidebar_name" value="' . esc_attr( $value['id'] ) . '" />';
				$output .= '<div class="dynamic-sidebars">';
				$output .= '<ul ' . $class . '>';
		 
				// Display every custom sidebar
				if ( $val ) {
					$i = 0;
					foreach ( $val as $sidebar ) {
						$output .= '<li>' . esc_html( $sidebar ) . '<a href="#" class="delete">' . __( 'Delete', 'anva' ) . '</a>';
						$output .= '<input type="hidden" name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" value="' . esc_attr( $sidebar ) . '" />';
						$output .= '</li>';
						$i++;
					}
				}
				 
				$output .= '</ul>';
				$output .= '</div><!-- .dynamic-sidebars (end) -->';
				
				break;

			/* ------------------------------------- */
			/* Contact Fields
			/* ------------------------------------- */

			case 'contact_fields':

				$default_fields = apply_filters( 'anva_contact_fields', array(
					'name'         => __( 'Name', 'anva' ),
					'email'        => __( 'Email', 'anva' ),
					'subject'      => __( 'Subject', 'anva' ),
					'message'      => __( 'Message', 'anva' ),
					'phone'        => __( 'Phone', 'anva' ),
					'mobile'       => __( 'Mobile', 'anva' ),
					'company_name' => __( 'Company Name', 'anva' ),
					'country'      => __( 'Country', 'anva' ),
				));

				$class = 'contact-fields';
				if ( ! $val ) {
					$class .= ' empty';
				}

				$output .= '<label class="anva-select-label" for="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '">';
				$output .= '<span></span>';
				$output .= '<select class="anva-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				foreach ( $default_fields as $key => $option ) {
					$output .= '<option value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';
				$output .= '<div>';
				$output .= '<input type="button" class="button" id="add-contact-field" value="' . __( 'Add', 'anva' ) . '" />';
				$output .= '</div>';
				$output .= '<input type="hidden" id="contact_field_name" value="' . esc_attr( $value['id'] ) . '" />';
				$output .= '<div class="dynamic-contact-fields">';
				$output .= '<ul class="' . $class . '">';
		 
				// Display every field
				if ( $val ) {
					foreach ( $val as $field ) {
						if ( isset( $default_fields[ $field ] ) ) {
							$output .= '<li id="field-' . esc_attr( $field ) . '">' . esc_html( $default_fields[ $field ] ) . '<a href="#" class="delete">' . __( 'Delete', 'anva' ) . '</a>';
							$output .= '<input type="hidden" name="' . esc_attr( $option_name . '[' . $value['id'] . '][]' ) . '" value="' . esc_attr( $field ) . '" />';
							$output .= '</li>';
						}
					}
				}
				 
				$output .= '</ul>';
				$output .= '</div><!-- .dynamic-contact-fields (end) -->';
				
				break;

			/* ------------------------------------- */
			/* Sidebar Layout
			/* ------------------------------------- */

			case 'layout':
				
				$layout = '';
				$right = '';
				$left = '';

				if ( isset( $val['layout'] ) ) {
					$layout = $val['layout'];
				}

				if ( isset( $val['right'] ) ) {
					$right = $val['right'];
				}

				if ( isset( $val['left'] ) ) {
					$left = $val['left'];
				}

				// Fill layouts array
				$layouts[''] = esc_html__( 'Default Sidebar Layout', 'anva' );
				foreach ( anva_get_sidebar_layouts() as $sidebar_id => $sidebar ) {
					$layouts[$sidebar_id] = esc_html( $sidebar['name'] );
				}

				// Fill sidebars array
				$sidebars[''] = esc_html__( 'Default Sidebar Location', 'anva' );
				foreach ( anva_get_sidebar_locations() as $location_id => $location ) {
					$sidebars[$location_id] = esc_html( $location['args']['name'] );
				}

				// Layout
				$output .= '<label class="anva-select-label" for="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '">';
				$output .= '<span></span>';
				$output .= '<select class="anva-input anva-select" name="' . esc_attr( $option_name . '[' . $value['id'] . '][layout]' ) . '" id="' . esc_attr( $value['id'] ) . '">';
				foreach ( $layouts as $key => $option ) {
					$output .= '<option'. selected( $layout, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';

				// Right
				$output .= '<div class="sidebar-layout">';
				$output .= '<div class="item item-right">';
				$output .= '<p>' . __( 'Right', 'anva' ) . '</p>';
				$output .= '<label class="anva-select-label" for="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '">';
				$output .= '<span></span>';
				$output .= '<select class="anva-input anva-select" name="' . esc_attr( $option_name . '[' . $value['id'] . '][right]' ) . '" id="' . esc_attr( $value['id'] . '_right' ) . '">';
				foreach ( $sidebars as $key => $option ) {
					$output .= '<option'. selected( $right, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';
				$output .= '</div>';

				// Left
				$output .= '<div class="item item-left">';
				$output .= '<p>' . __( 'Left', 'anva' ) . '</p>';
				$output .= '<label class="anva-select-label" for="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '">';
				$output .= '<span></span>';
				$output .= '<select class="anva-input anva-select" name="' . esc_attr( $option_name . '[' . $value['id'] . '][left]' ) . '" id="' . esc_attr( $value['id'] . '_left' ) . '">';
				foreach ( $sidebars as $key => $option ) {
					$output .= '<option'. selected( $left, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';
				$output .= '</div>';
				$output .= '</div>';

				break;

			/* ------------------------------------- */
			/* Color Picker
			/* ------------------------------------- */

			case "color":
				$default_color = '';
				if ( isset($value['std']) ) {
					if ( $val !=  $value['std'] )
						$default_color = ' data-default-color="' .$value['std'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" class="anva-color" type="text" value="' . esc_attr( $val ) . '"' . $default_color .' />';
				break;

			/* ------------------------------------- */
			/* Uploader
			/* ------------------------------------- */

			case "upload":
				$output .= Anva_Options_Media_Uploader::uploader( $value['id'], $val, NULL, $option_name . '[' . $value['id'] . ']' );

				break;

			/* ------------------------------------- */
			/* Range Slider
			/* ------------------------------------- */

			case "range":
				$max   = $value['options']['max'];
				$min   = $value['options']['min'];
				$step  = $value['options']['step'];
				$units = '';

				if ( isset( $value['options']['units'] ) ) {
					$units = $value['options']['units'];
				}
				
				$output .= sprintf(
					'<div id="%s_range" class="anva-input anva-range-slider" data-range="%s"></div>',
					 esc_attr( $value['id'] ),
					 esc_attr( $value['id'] )

				);
				$output .= sprintf(
					'<input id="%s" name="%s" class="anva-input-range hidden" type="text" value="%s" data-min="%s" data-max="%s" data-step="%s" data-units="%s" />',
					esc_attr( $value['id'] ),
					esc_attr( $option_name . '[' . $value['id'] . ']' ),
					esc_attr( $val ),
					esc_attr( $min ),
					esc_attr( $max ),
					esc_attr( $step ),
					esc_attr( $units )
				);
				
				break;

			/* ------------------------------------- */
			/* Typography
			/* ------------------------------------- */

			case 'typography':

				$typography_stored = $val;

				// Font Size
				if ( in_array( 'size', $value['options'] ) ) {

					if ( ! empty( $value['sizes'] ) ) {
						$sizes = $value['sizes'];
					} else {
						$sizes = anva_recognized_font_sizes();
					}

					$min   = intval( $sizes[0] );
					$max   = intval( end( $sizes ) );
					$step  = intval( $sizes[1] ) - intval( $sizes[0] );
					$units = 'px';

					$id = $value['id'] . '_size';

					$output .= '<div class="font-range">';
					$output .= sprintf(
						'<div id="%s_range" class="anva-input anva-range-slider" data-range="%s"></div>',
						 esc_attr( $id ),
						 esc_attr( $id )
					);
					$output .= sprintf(
						'<input id="%s" name="%s" class="anva-input-range hidden" type="text" value="%s" data-min="%s" data-max="%s" data-step="%s" data-units="%s" />',
						esc_attr( $id ),
						esc_attr( $option_name . '[' . $value['id'] . '][size]' ),
						esc_attr( $typography_stored['size'] ),
						esc_attr( $min ),
						esc_attr( $max ),
						esc_attr( $step ),
						esc_attr( $units )
					);
					$output .= '</div>';

				}

				// Font Styles
				if ( in_array( 'style', $value['options'] ) ) {
					$output .= '<label for="' . $value['id'] . '_style" class="anva-select-label">';
					$output .= '<span></span>';
					$output .= '<select class="anva-typography anva-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
					$styles = anva_recognized_font_styles();
					foreach ( $styles as $key => $style ) {
						$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
					}
					$output .= '</select>';
					$output .= '</label>';
				}

				// Font Weight
				if ( in_array( 'weight', $value['options'] ) ) {
					$output .= '<label for="' . $value['id'] . '_weight" class="anva-select-label">';
					$output .= '<span></span>';
					$output .= '<select class="anva-typography anva-typography-weight" name="' . esc_attr( $option_name . '[' . $value['id'] . '][weight]' ) . '" id="' . esc_attr( $value['id'] . '_weight' ) . '">';

					$weights = anva_recognized_font_weights();

                    foreach ( $weights as $key => $weight ) {
						$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['weight'], $key, false ) . '>' . esc_attr( $weight ) . '</option>';
					}

					$output .= '</select>';
					$output .= '</label>';
				}

				// Font Face
				if ( in_array( 'face', $value['options'] ) ) {
					$output .= '<label for="' . $value['id'] . '_face" class="anva-select-label">';
					$output .= '<span></span>';
					$output .= '<select class="anva-typography anva-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
					$faces = anva_recognized_font_faces();
					foreach ( $faces as $key => $face ) {
						$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
					}
					$output .= '</select>';
					$output .= '</label>';
				}

				// Font Color
				if ( in_array( 'color', $value['options'] ) ) {
					$default_color = '';
					if ( isset($value['std']['color']) ) {
						if ( $val !=  $value['std']['color'] )
							$default_color = ' data-default-color="' .$value['std']['color'] . '" ';
					}
					$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="anva-color anva-typography-color  type="text" value="' . esc_attr( $typography_stored['color'] ) . '"' . $default_color .' />';
				}

				$output .= '<div class="clear"></div>';

				// Google Font Support
				if ( in_array( 'face', $value['options'] ) ) {
					
					$output .= '<div class="google-font hidden">';
					$output .= sprintf( '<h5>%s <a href="' . esc_url( 'http://www.google.com/webfonts' ) . '" target="_blank">%s</a>.</h5>', __( 'Enter the name of a font from the', 'anva' ), __( 'Google Font Directory', 'anva' ) );
					$output .= '<input type="text" name="' . esc_attr( $option_name . '[' . $value['id'] . '][google]' ) . '" value="' . esc_attr( $typography_stored['google'] ) . '" />';
					$output .= sprintf( '<p class="note">%s: <br />"Open Sans", "Open Sans:400", "Open Sans:500,700&subset=latin"</p>', esc_html__( 'How to use the font names?, examples', 'anva' ) );
					$output .= '</div>';

					// Font Preview
					$sample_text = apply_filters( 'anva_typography_sample_text', 'Lorem Ipsum' );
					$output .= sprintf( '<div class="sample-text-font" style="font-family: Arial;">%s</div>', esc_html( $sample_text ) );
				}

				break;

			/* ------------------------------------- */
			/* Background
			/* ------------------------------------- */

			case 'background':

				$background = $val;

				// Background Color
				$default_color = '';
				if ( isset( $value['std']['color'] ) ) {
					if ( $val !=  $value['std']['color'] ) {
						$default_color = ' data-default-color="' . $value['std']['color'] . '" ';
					}
					$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="anva-color anva-background-color"  type="text" value="' . esc_attr( $background['color'] ) . '"' . $default_color .' />';
				}

				// Background Image
				if ( ! isset( $background['image'] ) ) {
					$background['image'] = '';
				}

				$output .= Anva_Options_Media_Uploader::uploader( $value['id'], $background['image'], null, esc_attr( $option_name . '[' . $value['id'] . '][image]' ) );

				$class = 'anva-background-properties';
				if ( '' == $background['image'] ) {
					$class .= ' hide';
				}
				$output .= '<div class="' . esc_attr( $class ) . '">';

				// Background Repeat
				$output .= '<label for="' . $value['id'] . '" class="anva-select-label">';
				$output .= '<span></span>';
				$output .= '<select class="anva-background anva-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
				$repeats = anva_recognized_background_repeat();

				foreach ($repeats as $key => $repeat) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';

				// Background Position
				$output .= '<label for="' . $value['id'] . '" class="anva-select-label">';
				$output .= '<span></span>';
				$output .= '<select class="anva-background anva-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
				$positions = anva_recognized_background_position();

				foreach ($positions as $key=>$position) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';

				// Background Attachment
				$output .= '<label for="' . $value['id'] . '" class="anva-select-label">';
				$output .= '<span></span>';
				$output .= '<select class="anva-background anva-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
				$attachments = anva_recognized_background_attachment();

				foreach ($attachments as $key => $attachment) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';
				$output .= '</div>';

				break;

			/* ------------------------------------- */
			/* Code Editor
			/* ------------------------------------- */

			case 'code':
				$val = stripslashes( $val );
				$output .= '<div class="anva-textarea-wrap">';
				$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>';
				if ( isset( $value['mode'] ) ) {
					$mode = $value['mode'];
					$output .= '<input id="code_editor_mode" type="hidden" value="'.esc_html( $mode ).'" />';
				}
				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="anva-input anva-code-editor" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '">' . $val . '</textarea>';
				$output .= '</div><!-- .anva-textarea-wrap (end) -->';
				break;

			/* ------------------------------------- */
			/* Editor
			/* ------------------------------------- */

			case 'editor':
				$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags ) . '</div><!-- .explain (end) -->'."\n";
				echo $output;
				$textarea_name = esc_attr( $option_name . '[' . $value['id'] . ']' );
				$default_editor_settings = array(
					'textarea_name' => $textarea_name,
					'media_buttons' => false,
					'tinymce' => array( 'plugins' => 'wordpress, wplink' )
				);
				$editor_settings = array();
				if ( isset( $value['settings'] ) ) {
					$editor_settings = $value['settings'];
				}
				$editor_settings = array_merge( $default_editor_settings, $editor_settings );
				wp_editor( $val, $value['id'], $editor_settings );
				$output = '';

				break;

			/* ------------------------------------- */
			/* Info Notice
			/* ------------------------------------- */

			case "info":
				$id = '';
				$class = 'section';
				
				if ( isset( $value['id'] ) ) {
					$id = 'id="' . esc_attr( $value['id'] ) . '" ';
				}
				
				if ( isset( $value['type'] ) ) {
					$class .= ' section-' . $value['type'];
				}
				
				if ( isset( $value['class'] ) ) {
					$class .= ' ' . $value['class'];
				}

				$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '">' . "\n";
				
				if ( isset($value['name']) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}

				if ( isset( $value['desc'] ) ) {
					$output .= '<p>' . wp_kses( $value['desc'], $allowedtags ) . "</p>\n";
				}

				$output .= '</div>' . "\n";
				
				break;

			/* ------------------------------------- */
			/* Heading
			/* ------------------------------------- */

			case "heading":
				$counter++;
				if ( $counter >= 2 ) {
					$output .= '</div><!-- .group (end) -->' . "\n";
				}
				$class = '';
				$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
				$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) );
				$output .= '<div id="options-group-' . esc_attr( $counter ) . '" class="group ' . esc_attr( $class ) . '">';
				break;

		endswitch;
		
		// Add your own custom option type.
		$output = apply_filters( 'anva_option_type', $output, $value, $option_name, $val );

		// Close div and add descriptions
		if ( ( $value['type'] != "group_start" ) && ( $value['type'] != "group_end" ) ) {
			if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {
					
				$output .= '</div><!-- .controls (end) -->';
				
				if ( ( $value['type'] != "checkbox" ) && ( $value['type'] != "editor" ) && ( $value['type'] != 'code' ) ) {
					$output .= '<div class="explain">' . $explain_value . '</div><!-- .explain (end) -->'."\n";
				}
				
				$output .= '</div><!-- .option (end) -->';
				$output .= '</div><!-- .section (end) -->'."\n";
			}
		}

		// Print html
		echo $output;
	
	endforeach;

	// Outputs closing div if there tabs
	if ( anva_get_options_tabs( $options ) != '' ) {
		echo '</div><!-- .group (end) -->';
	}
}

function anva_the_options_fields( $option_name, $settings, $options ) {
	anva_get_options_fields( $option_name, $settings, $options );
}