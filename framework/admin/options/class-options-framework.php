<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

class Options_Framework {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.7.0
	 * @type string
	 */
	const VERSION = '1.9.0';

	/**
	 * Gets option name
	 *
	 * @since 1.9.0
	 */
	function get_option_name() {

		$name = '';

		// Gets option name as defined in the theme
		if ( function_exists( 'optionsframework_option_name' ) ) {
			$name = optionsframework_option_name();
		}

		// Fallback
		if ( '' == $name ) {
			$name = get_option( 'stylesheet' );
			$name = preg_replace( "/\W/", "_", strtolower( $name ) );
		}

		return apply_filters( 'options_framework_option_name', $name );

	}

	/**
	 * Wrapper for optionsframework_options()
	 *
	 * Allows for manipulating or setting options via 'anva_options' filter
	 * For example:
	 *
	 * @return array (by reference)
	 */
	function get_options() {

		// Get options from api class Anva_Options_API
		$options = anva_get_formatted_options();

		// Allow setting/manipulating options via filters
		$options = apply_filters( 'anva_options', $options );

		return $options;
	}

}