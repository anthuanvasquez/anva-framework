<?php

function anva_customizer_get_options() {

	global $_anva_customizer_sections;

	if ( $_anva_customizer_sections ) {

		$options = array();

		foreach ( $_anva_customizer_sections as $section ) {
			foreach ( $section['options'] as $option_id => $option ) {
				$options[ $option_id ] = $option;
			}
		}

		return $options;

	}
}

function anva_customizer_add_panel( $panel, $wp_customize ) {

	$panels_default = array(
		'title'          	 => NULL,
		'description'    	 => NULL,
		'capability'     	 => 'edit_theme_options',
		'theme_supports' 	 => '',
		'priority'       	 => 10,
	);

	$panels = array_merge( $panels_default, $panel );

	$wp_customize->add_panel(
		$panels['id'], array(
			'title' 				 => $panels['title'],
			'description' 	 => $panels['description'],
			'capability'     => $panels['capability'],
			'theme_supports' => $panels['theme_supports'],
			'priority' 			 => $panels['priority'],
		)
	);

}

/**
 * Add the setting and proper sanitization.
 *
 * @since  1.0.0.
 * @param  string $option_name
 * @param  array  $option
 * @param  object $wp_customize
 * @param  string $default
 * @param  string $type
 * @return void
 */
function anva_customizer_add_setting( $option, $wp_customize ) {

	$settings_default = array(
		'default'              => NULL,
		'option_type'          => 'option',
		'capability'           => 'edit_theme_options',
		'theme_supports'       => NULL,
		'transport'            => NULL,
		'sanitize_callback'    => 'wp_kses_post',
		'sanitize_js_callback' => NULL
	);

	// Settings defaults
	$settings = array_merge( $settings_default, $option );

	// Arguments for $wp_customize->add_setting
	$wp_customize->add_setting( $option['settings'], array(
			'default'              => $settings['default'],
			'type'                 => $settings['option_type'],
			'capability'           => $settings['capability'],
			'theme_supports'       => $settings['theme_supports'],
			'transport'            => $settings['transport'],
			'sanitize_callback'    => $settings['sanitize_callback'],
			'sanitize_js_callback' => $settings['sanitize_js_callback']
		)
	);

}

/**
 * Sanitize a value from a list of allowed values.
 * @todo   Create sanitize validations
 *
 * @since  1.0.0.
 * @param  mixed $value    The value to sanitize.
 * @param  mixed $setting  The setting for which the sanitizing is occurring.
 * @return mixed           The sanitized value.
 */
function anva_customizer_sanitize_choices( $value, $setting ) {
	return $value;
}

/**
 * Helper function to return defaults.
 *
 * @since  1.0.0
 * @param  string
 * @return mixed $default
 */
function anva_customizer_get_default( $setting ) {

	$options = anva_customizer_get_options();

	if ( isset( $options[ $setting ]['default'] ) ) {
		return $options[ $setting ]['default'];
	}

}

/**
 * Helper function to return choices
 *
 * @since  1.0.0
 * @param  string
 * @return mixed $default
 */
function anva_customizer_get_choices( $setting ) {

	$options = anva_customizer_get_options();

	if ( isset( $options[ $setting ]['choices'] ) ) {
		return $options[ $setting ]['choices'];
	}

}

/**
 * Get default sanitization function for option type
 *
 * @since  1.0.0.
 * @param  array $option
 * @return void
 */
function anva_customizer_get_sanitization( $type ) {

	if ( 'select' == $type || 'radio' == $type ) {
		return 'anva_customizer_sanitize_choices';
	}

	if ( 'checkbox' == $type ) {
		return 'anva_sanitize_checkbox';
	}

	if ( 'color' == $type ) {
		return 'anva_sanitize_hex';
	}

	if ( 'upload' == $type || 'image' == $type ) {
		return 'anva_sanitize_upload';
	}

	if ( 'text' == $type ) {
		return 'sanitize_text_field';
	}

	if ( 'textarea' == $type ) {
		return 'anva_sanitize_textarea';
	}

	if ( 'url' == $type ) {
		return 'esc_url';
	}

	if ( 'range' == $type ) {
		return 'sanitize_text_field';
	}

	if ( 'dropdown-pages' == $type ) {
		return 'absint';
	}

	if ( 'typography' == $type ) {
		return 'anva_sanitize_typography';
	}

	// If a custom option is being used, return false
	return FALSE;
}
