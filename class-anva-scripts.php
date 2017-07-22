<?php

if ( ! class_exists( 'Anva_Scripts' ) ) :

/**
 * Anva Scripts API.
 *
 * This class sets up the framework scripts that get
 * enqueued on the frontend of the website.
 *
 * @since       1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Scripts {

		/**
		 * The theme version.
		 *
		 * @since 1.0.0
		 * @var string
		 */
		private static $version;

		/**
		 * A single instance of this class.
		 *
		 * @since 1.0.0
		 */
		private static $instance = null;

		/**
		 * Remove scripts array.
		 *
		 * @since 1.0.0
		 */
		private $remove_scripts = array();

		/**
		 * Core scripts array.
		 *
		 * @since 1.0.0
		 */
		private $framework_scripts = array();

		/**
		 * Framework dependencies.
		 *
		 * @since 1.0.0
		 */
		private $framework_deps = array();

		/**
		 * Custom scripts.
		 *
		 * @since 1.0.0
		 */
		private $custom_scripts = array();

		/**
		 * Creates or returns an instance of this class
		 */
		public static function instance() {

			if ( self::$instance == null ) {
				self::$instance = new self;
			}

			return self::$instance;
			}

		/**
		 * Constructor Hook everythin in.
		 */
		private function __construct() {

			self::$version = Anva::get_version();

			if ( ! is_admin() ) {
				// Setup scripts from Framework and Custom API.
				// No enqueuing yet.
				add_action( 'wp_enqueue_scripts', array( $this, 'set_framework_scripts' ), 1 );
				add_action( 'wp_enqueue_scripts', array( $this, 'set_custom_scripts' ), 1 );

				// Include scripts, framework and levels 1, 2, and 4
				// Note: Level 3 needs to be included at the theme level.
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_framework_scripts' ), 5 );
				add_action( 'wp_footer', array( $this, 'closing_scripts' ), 11 );
			}
			}

		/**
		 * Set core framework script.
		 */
		public function set_framework_scripts() {

			// jQuery Camera
			$this->framework_scripts['jquery_camera'] = array(
			'handle'    => 'jquery_camera',
			'src'       => Anva::$framework_dir_uri . 'assets/js/jquery.camera.js',
			'deps'      => array( 'jquery' ),
			'ver'       => '1.4.0',
			'footer'    => true,
			);

			// jQuery Nivo
			$this->framework_scripts['jquery_nivo'] = array(
			'handle'    => 'jquery_nivo',
			'src'       => Anva::$framework_dir_uri . 'assets/js/jquery.nivo.js',
			'deps'      => array( 'jquery' ),
			'ver'       => '3.2.0',
			'footer'    => true,
			);

			// Required Plugins
			$this->framework_scripts['anva_core_plugins'] = array(
			'handle'    => 'anva_core_plugins',
			'src'       => Anva::$framework_dir_uri . 'assets/js/core-plugins.js',
			'deps'      => array( 'jquery' ),
			'ver'       => self::$version,
			'footer'    => true,
			);

			// Utilities.
			$this->framework_scripts['anva_core_utils'] = array(
			'handle'    => 'anva_core_utils',
			'src'       => Anva::$framework_dir_uri . 'assets/js/core-utils.js',
			'deps'      => array( 'jquery', 'anva_core_plugins' ),
			'ver'       => self::$version,
			'footer'    => true,
			);

			// Core functions.
			$this->framework_scripts['anva_core'] = array(
			'handle'    => 'anva_core',
			'src'       => Anva::$framework_dir_uri . 'assets/js/core.js',
			'deps'      => array( 'jquery', 'anva_core_utils', 'anva_core_plugins' ),
			'ver'       => self::$version,
			'footer'    => true,
			);

			// Remove scripts
			if ( $this->remove_scripts ) {
				foreach ( $this->remove_scripts as $key => $handle ) {
					if ( isset( $this->framework_scripts[ $handle ] ) ) {

						// Remove framework script
						unset( $this->framework_scripts[ $handle ] );

						// Now that we've found the script and removed it,
						// we don't need to de-register it later.
						unset( $this->remove_scripts[ $key ] );

					}
				}
			}

			// Set framework $deps
			if ( $this->framework_scripts ) {
				foreach ( $this->framework_scripts as $handle => $args ) {
					$this->framework_deps[] = $handle;
				}
			}

			// Backwards compat for $deps
			$GLOBALS['anva_framework_scripts'] = apply_filters( 'anva_framework_scripts', $this->framework_deps );

			}

		/**
		 * Set custom scripts
		 */
		public function set_custom_scripts() {

			if ( ! is_admin() ) {

				// Remove scripts
				if ( $this->remove_scripts ) {
					foreach ( $this->remove_scripts as $handle ) {
						unset( $this->remove_scripts[ $handle ] );
					}
				}

				// Re-format array of custom scripts that are left
				// to be organized by level.
				$temp_scripts = $this->custom_scripts;

				$this->custom_scripts = array(
				'1' => array(), // Level 1: Before Framework scripts
				'2' => array(), // Level 2: After Framework scripts
				'3' => array(), // Level 3: After Theme scripts
				'4' => array(),// Level 4: After Theme Options-generated scripts
				);

				if ( $temp_scripts ) {
						foreach ( $temp_scripts as $handle => $file ) {
						$key = $file['level'];
						$this->custom_scripts[ $key ][ $handle ] = $file;
						}
}
}

			}

		/**
		 * Add script
		 */
		public function add( $handle, $src, $level = 4, $ver = null, $footer = true ) {
			if ( ! is_admin() ) {
				$this->custom_scripts[ $handle ] = array(
				'handle'    => $handle,
				'src'       => $src,
				'level'     => $level,
				'ver'       => $ver,
				'footer'    => $footer,
				);
			}
			}

		/**
		 * Remove script
		 */
		public function remove( $handle ) {
			if ( ! is_admin() ) {
				$this->remove_scripts[] = $handle;
			}
			}

		/**
		 * Get scripts to be removed
		 */
		public function get_remove_scripts() {
			return $this->remove_scripts;
			}

		/**
		 * Get framework scripts.
		 *
		 * Will only be fully available at the time it's enqueing everything.
		 * Not very useful in most cases.
		 */
		public function get_framework_scripts() {
			return $this->framework_scripts;
			}

		/**
		 * Get an array that could be used as your $deps if
		 * manually trying to enqueue script after framework scripts.
		 */
		public function get_framework_deps() {
			return $this->framework_deps;
			}


		/**
		 * Get scripts added through custom API
		 */
		public function get_custom_scripts() {
			return $this->custom_scripts;
			}

		/**
		 * Enqueue framework scripts
		 */
		public function enqueue_framework_scripts() {

			// Level 1 custom scripts
			$this->print_scripts( 1 );

			// Enqueue framework scripts
			if ( $this->framework_scripts ) {
				foreach ( $this->framework_scripts as $script ) {
					wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['footer'] );
				}
			}

			// Level 2 custom scripts
			$this->print_scripts( 2 );

			}

		/**
		 * Output closing scripts. Hooked to wp_footer, giving
		 * a chance to for a script outside of WP's enqueue
		 * system.
		 */
		public function closing_scripts() {
			// Level 4 scripts
			$this->print_scripts( 4 );
			}

		/**
		 * Print scripts. For levels 1-3, this means using
		 * WP's wp_enqueue_script(), and for level 4, the script
		 * is manually outputed at the end of wp_head.
		 */
		public function print_scripts( $level = 1 ) {

			// Only levels 1-4 currently exist
			if ( ! in_array( $level, array( 1, 2, 3, 4 ) ) ) {
				return;
			}

			// Add scripts
			if ( $level == 4 ) {

				// Manually insert level 4 scripts
				if ( $this->custom_scripts[4] ) {
					foreach ( $this->custom_scripts[4] as $file ) {
						printf( "<script type='text/javascript' src='%s'></script>\n", $file['src'] );
					}
				}
} else {

				// Use WordPress's enqueue system
				if ( $this->custom_scripts[ $level ] ) {
					foreach ( $this->custom_scripts[ $level ] as $file ) {
						wp_enqueue_script( $file['handle'], $file['src'], array(), $file['ver'], $file['footer'] );
					}
							}

				wp_localize_script( 'anva_main', 'AnvaMainJS', anva_get_js_locals() );

			}

			}
}

endif;
