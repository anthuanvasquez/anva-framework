<?php

// Instantiate the import export options
Anva_Options_Import_Export::instance();

/**
 * Init admin modules.
 *
 * @since 1.0.0
 * @return void
 */
function anva_admin_init() {

	// Instantiate the options page
	Anva_Options_Page::instance();

	// Instantiate the media uploader class
	Anva_Options_Media_Uploader::instance();

}

/**
 * Gets option name.
 *
 * @since 1.0.0
 */
function anva_get_option_name() {

	$name = '';

	// Gets option name as defined in the theme
	if ( function_exists( 'anva_option_name' ) ) {
		$name = anva_option_name();
	}

	// Fallback
	if ( '' == $name ) {
		$name = get_option( 'stylesheet' );
		$name = preg_replace( "/\W/", "_", strtolower( $name ) );
	}

	return apply_filters( 'anva_option_name', $name );

}

/**
 * Allows for manipulating or setting options via 'anva_options' filter.
 *
 * @since  1.0.0
 * @return array $options
 */
function anva_get_options() {

	// Get options from api class Anva_Options_API
	$options = anva_get_formatted_options();

	// Allow setting/manipulating options via filters
	$options = apply_filters( 'anva_options', $options );

	return $options;
}

/**
 * Admin Assets.
 *
 * @global $pagenow
 *
 * @since  1.0.0
 */
function anva_admin_assets() {

	global $pagenow;

	// Assets for meta boxes
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
		wp_enqueue_style( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_CSS . 'meta.min.css', array(), ANVA_FRAMEWORK_VERSION );
		wp_enqueue_script( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_JS . 'meta.min.js', array( 'jquery' ), ANVA_FRAMEWORK_VERSION, false );
	}

	// Sweet Alert
	wp_enqueue_script( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.js', array( 'jquery' ), '1.1.3', false );
	wp_enqueue_style( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.css', array(), '1.1.3' );

	// Admin Global
	wp_enqueue_script( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_JS . 'admin-global.min.js', array( 'jquery', 'wp-color-picker' ), ANVA_FRAMEWORK_VERSION, false );
	wp_enqueue_style( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-global.min.css', array(), ANVA_FRAMEWORK_VERSION );
	wp_enqueue_style( 'anva_admin_responive', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-responsive.min.css', array(), ANVA_FRAMEWORK_VERSION );

}

/**
 * Get options page menu settings.
 *
 * @since  1.0.0
 * @return array $options_page
 */
function anva_get_options_page_menu() {
	$options_page = new Anva_Options_Page;
	return $options_page->menu_settings();
}

/**
 * Get default options.
 *
 * @since  1.0.0
 * @return array Default Options
 */
function anva_get_option_defaults() {
	$options_page = new Anva_Options_Page;
	return $options_page->get_default_values();
}

/**
 * Register a new meta box.
 *
 * @since  1.0.0
 */
function anva_add_meta_box( $id, $args, $options ) {
	new Anva_Meta_Box( $id, $args, $options );
}
