<?php
/**
 * Anva Stylesheets API.
 *
 * This class sets up the framework stylesheets that get
 * enqueued on the frontend of the website.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */

if ( ! class_exists( 'Anva_Styles' ) ) :

	class Anva_Styles {

		/**
		 * The framework version.
		 *
		 * @since 1.0.0
		 * @var   string
		 */
		private static $version;

		/**
		 * A single instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 *
		 */
		private static $instance = null;

		/**
		 * Remove stylesheets array.
		 *
		 * @since 1.0.0
		 * @var	  array
		 */
		private $remove_stylesheets = array();

		/**
		 * Core stylesheets array.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $framework_stylesheets = array();

		/**
		 * Framework dependencies.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $framework_deps = array();

		/**
		 * Custom stylesheets.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $custom_stylesheets = array();

		/**
		 * Creates or returns an instance of this class.
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

			if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {

				// Setup stylesheets from Framework and Custom API.
				// No enqueuing yet.
				add_action( 'wp_enqueue_scripts', array( $this, 'set_framework_stylesheets' ), 1 );
				add_action( 'wp_enqueue_scripts', array( $this, 'set_custom_stylesheets' ), 1 );

				// Include stylesheets, framework and levels 1, 2, and 4
				// Note: Level 3 needs to be included at the theme level.
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_framework_stylesheets' ), 5 );
				add_action( 'wp_head', array( $this, 'closing_stylesheets' ), 11 );
			}
		}

		/**
		 * Set core framework stylesheet.
		 */
		public function set_framework_stylesheets() {

			// Boostrap 3
			$this->framework_stylesheets['bootstrap'] = array(
				'handle'	=> 'bootstrap',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/bootstrap.css',
				'deps'		=> array(),
				'ver'		=> '3.3.6',
				'media'		=> 'all',
			);

			// Swiper
			$this->framework_stylesheets['swiper'] = array(
				'handle'	=> 'swiper',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/swiper.css',
				'deps'		=> array(),
				'ver'		=> '3.3.1',
				'media'		=> 'all',
			);

			// Camera
			$this->framework_stylesheets['camera'] = array(
				'handle'	=> 'camera',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/camera.css',
				'deps'		=> array(),
				'ver'		=> '1.4.0',
				'media'		=> 'all',
			);

			// Nivo
			$this->framework_stylesheets['nivo'] = array(
				'handle'	=> 'nivo',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/nivo-slider.css',
				'deps'		=> array(),
				'ver'		=> '3.2.0',
				'media'		=> 'all',
			);

			// Animate
			$this->framework_stylesheets['animate'] = array(
				'handle'	=> 'animate',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/animate.css',
				'deps'		=> array(),
				'ver'		=> '3.5.1',
				'media'		=> 'all',
			);

			// Magnific Popup
			$this->framework_stylesheets['magnific_popup'] = array(
				'handle'	=> 'magnific_popup',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/magnific-popup.css',
				'deps'		=> array(),
				'ver'		=> '3.5.1',
				'media'		=> 'all',
			);

			// Font Icons
			$this->framework_stylesheets['anva_font_icons'] = array(
				'handle'	=> 'anva_font_icons',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/styles-font-icons.css',
				'deps'		=> array(),
				'ver'		=> self::$version,
				'media'		=> 'all',
			);

			// Framework Shortcodes
			$this->framework_stylesheets['anva_shortcodes'] = array(
				'handle'	=> 'anva_shortcodes',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/styles-shortcodes.css',
				'deps'		=> array(),
				'ver'		=> self::$version,
				'media'		=> 'all',
			);

			// Framework Styles
			$this->framework_stylesheets['anva_styles'] = array(
				'handle'	=> 'anva_styles',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/styles.css',
				'deps'		=> array(),
				'ver'		=> self::$version,
				'media'		=> 'all',
			);

			// Framework Responsive Styles
			$this->framework_stylesheets['anva_responsive'] = array(
				'handle'	=> 'anva_responsive',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/styles-responsive.css',
				'deps'		=> array( 'anva_shortcodes', 'anva_styles' ),
				'ver'		=> self::$version,
				'media'		=> 'all',
			);

			// Framework Theme Dark
			$this->framework_stylesheets['anva_dark'] = array(
				'handle'	=> 'anva_dark',
				'src'		=> Anva::$framework_dir_uri . 'assets/css/styles-dark.css',
				'deps'		=> array( 'anva_shortcodes', 'anva_styles', 'anva_responsive' ),
				'ver'		=> self::$version,
				'media'		=> 'all',
			);

			// Remove stylesheets
			if ( $this->remove_stylesheets ) {
				foreach ( $this->remove_stylesheets as $key => $handle ) {
					if ( isset( $this->framework_stylesheets[ $handle ] ) ) {

						// Remove framework stylesheet
						unset( $this->framework_stylesheets[ $handle ] );

						// Now that we've found the stylesheet and removed it,
						// we don't need to de-register it later.
						unset( $this->remove_stylesheets[ $key ] );
					}
				}
			}

			// Set framework $deps
			if ( $this->framework_stylesheets ) {
				foreach ( $this->framework_stylesheets as $handle => $args ) {
					$this->framework_deps[] = $handle;
				}
			}

			// Backwards compat for $deps
			$GLOBALS['anva_framework_styles'] = apply_filters( 'anva_framework_styles', $this->framework_deps );

		}

		/**
		 * Set custom stylesheets
		 */
		public function set_custom_stylesheets() {

			if ( ! is_admin() ) {

				// Remove stylesheets
				if ( $this->remove_stylesheets ) {
					foreach ( $this->remove_stylesheets as $handle ) {
						unset( $this->remove_stylesheets[ $handle ] );
					}
				}

				// Re-format array of custom stylesheets that are left
				// to be organized by level.
				$temp_stylesheets = $this->custom_stylesheets;

				$this->custom_stylesheets = array(
					'1' => array(),	// Level 1: Before Framework styles
					'2' => array(),	// Level 2: After Framework styles
					'3' => array(),	// Level 3: After Theme styles
					'4' => array()	// Level 4: After Theme Options-generated styles
				);

				if ( $temp_stylesheets ) {
					foreach ( $temp_stylesheets as $handle => $file ) {
						$key = $file['level'];
						$this->custom_stylesheets[$key][$handle] = $file;
					}

				}

			}

		}

		/**
		 * Add stylesheet
		 */
		public function add( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
			if ( ! is_admin() ) {
				$this->custom_stylesheets[$handle] = array(
					'handle' 	=> $handle,
					'src' 		=> $src,
					'level' 	=> $level,
					'ver' 		=> $ver,
					'media' 	=> $media
				);
			}
		}

		/**
		 * Remove stylesheet
		 */
		public function remove( $handle ) {
			if ( ! is_admin() ) {
				$this->remove_stylesheets[] = $handle;
			}
		}

		/**
		 * Get stylehsheets to be removed
		 */
		public function get_remove_stylesheets() {
			return $this->remove_stylesheets;
		}

		/**
		 * Get framework stylesheets.
		 * Will only be fully available at the time it's enqueing everything.
		 * Not very useful in most cases.
		 */
		public function get_framework_stylesheets() {
			return $this->framework_stylesheets;
		}

		/**
		 * Get an array that could be used as your $deps if
		 * manually trying to enqueue stylehsheet after framework stylesheets.
		 */
		public function get_framework_deps() {
			return $this->framework_deps;
		}

		/**
		 * Get stylesheets added through custom API
		 */
		public function get_custom_stylesheets() {
			return $this->custom_stylesheets;
		}

		/**
		 * Enqueue framework stylesheets
		 */
		public function enqueue_framework_stylesheets() {

			// Level 1 custom stylesheets
			$this->print_styles( 1 );

			// Enqueue framework stylesheets
			if ( $this->framework_stylesheets ) {
				foreach ( $this->framework_stylesheets as $style ) {
					wp_enqueue_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
				}
			}

			// Level 2 custom stylesheets
			$this->print_styles(2);

		}

		/**
		 * Output closing stylesheets. Hooked to wp_head, giving
		 * a chance to for a stylesheet outside of WP's enqueue
		 * system.
		 */
		public function closing_stylesheets() {
			// Level 4 stylesheets
			$this->print_styles(4);
		}

		/**
		 * Print stylesheets. For levels 1-3, this means using
		 * WP's wp_enqueue_style(), and for level 4, the stylesheet
		 * is manually outputed at the end of wp_head.
		 */
		public function print_styles( $level = 1 ) {

			// Only levels 1-4 currently exist
			if ( ! in_array( $level, array(1, 2, 3, 4) ) ) {
				return;
			}

			// Add styles
			if ( $level == 4 ) {
				// Manually insert level 4 stylesheets
				if ( $this->custom_stylesheets[4] ) {
					foreach ( $this->custom_stylesheets[4] as $file ) {
						printf( "<link rel='stylesheet' id='%s' href='%s' type='text/css' media='%s' />\n", $file['handle'], $file['src'], $file['media'] );
					}
				}
			} else {
				// Use WordPress's enqueue system
				if ( $this->custom_stylesheets[$level] ) {
					foreach ( $this->custom_stylesheets[$level] as $file ) {
						wp_enqueue_style( $file['handle'], $file['src'], array(), $file['ver'], $file['media'] );
					}
				}
			}
		}
	}
endif;
