<?php

if ( ! class_exists( 'Anva_Sliders_API' ) ) :
/**
 * Anva Sliders API.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Sliders_API {

	/**
	 * A single instance of this class
	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Core slider types
	 *
	 * @since 1.0.0
	 */
	private $core_sliders = array();

	/**
	 * Custom slider types
	 *
	 * @since 1.0.0
	 */
	private $custom_sliders = array();

	/**
	 * Slider types to be removed
	 *
	 * @since 1.0.0
	 */
	private $remove_sliders = array();

	/**
	 * Final slider types, core combined
	 * with custom slider types.
	 *
	 * @since 1.0.0
	 */
	private $sliders = array();

	/**
	 * Creates or returns an instance of this class
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 * 
	 * Hook everything in.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		//if ( is_admin() ) {

			// Setup plugin default slider types
			$this->set_core_sliders();
			$this->set_sliders();
			
			// Establish slider types based on custom modifications
			// combined with plugin defaults
			add_action( 'after_setup_theme', array( $this, 'set_sliders' ), 1000 );

		//}

	}

	/**
	 * Set default slider types
	 *
	 * @since 1.0.0
	 */
	public function set_core_sliders() {

		/*--------------------------------------------*/
		/* Helpers
		/*--------------------------------------------*/

		$animations = array();
		foreach ( anva_get_animations() as $animation_id => $animation ) {
			$animations[ $animation ] = $animation;
		}

		$this->core_sliders = array(
			'standard' => array(
				'name' 			=> 'Standard',
				'id'			=> 'standard',
				'custom_size' 	=> true
			),
			'owl' => array(
				'name' 			=> 'OWL',
				'id'			=> 'owl',
				'custom_size' 	=> false
			),
			'nivo' => array(
				'name' 			=> 'Nivo',
				'id'			=> 'nivo',
				'custom_size' 	=> true
			),
			'bootstrap' => array(
				'name' 			=> 'Bootstrap Carousel',
				'id'			=> 'bootstrap',
				'custom_size' 	=> false
			),
			'swiper' => array(
				'name' 			=> 'Swiper',
				'id'			=> 'swiper',
				'custom_size' 	=> true
			),
			'camera' => array(
				'name' 			=> 'Camera',
				'id'			=> 'camera',
				'custom_size' 	=> true
			),
		);

		/*--------------------------------------------*/
		/* Standard - Flex Slider
		/*--------------------------------------------*/

		// Slider fields
		$this->core_sliders['standard']['fields'] = array(
			'general' => array(
				'id' 			=> 'general',
				'name'		=> __( 'General', 'anva' ),
				'type' 		=> 'heading',
				'options' => array(
					'type' => array(
						'name' 		=> __( 'Slide Type', 'anva' ),
						'desc'		=> __( 'Select content type.', 'anva' ),
						'id'			=> 'type',
						'type' 		=> 'select',
						'std'			=> '',
						'options'	=> array(
							'image' => __( 'Image Slide', 'anva' ),
							'video' => __( 'Video Slide', 'anva' )
						)
					),
					'link' => array(
						'name' 		=> __( 'Image Link', 'anva' ),
						'desc'		=> __( 'Where should the link open?.', 'anva' ),
						'id'			=> 'link',
						'type' 		=> 'select',
						'std'			=> 'same',
						'options'	=> array(
							'same' 	=> __( 'Same Windows', 'anva' ),
							'new' 	=> __( 'New Windows', 'anva' ),
							'image' => __( 'Lightbox Image', 'anva' ),
							'video' => __( 'Lightbox Video', 'anva' )
						)
					),
					'url' => array(
						'name' 		=> __( 'URL', 'anva' ),
						'desc'		=> __( 'Where should the link go?.', 'anva' ),
						'id'			=> 'url',
						'type' 		=> 'text',
						'std'			=> ''
					),
					'description' => array(
						'name' 		=> __( 'Description', 'anva' ),
						'desc'		=> __( 'What should the description say?.', 'anva' ),
						'id'			=> 'description',
						'type' 		=> 'textarea',
						'std'			=> ''
					),
					'content' => array(
						'name' 		=> __( 'Content', 'anva' ),
						'desc'		=> __( 'Select a option to show the content.', 'anva' ),
						'id'			=> 'content',
						'type' 		=> 'select',
						'std'			=> 'hide',
						'options'	=> array(
							'title' => anva_get_local( 'slide_title'),
							'desc' 	=> anva_get_local( 'slide_desc' ),
							'both' 	=> anva_get_local( 'slide_show' ),
							'hide' 	=> anva_get_local( 'slide_hide' )
						)
					),
				)
			)
		);

		// Slider options
		$this->core_sliders['standard']['options'] = array(
			'standard_fx' => array(
				'id'			=> 'standard_fx',
				'name'		=> __( 'How to transition between slides?', 'anva' ),
				'desc'		=> __( 'Select the transition effect for slides.', 'anva' ),
				'std'			=> 'fade',
				'type'		=> 'select',
				'options'	=> array(
					'fade' 	=> 'Fade',
					'slide'	=> 'Slide'
				),
				'class' 	=> 'slider-item standard hide'
			),
			'standard_thumbs' => array(
				'id'			=> 'standard_thumbs',
				'name'		=> __( 'Show thumbnails?', 'anva' ),
				'desc'		=> __( 'Enable or disable the thumbnails for slides.', 'anva' ),
				'std'			=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable thumbnails.',
					'false'	=> 'No, disable thumbnails.'
				),
				'class'		=> 'slider-item standard hide'
			),
			'standard_grid' => array(
				'id'			=> 'standard_grid',
				'name'		=> __( 'Thumbnails Grid', 'anva' ),
				'desc'		=> __( 'The columns grid for display the thumbnails.', 'anva' ),
				'std'			=> 'grid-6',
				'type'		=> 'select',
				'options'	=> array(
					'grid-3' 	=> 'Grid 3',
					'grid-5' 	=> 'Grid 5',
					'grid-6' 	=> 'Grid 6',
					'grid-8' 	=> 'Grid 8',
					'grid-10' => 'Grid 10',
					'grid-12'	=> 'Grid 12',
				),
				'class'		=> 'slider-item standard hide'
			),
			'standard_pause' => array(
				'id'			=> 'standard_pause',
				'name'		=> __( 'Pause', 'anva' ),
				'desc'		=> __( 'Enter the time duration for slider pause.', 'anva' ),
				'std'			=> 7000,
				'type'		=> 'number',
				'class'		=> 'slider-item standard hide'
			),
			'standard_speed' => array(
				'id'			=> 'standard_speed',
				'name'		=> __( 'Speed', 'anva' ),
				'desc'		=> __( 'Enter speed for slides.', 'anva' ),
				'std'			=> 1000,
				'type'		=> 'number',
				'class'		=> 'slider-item standard hide'
			),
			'standard_arrows' => array(
				'id'			=> 'standard_arrows',
				'name'		=> __( 'Arrows', 'anva' ),
				'desc'		=> __( 'Enter the time duration for slider pause.', 'anva' ),
				'std'			=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable arrows.',
					'false'	=> 'No, disable arrows.'
				),
				'class'		=> 'slider-item standard hide'
			),
		);

		/*--------------------------------------------*/
		/* OWL Slider
		/*--------------------------------------------*/

		// Slider fields
		$this->core_sliders['owl']['fields'] = array(
			'general' => array(
				'id' 		=> 'general',
				'name'		=> __( 'General', 'anva' ),
				'type' 		=> 'heading',
				'options' => array(
					'type' => array(
						'name' 		=> __( 'Slide Type', 'anva' ),
						'desc'		=> __( 'Select content type.', 'anva' ),
						'id'			=> 'type',
						'type' 		=> 'select',
						'std'			=> '',
						'options'	=> array(
							'image' => __( 'Image Slide', 'anva' ),
							'video' => __( 'Video Slide', 'anva' )
						)
					),
					'link' => array(
						'name' 		=> __( 'Image Link', 'anva' ),
						'desc'		=> __( 'Where should the link open?.', 'anva' ),
						'id'			=> 'link',
						'type' 		=> 'select',
						'std'			=> 'same',
						'options'	=> array(
							'same' 	=> __( 'Same Windows', 'anva' ),
							'new' 	=> __( 'New Windows', 'anva' ),
							'image' => __( 'Lightbox Image', 'anva' ),
							'video' => __( 'Lightbox Video', 'anva' )
						)
					),
					'url' => array(
						'name' 		=> __( 'URL', 'anva' ),
						'desc'		=> __( 'Where should the link go?.', 'anva' ),
						'id'			=> 'url',
						'type' 		=> 'text',
						'std'			=> ''
					),
					'description' => array(
						'name' 		=> __( 'Description', 'anva' ),
						'desc'		=> __( 'What should the description say?.', 'anva' ),
						'id'			=> 'description',
						'type' 		=> 'textarea',
						'std'			=> ''
					),
					'content' => array(
						'name' 		=> __( 'Content', 'anva' ),
						'desc'		=> __( 'Select a option to show the content.', 'anva' ),
						'id'			=> 'content',
						'type' 		=> 'select',
						'std'			=> 'hide',
						'options'	=> array(
							'title' => anva_get_local( 'slide_title'),
							'desc' 	=> anva_get_local( 'slide_desc' ),
							'both' 	=> anva_get_local( 'slide_show' ),
							'hide' 	=> anva_get_local( 'slide_hide' )
						)
					),
				)
			)
		);

		// Slider options
		$this->core_sliders['owl']['options'] = array(
			'owl_items' => array(
				'id'		=> 'owl_items',
				'name'		=> __( 'Items', 'anva' ),
				'desc'		=> __( 'Enter the number of items you want to see on the screen.', 'anva' ),
				'std'		=> '1',
				'type'		=> 'number',
				'class' 	=> 'slider-item owl hide'
			),
			'owl_margin' => array(
				'id'		=> 'owl_margin',
				'name'		=> __( 'Margin', 'anva' ),
				'desc'		=> __( 'Enter the margin-right(px) on item.', 'anva' ),
				'std'		=> '0',
				'type'		=> 'number',
				'class' 	=> 'slider-item owl hide'
			),
			'owl_animate_in' => array(
				'id'		=> 'owl_animate_in',
				'name'		=> __( 'Animation In', 'anva' ),
				'desc'		=> __( 'Select the animation input.', 'anva' ),
				'std'		=> 'zoomIn',
				'type'		=> 'select',
				'options'	=> $animations,
				'class' 	=> 'slider-item owl hide'
			),
			'owl_animate_out' => array(
				'id'		=> 'owl_animate_out',
				'name'		=> __( 'Animation Out', 'anva' ),
				'desc'		=> __( 'Select the animation output.', 'anva' ),
				'std'		=> 'zoomOut',
				'type'		=> 'select',
				'options'	=> $animations,
				'class' 	=> 'slider-item owl hide'
			),
			'owl_loop' => array(
				'id'		=> 'owl_loop',
				'name'		=> __( 'Loop', 'anva' ),
				'desc'		=> __( 'Select if you want enable the infinity loop.', 'anva' ),
				'std'		=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'true' => __( 'Yes, enable inifnity loop', 'anva' ),
					'false' => __( 'No, disable infinity loop', 'anva' ),
				),
				'class' 	=> 'slider-item owl hide'
			),
			'owl_pagi' => array(
				'id'		=> 'owl_pagi',
				'name'		=> __( 'Pagination', 'anva' ),
				'desc'		=> __( 'Select if you want enable the pagination dots.', 'anva' ),
				'std'		=> 'false',
				'type'		=> 'select',
				'options'	=> array(
					'true' => __( 'Yes, enable pagination', 'anva' ),
					'false' => __( 'No, disable pagination', 'anva' ),
				),
				'class' 	=> 'slider-item owl hide'
			),
			'owl_speed' => array(
				'id'		=> 'owl_speed',
				'name'		=> __( 'Speed', 'anva' ),
				'desc'		=> __( 'Enter the speed. Default is 450.', 'anva' ),
				'std'		=> 450,
				'type'		=> 'number',
				'class'		=> 'slider-item owl hide'
			),
			'owl_autoplay' => array(
				'id'		=> 'owl_autoplay',
				'name'		=> __( 'Autoplay', 'anva' ),
				'desc'		=> __( 'Enter the autoplay interval timeout. Default is 5000 in milliseconds.', 'anva' ),
				'std'		=> 5000,
				'type'		=> 'number',
				'class'		=> 'slider-item owl hide'
			),
		);

		/*--------------------------------------------*/
		/* Nivo Slider
		/*--------------------------------------------*/

		// Slide Types
		$this->core_sliders['nivo']['types'] = array(
			'image' => array(
				'name' 			=> __( 'Image Slide', 'anva' ),
				'main_title'	=> __( 'Setup Image', 'anva' )
			)
		);

		// Slide Media Positions
		$this->core_sliders['nivo']['positions'] = array(
			'full' => 'slider_lg' // Default
		);

		// Slide Elements
		$this->core_sliders['nivo']['elements'] = array(
			'image_link',
			'description'
		);

		// Slider Options
		$this->core_sliders['nivo']['options'] = array(
			'nivo_fx' => array(
				'id'			=> 'nivo_fx',
				'name'		=> __( 'How to transition between slides?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'fade',
				'type'		=> 'select',
				'options'	=> array(
					'fade' 	=> 'Fade',
					'slide'	=> 'Slide'
				),
				'class' 	=> 'slider-item nivo hide'
			),
			'nivo_smoothheight' => array(
				'id'			=> 'nivo_smoothheight',
				'name'		=> __( 'Allow height to adjust on each transition?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'false',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable smoothHeight.',
					'false'	=> 'No, display as height of tallest slide.'
				),
				'class'		=> 'slider-item nivo hide'
			),
		);
		
		/*--------------------------------------------*/
		/* Bootstrap Carousel
		/*--------------------------------------------*/

		// Slide Types
		$this->core_sliders['bootstrap']['types'] = array(
			'image' => array(
				'name' 			=> __( 'Image Slide', 'anva' ),
				'main_title'	=> __( 'Setup Image', 'anva' )
			)
		);

		// Slide Media Positions
		$this->core_sliders['bootstrap']['positions'] = array(
			'full' => 'slider-large' // Default
		);

		// Slide Elements
		$this->core_sliders['bootstrap']['elements'] = array(
			'image_link',
			'headline',
			'description'
		);

		// Slider Options
		$this->core_sliders['bootstrap']['options'] = array(
			'bootstrap_fx' => array(
				'id'			=> 'bootstrap_fx',
				'name'		=> __( 'How to transition between slides?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'fade',
				'type'		=> 'select',
				'options'	=> array(
					'fade' 	=> 'Fade',
					'slide'	=> 'Slide'
				),
				'class' 	=> 'slider-item bootstrap hide'
			),
			'smoothheight' => array(
				'id'			=> 'smoothheight',
				'name'		=> __( 'Allow height to adjust on each transition?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'false',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable smoothHeight.',
					'false'	=> 'No, display as height of tallest slide.'
				),
				'class'		=> 'slider-item bootstrap hide'
			),
		);

		/*--------------------------------------------*/
		/* Swiper
		/*--------------------------------------------*/

		// Slider Options
		$this->core_sliders['swiper']['options'] = array(
			'swiper_fx' => array(
				'id'			=> 'swiper_fx',
				'name'		=> __( 'How to transition between slides?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'fade',
				'type'		=> 'select',
				'options'	=> array(
					'fade' 	=> 'Fade',
					'slide'	=> 'Slide'
				),
				'class' 	=> 'slider-item swiper hide'
			),
			'swiper_smoothheight' => array(
				'id'			=> 'swiper_smoothheight',
				'name'		=> __( 'Allow height to adjust on each transition?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'false',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable smoothHeight.',
					'false'	=> 'No, display as height of tallest slide.'
				),
				'class'		=> 'slider-item swiper hide'
			),
		);

		/*--------------------------------------------*/
		/* Camera
		/*--------------------------------------------*/

		// Slider Options
		$this->core_sliders['camera']['options'] = array(
			'camera_fx' => array(
				'id'			=> 'camera_fx',
				'name'		=> __( 'How to transition between slides?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'fade',
				'type'		=> 'select',
				'options'	=> array(
					'fade' 	=> 'Fade',
					'slide'	=> 'Slide'
				),
				'class' 	=> 'slider-item camera hide'
			),
			'smoothheight' => array(
				'id'			=> 'smoothheight',
				'name'		=> __( 'Allow height to adjust on each transition?', 'anva' ),
				'desc'		=> __( 'Hello', 'anva' ),
				'std'			=> 'false',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable smoothHeight.',
					'false'	=> 'No, display as height of tallest slide.'
				),
				'class'		=> 'slider-item camera hide'
			),
		);

		/*--------------------------------------------*/
		/* Extend
		/*--------------------------------------------*/

		$this->core_sliders = apply_filters( 'anva_core_sliders', $this->core_sliders );

	}

	/**
	 * Set slider types
	 * 
	 * Then remove any types that have been set to be removed.
	 *
	 * @since 1.0.0
	 */
	public function set_sliders() {

		// Combine core sliders with custom sliders
		$this->sliders = array_merge( $this->core_sliders, $this->custom_sliders );

		// Remove elements
		if ( $this->remove_sliders ) {
			foreach ( $this->remove_sliders as $slider_id ) {
				if ( isset( $this->sliders[$slider_id] ) ) {
					unset( $this->sliders[$slider_id] );
				}
			}
		}

		// Extend
		$this->sliders = apply_filters( 'anva_recognized_sliders', $this->sliders );

	}

	/**
	 * Add custom slider
	 *
	 * @since 1.0.0
	 */
	public function add( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options ) {

		//if ( is_admin() ) {

			// Start new slider
			$new_slider  = array(
				'name' 		 => $slider_name,
				'id'			 => $slider_id,
				'options'	 => $options,
				'elements' => $elements
			);

			// Slide Types
			// $slide_types should look something like: array( 'image', 'video', 'custom' )
			$new_slider['types'] = array();

			if ( $slide_types ) {
				foreach ( $slide_types as $type ) {
					switch ( $type ) {

						case 'image' :
							$new_slider['types']['image'] = array(
								'name' 			=> __( 'Image Slide', 'anva' ),
								'main_title' 	=> __( 'Setup Image', 'anva' )
							);
							break;

						case 'video' :
							$new_slider['types']['video'] = array(
								'name' 			=> __( 'Video Slide', 'anva' ),
								'main_title' 	=> __( 'Video Link', 'anva' )
							);
							break;

						case 'custom' :
							$new_slider['types']['custom'] = array(
								'name' 			=> __( 'Custom Slide', 'anva' ),
								'main_title' 	=> __( 'Setup Custom Content', 'anva' )
							);
							break;

					}
				}
			}

			// Slide Media Positions
			// $media_positions should look something like: array( 'full' => 'crop_size', 'align-left' => 'crop_size', 'align-right' => 'crop_size' )
			$new_slider['positions'] = array();

			$positions = apply_filters( 'anva_slider_image_positions', array( 'full', 'align-left', 'align-right' ) );

			if ( $media_positions ) {
				foreach ( $media_positions as $position => $crop_size ) {
					if ( in_array( $position, $positions ) ) {
						$new_slider['positions'][$position] = $crop_size;
					}
				}
			}

			// Add new slider
			$this->custom_sliders[$slider_id] = $new_slider;

		//}

		// Add frontend display
		//add_action( 'anva_slider_' . $slider_id, );
	}

	/**
	 * Remove slider
	 *
	 * @since 1.0.0
	 */
	public function remove( $slider_id ) {
		$this->remove_sliders[] = $slider_id;
	}

	/**
	 * Get default sliders
	 *
	 * @since 1.0.0
	 */
	public function get_core_sliders() {
		return $this->core_sliders;
	}

	/**
	 * Get custom sliders
	 *
	 * @since 1.0.0
	 */
	public function get_custom_sliders() {
		return $this->custom_sliders;
	}

	/**
	 * Get sliders to be removed
	 *
	 * @since 1.0.0
	 */
	public function get_remove_sliders() {
		return $this->remove_sliders;
	}

	/**
	 * Get finalized sliders
	 *
	 * @since 1.0.0
	 */
	public function get_sliders( $slider_id = '' ) {

		if ( ! $slider_id ) {
			return $this->sliders;
		}

		if ( isset( $this->sliders[$slider_id] ) ) {
			return $this->sliders[$slider_id];
		}

		return array();

	}

	/**
	 * Determine if slider type is valid
	 *
	 * @since 1.0.0
	 */
	public function is_slider( $slider_id ) {

		if ( isset( $this->sliders[$slider_id] ) ) {
			return true;
		}

		return false;
	}

}
endif;