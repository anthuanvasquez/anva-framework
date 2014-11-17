<?php

/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */

define( 'THEME_ID', 'theme' );
define( 'THEME_VERSION', '1.0.0');
define( 'OF_ADMIN', get_template_directory_uri() . '/framework/admin/' );

include_once ( get_template_directory() . '/framework/admin/options-framework.php' );
include_once ( get_template_directory() . '/framework/admin/options.php' );
include_once ( get_template_directory() . '/framework/admin/includes/general.php' );
include_once ( get_template_directory() . '/framework/admin/includes/display.php' );

include_once ( get_template_directory() . '/framework/init.php' );

/* 
 * Change the options.php directory.
 */
function theme_options_location() {
	return  '/framework/admin/options.php';
}
add_filter( 'options_framework_location', 'theme_options_location' );

/*
 * This is an example of filtering menu parameters
 */
function theme_options_menu_filter( $menu ) {

	$options_framework = new Options_Framework;
	$option_name = $options_framework->get_option_name();

	$menu['mode'] = 'menu';
	$menu['page_title'] = __( 'Theme Options', OF_DOMAIN );
	$menu['menu_title'] = __( 'Theme Options', OF_DOMAIN );
	$menu['menu_slug']  = $option_name;
	return $menu;
}
add_filter( 'optionsframework_menu', 'theme_options_menu_filter' );

/**
 * Setup theme.
 */
function theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Google fonts using by the theme.
 */
function theme_google_fonts() {
	of_enqueue_google_fonts(
		of_get_option('body_font'),
		of_get_option('heading_font')
	);
}
add_action('wp_enqueue_scripts', 'theme_google_fonts');

// Theme scripts
function theme_scripts() {

	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'superfish' );
	wp_enqueue_script( 'hoverIntent' );
	wp_enqueue_script( 'lightbox' );	
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/assets/js/ronin.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'theme-js', 'OF_OBJ', of_get_js_locals() );

}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

// Theme CSS
function theme_stylesheets() {
	
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'theme-screen', get_template_directory_uri() . '/assets/css/screen.css' );
	wp_enqueue_style( 'theme-skin', get_template_directory_uri() . '/assets/css/colors.css' );

	if ( 1 == of_get_option( 'responsive' ) ) {
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array( 'screen' ), false, 'all' );
	}

	// Inline styles from theme options
	// Note: Using skin_colors as $handle because it's the only
	// constant stylesheet just before screen.css
	wp_add_inline_style( 'theme-skin', theme_styles() );

}
add_action( 'wp_enqueue_scripts', 'theme_stylesheets' );

/**
 * Body Classes
 *
 * Here we filter WordPress's default body_class()
 * function to include necessary classes for Main
 * Styles selected in Theme Options panel.
 */
function theme_body_classes( $classes ) {
	$classes[] = 'layout_' . of_get_option( 'layout_style' );
	$classes[] = 'skin_' . of_get_option( 'skin' );
	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

/**
 * Custom Styles 
 */
function theme_styles() {
	$styles = '';
	$custom_css = of_get_option( 'custom_css' );
	$body_font = of_get_option( 'body_font' );
	$heading_font = of_get_option( 'heading_font' );
	$background_color = of_get_option( 'background_color' );
	$background_pattern = of_get_option( 'background_pattern' );

	ob_start();
	?>
	/* Typography */
	html,
	body {
		font-family: <?php echo of_get_font_face( $body_font ); ?>;
		font-size: <?php echo of_get_font_size( $body_font ); ?>;
		font-style: <?php echo of_get_font_style( $body_font ); ?>;
		font-weight: <?php echo of_get_font_weight( $body_font ); ?>;
	}
	h1, h2, h3, h4, h5, h6, .slide-title, .entry-title {
		font-family: <?php echo of_get_font_face( $heading_font ); ?>;
		font-style: <?php echo of_get_font_style( $heading_font ); ?>;
		font-weight: <?php echo of_get_font_weight( $heading_font ); ?>;
	}
	/* Background */
	body {
		background: <?php echo esc_html( $background_color ); ?>;
		<?php if ( '' == $background_pattern ) : ?>
		background-image: none;
		<?php else : ?>
		background-image: url(<?php echo of_get_background_pattern( $background_pattern ); ?>);
		background-repeat: repeat;
		<?php endif; ?>
	}
	<?php
	$styles = ob_get_clean();

	// Add custom CSS
	if ( $custom_css ) {
		$styles .= "\n/* Custom CSS */\n";
		$styles .= $custom_css;
	}

	// Compress output
	return of_compress( $styles );
}
add_action( 'wp_enqueue_scripts', 'theme_styles', 20 );