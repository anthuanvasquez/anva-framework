<?php

if ( ! class_exists( 'Anva_Sidebars' ) ) :

/**
 * Anva Sidebars API.
 *
 * This class sets up the framework sidebar locations.
 * Additionally, this class provides methods to add and remove locations.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Sidebars {

		/**
		 * A single instance of this class
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private static $instance = null;

		/**
		 * Core locations array
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private $core_locations = array();

		/**
		 * Custom locations array
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private $custom_locations = array();

		/**
		 * Remove locations array
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private $remove_locations = array();

		/**
		 * Locations
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private $locations = array();

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
		 * Constructor.
		 */
		private function __construct() {

			// Set core framework locations
			$this->set_core_locations();

			add_action( 'after_setup_theme', array( $this, 'set_locations' ), 1001 );
			add_action( 'widgets_init', array( $this, 'register' ), 1001 );

		}

		/**
		 * Set core framework sidebar locations.
		 */
		public function set_core_locations() {

			// Default Right Sidebar
			$this->core_locations['sidebar_right'] = array(
				'args' => array(
					'id'          => 'sidebar_right',
					'name'        => __( 'Right', 'anva' ),
					'description' => __( 'Sidebar right.', 'anva' ),
				),
			);

			// Default Left Sidebar
			$this->core_locations['sidebar_left'] = array(
				'args' => array(
					'id'          => 'sidebar_left',
					'name'        => __( 'Left', 'anva' ),
					'description' => __( 'Sidebar left.', 'anva' ),
				),
			);

			// Default Side Panel Sidebar
			$this->core_locations['side_panel_sidebar'] = array(
				'args' => array(
					'id'          => 'side_panel_sidebar',
					'name'        => __( 'Side Panel', 'anva' ),
					'description' => __( 'Side panel sidebar.', 'anva' ),
				),
			);

			$this->core_locations['above_header'] = array(
				'args' => array(
					'id'          => 'above_header',
					'name'        => __( 'Above Header', 'anva' ),
					'description' => __( 'Sidebar above header.', 'anva' ),
				),
			);

			$this->core_locations['above_content'] = array(
				'args' => array(
					'id'          => 'above_content',
					'name'        => __( 'Above Content', 'anva' ),
					'description' => __( 'Sidebar above content.', 'anva' ),
				),
			);

			$this->core_locations['below_content'] = array(
				'args' => array(
					'id'          => 'below_content',
					'name'        => __( 'Below Content', 'anva' ),
					'description' => __( 'Sidebar below content.', 'anva' ),
				),
			);

			$this->core_locations['below_footer'] = array(
				'args' => array(
					'id'          => 'below_footer',
					'name'        => __( 'Below Footer', 'anva' ),
					'description' => __( 'Sidebar below footer.', 'anva' ),
				),
			);

			$this->core_locations = apply_filters( 'anva_core_sidebar_locations', $this->core_locations );

		}

		/**
		 * Set final sidebar locations.
		 *
		 * This sets the merged result of core locations and custom locations.
		 */
		public function set_locations() {

			// Merge core locations with custom locations.
			$this->locations = array_merge( $this->core_locations, $this->custom_locations );

			// Remove locations.
			if ( $this->remove_locations ) {
				foreach ( $this->remove_locations as $location ) {
					unset( $this->locations[ $location ] );
				}
			}

			// Get dynamic sidebars from options API.
			$dynamic_sidebars  = anva_get_option( 'dynamic_sidebar' );
			$dynamic_locations = array();

			if ( $dynamic_sidebars ) {
				foreach ( $dynamic_sidebars as $key => $sidebar ) {
					$id = sanitize_title( $sidebar );
					$id = str_replace( '-', '_', $id );
					$dynamic_locations[ $id ] = array(
						'args' => array(
							'id'          => $id,
							'name'        => $sidebar,
							'description' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), $sidebar ),
						),
					);
				}
			}

			// Merge core and custom location with dynamic locations
			$this->locations = array_merge( $this->locations, $dynamic_locations );

			$this->locations = apply_filters( 'anva_sidebar_locations', $this->locations );

		}

		/**
		 * Add sidebar location.
		 */
		public function add_location( $id, $name, $desc = '', $class = '' ) {

			if ( ! $desc ) {
				$desc = sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), $name );
			}

			// Add Sidebar location
			$this->custom_locations[ $id ] = array(
				'args' 					 => array(
					'id' 				 => $id,
					'name' 				 => $name,
					'description'	 	 => $desc,
					'class'				 => $class,
				),
			);

		}

		/**
		 * Remove sidebar location.
		 */
		public function remove_location( $id ) {
			$this->remove_locations[] = $id;
		}

		/**
		 * Get core framework sidebar locations
		 */
		public function get_core_locations() {
			return $this->core_locations;
		}

		/**
		 * Get added custom locations.
		 */
		public function get_custom_locations() {
			return $this->custom_locations;
		}

		/**
		 * Get locations to be removed.
		 */
		public function get_remove_locations() {
			return $this->remove_locations;
		}

		/**
		 * Get final sidebar locations.
		 *
		 * This is the merged result of core locations and custom added locations.
		 */
		public function get_locations( $location_id = '' ) {

			if ( ! $location_id ) {
				return $this->locations;
			}

			if ( isset( $this->locations[ $location_id ] ) ) {
				return $this->locations[ $location_id ];
			}

			return array();
		}

		/**
		 * Register sidebars with WordPress
		 */
		public function register() {

			foreach ( $this->locations as $sidebar ) {

				// Filter args for each of default sidebar.
				$args = apply_filters( 'anva_sidebars_args_before', array(
					'id'    => $sidebar['args']['id'],
					'name'  => $sidebar['args']['name'],
					'desc'  => $sidebar['args']['description'],
					'class' => ( isset( $sidebar['args']['class'] ) ? $sidebar['args']['class'] : '' ),
				) );

				$args = anva_get_sidebar_args( $args );

				register_sidebar( $args );

			}

		}

		/**
		 * Display Sidebar
		 */
		public function display( $location ) {

			$config = array();

			$locations = $this->get_locations();

			foreach ( $locations as $location_id => $default_sidebar ) {

				$sidebar_id = apply_filters( 'anva_custom_sidebar_id', $location_id );

				$config[ $location_id ]['id']    = $sidebar_id;
				$config[ $location_id ]['error'] = false;

				if ( ! is_active_sidebar( $sidebar_id ) ) {
					$config[ $location_id ]['error'] = true;
				}

				if ( ! anva_get_option( 'sidebar_message' ) ) {
					$config[ $location_id ]['error'] = false;
				}
			}

			if ( ! isset( $config[ $location ] ) ) {
				return;
			}

			$sidebar = $config[ $location ];

			if ( ! $sidebar['error'] && ! is_active_sidebar( $sidebar['id'] ) ) {
				return;
			}

			/**
			 * Sidebar location before not hookked by default.
			 */
			do_action( 'anva_sidebar_' . $location . '_before' );
			?>
			<div <?php anva_attr( 'sidebar', array(), $location ); ?>">
				<?php
				if ( $sidebar['error'] ) :

					$message = sprintf(
						esc_html__( 'This is a fixed sidebar with ID, %s, but you haven\'t put any widgets in it yet.', 'anva' ),
						sprintf( '<strong>%s</strong>', $sidebar['id'] )
					);
					?>

					<div class="alert alert-warning">
						<p><?php echo $message; ?></p>
					</div><!-- .alert (end) -->

				<?php
				else :

					dynamic_sidebar( $sidebar['id'] );

				endif;
				?>
			</div><!-- .widget-area (end) -->
		<?php
		/**
		 * Sidebar location after not hookked by default.
		 */
		do_action( 'anva_sidebar_' . $location . '_after' );

	}
}
endif;
