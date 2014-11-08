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
define( 'OF_DOMAIN', 'tm' );

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

// Validate if Woocommerce is activated
if ( class_exists( 'Woocommerce' ) ) :
	include_once( OF_DIRECTORY . '/plugins/woocommerce-config.php' );
endif;

// Validate if Foodlist ist activated
if ( defined( 'FOODLIST_VERSION' )) {
	include_once( OF_DIRECTORY . 'plugins/foodlist.php' );
}

// Initial Hooks
add_action( 'init', 'of_register_menus' );
add_action( 'wp', 'of_setup_author' );
add_action( 'wp_enqueue_scripts', 'of_load_scripts' );
add_action( 'widgets_init', 'of_register_sidebars' );
add_action( 'widgets_init', 'of_register_widgets' );
add_action( 'after_setup_theme', 'of_add_image_sizes' );

add_filter( 'next_posts_link_attributes', 'of_posts_link_attr' );
add_filter( 'previous_posts_link_attributes', 'of_posts_link_attr' );
add_filter( 'next_post_link', 'of_post_link_attr' );
add_filter( 'previous_post_link', 'of_post_link_attr' );
add_filter( 'the_generator', 'of_kill_version' );
add_filter( 'wp_page_menu_args', 'of_page_menu_args' );
add_filter( 'body_class', 'of_body_classes' );
add_filter( 'body_class', 'of_browser_class' );
add_filter( 'wp_title', 'of_wp_title', 10, 2 );
add_filter( 'wp_mail_from', 'of_wp_mail_from' );
add_filter( 'wp_mail_from_name', 'of_wp_mail_from_name' );
add_filter( 'pre_get_posts', 'of_search_filter' );
add_filter( 'manage_posts_columns', 'of_posts_columns_head');
add_filter( 'image_size_names_choose', 'of_image_sizes_choose' );

// Options Framework Hooks
add_action( 'add_meta_boxes', 'of_add_page_options' );
add_action( 'save_post', 'of_page_options_save_meta', 1, 2 );
add_action( 'manage_posts_custom_column', 'of_posts_columns_content', 10, 2);
add_action( 'wp_head', 'of_apple_touch_icon' );
add_action( 'wp_head', 'of_custom_css' );
add_action( 'wp_head', 'of_navigation' );
add_action( 'of_texdomain', 'of_theme_texdomain' );
add_action( 'of_header_addon', 'of_site_search' );
add_action( 'of_header_addon', 'of_social_icons' );
add_action( 'of_header_logo', 'of_header_logo_default' );
add_action( 'of_featured', 'of_featured_default' );
add_action( 'of_menu', 'of_menu_default' );
add_action( 'of_footer_text', 'of_footer_text_default' );
add_action( 'of_layout_before', 'of_layout_before_default' );
add_action( 'of_layout_after', 'of_layout_after_default' );
add_action( 'of_layout_before', 'of_ie_browser_message' );
add_action( 'of_layout_after', 'of_debug_queries' );
add_action( 'of_content_before', 'of_breadcrumbs' );
add_action( 'of_content_before', 'of_content_before_default' );
add_action( 'of_content_after', 'of_content_after_default' );
add_action( 'of_sidebar_layout_before', 'of_sidebar_layout_before_default' );
add_action( 'of_sidebar_layout_after', 'of_sidebar_layout_after_default' );

// Plugin Hooks
add_action( 'init', 'of_contact_send_email' );
add_action( 'after_setup_theme', 'of_slideshows_setup' );