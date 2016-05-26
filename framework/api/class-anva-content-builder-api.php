<?php

if ( ! class_exists( 'Anva_Content_Builder_API' ) ) :

/**
 * Anva Page Builder Elements API.
 *
 * This sets up the default Builder elements
 * Also, this class adds and API to add/remove these elements.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Content_Builder_API
{
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
	public static function instance()
	{
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
	private function __construct()
	{
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
	public function set_core_elements()
	{
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
			$galleries[''] = __( 'Select a Gallery', 'anva' );
			foreach ( $gallery_posts as $gallery ) {
				$galleries[ $gallery->ID ] = $gallery->post_title;
			}
		}

		// Pull all the galleries cat
		$gallery_cats = array();
		$terms = get_terms( 'gallery_cat', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order' );

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
			'name'    => __( 'Divider', 'anva' ),
			'desc'    => __( 'Separate sections with page break.', 'anva' ),
			'icon'    => $image_path . 'divider.png',
			'content' => false,
			'attr'    => array(),
		);

		/*--------------------------------------------*/
		/* Header
		/*--------------------------------------------*/

		$this->core_elements['header'] = array(
			'name'    => __( 'Header', 'anva' ),
			'desc'    => __( 'Create a header with some nice text.', 'anva' ),
			'icon'    => $image_path . 'header.png',
			'content' => true,
			'attr'    => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
					'id'   => 'slug',
					'std' => '',
					'type' => 'text',
				),
				'subtitle' => array(
					'name' => 'Sub Title (Optional)',
					'desc' => 'Enter short description for this header',
					'id'   => 'subtitle',
					'std' => '',
					'type' => 'text',
				),
				'width' => array(
					'name' => 'Content Width',
					'desc' => 'Select width in percentage for this content',
					'id' => 'width',
					'std' => '100%',
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
					'name' => 'Content Padding',
					'desc' => 'Select padding top and bottom value for this header block.',
					'type' => 'range',
					'id' => 'padding',
					'std' => 30,
					'options' => array(
						'min' => 0,
						'max' => 200,
						'step' => 5,
						'units' => 'px',
					),
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'desc' => 'Select background color for this this block.',
					'id' => 'bgcolor',
					'std' => '#f9f9f9',
					'type' => 'color',
				),
				'fontcolor' => array(
					'name' => 'Text Color',
					'desc' => 'Select font color for content on this block.',
					'id' => 'fontcolor',
					'std' => '#444444',
					'type' => 'color',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'desc' => 'You can add custom CSS style for this block (advanced user only).',
					'id' => 'custom_css',
					'std' => '',
					'type' => 'code',
				),
			),
		);

		/*--------------------------------------------*/
		/* Header Image
		/*--------------------------------------------*/

		$this->core_elements['header_image'] = array(
			'name' =>  'Header With Background Image',
			'icon' => $image_path . 'header_image.png',
			'type' => 'media',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'name' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'background' => array(
					'name' => 'Background Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display as background',
				),
				'background_parallax' => array(
					'name' => 'Background Parallax',
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => 'Select to enable parallax effect to background image',
				),
				'background_position' => array(
					'name' => 'Background Position (Optional)',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'fontcolor' => array(
					'name' => 'Font Color',
					'type' => 'color',
					'std' => '#dd3333',
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => __( 'Create a header with some nice text using a background image.', 'anva' ),
			'content' => true
		);
		
		/*--------------------------------------------*/
		/* Text
		/*--------------------------------------------*/

		$this->core_elements['text'] = array(
			'name' =>  'Text Fullwidth',
			'icon' => $image_path . 'text.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'width' => array(
					'name' => 'Content Width',
					'type' => 'select',
					'options' => array(
						'100%' 	=> '100%',
						'90%' 	=> '90%',
						'80%' 	=> '80%',
						'70%' 	=> '70%',
						'60%' 	=> '60%',
						'50%' 	=> '50%',
					),
					'desc' => 'Select width in percentage for this content',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'fontcolor' => array(
					'name' => 'Font Color',
					'type' => 'color',
					'std' => '#444444',
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => true
		);

		/*--------------------------------------------*/
		/* Text Image
		/*--------------------------------------------*/

		$this->core_elements['text_image'] = array(
			'name' => 'Text With Background Image',
			'icon' => $image_path . 'text_image.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'background' => array(
					'name' => 'Background Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display as background',
				),
				'background_parallax' => array(
					'name' => 'Background Parallax',
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => 'Select to enable parallax effect to background image',
				),
				'background_position' => array(
					'name' => 'Background Position (Optional)',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'fontcolor' => array(
					'name' => 'Font Color',
					'type' => 'color',
					'std' => '#444444',
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => true
		);
		
		/*--------------------------------------------*/
		/* Image Fullwidth
		/*--------------------------------------------*/

		$this->core_elements['image_fullwidth'] = array(
			'name' =>  'Image Fullwidth',
			'icon' => $image_path . 'image_full.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'name' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'height' => array(
					'name' => 'Height',
					'type' => 'range',
					'std' => '600',
					'min' => 30,
					'max' => 1000,
					'step' => 5,
					'desc' => 'Select number of height for this content (in pixel)',
				),
				'background_position' => array(
					'name' => 'Background Position',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'display_caption' => array(
					'name' => 'Display caption',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);
		
		/*--------------------------------------------*/
		/* Image Parallax
		/*--------------------------------------------*/

		$this->core_elements['image_parallax'] = array(
			'name' =>  'Image Parallax',
			'icon' => $image_path . 'image_parallax.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'name' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'height' => array(
					'name' => 'Height',
					'type' => 'range',
					'std' => '600',
					'min' => 30,
					'max' => 1000,
					'step' => 5,
					'desc' => 'Select number of height for this content (in pixel)',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);

		/*--------------------------------------------*/
		/* Image Fixed Width
		/*--------------------------------------------*/

		$this->core_elements['image_fixed_width'] = array(
			'name' =>  'Image Fixed Width',
			'icon' => $image_path . 'image_fixed.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'name' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'name' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);
		
		/*--------------------------------------------*/
		/* 1/2 Content with Background
		/*--------------------------------------------*/

		$this->core_elements['content_half_bg'] = array(
			'name' =>  '1/2 Content with Background',
			'icon' => $image_path . 'half_content_bg.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'name' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'background' => array(
					'name' => 'Background Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display as background',
				),
				'background_parallax' => array(
					'name' => 'Background Parallax',
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => 'Select to enable parallax effect to background image',
				),
				'background_position' => array(
					'name' => 'Background Position (Optional)',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 400,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Content Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this content block',
				),
				'opacity' => array(
					'name' => 'Content Background Opacity',
					'type' => 'range',
					'std' => '100',
					'min' => 10,
					'max' => 100,
					'step' => 5,
					'desc' => 'Select background opacity for this content block',
				),
				'fontcolor' => array(
					'name' => 'Font Color (Optional)',
					'type' => 'color',
					'std' => '#444444',
					'desc' => 'Select font color for this content',
				),
				'align' => array(
					'name' => 'Content Box alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for content box',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['image_half_fixed_width'] = array(
			'name' =>  'Image 1/2 Width',
			'icon' => $image_path . 'image_half_fixed.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'name' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'align' => array(
					'name' => 'Image alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for image',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['image_half_fullwidth'] = array(
			'name' =>  'Image 1/2 Fullwidth',
			'icon' => $image_path . 'image_half_full.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'name' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'image' => array(
					'name' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'height' => array(
					'name' => 'Height',
					'type' => 'range',
					'std' => '600',
					'min' => 30,
					'max' => 1000,
					'step' => 5,
					'desc' => 'Select number of height for this content (in pixel)',
				),
				'align' => array(
					'name' => 'Image alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for image',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'fontcolor' => array(
					'name' => 'Font Color',
					'type' => 'color',
					'std' => '#000000',
					'desc' => 'Select font color for title and subtitle',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['two_cols_images'] = array(
			'name' =>  'Images Two Columns',
			'icon' => $image_path . 'images_two_cols.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image1' => array(
					'name' => 'Image 1',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image2' => array(
					'name' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'name' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['three_cols_images'] = array(
			'name' =>  'Images Three Columns',
			'icon' => $image_path . 'images_three_cols.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image1' => array(
					'name' => 'Image 1',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image2' => array(
					'name' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image3' => array(
					'name' => 'Image 3',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'name' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['three_images_block'] = array(
			'name' =>  'Images Three blocks',
			'icon' => $image_path . 'images_three_block.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image_portrait' => array(
					'name' => 'Image Portrait',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content (Portrait image size)',
				),
				'image_portrait_align' => array(
					'name' => 'Image Portrait alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for image portrait size',
				),
				'image2' => array(
					'name' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image3' => array(
					'name' => 'Image 3',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'name' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['four_images_block'] = array(
			'name' =>  'Images Four blocks',
			'icon' => $image_path . 'images_four_block.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image1' => array(
					'name' => 'Image 1',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image2' => array(
					'name' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image3' => array(
					'name' => 'Image 3',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image4' => array(
					'name' => 'Image 4',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'name' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'name' => 'Background Color',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);
		
			$this->core_elements['galleries'] = array(
				'name' =>  'Gallery Archive',
				'icon' => $image_path . 'galleries.png',
				'attr' => array(
					'cat' => array(
						'name' => 'Gallery Category',
						'type' => 'select',
						'options' => $gallery_cats,
						'desc' => 'Select the gallery category (optional)',
					),
					'items' => array(
						'type' => 'range',
						'std' => '12',
						'min' => 1,
						'max' => 100,
						'step' => 1,
						'desc' => 'Enter number of items to display',
					),
					'bgcolor' => array(
						'name' => 'Background Color (Optional)',
						'type' => 'color',
						'std' => '#f9f9f9',
						'desc' => 'Select background color for this content block',
					),
					'custom_css' => array(
						'name' => 'Custom CSS',
						'type' => 'text',
						'desc' => 'You can add custom CSS style for this block (advanced user only)',
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['gallery_slider'] = array(
				'name' =>  'Gallery Slider Fullwidth',
				'icon' => $image_path . 'gallery_slider_full.png',
				'attr' => array(
					'slug' => array(
						'name' => 'Slug (Optional)',
						'type' => 'text',
						'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
					),
					'gallery' => array(
						'name' => 'Gallery',
						'type' => 'select',
						'options' => $galleries,
						'desc' => 'Select the gallery you want to display',
					),
					'autoplay' => array(
						'name' => 'Auto Play',
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => 'Auto play gallery image slider',
					),
					'timer' => array(
						'name' => 'Timer',
						'type' => 'range',
						'std' => '5',
						'min' => 1,
						'max' => 60,
						'step' => 1,
						'desc' => 'Select number of seconds for slider timer',
					),
					'caption' => array(
						'name' => 'Display Image Caption',
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => 'Display gallery image caption',
					),
					'padding' => array(
						'name' => 'Content Padding',
						'type' => 'range',
						'std' => '30',
						'min' => 0,
						'max' => 200,
						'step' => 5,
						'desc' => 'Select padding top and bottom value for this header block',
					),
					'custom_css' => array(
						'name' => 'Custom CSS',
						'type' => 'text',
						'desc' => 'You can add custom CSS style for this block (advanced user only)',
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['gallery_slider_fixed_width'] = array(
				'name' =>  'Gallery Slider Fixed Width',
				'icon' => $image_path . 'gallery_slider_fixed.png',
				'attr' => array(
					'slug' => array(
						'name' => 'Slug (Optional)',
						'type' => 'text',
						'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
					),
					'gallery' => array(
						'name' => 'Gallery',
						'type' => 'select',
						'options' => $galleries,
						'desc' => 'Select the gallery you want to display',
					),
					'autoplay' => array(
						'name' => 'Auto Play',
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => 'Auto play gallery image slider',
					),
					'timer' => array(
						'name' => 'Timer',
						'type' => 'range',
						'std' => '5',
						'min' => 1,
						'max' => 60,
						'step' => 1,
						'desc' => 'Select number of seconds for slider timer',
					),
					'caption' => array(
						'name' => 'Display Image Caption',
						'type' => 'select',
						'options' => array(
							1 => 'Yes',
							0 => 'No'
						),
						'desc' => 'Display gallery image caption',
					),
					'padding' => array(
						'name' => 'Content Padding',
						'type' => 'range',
						'std' => '30',
						'min' => 0,
						'max' => 200,
						'step' => 5,
						'desc' => 'Select padding top and bottom value for this header block',
					),
					'bgcolor' => array(
						'name' => 'Background Color',
						'type' => 'color',
						'std' => '#f9f9f9',
						'desc' => 'Select background color for this header block',
					),
					'custom_css' => array(
						'name' => 'Custom CSS',
						'type' => 'text',
						'desc' => 'You can add custom CSS style for this block (advanced user only)',
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['animated_gallery_grid'] = array(
				'name' =>  'Animated Gallery Grid',
				'icon' => $image_path . 'animated_grid.png',
				'attr' => array(
					'slug' => array(
						'name' => 'Slug (Optional)',
						'type' => 'text',
						'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
					),
					'subtitle' => array(
						'name' => 'Sub Title (Optional)',
						'type' => 'text',
						'desc' => 'Enter short description for this header',
					),
					'gallery_id' => array(
						'name' => 'Gallery',
						'type' => 'select',
						'options' => $galleries,
						'desc' => 'Select the gallery you want to display',
					),
					'logo' => array(
						'name' => 'Retina Logo or Signature Image (Optional)',
						'type' => 'file',
						'desc' => 'Enter custom logo or signature image URL',
					),
					'bgcolor' => array(
						'name' => 'Background Color (Optional)',
						'type' => 'color',
						'std' => '#ffffff',
						'desc' => 'Select background color for this content block',
					),
					'opacity' => array(
						'name' => 'Content Background Opacity',
						'type' => 'range',
						'std' => '100',
						'min' => 10,
						'max' => 100,
						'step' => 5,
						'desc' => 'Select background opacity for this content block',
					),
					'fontcolor' => array(
						'name' => 'Font Color (Optional)',
						'type' => 'color',
						'std' => '#444444',
						'desc' => 'Select font color for this content',
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['gallery_grid'] = array(
				'name' =>  __( 'Gallery Grid', 'anva' ),
				'icon' => $image_path . 'gallery_grid.png',
				'attr' => array(
					'slug' => array(
						'name' => 'Slug (Optional)',
						'type' => 'text',
						'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
					),
					'gallery_id' => array(
						'name' => 'Gallery',
						'type' => 'select',
						'options' => $galleries,
						'desc' => 'Select the gallery you want to display',
					),
					'bgcolor' => array(
						'name' => 'Background Color (Optional)',
						'type' => 'color',
						'std' => '#ffffff',
						'desc' => 'Select background color for this content block',
					),
				),
				'desc' => '',
				'content' => false
			);

			$this->core_elements['gallery_masonry'] = array(
				'name' =>  'Gallery Masonry',
				'icon' => $image_path . 'gallery_masonry.png',
				'attr' => array(
					'slug' => array(
						'name' => 'Slug (Optional)',
						'type' => 'text',
						'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
					),
					'gallery_id' => array(
						'name' => 'Gallery',
						'type' => 'select',
						'options' => $galleries,
						'desc' => 'Select the gallery you want to display',
					),
					'bgcolor' => array(
						'name' => 'Background Color (Optional)',
						'type' => 'color',
						'std' => '#ffffff',
						'desc' => 'Select background color for this content block',
					),
				),
				'desc' => '',
				'content' => false
			);

		$this->core_elements['blog_grid'] = array(
			'name' =>  'Blog Grid',
			'icon' => $image_path . 'blog.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'cat' => array(
					'name' => 'Filter by category',
					'type' => 'select',
					'options' => $categories,
					'desc' => 'You can choose to display only some posts from selected category',
				),
				'items' => array(
					'type' => 'range',
					'std' => '9',
					'min' => 1,
					'max' => 100,
					'step' => 1,
					'desc' => 'Enter number of items to display',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'link_title' => array(
					'name' => 'Enter button title (Optional)',
					'type' => 'text',
					'desc' => 'Enter link button to display link to your blog page for example. Read more',
				),
				'link_url' => array(
					'name' => 'Button Link URL (Optional)',
					'type' => 'text',
					'desc' => 'Enter redirected link URL when button is clicked',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => false
		);

		$this->core_elements['contact_map'] = array(
			'name' =>  'Contact Form With Map',
			'icon' => $image_path . 'contact_map.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'name' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'type' => array(
					'name' => 'Map Type',
					'type' => 'select',
					'options' => array(
						'ROADMAP' => 'Roadmap',
						'SATELLITE' => 'Satellite',
						'HYBRID' => 'Hybrid',
						'TERRAIN' => 'Terrain',
					),
					'desc' => 'Select google map type',
				),
				'lat' => array(
					'name' => 'Latitude',
					'type' => 'text',
					'desc' => __( 'Map latitude.', 'anva' ),
				),
				'long' => array(
					'name' => 'Longtitude',
					'type' => 'text',
					'desc' => __('Map longitude.', 'anva' ),
				),
				'zoom' => array(
					'name' => 'Zoom Level',
					'type' => 'range',
					'std' => '8',
					'min' => 1,
					'max' => 16,
					'step' => 1,
					'desc' => 'Enter zoom level',
				),
				'popup' => array(
					'name' => 'Popup Text',
					'type' => 'text',
					'desc' => 'Enter text to display as popup above location on map for example. your company name',
				),
				'marker' => array(
					'name' => 'Custom Marker Icon (Optional)',
					'type' => 'file',
					'desc' => 'Enter custom marker image URL',
				),
				'bgcolor' => array(
					'name' => 'Background Color (Optional)',
					'type' => 'color',
					'std' => '#f9f9f9',
					'desc' => 'Select background color for this content block',
				),
				'fontcolor' => array(
					'name' => 'Font Color (Optional)',
					'type' => 'color',
					'std' => '#444444',
					'desc' => 'Select font color for this content',
				),
				'buttonbgcolor' => array(
					'name' => 'Button Background Color (Optional)',
					'type' => 'color',
					'std' => '#000000',
					'desc' => 'Select background color for contact form button',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => '',
			'content' => true
		);

		$this->core_elements['map'] = array(
			'name' =>  'Fullwidth Map',
			'icon' => $image_path . 'googlemap.png',
			'desc' => '',
			'content' => false,
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'type' => array(
					'name' => 'Map Type',
					'type' => 'select',
					'options' => array(
						'ROADMAP' => 'Roadmap',
						'SATELLITE' => 'Satellite',
						'HYBRID' => 'Hybrid',
						'TERRAIN' => 'Terrain',
					),
					'desc' => 'Select google map type',
				),
				'height' => array(
					'name' => 'Height',
					'type' => 'range',
					'std' => '600',
					'min' => 10,
					'max' => 1000,
					'step' => 10,
					'desc' => 'Select map height (in px)',
				),
				'lat' => array(
					'name' => 'Latitude',
					'type' => 'text',
					'desc' => 'Map latitude.',
				),
				'long' => array(
					'name' => 'Longtitude',
					'type' => 'text',
					'desc' => 'Map longitude.',
				),
				'zoom' => array(
					'name' => 'Zoom Level',
					'type' => 'range',
					'std' => '8',
					'min' => 1,
					'max' => 16,
					'step' => 1,
					'desc' => 'Enter zoom level',
				),
				'popup' => array(
					'name' => 'Popup Text',
					'type' => 'text',
					'desc' => 'Enter text to display as popup above location on map for example. your company name',
				),
				'marker' => array(
					'name' => 'Custom Marker Icon (Optional)',
					'type' => 'file',
					'desc' => 'Enter custom marker image URL',
				),
			),
		);

		/*--------------------------------------------*/
		/* Text Sidebar
		/*--------------------------------------------*/

		$this->core_elements['text_sidebart'] = array(
			'name' => __( 'Text Sidebar', 'anva' ),
			'desc' => __( 'Create a text block with sidebar.', 'anva' ),
			'content' => false,
			'icon' => $image_path . '/contact_sidebar.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'sidebar' => array(
					'name' => 'Content Sidebar',
					'type' => 'select',
					'options' => $sidebars,
					'desc' => 'You can select sidebar to display next to classic blog content',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				)
			),
		);

		/*--------------------------------------------*/
		/* Contact Sidebar
		/*--------------------------------------------*/

		$this->core_elements['contact_sidebar'] = array(
			'name' => __( 'Contact Sidebar', 'anva' ),
			'desc' => __( 'Create a contact form with sidebar.', 'anva' ),
			'content' => false,
			'icon' => $image_path . '/contact_sidebar.png',
			'attr' => array(
				'slug' => array(
					'name' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The slug is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers and hyphens.',
				),
				'subtitle' => array(
					'name' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header.',
				),
				'sidebar' => array(
					'name' => 'Content Sidebar',
					'type' => 'select',
					'options' => $sidebars,
					'desc' => 'You can select sidebar to display next to classic blog content.',
				),
				'padding' => array(
					'name' => 'Content Padding',
					'type' => 'range',
					'std' => '30',
					'min' => 0,
					'max' => 200,
					'step' => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'name' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
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
	public function set_elements()
	{
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
	public function add_element( $id, $name = '', $icon = '', $attr = array(), $desc = '', $content = false )
	{
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
			'name'   => $args['name'],
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
	public function remove_element( $element_id )
	{
		// Add to removal array, and process in set_elements()
		$this->remove_elements[] = $element_id;
	}

	/**
	 * Check if an element is currently registered.
	 *
	 * @since 1.0.0
	 */
	public function is_element( $element_id )
	{
		return array_key_exists( $element_id, $this->elements );
	}

	/**
	 * Get core elements.
	 *
	 * @since 1.0.0
	 */
	public function get_core_elements()
	{
		return $this->core_elements;
	}

	/**
	 * Get custom elements.
	 *
	 * @since 1.0.0
	 */
	public function get_custom_elements()
	{
		return $this->custom_elements;
	}

	/**
	 * Get final elements.
	 * 
	 * This is the merged result of core elements and custom elements.
	 * 
	 * @since 1.0.0
	 */
	public function get_elements()
	{
		return $this->elements;
	}

}

endif;