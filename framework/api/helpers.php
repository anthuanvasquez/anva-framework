<?php

/**
 * Init framework's API.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_api_init() {

	// Setup Framework Core Options API
	Anva_Options_API::instance();

	// Setup Framework Stylesheets API
	Anva_Stylesheets_API::instance();

	// Setup Framework JavaScripts API
	Anva_Scripts_API::instance();

	// Setup Framework Sidebars Locations API
	Anva_Sidebars_API::instance();

	// Setup Framework Core Sliders API
	Anva_Sliders_API::instance();
	
	// Setup Framework Page Builder Elements API
	Anva_Content_Builder_API::instance();

	// Setup customizer API
	$GLOBALS['_anva_customizer_sections'] = array();
	
}

/**
 * Get theme option value.
 * 
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Based on "Options Framework" by Devin Price.
 * @link http://wptheming.com
 *
 * @since  1.0.0
 * @param  string               $name
 * @param  string|array|boolean $default
 * @return string|array|boolean $options
 */
function anva_get_option( $name, $default = false ) {

	$option_name = '';

	// Gets option name as defined in the theme
	if ( function_exists( 'anva_option_name' ) ) {
		$option_name = anva_option_name();
	}

	// Fallback option name
	if ( '' == $option_name ) {
		$option_name = get_option( 'stylesheet' );
		$option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) ); // correct name is $option_name
	}

	// Get option settings from database
	$options = get_option( $option_name );

	// Return specific option
	if ( isset( $options[ $name ] ) ) {
		return $options[ $name ];
	}
	
	return $default;
}

/**
 * This is for print theme option value.
 * 
 * @since 1.0.0
 * @param string               $name
 * @param string|array|boolean $default
 */
function anva_the_option( $name, $default = false ) {
	echo anva_get_option( $name, $default );
}

/**
 * Get raw options.
 *
 * @since 1.0.0
 */
function anva_get_core_options() {
	$api = Anva_Options_API::instance();
	return $api->get_raw_options();
}

/**
 * Get formatted options. Note that options will not be
 * formatted until after WP's after_setup_theme hook.
 *
 * @since 1.0.0
 */
function anva_get_formatted_options() {
	$api = Anva_Options_API::instance();
	return $api->get_formatted_options();
}

/**
 * Add theme option tab.
 *
 * @since 1.0.0
 */
function anva_add_option_tab( $tab_id, $tab_name, $top = false, $icon = 's' ) {
	$api = Anva_Options_API::instance();
	$api->add_tab( $tab_id, $tab_name, $top, $icon );
}

/**
 * Remove theme option tab
 *
 * @since 1.0.0
 */
function anva_remove_option_tab( $tab_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_tab( $tab_id );
}

/**
 * Add theme option section
 *
 * @since 1.0.0
 */
function anva_add_option_section( $tab_id, $section_id, $section_name, $section_desc = null, $options = null, $top = false ) {
	$api = Anva_Options_API::instance();
	$api->add_section( $tab_id, $section_id, $section_name, $section_desc, $options, $top );
}

/**
 * Remove theme option section
 *
 * @since 1.0.0
 */
function anva_remove_option_section( $tab_id, $section_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_section( $tab_id, $section_id );
}

/**
 * Add theme option
 *
 * @since 1.0.0
 */
function anva_add_option( $tab_id, $section_id, $option_id, $option ) {
	$api = Anva_Options_API::instance();
	$api->add_option( $tab_id, $section_id, $option_id, $option );
}

/**
 * Remove theme option
 *
 * @since 1.0.0
 */
function anva_remove_option( $tab_id, $section_id, $option_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_option( $tab_id, $section_id, $option_id );
}

/**
 * Edit theme option
 *
 * @since 1.0.0
 */
function anva_edit_option( $tab_id, $section_id, $option_id, $att, $value ) {
	$api = Anva_Options_API::instance();
	$api->edit_option( $tab_id, $section_id, $option_id, $att, $value );
}

/**
 * Get all core elements of Page Builder
 *
 * @since 1.0.0
 */
function anva_get_core_elements() {
	$api = Anva_Content_Builder_API::instance();
	return $api->get_core_elements();
}

/**
 * Get layout builder's elements after new elements
 * have been given a chance to be added at the theme-level.
 *
 * @since 1.0.0
 */
function anva_get_elements() {
	$api = Anva_Content_Builder_API::instance();
	return $api->get_elements();
}

/**
 * Check that the element ID exists.
 *
 * @deprecated use anva_element_exists()
 *
 * @since  1.0.0
 * @param  string $element_id
 * @return string $element_id
 */
function anva_is_element( $element_id ) {
	anva_deprecated_function( __FUNCTION__, '1.0.0', null, __( 'This function has been deprecated. Use anva_element_exists() instead.', 'anva' ) );
	$api = Anva_Content_Builder_API::instance();
	return $api->is_element( $element_id );
}

/**
 * Check that the element ID exists.
 *
 * @since  1.0.0
 * @param  string $element_id
 * @return string $element_id
 */
function anva_element_exists( $element_id ) {
	$api = Anva_Content_Builder_API::instance();
	return $api->is_element( $element_id );
}

/**
 * Add custom element to page content builder.
 *
 * @since 1.0.0
 */
function anva_add_builder_element( $element_id, $name, $icon, $attr, $desc, $content ) {
	$api = Anva_Content_Builder_API::instance();
	$api->add_element( $element_id, $name, $icon, $attr, $desc, $content );
}

