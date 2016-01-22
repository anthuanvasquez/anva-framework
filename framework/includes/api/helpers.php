<?php

/**
 * Init framework API
 * 
 * @since 1.0.0
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
	Anva_Builder_Elements_API::instance();
	
}

/* ---------------------------------------------------------------- */
/* (0) Helpers - Options Framework
/* ---------------------------------------------------------------- */

if ( ! function_exists( 'anva_get_option' ) ) :
/**
 * Get theme option value
 * 
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * @since 1.0.0
 */
function anva_get_option( $name, $default = false ) {

	$option_name = '';

	// Gets option name as defined in the theme
	if ( function_exists( 'optionsframework_option_name' ) ) {
		$option_name = optionsframework_option_name();
	}

	// Fallback option name
	if ( '' == $option_name ) {
		$option_name = get_option( 'stylesheet' );
		$option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) ); // correct name is $option_name
	}

	// Get option settings from database
	$options = get_option( $option_name );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}
	
	return $default;
}
endif;

if ( ! function_exists( 'anva_the_option' ) ) :
/**
 * This is for print theme option value
 * 
 * @since 1.0.0
 */
function anva_the_option( $name, $default = false ) {
	echo anva_get_option( $name, $default );
}
endif;

if ( ! function_exists( 'anva_get_option_name' ) ) :
/**
 * Get theme option name
 * 
 * @since 1.0.0
 */
function anva_get_option_name() {
	$options_framework = new Options_Framework;
	return $options_framework->get_option_name();
}
endif;

if ( ! function_exists( 'anva_get_options' ) ) :
/**
 * Get core and theme options
 * 
 * @since 1.0.0
 */
function anva_get_options() {
	$options_framework = new Options_Framework;
	return $options_framework->get_options();
}
endif;

/**
 * Optiosframework tabs
 * 
 * @since 1.0.0
 */
function anva_get_options_tabs( $options ) {
	$options_framework_interface = new Options_Framework_Interface;
	return $options_framework_interface->get_tabs( $options );
}

/**
 * Get optionsframework fields
 * 
 * @since 1.0.0
 */
function anva_get_options_fields(  $option_name, $settings, $options ) {
	$options_framework_interface = new Options_Framework_Interface;
	return $options_framework_interface->get_fields(  $option_name, $settings, $options );
}

if ( ! function_exists( 'anva_get_option_defaults' ) ) :
/**
 * Get default options
 * 
 * @since 1.0.0
 */
function anva_get_option_defaults() {
	$options_framework = new Options_Framework_Admin;
	return $options_framework->get_default_values();
}
endif;

if ( ! function_exists( 'anva_get_admin_menu_settings' ) ) :
/**
 * Get optionsframework menu settings
 * 
 * @since 1.0.0
 */
function anva_get_admin_menu_settings() {
	$options_framework = new Options_Framework_Admin;
	return $options_framework->menu_settings();
}
endif;

/* ---------------------------------------------------------------- */
/* (1) Helpers - Anva Core Options API
/* ---------------------------------------------------------------- */

if ( ! function_exists( 'anva_get_core_options' ) ) :
/**
 * Get raw options. This helper function is more
 * for backwards compatibility. Realistically, it
 * doesn't have much use unless an old plugin is
 * still using it.
 *
 * @since 1.0.0
 */
function anva_get_core_options() {
	$api = Anva_Options_API::instance();
	return $api->get_raw_options();
}
endif;

if ( ! function_exists( 'anva_get_formatted_options' ) ) :
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
endif;

if ( ! function_exists( 'anva_add_option_tab' ) ) :
/**
 * Add theme option tab
 *
 * @since 1.0.0
 */
function anva_add_option_tab( $tab_id, $tab_name, $top = false ) {
	$api = Anva_Options_API::instance();
	$api->add_tab( $tab_id, $tab_name, $top );
}
endif;

if ( ! function_exists( 'anva_remove_option_tab' ) ) :
/**
 * Remove theme option tab
 *
 * @since 1.0.0
 */
function anva_remove_option_tab( $tab_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_tab( $tab_id );
}
endif;

if ( ! function_exists( 'anva_add_option_section' ) ) :
/**
 * Add theme option section
 *
 * @since 1.0.0
 */
function anva_add_option_section( $tab_id, $section_id, $section_name, $section_desc = null, $options = null, $top = false ) {
	$api = Anva_Options_API::instance();
	$api->add_section( $tab_id, $section_id, $section_name, $section_desc, $options, $top );
}
endif;

if ( ! function_exists( 'anva_remove_option_section' ) ) :
/**
 * Remove theme option section
 *
 * @since 1.0.0
 */
function anva_remove_option_section( $tab_id, $section_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_section( $tab_id, $section_id );
}
endif;

