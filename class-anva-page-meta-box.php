<?php

if ( ! class_exists( 'Anva_Page_Meta_Box' ) ) :

/**
 * Adds meta boxes.
 *
 * WP's built-in add_meta_box() functionality.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Page_Meta_Box {

		/**
		 * ID for meta box and post field saved.
		 *
		 * @since 1.0.0
		 * @var   string
		 */
		public $id;

		/**
		 * Arguments to pass to add_meta_box().
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $args;

		/**
		 * Raw options array.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $options;

		/**
		 * Prefix options.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $prefix = '_anva_';

		/**
		 * Constructor Hook in meta box to start the process.
		 *
		 * @since 1.0.0
		 */
		public function __construct( $id, $args, $options ) {
			$this->id = $id;
			$this->options = $options;

			// Set the field prefix
			if ( isset( $this->args['prefix'] ) ) {
				$this->prefix = $this->args['prefix'];
			}

			$defaults = array(
			'page'     => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			);

			$this->args = wp_parse_args( $args, $defaults );

			// Hooks.
			add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
			add_action( 'add_meta_boxes', array( $this, 'add' ) );
			add_action( 'save_post', array( $this, 'save' ) );
			}

		/**
		 * Enqueue scripts.
		 *
		 * @global $typenow
		 *
		 * @since  1.0.0
		 * @param  object $hook
		 */
		public function assets( $hook ) {
			global $typenow;

			foreach ( $this->args['page'] as $page ) {

				// Add scripts only if page match with post type
				if ( $typenow == $page ) {

					wp_enqueue_script( 'jquery-ui-spinner' );
					wp_enqueue_script( 'jquery-ui-datepicker' );
					wp_enqueue_script( 'jquery-ui-slider' );
					wp_enqueue_script( 'jquery_slider_pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.js', array( 'jquery', 'jquery-ui-slider' ), '1.11.3', false );
					wp_enqueue_script( 'selectric', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'selectric/jquery.selectric.min.js', array( 'jquery' ), '1.9.6', true );
					wp_enqueue_script( 'select2', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'select2/select2.min.js', array( 'jquery' ), '4.0.3', true );

					wp_enqueue_style( 'wp-color-picker' );
					wp_enqueue_style( 'jquery_ui_custom', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-custom.min.css', array(), '1.11.4', 'all' );
					wp_enqueue_style( 'jquery_slider_pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.css', array( 'jquery_ui_custom' ),  '1.11.3' );
					wp_enqueue_style( 'selectric', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'selectric/selectric.css', array(), '1.9.6' );
					wp_enqueue_style( 'select2', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'select2/select2.min.css', array(), '4.0.3' );

				}
			}
			}

		/**
		 * Call WP's add_meta_box() for each post type.
		 *
		 * @since 1.0.0
		 */
		public function add() {
			// Filters
			$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );
			$this->options = apply_filters( 'anva_meta_options_' . $this->id, $this->options );

			foreach ( $this->args['page'] as $page ) {
				add_meta_box(
				$this->id,
				$this->args['title'],
				array( $this, 'display' ),
				$page,
				$this->args['context'],
				$this->args['priority']
				);
			}
			}

		/**
		 * Renders the content of the meta box.
		 *
		 * @since 1.0.0
		 * @param object $post
		 */
		public function display( $post ) {
			// Make sure options interface exists so we can show the options form
			if ( ! function_exists( 'anva_get_options_fields' ) ) {
				echo esc_html__( 'Anva Options Interface not found.', 'anva' );
				return;
			}

			$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );
			$this->options = apply_filters( 'anva_meta_options_' . $this->id, $this->options );

			if ( isset( $this->args['context'] ) ) {
				$class = 'anva-meta-box-' . $this->args['context'];
			}

			// Add an nonce field so we can check for it later
			wp_nonce_field( $this->id, $this->id . '_nonce' );

			$settings = array();
			$option_name = 'anva_meta[' . $this->id . ']';

			?>
			<div class="anva-framework anva-meta-box <?php echo esc_attr( $class ); ?>">
			<?php

				if ( isset( $this->args['desc'] ) && ! empty( $this->args['desc'] ) ) {
				echo '<div class="section section-description">' . $this->args['desc'] . '</div>';
				}

				// Get settings from database
				foreach ( $this->options as $option_id => $option ) {

				if ( empty( $option['id'] ) ) {
					continue;
					}

				$prefix = $this->prefix . $option['id'];

				$settings[ $option['id'] ] = get_post_meta( $post->ID, $prefix, true );

				if ( ! $settings[ $option['id'] ] ) {
					if ( isset( $option['std'] ) ) {
						$settings[ $option['id'] ] = $option['std'];
						}
					}
}

				// Use options interface to display form elements
				anva_the_options_fields( $option_name, $settings, $this->options, false );
			?>
			</div><!-- .anva-meta-box (end) -->
			<?php
			}

		/**
		 * Save meta data sent from meta box.
		 *
		 * @since 1.0.0
		 * @param integer $post_id
		 */
		public function save( $post_id ) {
			/*
			 * We need to verify this came from the our screen and with proper authorization,
			 * because save_post can be triggered at other times.
			 */

			// Check if our nonce is set.
			if ( ! isset( $_POST[ $this->id . '_nonce' ] ) ) {
				return $post_id;
			}

			$nonce = $_POST[ $this->id . '_nonce' ];

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $nonce, $this->id ) ) {
				return $post_id;
			}

			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			// Check the user's permissions.
			if ( 'page' == $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
							}
			}

			/*
			 * OK, its safe!
			 */

			if ( isset( $_POST['anva_meta'][ $this->id ] ) ) {
				$input = $_POST['anva_meta'][ $this->id ];
			}

			if ( ! empty( $input ) ) {

				foreach ( $this->options as $option ) {

					if ( empty( $option['id'] ) ) {
						continue;
					}

					$id = $option['id'];

					// Set checkbox to false if it wasn't sent in the $_POST
					if ( $option['type'] == 'checkbox' && ! isset( $input[ $id ] ) ) {
						$input[ $id ] = '0';
					}

					if ( $option['type'] == 'switch' && ! isset( $input[ $id ] ) ) {
						$input[ $id ] = '0';
					}

					// Set each item in the multicheck to false if it wasn't sent in the $_POST
					if ( $option['type'] == 'multicheck' && ! isset( $input[ $id ] ) && ! empty( $option['options'] ) ) {
						foreach ( $option['options'] as $key => $value ) {
							$input[ $id ][ $key ] = '0';
						}
					}

					if ( isset( $input[ $id ] ) ) {

						$input[ $id ] = apply_filters( 'anva_sanitize_' . $option['type'], $input[ $id ], $option );

						$prefix = $this->prefix . $id;

						if ( ! empty( $input[ $id ] ) ) {
							update_post_meta( $post_id, $prefix, $input[ $id ] );
						} else {
							delete_post_meta( $post_id, $prefix );
						}
}
				}// End foreach().
			}// End if().
			}
}
endif;
