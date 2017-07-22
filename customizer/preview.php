<?php

/**
 * Styles for WordPress customizer.
 *
 * @since  1.0.0
 */
function anva_customizer_styles() {
	wp_register_style( 'anva_customizer', Anva::$framework_dir_uri . 'admin/assets/css/customizer.css', false, Anva::$version );
	wp_enqueue_style( 'anva_customizer' );
}

/**
 * Scripts for WordPress customizer.
 *
 * @since  1.0.0
 */
function anva_customizer_scripts() {
	wp_register_script( 'anva_customizer', Anva::$framework_dir_uri . 'admin/assets/js/customizer.js', array( 'jquery' ), Anva::get_version() );
	wp_enqueue_script( 'anva_customizer' );
	wp_localize_script( 'anva_customizer', 'AnvaCustomizerLocal', anva_get_admin_locals( 'customizer_js' ) );
}

/**
 * The actions added here are triggered only in the Previewer
 * and not in the Customizer.
 *
 * @since  1.0.0
 */
function my_customize_preview_init() {
	add_action( 'wp_enqueue_scripts', 'anva_customize_preview_enqueue_scripts' );
}

/**
 * Scripts for WordPress customizer preview.
 *
 * @since  1.0.0
 */
function anva_customize_preview_enqueue_scripts() {
	wp_enqueue_script( 'anva_customizer_preview', Anva::$framework_dir_uri . 'admin/assets/js/customizer-preview.js', array( 'customize-preview' ), Anva::get_version(), true );
	wp_localize_script( 'anva_customizer_preview', 'AnvaCustomizerPreview', anva_get_customizer_preview_locals() );
}

/**
 * Get all js locals (not admin).
 *
 * @since  1.0.0
 * @return array $localize
 */
function anva_get_customizer_preview_locals() {

	$option_name = anva_get_option_name();

	// ---------------------------------------
	// Setup for logo
	// ---------------------------------------
	$logo_options = anva_get_option( 'logo' );

	$logo_atts = array(
		'type'           => '',
		'site_url'       => home_url(),
		'title'          => get_bloginfo( 'name' ),
		'tagline'        => get_bloginfo( 'description' ),
		'custom'         => '',
		'custom_tagline' => '',
		'image'          => '',
	);

	foreach ( $logo_atts as $key => $value ) {
		if ( isset( $logo_options[ $key ] ) ) {
			$logo_atts[ $key ] = $logo_options[ $key ];
		}
	}

	// ------------------------------------------
	// Fonts
	// ------------------------------------------
	// Setup font stacks
	$font_stacks = anva_get_font_stacks();
	unset( $font_stacks['google'] );

	// Determine current google fonts with fake
	// booleans to be used in printed JS object.
	$types = array( 'body', 'heading' );
	$google_fonts = array();

	foreach ( $types as $type ) {
		$font = anva_get_option( $type . '_font' );
		$google_fonts[ $type . 'Name' ] = ! empty( $font['google'] ) && $font['google'] ? $font['google'] : '';
	}

	$localize = array(
		'optionName'    => $option_name,
		'templateUrl'   => trailingslashit( get_template_directory_uri() ),
		'frameworkUrl'  => Anva::$framework_dir_uri,
		'logo'          => json_encode( $logo_atts ),
		'fontStacks'    => json_encode( $font_stacks ),
		'googleFonts'   => json_encode( $google_fonts ),
	);

	return apply_filters( 'anva_js_locals', $localize );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since  1.0.0.
 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function anva_customizer_register_blog( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}

/**
 * Allow "refresh" transport type settings to work right in the customizer.
 *
 * @since  1.0.0
 * @return void
 */
function anva_customizer_preview() {

	global $wp_customize;

	// Check if customizer is running.
	if ( ! is_a( $wp_customize, 'WP_Customize_Manager' ) ) {
		return;
	}

	$wp_customize->is_preview();

}