/**
 * Remove element from page content builder.
 *
 * @since 1.0.0
 */
function anva_remove_builder_element( $element_id ) {
	$api = Anva_Content_Builder_API::instance();
	$api->remove_element( $element_id );
}

/**
 * Add sidebar location.
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_location( $id, $name, $desc = '' ) {
	$api = Anva_Sidebars_API::instance();
	$api->add_location( $id, $name, $desc );
}

/**
 * Remove sidebar location.
 * 
 * @since 1.0.0
 */
function anva_remove_sidebar_location( $id ) {
	$api = Anva_Sidebars_API::instance();
	$api->remove_location( $id );
}

/**
 * Get sidebar locations.
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_locations() {
	$api = Anva_Sidebars_API::instance();
	return $api->get_locations();
}

/**
 * Get sidebar location name or slug name.
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_location_name( $location, $slug = false ) {
	$api = Anva_Sidebars_API::instance();
	$sidebar = $api->get_locations( $location );

	if ( isset( $sidebar['args']['name'] ) ) {
		if ( $slug ) {
			return sanitize_title( $sidebar['args']['name'] );
		}
		return $sidebar['args']['name'];
	}

	return __( 'Widget Area', 'anva' );
}

/**
 * Display sidebar location.
 * 
 * @since 1.0.0
 */
function anva_display_sidebar( $location ) {
	$api = Anva_Sidebars_API::instance();
	$api->display( $location );
}

/**
 * Add sidebar arguments when register locations.
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_args( $id, $name, $desc = '', $classes = '' ) {
	if ( ! empty( $classes ) ) {
		$classes = ' ' . $classes;
	}
	$args = array(
		'id'            => $id,
		'name'          => $name,
		'description'   => $desc,
		'before_widget' => '<div id="%1$s" class="widget %2$s'. esc_attr( $classes ) .'">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	);
	return apply_filters( 'anva_add_sidebar_args', $args );
}

/**
 * Add stylesheet.
 * 
 * @since 1.0.0
 */
function anva_add_stylesheet( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
	$api = Anva_Stylesheets_API::instance();
	$api->add( $handle, $src, $level, $ver, $media );
}

/**
 * Remove stylesheet.
 * 
 * @since 1.0.0
 */
function anva_remove_stylesheet( $handle ) {
	$api = Anva_Stylesheets_API::instance();
	$api->remove( $handle );
}

/**
 * Get framework stylesheets.
 * 
 * @since 1.0.0
 */
function anva_get_stylesheets() {
	$api = Anva_Stylesheets_API::instance();
	$core = $api->get_framework_stylesheets();
	$custom = $api->get_custom_stylesheets();
	return array_merge( $core, $custom );
}

/**
 * Print out styles.
 * 
 * @since 1.0.0
 */
function anva_print_styles( $level ) {
	$api = Anva_Stylesheets_API::instance();
	$api->print_styles( $level );
}

/**
 * Add script.
 *
 * @since 1.0.0
 */
function anva_add_script( $handle, $src, $level = 4, $ver = null, $footer = true ) {
	$api = Anva_Scripts_API::instance();
	$api->add( $handle, $src, $level, $ver, $footer );
}

/**
 * Remove script.
 *
 * @since 1.0.0
 */
function anva_remove_script( $handle ) {
	$api = Anva_Scripts_API::instance();
	$api->remove( $handle );
}

/**
 * Get framework scripts.
 *
 * @since 1.0.0
 */
function anva_get_scripts() {
	$api = Anva_Scripts_API::instance();
	$core = $api->get_framework_scripts();
	$custom = $api->get_custom_scripts();
	return array_merge( $core, $custom );
}

/**
 * Print out scripts.
 *
 * @since 1.0.0
 */
function anva_print_scripts( $level ) {
	$api = Anva_Scripts_API::instance();
	$api->print_scripts( $level );
}

/**
 * Add slider.
 *
 * @since 1.0.0
 */
function anva_add_slider( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options ) {
	$api = Anva_Sliders_API::instance();
	$api->add( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options );
}

/**
 * Remove slider.
 *
 * @since 1.0.0
 */
function anva_remove_slider( $slider_id ) {
	$api = Anva_Sliders_API::instance();
	$api->remove( $slider_id );
}

/**
 * Get framework sliders.
 *
 * @since 1.0.0
 */
function anva_get_sliders( $slider_id = '' ) {
	$api = Anva_Sliders_API::instance();
	return $api->get_sliders( $slider_id );
}

/**
 * Check that the slider ID exists.
 *
 * @deprecated use anva_slider_exists()
 *
 * @since  1.0.0
 * @param  string $slider_id
 * @return string $sldier_id
 */
function anva_is_slider( $slider_id ) {
	anva_deprecated_function( __FUNCTION__, '1.0.0', null, __( 'This function has been deprecated. Use anva_slider_exists() instead.', 'anva' ) );
	$api = Anva_Sliders_API::instance();
	return $api->is_slider( $slider_id );
}

/**
 * Check that the slider ID exists.
 *
 * @since  1.0.0
 * @param  string $slider_id
 * @return string $sldier_id
 */
function anva_slider_exists( $slider_id ) {
	$api = Anva_Sliders_API::instance();
	return $api->is_slider( $slider_id );
}