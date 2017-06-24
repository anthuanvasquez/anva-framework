<?php

if ( ! class_exists( 'Anva_Builder_Components' ) ) :

/**
 * Anva Page Builder Elements API.
 *
 * This sets up the default Builder elements
 * Also, this class adds and API to add/remove these elements.
 *
 * @since     1.0.0
 * @author    Anthuan Vásquez
 * @copyright Copyright (c) Anthuan Vásquez
 * @link      http://anthuanvasquez.net
 * @package   AnvaFramework
 */
class Anva_Builder_Components {
	/**
	 * A single instance of this class.
	 *
	 * @since 1.0.0
	 */
	private static $instance = NULL;

	/**
	 * Core framework builder elements and settings
	 * WP-Admin only.
	 *
	 * @since 1.0.0
	 */
	private $core_elements = array();

	/**
	 * Elements and settings added
	 * WP-Admin only.
	 *
	 * @since 1.0.0
	 */
	private $custom_elements = array();

	/**
	 * Elements to remove from page builder.
	 * WP-Admin only.
	 *
	 * @since 1.0.0
	 */
	private $remove_elements = array();

	/**
	 * Final array of elements and settings. This combines
	 * $core_elements and $custom_elements. WP-Admin only.
	 *
	 * @since 1.0.0
	 */
	private $elements = array();

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
	 * Hook everything in.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// Setup framework default elements
		$this->set_core_elements();

