<?php

if ( ! class_exists( 'Anva_Scripts_API' ) ) :

/**
 * Anva Javascripts
 * 
 * This class sets up the framework scripts that get
 * enqueued on the frontend of the website.
 *
 * Additionally, this class provides methods to add and
 * remove scripts. Custom API-added scripts are organized
 * within four levels.
 *	- Level 1: Before Framework scripts
 *	- Level 2: After Framework scripts
 *	- Level 3: After Theme scripts (implemented at theme level)
 *	- Level 4: After everything (end of wp_head)
 *
 * @since 		 1.0.0
 * @package    Anva
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */
class Anva_Scripts_API {

	/**
	 * Properties
	 */
	private static $instance = null;
	private $remove_scripts = array();
	private $framework_scripts = array();
	private $framework_deps = array();
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
	 * Constructor
	 */
	private function __construct() {

		// Setup scripts from Framework and Custom API.
		// No enqueuing yet.
		add_action( 'wp_enqueue_scripts', array( $this, 'set_framework_scripts' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'set_custom_scripts' ), 1 );

		// Include scripts, framework and levels 1, 2, and 4
		// Note: Level 3 needs to be included at the theme level.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_framework_scripts' ), 5 );
		add_action( 'wp_footer', array( $this, 'closing_scripts' ), 11 );
	}

	/**
	 * Set core framework script
	 */
	public function set_framework_scripts() {

		// Boostrap
		$this->framework_scripts['bootstrap'] = array(
			'handle'	=> 'bootstrap',
			'src'			=> anva_get_core_uri() .'/assets/js/vendor/bootstrap.min.js',
			'deps'		=> array( 'jquery' ),
			'ver'			=> '3.3.5',
			'footer'	=> true
		);

		// Plugins
		$this->framework_scripts['anva_plugins'] = array(
			'handle'	=> 'anva_plugins',
			'src'			=> anva_get_core_uri() .'/assets/js/plugins.min.js',
			'deps'		=> array( 'jquery' ),
			'ver'			=> ANVA_FRAMEWORK_VERSION,
			'footer'	=> true
		);

		// jQuery Validate
		$this->framework_scripts['jquery_validate'] = array(
			'handle'	=> 'jquery_validate',
			'src'			=> anva_get_core_uri() .'/assets/js/vendor/jquery.validate.min.js',
			'deps'		=> array( 'jquery' ),
			'ver'			=> '1.12.0',
			'footer'	=> true
		);

		// Swiper
		$this->framework_scripts['swiper'] = array(
			'handle'	=> 'swiper',
			'src'			=> anva_get_core_uri() .'/assets/js/vendor/swiper.min.js',
			'deps'		=> array(),
			'ver'			=> '3.1.2',
			'footer'	=> true
		);

		// Camera
		$this->framework_scripts['camera'] = array(
			'handle'	=> 'camera',
			'src'			=> anva_get_core_uri() .'/assets/js/vendor/jquery.camera.js',
			'deps'		=> array( 'jquery' ),
			'ver'			=> '1.4.0',
			'footer'	=> true
		);

		// Main JS
		$this->framework_scripts['anva_main'] = array(
			'handle'	=> 'anva',
			'src'			=> anva_get_core_uri() .'/assets/js/anva.min.js',
			'deps'		=> array( 'jquery', 'anva_plugins' ),
			'ver'			=> ANVA_FRAMEWORK_VERSION,
			'footer'	=> true
		);

		// Remove scripts
		if ( $this->remove_scripts ) {
			foreach ( $this->remove_scripts as $key => $handle ) {
				if ( isset( $this->framework_scripts[$handle] ) ) {

					// Remove framework script
					unset( $this->framework_scripts[$handle] );

					// Now that we've found the script and removed it,
					// we don't need to de-register it later.
					unset( $this->remove_scripts[$key] );

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
					unset( $this->remove_scripts[$handle] );
				}
			}

			// Re-format array of custom scripts that are left
			// to be organized by level.
			$temp_scripts = $this->custom_scripts;

			$this->custom_scripts = array(
				'1' => array(),	// Level 1: Before Framework scripts
				'2' => array(),	// Level 2: After Framework scripts
				'3' => array(),	// Level 3: After Theme scripts
				'4' => array()	// Level 4: After Theme Options-generated scripts
			);

			if ( $temp_scripts ) {
				foreach ( $temp_scripts as $handle => $file ) {
					$key = $file['level'];
					$this->custom_scripts[$key][$handle] = $file;
				}

			}

		}

	}

	/**
	 * Add script
	 */
	public function add( $handle, $src, $level = 4, $ver = null, $footer = true ) {
		if ( ! is_admin() ) {
			$this->custom_scripts[$handle] = array(
				'handle' 	=> $handle,
				'src' 		=> $src,
				'level' 	=> $level,
				'ver' 		=> $ver,
				'footer' 	=> $footer
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
		$this->print_scripts(1);

		// Enqueue framework scripts
		if ( $this->framework_scripts ) {
			foreach ( $this->framework_scripts as $script ) {
				wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['footer'] );
			}
		}

		// Level 2 custom scripts
		$this->print_scripts(2);

	}

	/**
	 * Output closing scripts. Hooked to wp_footer, giving
	 * a chance to for a script outside of WP's enqueue
	 * system.
	 */
	public function closing_scripts() {
		// Level 4 scripts
		$this->print_scripts(4);
	}

	/**
	 * Print scripts. For levels 1-3, this means using
	 * WP's wp_enqueue_script(), and for level 4, the script
	 * is manually outputed at the end of wp_head.
	 */
	public function print_scripts( $level = 1 ) {

		// Only levels 1-4 currently exist
		if ( ! in_array( $level, array(1, 2, 3, 4) ) ) {
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
			if ( $this->custom_scripts[$level] ) {
				foreach ( $this->custom_scripts[$level] as $file ) {
					wp_enqueue_script( $file['handle'], $file['src'], array(), $file['ver'], $file['footer'] );
				}
			}

		}

	}
}

endif;