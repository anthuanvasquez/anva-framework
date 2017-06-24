<?php

if ( ! class_exists( 'Anva_Options_Media_Uploader' ) ) :

/**
 * Media uploader.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Options_Media_Uploader {

	/**
	 * A single instance of this class.
 	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = NULL;

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
	 * Initialize the media uploader class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'media_scripts' ) );
	}

	/**
	 * Media Uploader Using the WordPress Media Library.
	 *
	 * @since  1.0.0
	 * @param  string $_id
	 * @param  string $_value
	 * @param  string $_desc
	 * @param  string $_name
	 * @return string $output
	 */
	public static function uploader( $_id, $_value, $_desc = '', $_name = '' ) {
		// Gets the unique option id
		$option_name = anva_get_option_name();

		$output = '';
		$id     = '';
		$class  = '';
		$int    = '';
		$value  = '';
		$name   = '';

		$id = strip_tags( strtolower( $_id ) );

		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if ( $_value != '' && $value == '' ) {
			$value = $_value;
		}

		if ( $_name != '' ) {
			$name = $_name;
		} else {
			$name = $option_name . '[' . $id . ']';
		}

		if ( $value ) {
			$class = ' has-file';
		}

		$output .= '<div class="group-button">';
		$output .= '<input id="' . esc_attr( $id ) . '" class="upload' . esc_attr( $class ) . '" type="text" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . __( 'No file chosen', 'anva' ) .'" />' . "\n";

		if ( function_exists( 'wp_enqueue_media' ) ) {
			if ( ( $value == '' ) ) {
				$output .= '<span>';
				$output .= '<input id="upload-' . esc_attr( $id ) . '" class="upload-button button" type="button" value="' . __( 'Browse', 'anva' ) . '" />' . "\n";
				$output .= '</span>';
			} else {
				$output .= '<span>';
				$output .= '<input id="remove-' . esc_attr( $id ) . '" class="remove-file button" type="button" value="' . __( 'Remove', 'anva' ) . '" />' . "\n";
				$output .= '</span>';
			}
		} else {
			$output .= '<p class="anva-disclaimer"><i>' . __( 'Upgrade your version of WordPress for full media support.', 'anva' ) . '</i></p>';
		}

		$output .= '</div>';

		if ( $_desc != '' ) {
			$output .= '<span class="anva-metabox-desc">' . esc_html( $_desc ) . '</span>' . "\n";
		}

		$output .= '<div class="screenshot" id="' . esc_attr( $id ) . '-image">' . "\n";

		if ( $value != '' ) {
			$remove = '<a class="remove-image">X</a>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if ( $image ) {
				$output .= '<img src="' . $value . '" alt="" />' . $remove;
			} else {
				$parts = explode( "/", $value );
				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				// No output preview if it's not an image.
				$output .= '';

				// Standard generic output if it's not an image.
				$title = __( 'View File', 'anva' );
				$output .= '<div class="no-image"><span class="file_link"><a href="' . esc_url( $value ) . '" target="_blank" rel="external">' . esc_html( $title ) . '</a></span></div>';
			}
		}
		$output .= '</div>' . "\n";
		return $output;
	}

	/**
	 * Enqueue scripts for file uploader.
	 *
	 * @since 1.0.0
	 * @param object $hook
	 */
	public function media_scripts( $hook ) {
		$menu = anva_get_options_page_menu();

		// if ( substr( $hook, -strlen( $menu['menu_slug'] ) ) !== $menu['menu_slug'] )
		// 	return;

		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_register_script( 'anva_media_uploader', ANVA_FRAMEWORK_ADMIN_JS . 'media-uploader.js', array( 'jquery' ), Anva::$version );
		wp_enqueue_script( 'anva_media_uploader' );
		wp_localize_script( 'anva_media_uploader', 'anvaMediaJs', array(
			'upload' => __( 'Browse', 'anva' ),
			'remove' => __( 'Remove', 'anva' )
		) );
	}
}

endif;
