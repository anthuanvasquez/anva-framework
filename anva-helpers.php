<?php

/**
 * Initialization the Framework's API.
 *
 * @since  1.0.0
 * @return void
 */
function anva_init_api_helpers() {

	// Setup Framework Options.
	Anva_Options::instance();

	// Setup custom options for import export.
	Anva_Options_Import_Export::instance();

	// Setup Framework Stylesheets.
	Anva_Styles::instance();

	// Setup Framework Scripts.
	Anva_Scripts::instance();

	// Setup Framework Sidebars Locations.
	Anva_Sidebars::instance();

	// Setup Framework Sliders.
	Anva_Sliders::instance();

	// Setup Builder Components.
	Anva_Builder_Components::instance();

	// Setup customizer API.
	$GLOBALS['_anva_customizer_sections'] = array();

}

/**
 * Print single option value.
 *
 * @since 1.0.0
 * @param string  $name
 * @param boolean $default
 */
function anva_the_option( $id, $default = false ) {
	// Don't print option with array values.
	if ( is_array( $default ) ) {
		return false;
	}

	echo anva_get_option( $id, $default );
}

/**
 * Get single option value.
 *
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 * Based on "Options Framework" by Devin Price.
 *
 * @link http://wptheming.com
 *
 * @since  1.0.0
 * @param  string               $id
 * @param  string|array|boolean $default
 * @return string|array|boolean $options
 */
function anva_get_option( $id, $default = false ) {
	$options = Anva_Options::instance();
	return $options->get_option( $id, $default );
}

/**
 * Get all saved options values.
 *
 * @since  1.0.0
 * @return array $options
 */
function anva_get_option_all() {
	$options = Anva_Options::instance();
	return $options->get_all();
}

/**
 * Print option name.
 *
 * @since 1.0.0
 */
function anva_the_option_name() {
	echo esc_html( anva_get_option_name() );
}

/**
 * Get option name.
 *
 * @since 1.0.0
 */
function anva_get_option_name() {
	$options = Anva_Options::instance();
	return $options->get_option_name();
}

/**
 * Get formatted options array.
 *
 * @since  1.0.0
 * @return array $options
 */
function anva_get_options() {
	$options = Anva_Options::instance();
	return $options->get_formatted_options();
}

/**
 * Get default options values.
 *
 * @since  1.0.0
 * @return array $options
 */
function anva_get_default_options_values() {
	$options = Anva_Options::instance();
	return $options->get_default_values();
}

/**
 * Add theme option tab.
 *
 * @since 1.0.0
 * @param string  $tab_id
 * @param string  $tab_name
 * @param boolean $top
 * @param string  $icon
 */
function anva_add_option_tab( $tab_id, $tab_name, $top = false, $icon = 's' ) {
	$options = Anva_Options::instance();
	$options->add_tab( $tab_id, $tab_name, $top, $icon );
}

/**
 * Remove theme option tab.
 *
 * @since 1.0.0
 * @param string $tab_id
 */
function anva_remove_option_tab( $tab_id ) {
	$options = Anva_Options::instance();
	$options->remove_tab( $tab_id );
}

/**
 * Add theme option section.
 *
 * @since  1.0.0
 * @param  string  $tab_id       Tab ID.
 * @param  string  $section_id   Section ID.
 * @param  string  $section_name Sectio name.
 * @param  string  $section_desc Section description.
 * @param  array   $options      Options array group for section.
 * @param  boolean $top          Move sectopn to the top.
 */
function anva_add_option_section( $tab_id, $section_id, $section_name, $section_desc = null, $options = null, $top = false ) {
	$options_section = Anva_Options::instance();
	$options_section->add_section( $tab_id, $section_id, $section_name, $section_desc, $options, $top );
}

/**
 * Remove theme option section.
 *
 * @since 1.0.0
 */
function anva_remove_option_section( $tab_id, $section_id ) {
	$options = Anva_Options::instance();
	$options->remove_section( $tab_id, $section_id );
}

/**
 * Add theme option.
 *
 * @since 1.0.0
 */
function anva_add_option( $tab_id, $section_id, $option_id, $option ) {
	$options = Anva_Options::instance();
	$options->add_option( $tab_id, $section_id, $option_id, $option );
}

/**
 * Remove theme option.
 *
 * @since 1.0.0
 */
function anva_remove_option( $tab_id, $section_id, $option_id ) {
	$options = Anva_Options::instance();
	$options->remove_option( $tab_id, $section_id, $option_id );
}

/**
 * Edit theme option.
 *
 * @since 1.0.0
 */
function anva_edit_option( $tab_id, $section_id, $option_id, $att, $value ) {
	$options = Anva_Options::instance();
	$options->edit_option( $tab_id, $section_id, $option_id, $att, $value );
}

/**
 * Get all core elements of Page Builder
 *
 * @since 1.0.0
 */
function anva_get_core_elements() {
	$api = Anva_Builder_Components::instance();
	return $api->get_core_elements();
}

/**
 * Get layout builder's elements after new elements
 * have been given a chance to be added at the theme-level.
 *
 * @since 1.0.0
 */
function anva_get_elements() {
	$api = Anva_Builder_Components::instance();
	return $api->get_elements();
}

/**
 * Check that the element ID exists.
 *
 * @since  1.0.0
 * @param  string $element_id
 * @return string $element_id
 */
function anva_element_exists( $element_id ) {
	$api = Anva_Builder_Components::instance();
	return $api->is_element( $element_id );
}