if ( ! function_exists( 'anva_add_option' ) ) :
/**
 * Add theme option
 *
 * @since 1.0.0
 */
function anva_add_option( $tab_id, $section_id, $option_id, $option ) {
	$api = Anva_Options_API::instance();
	$api->add_option( $tab_id, $section_id, $option_id, $option );
}
endif;

if ( ! function_exists( 'anva_remove_option' ) ) :
/**
 * Remove theme option
 *
 * @since 1.0.0
 */
function anva_remove_option( $tab_id, $section_id, $option_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_option( $tab_id, $section_id, $option_id );
}
endif;

if ( ! function_exists( 'anva_edit_option' ) ) :
/**
 * Edit theme option
 *
 * @since 1.0.0
 */
function anva_edit_option( $tab_id, $section_id, $option_id, $att, $value ) {
	$api = Anva_Options_API::instance();
	$api->edit_option( $tab_id, $section_id, $option_id, $att, $value );
}
endif;


/*------------------------------------------------------------*/
/* (2) Helpers - Anva Page Builder Elements API
/*------------------------------------------------------------*/

/**
 * Get all core elements of Page Builder
 *
 * @since 1.0.0
 */
function anva_get_core_elements() {
	$api = Anva_Builder_Elements_API::instance();
	return $api->get_core_elements();
}

/**
 * Setup all core theme options of framework, which can
 * then be altered at the theme level.
 *
 * @since 1.0.0
 */
function anva_get_registered_elements() {
	$api = Anva_Builder_Elements_API::instance();
	return $api->get_registered_elements();
}

/**
 * Get layout builder's elements after new elements
 * have been given a chance to be added at the theme-level.
 *
 * @since 1.0.0
 */
function anva_get_elements() {
	$api = Anva_Builder_Elements_API::instance();
	return $api->get_elements();
}

/**
 * Check if element is currently registered
 *
 * @since 1.0.0
 */
function anva_is_element( $element_id ) {
	$api = Anva_Builder_Elements_API::instance();
	return $api->is_element( $element_id );
}

/**
 * Add element to page builder
 *
 * @since 1.0.0
 */
function anva_add_builder_element( $element_id, $name, $icon, $attr, $desc, $content ) {
	$api = Anva_Builder_Elements_API::instance();
	$api->add_element( $element_id, $name, $icon, $attr, $desc, $content );
}

/**
 * Remove element from page builder
 *
 * @since 1.0.0
 */
function anva_remove_builder_element( $element_id ) {
	$api = Anva_Builder_Elements_API::instance();
	$api->remove_element( $element_id );
}

/**
 * Add block to page builder single element
 *
 * @since 1.0.0
 */
function anva_add_block_element( $args ) {
	$api = Anva_Builder_Elements_API::instance();
	$api->add_block( $args );
}

function anva_is_block_element( $element_id, $block_id ) {
	$api = Anva_Builder_Elements_API::instance();
	return $api->is_block( $element_id, $block_id );
}

/* ---------------------------------------------------------------- */
/* (3) Helpers - Anva Sidebar Locations API
/* ---------------------------------------------------------------- */

/**
 * Add sidebar location
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_location( $id, $name, $desc = '' ) {
	$api = Anva_Sidebars_API::instance();
	$api->add_location( $id, $name, $desc );
}

/**
 * Remove sidebar location
 * 
 * @since 1.0.0
 */
function anva_remove_sidebar_location( $id ) {
	$api = Anva_Sidebars_API::instance();
	$api->remove_location( $id );
}

/**
 * Get sidebar locations
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_locations() {
	$api = Anva_Sidebars_API::instance();
	return $api->get_locations();
}

/**
 * Get sidebar location name or slug name
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
 * Display sidebar location
 * 
 * @since 1.0.0
 */
function anva_display_sidebar( $location ) {
	$api = Anva_Sidebars_API::instance();
	$api->display( $location );
}

/**
 * Add sidebar args when register locations
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
		'before_widget' => '<div id="%1$s" class="widget %2$s'. esc_attr( $classes ) .'"><div class="widget-inner clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);
	return apply_filters( 'anva_add_sidebar_args', $args );
}

/* ---------------------------------------------------------------- */
/* (4) Helpers - Anva Front End Stylesheets
/* ---------------------------------------------------------------- */

/**
 * Add custom stylesheet
 * 
 * @since 1.0.0
 */
function anva_add_stylesheet( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
	$api = Anva_Stylesheets_API::instance();
	$api->add( $handle, $src, $level, $ver, $media );
}

/**
 * Remove custom stylesheet
 * 
 * @since 1.0.0
 */
function anva_remove_stylesheet( $handle ) {
	$api = Anva_Stylesheets_API::instance();
	$api->remove( $handle );
}

