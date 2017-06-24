<?php

if ( ! class_exists( 'Anva_Options_Import_Export' ) ) :

/**
 * Add import export options to theme options.
 *
 * @since       1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Options_Import_Export {

	/**
	 * A single instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Theme option ID.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private $option_id;

	/**
	 * Theme options from database.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private $options;

	/**
	 * Trasient option.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var string
	 */
	private $transient = '_anva_import_happened';

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			// Get theme option name.
			$option_name = anva_get_option_name();

			// Set option name key.
			$this->option_id = $option_name;

			// Get options from database.
			$this->options = get_option( $option_name );

			add_filter( 'anva_option_type', array( $this, 'import_option' ), 10, 4 );
			add_filter( 'anva_option_type', array( $this, 'export_option' ), 10, 4 );
			add_action( 'after_setup_theme', array( $this, 'add_options' ) );
			add_action( 'admin_init', array( $this, 'import_settings' ) );
			add_action( 'appearance_page_' . $option_name, array( $this, 'add_save_notice' ) );
		}
	}

	/**
	 * Add import export options to advanced tab.
	 *
	 * @since  1.0.0
	 */
	public function add_options() {
		$import_export_options = array(
			'export' => array(
				'name' => __( 'Export', 'anva' ),
				'id'   => 'export_settings',
				'std'  => '',
				'desc' => __( 'Select all and copy to export your current theme settings.', 'anva'  ),
				'type' => 'export',
			),
			'import' => array(
				'name' => __( 'Import', 'anva' ),
				'id'   => 'import_settings',
				'std'  => '',
				'desc' => __( 'Paste your exported settings here. When you click "Import" your settings will be imported to this site. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'anva' ) . '<br/><br/>' .  __( 'When you click "Restore Previous", the latest settings will be imported.', 'anva' ),
				'type' => 'import',
				'rows' => 10,
			),
		);

		anva_add_option_section( 'advanced', 'import_export', __( 'Backup Options', 'anva' ), null, $import_export_options, false );
	}

	/**
	 * Define the import option.
	 *
	 * @since  1.0.0
	 * @return string|html $output
	 */
	public function import_option( $output, $value, $option_name, $val ) {

		if ( $value['type'] == 'import' ) {

			$output .= sprintf( '<textarea name="%s[import_settings]" class="anva-input anva-textarea" rows="10"></textarea>', $option_name );

			$option_import = get_option( $this->option_id . '_import' );

			if ( $option_import ) {
				$time = strtotime( $option_import['time'] );
				$time = date( 'M d, Y @ g:i A', $time );
				$output .= sprintf( '<p><span class="dashicons dashicons-clock"></span> <strong>%s:</strong> %s</p>', __( 'Last imported settings', 'anva' ), $time );
			}

			$output .= sprintf( '<p><input type="submit" class="button button-secondary import-button" value="%s" />  <input type="submit" class="button button-secondary restore-button" value="%s" /></p>', esc_attr__( 'Import', 'anva' ), esc_attr__( 'Restore Previous', 'anva' ) );

		}

		return $output;

	}

	/**
	 * Define the export option.
	 *
	 * @since  1.0.0
	 * @param  array       $options
	 * @return string|html $output
	 */
	public function export_option( $output, $value, $option_name, $val ) {
		if ( $value['type'] == 'export' ) {

			if ( ! $this->options && ! is_array( $this->options ) ) {
				$output .= sprintf( '<div class="anva-disclaimer section-info danger"><p>%s</p></div>', __( 'ERROR! You don\'t have any options to export. Trying saving your options first.', 'anva' ) );
				return $output;
			}

			// Add the theme name
			$this->options['theme_name'] = $option_name;

			// Generate the export data.
			$val = base64_encode( maybe_serialize( (array)$this->options ) );

			$output .= '<textarea disabled="disabled" class="anva-input anva-textarea" rows="10">' . esc_textarea( $val ) . '</textarea>';
		}

		return $output;

	}

	/**
	 * Import the settings.
	 *
	 * @since  1.0.0
	 * @param  array $input
	 * @return void
	 */
	public function import_settings() {
		if ( isset( $_POST['import'] ) ) {

			// Decode the pasted data
			$data = (array) maybe_unserialize( base64_decode( $_POST[ $this->option_id ]['import_settings'] ) );

			if ( is_array( $data ) && isset( $data['theme_name'] ) && $this->option_id == $data['theme_name'] ) {

				unset( $data['theme_name'] );

				$import = array();

				// @TODO sanitize settings before update option

				// Update the settings in the database
				update_option( $this->option_id, $data );
				set_transient( $this->transient, 'success', 30 );

				$import['time'] = current_time( 'mysql' );
				$import['settings'] = $data;

				update_option( $this->option_id . '_import', $import );

			} else {
				set_transient( $this->transient, 'fail', 30 );
			}

			/**
			 * Redirect back to the settings page that was submitted
			 */
			$goback = add_query_arg( 'settings-imported', 'true',  wp_get_referer() );
			wp_redirect( $goback );
			exit;

		}
	}

	/**
	 * Add notices for import success/failure.
	 *
	 * @since  1.0.0
	 */
	public function add_save_notice() {
		$success = get_transient( $this->transient );

		if ( $success ) {

			if ( $success === 'success' ) {
				add_settings_error( 'anva-options-page-errors', 'import_options', __( 'Options imported successfully.', 'anva' ), 'updated fade' );
			} else {
				add_settings_error( 'anva-options-page-errors', 'import_options_fail', __( 'Options could not be imported.', 'anva' ), 'error fade' );
			}

		}

		delete_transient( $this->transient );
	}
}

endif;
