<?php
/**
 * Options Framework
 *
 * @package   Options Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 *
 * @wordpress-plugin
 * Plugin Name: Options Framework
 * Plugin URI:  http://wptheming.com
 * Description: A framework for building theme options.
 * Version:     1.9.0
 * Author:      Devin Price
 * Author URI:  http://wptheming.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: optionsframework
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'optionsframework_init' ) ) :
/*
 * Don't load if optionsframework_init is already defined
 */
function optionsframework_init() {

	//  If user can't edit theme options, exit
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Loads the required Options Framework classes.
	require anva_get_core_directory() . '/admin/options/class-options-framework.php';
	require anva_get_core_directory() . '/admin/options/class-options-framework-admin.php';
	require anva_get_core_directory() . '/admin/options/class-options-framework-importer.php';
	require anva_get_core_directory() . '/admin/options/class-options-interface.php';
	require anva_get_core_directory() . '/admin/options/class-options-media-uploader.php';
	require anva_get_core_directory() . '/admin/options/class-options-sanitization.php';

	// Instantiate the options page.
	$options_framework_admin = new Options_Framework_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new Options_Framework_Media_Uploader;
	$options_framework_media_uploader->init();

}

add_action( 'init', 'optionsframework_init', 20 );

endif;