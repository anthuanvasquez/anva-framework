<?php

/**
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 *
 */
define( 'OF_DIRECTORY', get_template_directory() . '/framework' );
define( 'OF_URL', get_template_directory_uri() . '/framework' );
define( 'OF_DOMAIN', '_of' );

// Include Files
include_once( OF_DIRECTORY . '/includes/actions.php' );
include_once( OF_DIRECTORY . '/includes/display.php' );
include_once( OF_DIRECTORY . '/includes/meta.php' );
include_once( OF_DIRECTORY . '/includes/helpers.php' );
include_once( OF_DIRECTORY . '/includes/media.php' );
include_once( OF_DIRECTORY . '/includes/locals.php' );
include_once( OF_DIRECTORY . '/includes/parts.php' );
include_once( OF_DIRECTORY . '/includes/general.php' );
include_once( OF_DIRECTORY . '/includes/widgets.php' );
include_once( OF_DIRECTORY . '/includes/shortcodes.php' );
include_once( OF_DIRECTORY . '/plugins/contact-email.php' );
include_once( OF_DIRECTORY . '/plugins/slideshows.php' );

// Admin
add_action( 'optionsframework_after', 'of_admin_footer_after' );

// Initial
add_action( 'init', 'of_register_menus' );
add_action( 'wp', 'of_setup_author' );
add_action( 'wp_enqueue_scripts', 'of_register_scripts' );
add_action( 'widgets_init', 'of_register_sidebars' );
add_action( 'widgets_init', 'of_register_widgets' );
add_action( 'after_setup_theme', 'of_add_image_sizes' );

add_filter( 'wp_page_menu_args', 'of_page_menu_args' );
add_filter( 'body_class', 'of_body_classes' );
add_filter( 'body_class', 'of_browser_class' );
add_filter( 'wp_title', 'of_wp_title', 10, 2 );
add_filter( 'image_size_names_choose', 'of_image_sizes_choose' );

// Header
add_action( 'of_header_content', 'of_header_logo_default' );
add_action( 'of_header_menu', 'of_menu_default' );

// Featured
add_action( 'of_featured', 'of_featured_default' );

// Main
add_action( 'of_main_before', 'of_main_before_default' );
add_action( 'of_main_after', 'of_main_after_default' );
add_action( 'of_breadcrumbs', 'of_breadcrumbs_default' );

// Footer
add_action( 'of_footer_copyright', 'of_footer_copyright_default' );

// Plugin Hooks
add_action( 'init', 'of_contact_send_email' );
add_action( 'after_setup_theme', 'of_slideshows_setup' );

// Textdomain
add_action( 'of_texdomain', 'of_theme_texdomain' );

/**
 * Hook Text Domain
 */
do_action( 'of_texdomain' );