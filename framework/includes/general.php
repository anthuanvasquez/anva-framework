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
	) );
}

/*
 * Register widgets areas.
 */
function of_register_sidebars() {

	register_sidebar(
		of_get_widget_args( 'main-sidebar', 'main_sidebar_title', 'main_sidebar_desc' )
	);

	register_sidebar(
		of_get_widget_args( 'sidebar-left', 'sidebar_left_title', 'sidebar_left_desc' )
	);

	register_sidebar(
		of_get_widget_args( 'sidebar-right', 'sidebar_right_title', 'sidebar_right_desc' )
	);

	register_sidebar(
		of_get_widget_args( 'home-sidebar', 'home_sidebar_title', 'home_sidebar_desc' )
	);

	register_sidebar(
		of_get_widget_args( 'footer-sidebar', 'footer_sidebar_title', 'footer_sidebar_desc' )
	);

}

/*
 * Enqueue custom Javascript & Stylesheets using wp_enqueue_script() and wp_enqueue_style().
 */
function of_load_scripts() {
	
	// Load Stylesheets
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'screen', get_template_directory_uri() . '/assets/css/screen.css' );
	
	if ( 1 == of_get_option( 'responsive' ) ) {
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array( 'screen' ), false, 'all' );
	}
	
	// Load Scripts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'main', 'of_FRAMEWORK', of_get_js_locals() );

}

/*
 * Hide wordpress version number.
 */
function of_kill_version() {
	return '';
}

/*
 * Add class to posts_link_next() and previous.
 * @since 1.3.1
 */
function of_posts_link_attr() {
	return 'class="button button-link"';
}

function of_post_link_attr( $output ) {
	$class = 'class="button button-link"';
	return str_replace('<a href=', '<a '. $class .' href=', $output);
}

/**
 * Include post types in search page
 * @since 1.5.1
 */
function of_search_filter( $query ) {

	$post_types = array(
		'post',
		'page'
	);

	if ( ! class_exists( 'Woocommerce' ) ) {
		if ( ! $query->is_admin && $query->is_search ) {
			$query->set( 'post_type', apply_filters( 'of_search_filter_post_types', $post_types ) );
		}
	}
	
	return $query;
}

function of_posts_columns_head( $columns ) {
	$columns['featured_image'] = of_get_local( 'featured_image' );
	return $columns;
}