		// Establish elements
		add_action( 'after_setup_theme', array( $this, 'set_elements' ), 1000 );

	}

	/**
	 * Set core elements
	 *
	 * These will be later merged with custom elements.
	 * WP-Admin only.
	 *
	 * @since 1.0.0
	 */
	public function set_core_elements() {

		/*--------------------------------------------*/
		/* Helpers
		/*--------------------------------------------*/

		// Get sidebar locations
		$sidebars = array();
		foreach ( anva_get_sidebar_layouts() as $sidebar_id => $sidebar ) {
			$sidebars[$sidebar_id] = $sidebar['name'];
		}

		// Pull all the posts galleries
		$galleries      = array();
		$galleries_args = array( 'numberposts' => -1, 'post_type' => array( 'galleries' ) );
		$gallery_posts  = get_posts( $galleries_args );

		if ( count( $gallery_posts ) > 0 ) {
			$galleries[''] = esc_html__( 'Select a Gallery', 'anva' );
			foreach ( $gallery_posts as $gallery ) {
				$galleries[ $gallery->ID ] = $gallery->post_title;
			}
		}

		// Pull all the galleries cat
		$gallery_cats = array();
		$terms = get_terms( 'gallery_album', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order' );

		// Pull all the blog categories into an array
		$categories = array();
		if ( is_admin() ) {
			foreach ( get_categories() as $category ) {
				$categories[$category->cat_ID] = $category->cat_name;
			}
		}

		// Image path
		$image_path = trailingslashit( ANVA_FRAMEWORK_ADMIN_IMG . 'builder' );

		/*--------------------------------------------*/
		/* Divider
		/*--------------------------------------------*/

		$this->core_elements['divider'] = array(
			'name'    => esc_html__( 'Divider', 'anva' ),
			'desc'    => esc_html__( 'Separate sections with page break.', 'anva' ),
			'icon'    => $image_path . 'divider.png',
			'content' => false,
			'attr'    => array(),
		);

		/*--------------------------------------------*/
		/* Header
		/*--------------------------------------------*/

		$this->core_elements['header_text'] = array(
			'name'    => esc_html__( 'Header', 'anva' ),
			'desc'    => esc_html__( 'Create a header with some nice text.', 'anva' ),
			'icon'    => $image_path . 'header.png',
			'content' => true,
			'attr'    => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
					'id'   => 'slug',
					'std'  => '',
					'type' => 'text',
				),
				'subtitle' => array(
					'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
					'desc' => esc_html__( 'Enter short description for this header', 'anva' ),
					'id'   => 'subtitle',
					'std'  => '',
					'type' => 'text',
				),
				'width' => array(
					'name'    => esc_html__( 'Content Width', 'anva' ),
					'desc'    => esc_html__( 'Select width in percentage for this content', 'anva' ),
					'id'      => 'width',
					'std'     => '100%',
					'type'    => 'select',
					'options' => array(
						'100%' 	=> '100%',
						'90%' 	=> '90%',
						'80%' 	=> '80%',
						'70%' 	=> '70%',
						'60%' 	=> '60%',
						'50%' 	=> '50%',
					),
				),
				'padding' => array(
					'name'    => esc_html__( 'Content Padding', 'anva' ),
					'desc'    => esc_html__( 'Select padding top and bottom value for this header block.', 'anva' ),
					'type'    => 'range',
					'id'      => 'padding',
					'std'     => 30,
					'options' => array(
						'min'   => 0,
						'max'   => 200,
						'step'  => 5,
						'units' => 'px',
					),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'desc' => esc_html__( 'Select background color for this this block.', 'anva' ),
					'id'   => 'bgcolor',
					'std'  => '#f9f9f9',
					'type' => 'color',
				),
				'fontcolor' => array(
					'name' => esc_html__( 'Text Color', 'anva' ),
					'desc' => esc_html__( 'Select font color for content on this block.', 'anva' ),
					'id'   => 'fontcolor',
					'std'  => '#444444',
					'type' => 'color',
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only).', 'anva' ),
					'id'   => 'custom_css',
					'std'  => '',
					'type' => 'code',
				),
			),
		);

		/*--------------------------------------------*/
		/* Header Image
		/*--------------------------------------------*/

		$this->core_elements['header_image'] = array(
			'name' => esc_html__( 'Header With Background Image', 'anva' ),
			'icon' => $image_path . 'header_image.png',
			'type' => 'media',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'subtitle' => array(
					'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter short description for this header', 'anva' ),
				),
				'background' => array(
					'name' => esc_html__( 'Background Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display as background', 'anva' ),
				),
				'background_parallax' => array(
					'name' => esc_html__( 'Background Parallax', 'anva' ),
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => esc_html__( 'Select to enable parallax effect to background image', 'anva' ),
				),
				'background_position' => array(
					'name' => esc_html__( 'Background Position (Optional)', 'anva' ),
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => esc_html__( 'Select image background position option', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'fontcolor' => array(
					'name' => esc_html__( 'Font Color', 'anva' ),
					'type' => 'color',
					'std' => '#dd3333',
					'desc' => esc_html__( 'Select font color for content on this block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => esc_html__( 'Create a header with some nice text using a background image.', 'anva' ),
			'content' => true
		);

		/*--------------------------------------------*/
		/* Text
		/*--------------------------------------------*/

		$this->core_elements['text_fullwidth'] = array(
			'name' => esc_html__( 'Text Fullwidth', 'anva' ),
			'icon' => $image_path . 'text.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				    'id'   => 'slug',
					'type' => 'text',
				),
				'width' => array(
					'name' => esc_html__( 'Content Width', 'anva' ),
					'desc' => esc_html__( 'Select width in percentage for this content', 'anva' ),
					'id'   => 'width',
					'std'  => '80%',
					'type' => 'select',
					'options' => array(
						'100%' 	=> '100%',
						'90%' 	=> '90%',
						'80%' 	=> '80%',
						'70%' 	=> '70%',
						'60%' 	=> '60%',
						'50%' 	=> '50%',
					),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				    'id'   => 'padding',
					'std'  => 30,
					'type' => 'range',
					'options' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 5,
					),
				),
				'bgcolor' => array(
				    'id'  => 'bgcolor',
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std'  => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'fontcolor' => array(
				    'id'   => 'fontcolor',
					'name' => esc_html__( 'Font Color', 'anva' ),
					'type' => 'color',
					'std'  => '#444444',
					'desc' => esc_html__( 'Select font color for content on this block', 'anva' ),
				),
				'custom_css' => array(
					'id'   => 'custom_css',
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => true
		);

		/*--------------------------------------------*/
		/* Text Image
		/*--------------------------------------------*/

		$this->core_elements['text_image'] = array(
			'name' => esc_html__( 'Text With Background Image', 'anva' ),
			'icon' => $image_path . 'text_image.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'background' => array(
					'name' => esc_html__( 'Background Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display as background', 'anva' ),
				),
				'background_parallax' => array(
					'name' => esc_html__( 'Background Parallax', 'anva' ),
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => esc_html__( 'Select to enable parallax effect to background image', 'anva' ),
				),
				'background_position' => array(
					'name' => esc_html__( 'Background Position (Optional)', 'anva' ),
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => esc_html__( 'Select image background position option', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'fontcolor' => array(
					'name' => esc_html__( 'Font Color', 'anva' ),
					'type' => 'color',
					'std' => '#444444',
					'desc' => esc_html__( 'Select font color for content on this block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => true
		);

		/*--------------------------------------------*/
		/* Image Fullwidth
		/*--------------------------------------------*/

		$this->core_elements['image_fullwidth'] = array(
			'name' => esc_html__( 'Image Fullwidth', 'anva' ),
			'icon' => $image_path . 'image_full.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image' => array(
					'name' => esc_html__( 'Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'height' => array(
					'name' => esc_html__( 'Height', 'anva' ),
					'type' => 'range',
					'std' => '600',
					'min' => 30,
					'max' => 1000,
					'step' => 5,
					'desc' => esc_html__( 'Select number of height for this content (in pixel)', 'anva' ),
				),
				'background_position' => array(
					'name' => esc_html__( 'Background Position', 'anva' ),
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => esc_html__( 'Select image background position option', 'anva' ),
				),
				'display_caption' => array(
					'name' => esc_html__( 'Display caption', 'anva' ),
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No',
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std'  => '30',
					'min'  => 0,
					'max'  => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		/*--------------------------------------------*/
		/* Image Parallax
		/*--------------------------------------------*/

		$this->core_elements['image_parallax'] = array(
			'name' => esc_html__( 'Image Parallax', 'anva' ),
			'icon' => $image_path . 'image_parallax.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image' => array(
					'name' => esc_html__( 'Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'height' => array(
					'name' => esc_html__( 'Height', 'anva' ),
					'type' => 'range',
					'std' => '600',
					'min' => 30,
					'max' => 1000,
					'step' => 5,
					'desc' => esc_html__( 'Select number of height for this content (in pixel)', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		/*--------------------------------------------*/
		/* Image Fixed Width
		/*--------------------------------------------*/

		$this->core_elements['image_fixed_width'] = array(
			'name' => esc_html__( 'Image Fixed Width', 'anva' ),
			'icon' => $image_path . 'image_fixed.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image' => array(
					'name' => esc_html__( 'Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'display_caption' => array(
					'name' => esc_html__( 'Display caption and description', 'anva' ),
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		/*--------------------------------------------*/
		/* 1/2 Content with Background
		/*--------------------------------------------*/

		$this->core_elements['content_half_bg'] = array(
			'name' => esc_html__( '1/2 Content with Background', 'anva' ),
			'icon' => $image_path . 'half_content_bg.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'subtitle' => array(
					'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter short description for this header', 'anva' ),
				),
				'background' => array(
					'name' => esc_html__( 'Background Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display as background', 'anva' ),
				),
				'background_parallax' => array(
					'name' => esc_html__( 'Background Parallax', 'anva' ),
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => esc_html__( 'Select to enable parallax effect to background image', 'anva' ),
				),
				'background_position' => array(
					'name' => esc_html__( 'Background Position (Optional)', 'anva' ),
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => esc_html__( 'Select image background position option', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 400,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Content Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this content block', 'anva' ),
				),
				'opacity' => array(
					'name' => esc_html__( 'Content Background Opacity', 'anva' ),
					'type' => 'range',
					'std' => '100',
					'min' => 10,
					'max' => 100,
					'step' => 5,
					'desc' => esc_html__( 'Select background opacity for this content block', 'anva' ),
				),
				'fontcolor' => array(
					'name' => esc_html__( 'Font Color (Optional)', 'anva' ),
					'type' => 'color',
					'std' => '#444444',
					'desc' => esc_html__( 'Select font color for this content', 'anva' ),
				),
				'align' => array(
					'name' => esc_html__( 'Content Box alignment', 'anva' ),
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => esc_html__( 'Select the alignment for content box', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['image_half_fixed_width'] = array(
			'name' => esc_html__( 'Image 1/2 Width', 'anva' ),
			'icon' => $image_path . 'image_half_fixed.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image' => array(
					'name' => esc_html__( 'Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'align' => array(
					'name' => esc_html__( 'Image alignment', 'anva' ),
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => esc_html__( 'Select the alignment for image', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['image_half_fullwidth'] = array(
			'name' => esc_html__( 'Image 1/2 Fullwidth', 'anva' ),
			'icon' => $image_path . 'image_half_full.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'subtitle' => array(
					'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter short description for this header', 'anva' ),
				),
				'image' => array(
					'name' => esc_html__( 'Image', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'height' => array(
					'name' => esc_html__( 'Height', 'anva' ),
					'type' => 'range',
					'std' => '600',
					'min' => 30,
					'max' => 1000,
					'step' => 5,
					'desc' => esc_html__( 'Select number of height for this content (in pixel)', 'anva' ),
				),
				'align' => array(
					'name' => esc_html__( 'Image alignment', 'anva' ),
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => esc_html__( 'Select the alignment for image', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'fontcolor' => array(
					'name' => esc_html__( 'Font Color', 'anva' ),
					'type' => 'color',
					'std' => '#000000',
					'desc' => esc_html__( 'Select font color for title and subtitle', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['two_cols_images'] = array(
			'name' => esc_html__( 'Images Two Columns', 'anva' ),
			'icon' => $image_path . 'images_two_cols.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image1' => array(
					'name' => esc_html__( 'Image 1', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image2' => array(
					'name' => esc_html__( 'Image 2', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'display_caption' => array(
					'name' => esc_html__( 'Display caption and description', 'anva' ),
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['three_cols_images'] = array(
			'name' => esc_html__( 'Images Three Columns', 'anva' ),
			'icon' => $image_path . 'images_three_cols.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image1' => array(
					'name' => esc_html__( 'Image 1', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image2' => array(
					'name' => esc_html__( 'Image 2', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image3' => array(
					'name' => esc_html__( 'Image 3', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'display_caption' => array(
					'name' => esc_html__( 'Display caption and description', 'anva' ),
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['three_images_block'] = array(
			'name' => esc_html__( 'Images Three blocks', 'anva' ),
			'icon' => $image_path . 'images_three_block.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image_portrait' => array(
					'name' => esc_html__( 'Image Portrait', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content (Portrait image size)', 'anva' ),
				),
				'image_portrait_align' => array(
					'name' => esc_html__( 'Image Portrait alignment', 'anva' ),
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => esc_html__( 'Select the alignment for image portrait size', 'anva' ),
				),
				'image2' => array(
					'name' => esc_html__( 'Image 2', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image3' => array(
					'name' => esc_html__( 'Image 3', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'display_caption' => array(
					'name' => esc_html__( 'Display caption and description', 'anva' ),
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['four_images_block'] = array(
			'name' => esc_html__( 'Images Four blocks', 'anva' ),
			'desc' => '',
			'icon' => $image_path . 'images_four_block.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'image1' => array(
					'name' => esc_html__( 'Image 1', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image2' => array(
					'name' => esc_html__( 'Image 2', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image3' => array(
					'name' => esc_html__( 'Image 3', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'image4' => array(
					'name' => esc_html__( 'Image 4', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Upload image you want to display for this content', 'anva' ),
				),
				'display_caption' => array(
					'name' => esc_html__( 'Display caption and description', 'anva' ),
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'content' => false
		);

			$this->core_elements['galleries'] = array(
				'name' => esc_html__( 'Gallery Archive', 'anva' ),
				'desc' => '',
				'icon' => $image_path . 'galleries.png',
				'attr' => array(
					'cat' => array(
						'name' => esc_html__( 'Gallery Category', 'anva' ),
						'type' => 'select',
						'options' => $gallery_cats,
						'desc' => esc_html__( 'Select the gallery category (optional)', 'anva' ),
					),
					'items' => array(
						'type' => 'range',
						'std' => '12',
						'min' => 1,
						'max' => 100,
						'step' => 1,
						'desc' => esc_html__( 'Enter number of items to display', 'anva' ),
					),
					'bgcolor' => array(
						'name' => esc_html__( 'Background Color (Optional)', 'anva' ),
						'type' => 'color',
						'std' => '#f9f9f9',
						'desc' => esc_html__( 'Select background color for this content block', 'anva' ),
					),
					'custom_css' => array(
						'name' => esc_html__( 'Custom CSS', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
					),
				),
				'content' => false
			);

			$this->core_elements['gallery_slider'] = array(
				'name' => esc_html__( 'Gallery Slider Fullwidth', 'anva' ),
				'desc' => '',
				'icon' => $image_path . 'gallery_slider_full.png',
				'attr' => array(
					'slug' => array(
						'name' => esc_html__( 'Slug (Optional)', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
					),
					'gallery' => array(
						'name' => esc_html__( 'Gallery', 'anva' ),
						'type' => 'select',
						'options' => $galleries,
						'desc' => esc_html__( 'Select the gallery you want to display', 'anva' ),
					),
					'autoplay' => array(
						'name' => esc_html__( 'Auto Play', 'anva' ),
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => esc_html__( 'Auto play gallery image slider', 'anva' ),
					),
					'timer' => array(
						'name' => esc_html__( 'Timer', 'anva' ),
						'type' => 'range',
						'std' => '5',
						'min' => 1,
						'max' => 60,
						'step' => 1,
						'desc' => esc_html__( 'Select number of seconds for slider timer', 'anva' ),
					),
					'caption' => array(
						'name' => esc_html__( 'Display Image Caption', 'anva' ),
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => esc_html__( 'Display gallery image caption', 'anva' ),
					),
					'padding' => array(
						'name' => esc_html__( 'Content Padding', 'anva' ),
						'type' => 'range',
						'std' => '30',
						'min' => 0,
						'max' => 200,
						'step' => 5,
						'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
					),
					'custom_css' => array(
						'name' => esc_html__( 'Custom CSS', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
					),
				),
				'content' => false
			);

			$this->core_elements['gallery_slider_fixed_width'] = array(
				'name' => esc_html__( 'Gallery Slider Fixed Width', 'anva' ),
				'desc' => '',
				'icon' => $image_path . 'gallery_slider_fixed.png',
				'attr' => array(
					'slug' => array(
						'name' => esc_html__( 'Slug (Optional)', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
					),
					'gallery' => array(
						'name' => esc_html__( 'Gallery', 'anva' ),
						'type' => 'select',
						'options' => $galleries,
						'desc' => esc_html__( 'Select the gallery you want to display', 'anva' ),
					),
					'autoplay' => array(
						'name' => esc_html__( 'Auto Play', 'anva' ),
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => esc_html__( 'Auto play gallery image slider', 'anva' ),
					),
					'timer' => array(
						'name' => esc_html__( 'Timer', 'anva' ),
						'type' => 'range',
						'std' => '5',
						'min' => 1,
						'max' => 60,
						'step' => 1,
						'desc' => esc_html__( 'Select number of seconds for slider timer', 'anva' ),
					),
					'caption' => array(
						'name' => esc_html__( 'Display Image Caption', 'anva' ),
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => esc_html__( 'Display gallery image caption', 'anva' ),
					),
					'padding' => array(
						'name' => esc_html__( 'Content Padding', 'anva' ),
						'type' => 'range',
						'std' => '30',
						'min' => 0,
						'max' => 200,
						'step' => 5,
						'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
					),
					'bgcolor' => array(
						'name' => esc_html__( 'Background Color', 'anva' ),
						'type' => 'color',
						'std' => '#f9f9f9',
						'desc' => esc_html__( 'Select background color for this header block', 'anva' ),
					),
					'custom_css' => array(
						'name' => esc_html__( 'Custom CSS', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
					),
				),
				'content' => false,
			);

			$this->core_elements['animated_gallery_grid'] = array(
				'name' => esc_html__( 'Animated Gallery Grid', 'anva' ),
				'icon' => $image_path . 'animated_grid.png',
				'attr' => array(
					'slug' => array(
						'name' => esc_html__( 'Slug (Optional)', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
					),
					'subtitle' => array(
						'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'Enter short description for this header', 'anva' ),
					),
					'gallery_id' => array(
						'name' => esc_html__( 'Gallery', 'anva' ),
						'type' => 'select',
						'options' => $galleries,
						'desc' => esc_html__( 'Select the gallery you want to display', 'anva' ),
					),
					'logo' => array(
						'name' => esc_html__( 'Retina Logo or Signature Image (Optional)', 'anva' ),
						'type' => 'file',
						'desc' => esc_html__( 'Enter custom logo or signature image URL', 'anva' ),
					),
					'bgcolor' => array(
						'name' => esc_html__( 'Background Color (Optional)', 'anva' ),
						'type' => 'color',
						'std' => '#ffffff',
						'desc' => esc_html__( 'Select background color for this content block', 'anva' ),
					),
					'opacity' => array(
						'name' => esc_html__( 'Content Background Opacity', 'anva' ),
						'type' => 'range',
						'std' => '100',
						'min' => 10,
						'max' => 100,
						'step' => 5,
						'desc' => esc_html__( 'Select background opacity for this content block', 'anva' ),
					),
					'fontcolor' => array(
						'name' => esc_html__( 'Font Color (Optional)', 'anva' ),
						'type' => 'color',
						'std' => '#444444',
						'desc' => esc_html__( 'Select font color for this content', 'anva' ),
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['gallery_grid'] = array(
				'name' =>  esc_html__( 'Gallery Grid', 'anva' ),
				'icon' => $image_path . 'gallery_grid.png',
				'attr' => array(
					'slug' => array(
						'name' => esc_html__( 'Slug (Optional)', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
					),
					'gallery_id' => array(
						'name' => esc_html__( 'Gallery', 'anva' ),
						'type' => 'select',
						'options' => $galleries,
						'desc' => esc_html__( 'Select the gallery you want to display', 'anva' ),
					),
					'bgcolor' => array(
						'name' => esc_html__( 'Background Color (Optional)', 'anva' ),
						'type' => 'color',
						'std' => '#ffffff',
						'desc' => esc_html__( 'Select background color for this content block', 'anva' ),
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['gallery_masonry'] = array(
				'name' => esc_html__( 'Gallery Masonry', 'anva' ),
				'icon' => $image_path . 'gallery_masonry.png',
				'attr' => array(
					'slug' => array(
						'name' => esc_html__( 'Slug (Optional)', 'anva' ),
						'type' => 'text',
						'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
					),
					'gallery_id' => array(
						'name' => esc_html__( 'Gallery', 'anva' ),
						'type' => 'select',
						'options' => $galleries,
						'desc' => esc_html__( 'Select the gallery you want to display', 'anva' ),
					),
					'bgcolor' => array(
						'name' => esc_html__( 'Background Color (Optional)', 'anva' ),
						'type' => 'color',
						'std' => '#ffffff',
						'desc' => esc_html__( 'Select background color for this content block', 'anva' ),
					),
				),
				'desc' => '',
				'content' => false
			);

		$this->core_elements['blog_grid'] = array(
			'name' => esc_html__( 'Blog Grid', 'anva' ),
			'icon' => $image_path . 'blog.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'cat' => array(
					'name' => esc_html__( 'Filter by category', 'anva' ),
					'type' => 'select',
					'options' => $categories,
					'desc' => esc_html__( 'You can choose to display only some posts from selected category', 'anva' ),
				),
				'items' => array(
					'type' => 'range',
					'std' => '9',
					'min' => 1,
					'max' => 100,
					'step' => 1,
					'desc' => esc_html__( 'Enter number of items to display', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'link_title' => array(
					'name' => esc_html__( 'Enter button title (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter link button to display link to your blog page for example. Read more', 'anva' ),
				),
				'link_url' => array(
					'name' => esc_html__( 'Button Link URL (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter redirected link URL when button is clicked', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['contact_map'] = array(
			'name' => esc_html__( 'Contact Form With Map', 'anva' ),
			'icon' => $image_path . 'contact_map.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'subtitle' => array(
					'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter short description for this header', 'anva' ),
				),
				'type' => array(
					'name' => esc_html__( 'Map Type', 'anva' ),
					'type' => 'select',
					'options' => array(
						'ROADMAP' => 'Roadmap',
						'SATELLITE' => 'Satellite',
						'HYBRID' => 'Hybrid',
						'TERRAIN' => 'Terrain',
					),
					'desc' => esc_html__( 'Select google map type', 'anva' ),
				),
				'lat' => array(
					'name' => esc_html__( 'Latitude', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Map latitude.', 'anva' ),
				),
				'long' => array(
					'name' => esc_html__( 'Longtitude', 'anva' ),
					'type' => 'text',
					'desc' => __('Map longitude.', 'anva' ),
				),
				'zoom' => array(
					'name' => esc_html__( 'Zoom Level', 'anva' ),
					'type' => 'range',
					'std' => '8',
					'min' => 1,
					'max' => 16,
					'step' => 1,
					'desc' => esc_html__( 'Enter zoom level', 'anva' ),
				),
				'popup' => array(
					'name' => esc_html__( 'Popup Text', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter text to display as popup above location on map for example. your company name', 'anva' ),
				),
				'marker' => array(
					'name' => esc_html__( 'Custom Marker Icon (Optional)', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Enter custom marker image URL', 'anva' ),
				),
				'bgcolor' => array(
					'name' => esc_html__( 'Background Color (Optional)', 'anva' ),
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => esc_html__( 'Select background color for this content block', 'anva' ),
				),
				'fontcolor' => array(
					'name' => esc_html__( 'Font Color (Optional)', 'anva' ),
					'type' => 'color',
					'std' => '#444444',
					'desc' => esc_html__( 'Select font color for this content', 'anva' ),
				),
				'buttonbgcolor' => array(
					'name' => esc_html__( 'Button Background Color (Optional)', 'anva' ),
					'type' => 'color',
					'std' => '#000000',
					'desc' => esc_html__( 'Select background color for contact form button', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['map'] = array(
			'name' => esc_html__( 'Fullwidth Map', 'anva' ),
			'icon' => $image_path . 'googlemap.png',
			'desc' => '',
			'content' => false,
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'type' => array(
					'name' => esc_html__( 'Map Type', 'anva' ),
					'type' => 'select',
					'options' => array(
						'ROADMAP' => 'Roadmap',
						'SATELLITE' => 'Satellite',
						'HYBRID' => 'Hybrid',
						'TERRAIN' => 'Terrain',
					),
					'desc' => esc_html__( 'Select google map type', 'anva' ),
				),
				'height' => array(
					'name' => esc_html__( 'Height', 'anva' ),
					'type' => 'range',
					'std' => '600',
					'min' => 10,
					'max' => 1000,
					'step' => 10,
					'desc' => esc_html__( 'Select map height (in px)', 'anva' ),
				),
				'lat' => array(
					'name' => esc_html__( 'Latitude', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Map latitude.', 'anva' ),
				),
				'long' => array(
					'name' => esc_html__( 'Longtitude', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Map longitude.', 'anva' ),
				),
				'zoom' => array(
					'name' => esc_html__( 'Zoom Level', 'anva' ),
					'type' => 'range',
					'std' => '8',
					'min' => 1,
					'max' => 16,
					'step' => 1,
					'desc' => esc_html__( 'Enter zoom level', 'anva' ),
				),
				'popup' => array(
					'name' => esc_html__( 'Popup Text', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter text to display as popup above location on map for example. your company name', 'anva' ),
				),
				'marker' => array(
					'name' => esc_html__( 'Custom Marker Icon (Optional)', 'anva' ),
					'type' => 'file',
					'desc' => esc_html__( 'Enter custom marker image URL', 'anva' ),
				),
			),
		);

		/*--------------------------------------------*/
		/* Text Sidebar
		/*--------------------------------------------*/

		$this->core_elements['text_sidebart'] = array(
			'name' => esc_html__( 'Text Sidebar', 'anva' ),
			'desc' => esc_html__( 'Create a text block with sidebar.', 'anva' ),
			'content' => false,
			'icon' => $image_path . '/contact_sidebar.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'anva' ),
				),
				'sidebar' => array(
					'name' => esc_html__( 'Content Sidebar', 'anva' ),
					'type' => 'select',
					'options' => $sidebars,
					'desc' => esc_html__( 'You can select sidebar to display next to classic blog content', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				)
			),
		);

		/*--------------------------------------------*/
		/* Contact Sidebar
		/*--------------------------------------------*/

		$this->core_elements['contact_sidebar'] = array(
			'name' => esc_html__( 'Contact Sidebar', 'anva' ),
			'desc' => esc_html__( 'Create a contact form with sidebar.', 'anva' ),
			'content' => false,
			'icon' => $image_path . '/contact_sidebar.png',
			'attr' => array(
				'slug' => array(
					'name' => esc_html__( 'Slug (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers and hyphens.', 'anva' ),
				),
				'subtitle' => array(
					'name' => esc_html__( 'Sub Title (Optional)', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'Enter short description for this header.', 'anva' ),
				),
				'sidebar' => array(
					'name' => esc_html__( 'Content Sidebar', 'anva' ),
					'type' => 'select',
					'options' => $sidebars,
					'desc' => esc_html__( 'You can select sidebar to display next to classic blog content.', 'anva' ),
				),
				'padding' => array(
					'name' => esc_html__( 'Content Padding', 'anva' ),
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => esc_html__( 'Select padding top and bottom value for this header block', 'anva' ),
				),
				'custom_css' => array(
					'name' => esc_html__( 'Custom CSS', 'anva' ),
					'type' => 'text',
					'desc' => esc_html__( 'You can add custom CSS style for this block (advanced user only)', 'anva' ),
				),
			),
		);

		$this->core_elements = apply_filters( 'anva_core_elements', $this->core_elements );

	}

	/**
	 * Set elements by combining core elements and custom elements.
	 * Then remove any elements that have been set to be removed.
	 *
	 * @since 1.0.0
	 */
	public function set_elements() {
		// Combine core elements with custom elements
		$this->elements = array_merge( $this->core_elements, $this->custom_elements );

		// Remove elements
		if ( $this->remove_elements ) {
			foreach ( $this->remove_elements as $element_id ) {
				if ( isset( $this->elements[$element_id] ) ) {
					unset( $this->elements[$element_id] );
				}
			}
		}

		// Extend
		$this->elements = apply_filters( 'anva_elements', $this->elements );

	}

	/**
	 * Add a new element.
	 *
	 * @since 1.0.0
	 */
	public function add_element( $id, $name = '', $icon = '', $attr = array(), $desc = '', $content = false ) {
		$args = array(
			'id'      => $id,
			'name'    => $name,
			'icon'    => $icon,
			'attr'    => $attr,
			'desc'    => $desc,
			'content' => $content
		);

		$defaults = array(
			'id'      => '',
			'name'    => '',
			'icon'    => '',
			'attr'    => array(),
			'desc'    => '',
			'content' => true
		);

		$args = wp_parse_args( $args, $defaults );

		// Add in element
		$this->custom_elements[$args['id']] = array(
			'id'      => $args['id'],
			'name'    => $args['name'],
			'icon'    => $args['icon'],
			'attr'    => $args['attr'],
			'desc'    => $args['desc'],
			'content' => $args['content']
		);

	}

	/**
	 * Remove element.
	 *
	 * @since 1.0.0
	 */
	public function remove_element( $element_id ) {
		// Add to removal array, and process in set_elements()
		$this->remove_elements[] = $element_id;
	}

	/**
	 * Check if an element is currently registered.
	 *
	 * @since 1.0.0
	 */
	public function is_element( $element_id ) {
		return array_key_exists( $element_id, $this->elements );
	}

	/**
	 * Get core elements.
	 *
	 * @since 1.0.0
	 */
	public function get_core_elements() {
		return $this->core_elements;
	}

	/**
	 * Get custom elements.
	 *
	 * @since 1.0.0
	 */
	public function get_custom_elements() {
		return $this->custom_elements;
	}

	/**
	 * Get final elements.
	 *
	 * This is the merged result of core elements and custom elements.
	 *
	 * @since 1.0.0
	 */
	public function get_elements() {
		return $this->elements;
	}

}

endif;