/**
 * Add custom element to page content builder.
 *
 * @since 1.0.0
 */
function anva_add_builder_Components( $element_id, $name, $icon, $attr, $desc, $content ) {
	$api = Anva_Builder_Components::instance();
	$api->add_element( $element_id, $name, $icon, $attr, $desc, $content );
}

/**
 * Remove element from page content builder.
 *
 * @since 1.0.0
 */
function anva_remove_builder_Components( $element_id ) {
	$api = Anva_Builder_Components::instance();
	$api->remove_element( $element_id );
}

/**
 * Add sidebar location.
 *
 * @since 1.0.0
 */
function anva_add_sidebar_location( $id, $name, $desc = '' ) {
	$api = Anva_Sidebars::instance();
	$api->add_location( $id, $name, $desc );
}

/**
 * Remove sidebar location.
 *
 * @since 1.0.0
 */
function anva_remove_sidebar_location( $id ) {
	$api = Anva_Sidebars::instance();
	$api->remove_location( $id );
}

/**
 * Get sidebar locations.
 *
 * @since 1.0.0
 */
function anva_get_sidebar_locations() {
	$api = Anva_Sidebars::instance();
	return $api->get_locations();
}

/**
 * Get sidebar location name or slug name.
 *
 * @since 1.0.0
 */
function anva_get_sidebar_location_name( $location, $slug = false ) {
	$sidebars = Anva_Sidebars::instance();
	$sidebar  = $sidebars->get_locations( $location );

	if ( isset( $sidebar['args']['name'] ) ) {
		if ( $slug ) {
			return sanitize_title( $sidebar['args']['name'] );
		}
		return $sidebar['args']['name'];
	}

	return esc_html__( 'Widget Area', 'anva' );
}

/**
 * Display sidebar location.
 *
 * @since 1.0.0
 */
function anva_display_sidebar( $location ) {
	$sidebars = Anva_Sidebars::instance();
	$sidebars->display( $location );
}

/**
 * Add sidebar arguments when register locations.
 *
 * @since  1.0.0
 * @param  array $args Arguments list.
 * @return array $args Argumetns list.
 */
function anva_get_sidebar_args( $args ) {

	$class = '';

	if ( isset( $args['class'] ) && ! empty( $args['class'] ) ) {
		$class = $args['class'];
	}

	// Set up some default sidebar arguments.
	$defaults = array(
		'id'            => '',
		'name'          => '',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s' . esc_attr( $class ) . '">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	);

	// Parse the arguments.
	$args = wp_parse_args( $args, apply_filters( 'anva_sidebar_defaults', $defaults ) );

	return apply_filters( 'anva_sidebar_args', $args );
}

/**
 * Add stylesheet.
 *
 * @since 1.0.0
 */
function anva_add_stylesheet( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
	$api = Anva_Styles::instance();
	$api->add( $handle, $src, $level, $ver, $media );
}

/**
 * Remove stylesheet.
 *
 * @since 1.0.0
 */
function anva_remove_stylesheet( $handle ) {
	$api = Anva_Styles::instance();
	$api->remove( $handle );
}

/**
 * Get framework stylesheets.
 *
 * @since 1.0.0
 */
function anva_get_stylesheets() {
	$api    = Anva_Styles::instance();
	$core   = $api->get_framework_stylesheets();
	$custom = $api->get_custom_stylesheets();
	return array_merge( $core, $custom );
}

/**
 * Print out styles.
 *
 * @since 1.0.0
 */
function anva_print_styles( $level ) {
	$api = Anva_Styles::instance();
	$api->print_styles( $level );
}

/**
 * Add script.
 *
 * @since 1.0.0
 */
function anva_add_script( $handle, $src, $level = 4, $ver = null, $footer = true ) {
	$api = Anva_Scripts::instance();
	$api->add( $handle, $src, $level, $ver, $footer );
}

/**
 * Remove script.
 *
 * @since 1.0.0
 */
function anva_remove_script( $handle ) {
	$api = Anva_Scripts::instance();
	$api->remove( $handle );
}

/**
 * Get framework scripts.
 *
 * @since 1.0.0
 */
function anva_get_scripts() {
	$api    = Anva_Scripts::instance();
	$core   = $api->get_framework_scripts();
	$custom = $api->get_custom_scripts();
	return array_merge( $core, $custom );
}

/**
 * Print out scripts.
 *
 * @since 1.0.0
 */
function anva_print_scripts( $level ) {
	$api = Anva_Scripts::instance();
	$api->print_scripts( $level );
}

/**
 * Add slider.
 *
 * @since 1.0.0
 */
function anva_add_slider( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options ) {
	$api = Anva_Sliders::instance();
	$api->add( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options );
}

/**
 * Remove slider.
 *
 * @since 1.0.0
 */
function anva_remove_slider( $slider_id ) {
	$api = Anva_Sliders::instance();
	$api->remove( $slider_id );
}

/**
 * Get framework sliders.
 *
 * @since 1.0.0
 */
function anva_get_sliders( $slider_id = '' ) {
	$api = Anva_Sliders::instance();
	return $api->get_sliders( $slider_id );
}

/**
 * Check that the slider ID exists.
 *
 * @since  1.0.0
 * @param  string $slider_id
 * @return string $sldier_id
 */
function anva_slider_exists( $slider_id ) {
	$api = Anva_Sliders::instance();
	return $api->is_slider( $slider_id );
}