/**
 * Get stylesheets
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
 * Print out styles
 * 
 * @since 1.0.0
 */
function anva_print_styles( $level ) {
	$api = Anva_Stylesheets_API::instance();
	$api->print_styles( $level );
}

/* ---------------------------------------------------------------- */
/* (5) Helpers - Anva Front End Scripts
/* ---------------------------------------------------------------- */

/**
 * Add custom script
 *
 * @since 1.0.0
 */
function anva_add_script( $handle, $src, $level = 4, $ver = null, $footer = true ) {
	$api = Anva_Scripts_API::instance();
	$api->add( $handle, $src, $level, $ver, $footer );
}

/**
 * Remove custom script
 *
 * @since 1.0.0
 */
function anva_remove_script( $handle ) {
	$api = Anva_Scripts_API::instance();
	$api->remove( $handle );
}

/**
 * Get scripts
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
 * Print out scripts
 *
 * @since 1.0.0
 */
function anva_print_scripts( $level ) {
	$api = Anva_Scripts_API::instance();
	$api->print_scripts( $level );
}

/* ---------------------------------------------------------------- */
/* (6.5) Helpers - Sliders
/* ---------------------------------------------------------------- */

/**
 * Add slider type
 *
 * @since 1.0.0
 */
function anva_add_slider( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options ) {
	$api = Anva_Sliders_API::instance();
	$api->add( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options );
}

/**
 * Remove slider type
 *
 * @since 1.0.0
 */
function anva_remove_slider( $slider_id ) {
	$api = Anva_Sliders_API::instance();
	$api->remove( $slider_id );
}

/**
 * Get sliders
 *
 * @since 1.0.0
 */
function anva_get_sliders( $slider_id = '' ) {
	$api = Anva_Sliders_API::instance();
	return $api->get_sliders( $slider_id );
}

/**
 * Check if slider type
 *
 * @since 1.0.0
 */
function anva_is_slider( $slider_id ) {
	$api = Anva_Sliders_API::instance();
	return $api->is_slider( $slider_id );
}

/* ---------------------------------------------------------------- */
/* (6) Helpers - Meta Box API
/* ---------------------------------------------------------------- */

/**
 * Add new meta box with ID, Arguments and Options
 *
 * @since  1.0.0
 * @return Instance of Class
 */
function anva_add_new_meta_box( $id, $args, $options ) {
	$meta_box = new Anva_Meta_Box( $id, $args, $options );
}

/**
 * Get field
 *
 * @since  1.0.0
 * @return string The field from meta box array settings
 */
function anva_get_field( $field, $default = false ) {

	global $post;

	$id = null;
	$page = array();
	$typenow = '';

	// Only WP Admin
	if ( is_admin() ) {
		global $typenow;
	}
	
	// Get meta for pages
	if ( is_page() ) {
		$page = anva_setup_page_meta();
	}

	// Get meta for posts
	if ( $post->post_type == 'post' ) {
		$page = anva_setup_post_meta();
	}

	// Get meta for portfolio
	if ( $post->post_type == 'portfolio' ) {
		$page = anva_setup_portfolio_meta();
	}

	// Get meta for galleries
	if ( $post->post_type == 'galleries' ) {
		$page = anva_setup_gallery_meta();
	}

	// Get meta for slideshows
	if ( $post->post_type == 'slideshows' || isset( $typenow ) && 'slideshows' == $typenow ) {
		$page = anva_setup_slider_meta();
	}

	// Get ID
	if ( isset( $page['args']['id'] ) ) {
		$id = $page['args']['id'];
	}

	// Validate if ID exist
	if ( ! is_null( $id ) ) {
		$fields = anva_get_post_meta( $id );
		if ( isset( $fields[$field] ) ) {
			return $fields[$field];
		}
	}

	return $default;
}

/**
 * Show field
 *
 * @since  1.0.0
 * @return string The field from anva_get_field()
 */
function anva_the_field( $field, $default = false ) {
	echo anva_get_field( $field, $default );
}

/**
 * Get gallery field meta
 *
 * @since  1.0.0
 * @return string The page builder field meta
 */
function anva_get_gallery_field() {
	
	$field = false;
	$gallery_meta = anva_setup_gallery_attachments_meta();
	
	if ( isset( $gallery_meta['args']['id'] ) ) {
		$field = anva_get_post_meta( $gallery_meta['args']['id'] );
	}

	return $field;
}

/**
 * Get page builder field meta
 *
 * @since  1.0.0
 * @return string The page builder field meta
 */
function anva_get_page_builder_field() {
	
	$field = false;
	$page_builder_meta = anva_setup_page_builder_meta();

	if ( isset( $page_builder_meta['args']['id'] ) ) {
		$field = anva_get_post_meta( $page_builder_meta['args']['id'] );
	}

	return $field;
}