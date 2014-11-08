<?php

/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/admin/' );
include_once ( get_template_directory() . '/framework/admin/options-framework.php' );
include_once ( get_template_directory() . '/framework/admin/options.php' );
include_once ( get_template_directory() . '/framework/admin/includes/general.php' );

/*
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 *
 * You can delete it if you not using that option
 */
add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});

	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}

});
</script>

<?php
}

function change_options_location() {
	return  '/framework/admin/options.php';
}
add_filter( 'options_framework_location', 'change_options_location' );

/*
 * This is an example of filtering menu parameters
 */

function prefix_options_menu_filter( $menu ) {

	$options_framework = new Options_Framework;
	$option_name = $options_framework->get_option_name();

	$menu['mode'] = 'menu';
	$menu['page_title'] = __( 'Theme Options', 'tm');
	$menu['menu_title'] = __( 'Theme Options', 'tm');
	$menu['menu_slug'] = $option_name;
	return $menu;
}

add_filter( 'optionsframework_menu', 'prefix_options_menu_filter' );

/**
 * Load framework
 * @since 2.0
 */
include_once( get_template_directory() . '/framework/init.php' );

/**
 * Hook textdomain
 * @since 1.4.0
 */
do_action( 'tm_texdomain' );

/**
 * Setup theme functions. After theme setup hooks and filters.
 * @since 1.3.1
 */
function tm_setup() {

	global $content_width;

	// Global content width
	if ( ! isset( $content_width ) )
		$content_width = 980;

	// Add theme-supported features
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'tm_setup' );

function include_google_font() {
	of_enqueue_google_fonts(
		of_get_option('body_font')
	);
}
add_action('wp_enqueue_scripts', 'include_google_font');
