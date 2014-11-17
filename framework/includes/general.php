<?php

/**
 * Make theme available for translations
 * @since 1.0.0
 */
function of_theme_texdomain() {
	load_theme_textdomain( OF_DOMAIN, get_template_directory() . '/languages' );
}

/*
 * Register menus.
 */
function of_register_menus() {

	/* Register Menus */
	register_nav_menus( array(
		'primary' 	=> of_get_local( 'menu_primary' ),
		'secondary' => of_get_local( 'menu_secondary' )
	));

}

/*
 * Register widgets areas.
 */
function of_register_sidebars() {

	register_sidebar(
		of_get_widget_args(
			'main_sidebar',
			'main_sidebar_title',
			'main_sidebar_desc'
		)
	);

	register_sidebar(
		of_get_widget_args(
			'sidebar_left',
			'sidebar_left_title',
			'sidebar_left_desc'
		)
	);

	register_sidebar(
		of_get_widget_args(
			'sidebar_right',
			'sidebar_right_title',
			'sidebar_right_desc'
		)
	);

	register_sidebar(
		of_get_widget_args(
			'footer_sidebar',
			'footer_sidebar_title',
			'footer_sidebar_desc'
		)
	);

}

/**
 * Register Javascript & Stylesheets
 */
function of_register_scripts() {
	
	// Register stylsheets
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '', 'all' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '', 'all' );

	// Register javascripts
	wp_register_script( 'fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'superfish', get_template_directory_uri() . '/assets/js/superfish.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'hoverIntent', get_template_directory_uri() . '/assets/js/hoverIntent.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'lightbox', get_template_directory_uri() . '/assets/js/lightbox.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '', true );
	
}

/**
 * Compress output.
 *
 * @param string $buffer Text to compress
 * @param string $buffer Buffered text
 * @return array $buffer Compressed text
 */
function of_compress( $buffer ) {

	// Remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

	return $buffer;
}