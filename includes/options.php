<?php
/**
 * Use Anva_Options_API to add options onto options already
 * present in framework
 *
 * @since 1.0.0
 */
function eren_options() {

	$pattern_path = get_template_directory_uri() . '/assets/images/patterns/';
	$skin_path = get_template_directory_uri() . '/assets/images/skins/';

	/* ---------------------------------------------------------------- */
	/* Layout
	/* ---------------------------------------------------------------- */

	$base_color = array(
		'name' => __( 'Base Color Scheme', 'anva' ),
		'desc' => __( 'Choose skin color for the theme. Check live preview in the <a href="' . esc_url( admin_url( '/customize.php' ) ) . '">Customizer.</a>', 'anva' ),
		'id' => 'base_color',
		'std' => 'blue',
		'type' => 'images',
		'options' => array(
			'blue' 		=> $skin_path . 'blue.png',
			'green' 	=> $skin_path . 'green.png',
			'orange' 	=> $skin_path . 'orange.png',
			'red' 		=> $skin_path . 'red.png',
			'teal' 		=> $skin_path . 'teal.png',
		)
	);
	anva_add_option( 'styles', 'main', 'base_colors', $base_color );

	$footer_color = array(
		'name' => __( 'Footer Color Scheme', 'anva' ),
		'desc' => __( 'Choose the color for the footer.', 'anva' ),
		'id' => 'footer_color',
		'std' => 'light',
		'type' => 'select',
		'options' => array(
			'light' => __( 'Light', 'anva' ),
			'dark' 	=> __( 'Dark', 'anva' )
		)
	);
	anva_add_option( 'styles', 'main', 'base_color', $footer_color );

	/* ---------------------------------------------------------------- */
	/* Background
	/* ---------------------------------------------------------------- */

	// Background defaults
	$background_defaults = array(
		'image' 			=> '',
		'repeat' 			=> 'repeat',
		'position' 		=> 'top center',
		'attachment' 	=> 'scroll'
	);

	$background_options = array(
		'background_color' => array(
			'name' => __('Background Color', 'anva'),
			'desc' => __('Select the background color.', 'anva'),
			'id' => 'background_color',
			'std' => '#dddddd',
			'type' => 'color'
		),
		'background_image' => array(
			'name' => __('Background Image', 'anva'),
			'desc' => __('Select the background image. This option only take effect if layout style is boxed.', 'anva'),
			'id' => 'background_image',
			'std' => $background_defaults,
			'type' => 'background'
		),
		'background_cover' => array(
			'name' => __( 'Background Cover', 'anva' ),
			'desc' => __( 'Use background size cover.', 'anva' ),
			'id' => 'background_cover',
			'std' => '',
			'type' => 'checkbox'
		),
		'background_pattern' => array(
			'name' => __( 'Background Pattern', 'anva' ),
			'desc' => __( 'Select the background pattern. Note: this option is only applied if the braclground image option is empty.', 'anva' ),
			'id' => 'background_pattern',
			'std' => '',
			'type' => 'select',
			'options' => array(
				'' 										 => __( 'None', 'anva' ),
				'binding_light' 			 => 'Binding Light',
				'dimension_@2X' 			 => 'Dimension',
				'hoffman_@2X' 				 => 'Hoffman',
				'knitting250px' 			 => 'Knitting',
				'noisy_grid' 					 => 'Noisy Grid',
				'pixel_weave_@2X' 		 => 'Pixel Weave',
				'struckaxiom' 				 => 'Struckaxiom',
				'subtle_stripes' 			 => 'Subtle Stripes',
				'white_brick_wall_@2X' => 'White Brick Wall'
			)
		)
	);
	anva_add_option_section( 'styles', 'background', __( 'Background', 'anva' ), null, $background_options, false );

	/* ---------------------------------------------------------------- */
	/* Links
	/* ---------------------------------------------------------------- */

	$links_options = array(
		'link_color' => array(
			'name' => __( 'Link Color', 'anva' ),
			'desc' => __( 'Set the link color.', 'anva' ),
			'id' => 'link_color',
			'std' => '',
			'type' => 'color'
		),
		'link_color_hover' => array(
			'name' => __( 'Link Color (:Hover)', 'anva' ),
			'desc' => __( 'Set the link color.', 'anva' ),
			'id' => 'link_color_hover',
			'std' => '',
			'type' => 'color'
		)
	);
	anva_add_option_section( 'styles', 'links', __( 'Links', 'anva' ), null, $links_options, false );

	/* ---------------------------------------------------------------- */
	/* Typography
	/* ---------------------------------------------------------------- */

	$typography_options = array(
		'body_font' => array(
			'name' => __( 'Body Font', 'anva' ),
			'desc' => __( 'This applies to most of the text on your site.', 'anva' ),
			'id' => 'body_font',
			'std' => array(
				'size' => '14px',
				'face' => 'google',
				'google' => 'Lato',
				'style' => 'normal',
			),
			'type' => 'typography',
			'options' => array( 'size', 'style', 'face' )
		),
		'heading_font' => array(
			'name' => __( 'Headings Font', 'anva' ),
			'desc' => __( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', 'anva' ),
			'id' => 'heading_font',
			'std' => array(
				'face' => 'google',
				'google' => 'Raleway',
				'style' => 'normal'
			),
			'type' => 'typography',
			'options' => array( 'style', 'face' )
			
		),
		'heading_h1' => array(
			'name' => __( 'H1', 'anva' ),
			'desc' => __( 'Select the size for H1 tag in px.', 'anva' ),
			'id' => 'heading_h1',
			'std' => '27',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
				'format' => 'px',
			)
		),
		'heading_h2' => array(
			'name' => __( 'H2', 'anva' ),
			'desc' => __( 'Select the size for H2 tag in px.', 'anva' ),
			'id' => 'heading_h2',
			'std' => '24',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
				'format' => 'px',
			)
		),
		'heading_h3' => array(
			'name' => __('H3', 'anva'),
			'desc' => __('Select the size for H3 tag in px.', 'anva'),
			'id' => 'heading_h3',
			'std' => '18',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
				'format' => 'px',
			)
		),
		'heading_h4' => array(
			'name' => __('H4', 'anva'),
			'desc' => __('Select the size for H4 tag in px.', 'anva'),
			'id' => 'heading_h4',
			'std' => '14',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
				'format' => 'px',
			)
		),
		'heading_h5' => array(
			'name' => __('H5', 'anva'),
			'desc' => __('Select the size for H5 tag in px.', 'anva'),
			'id' => 'heading_h5',
			'std' => '13',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
				'format' => 'px',
			)
		),
		'heading_h6' => array(
			'name' => __('H6', 'anva'),
			'desc' => __('Select the size for H6 tag in px.', 'anva'),
			'id' => 'heading_h6',
			'std' => '11',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
				'format' => 'px',
			)
		),
	);
	anva_add_option_section( 'styles', 'typography', __( 'Typography', 'anva' ), null, $typography_options, false );

	/* ---------------------------------------------------------------- */
	/* Custom
	/* ---------------------------------------------------------------- */

	$custom_options = array(
		'css_warning' => array(
			'name' => __( 'Warning', 'anva'),
			'desc' => __( 'If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva'),
			'id' => 'css_warning',
			'type' => 'info'
		),
		'custom_css' => array(
			'name' => __( 'Custom CSS', 'anva'),
			'desc' => __( 'If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva'),
			'id' => 'custom_css',
			'std' => '',
			'type' => 'textarea'
		)
	);
	anva_add_option_section( 'styles', 'custom', __( 'Custom', 'anva' ), null, $custom_options, false );

	/* ---------------------------------------------------------------- */
	/* Header
	/* ---------------------------------------------------------------- */

	$favicon = array(
		'name' => __('Favicon', 'anva'),
		'desc' => __('Configure your won favicon.', 'anva'),
		'id' => 'favicon',
		'std' => '',
		'class' => 'input-text',
		'type' => 'upload'
	);
	anva_add_option( 'layout', 'header', 'favicon', $favicon );

	/* ---------------------------------------------------------------- */
	/* Galleries
	/* ---------------------------------------------------------------- */

	if ( is_admin() ) {

		// Pull all gallery templates
		$galleries = array();
		foreach ( anva_gallery_templates() as $key => $gallery ) {
			$galleries[$key] = $gallery['name'];
		}

		$animations = array();
		foreach ( anva_get_animations() as $key => $value ) {
			$animations[$value] = $value; 
		}

		$gallery_options = array(
			'gallery_sort' => array(
				'name' => __('Images Sorting', 'anva'),
				'desc' => __('Select how you want to sort gallery images.', 'anva'),
				'id' => 'gallery_sort',
				'std' => 'drag',
				'type' => 'select',
				'options' => array(
					'drag' => __('Drag & Drop', 'anva'),
					'desc' => __('Newest', 'anva'),
					'asc' => __('Oldest', 'anva'),
					'rand' => __('Random', 'anva'),
					'title' => __('Title', 'anva')
				)
			),
			'gallery_template' => array(
				'name' => __('Default Template', 'anva'),
				'desc' => __('Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', 'anva'),
				'id' => 'gallery_template',
				'std' => '3-col',
				'type' => 'select',
				'options' => $galleries
			),
			'gallery_animate' => array(
				'name' => __( 'Animate', 'anva' ),
				'desc' => __( 'Choose the default animation for gallery images. Get a <a href="' . esc_url( 'https://daneden.github.io/animate.css/' ) . '" target="_blank">preview</a> of the animations.', 'anva' ),
				'id' => 'gallery_animate',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $animations
			),
			'gallery_delay' => array(
				'name' => __( 'Delay', 'anva' ),
				'desc' => __( 'Choose the default delay for animation.', 'anva' ),
				'id' => 'gallery_delay',
				'std' => 400,
				'type' => 'number'
			),
		);
		anva_add_option_section( 'layout', 'gallery', __( 'Galleries', 'anva' ), null, $gallery_options, false );
	}

	/* ---------------------------------------------------------------- */
	/* Sliders
	/* ---------------------------------------------------------------- */

	if ( is_admin() ) {

		// Get all sliders
		$sliders = anva_get_sliders();

		// Pull all sliders
		$slider_select = array();
		foreach ( $sliders as $slider_id => $slider ) {
			$slider_select[$slider_id] = $slider['name'];
		}

		// Revolution Slider
		if ( class_exists( 'RevSliderAdmin' ) ) {
			$slider_select['revslider'] = 'Revolution Slider';
		}

		$slider_options = array(
			'slider_id' => array(
				'name' => __( 'Slider', 'anva'),
				'desc' => __( 'Select the main slider. Based on the slider you select, the options below may change.', 'anva'),
				'id' => 'slider_id',
				'std' => 'standard',
				'type' => 'select',
				'options' => $slider_select
			),
			'slider_style' => array(
				'name' => __( 'Style', 'anva'),
				'desc' => __( 'Select the slider style.', 'anva'),
				'id' => 'slider_style',
				'std' => 'boxed',
				'type' => 'select',
				'options' => array(
					'slider-boxed' => __( 'Boxed', 'anva' ),
					'full-screen'  => __( 'Full Screen', 'anva' ),
				)
			),
			'slider_parallax' => array(
				'name' => __( 'Parallax', 'anva'),
				'desc' => __( 'If you use the parallax effect for sliders enable this option.', 'anva'),
				'id' => 'slider_parallax',
				'std' => 'true',
				'type' => 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable parallax.',
					'false'	=> 'No, disable parallax.'
				),
			),
		);
		
		// Get dynamic slider options
		foreach ( $sliders as $slider_id => $slider ) {
			foreach ( $slider['options'] as $option_id => $option ) {
				$slider_options[$option_id] = $option;
			}
		}

		$slider_options['revslider_id'] = array(
			'name' => __( 'Revolution Slider ID', 'anva' ),
			'desc' => __( 'Show or hide the slider direction navigation.', 'anva' ),
			'id' => 'revslider_id',
			'std' => '',
			'type' => 'text',
			'class' => 'revslider hide'
		);
		anva_add_option_section( 'layout', 'slider', __( 'Sliders', 'anva' ), null, $slider_options, false );
	}

	/* ---------------------------------------------------------------- */
	/* Minify
	/* ---------------------------------------------------------------- */

	$minify_options = array(
		'minify_warning' => array(
			'name' => __( 'Warning', 'anva' ),
			'desc' => __( 'If you have a cache plugin installed in your site desactive this options.', 'anva' ),
			'id' 	 => 'minify_warning',
			'type' => 'info'
		),

		'compress_css' => array(
			'name' => __( 'Combine and Compress CSS files', 'anva'),
			'desc' => __( 'Combine and compress all CSS files to one. Help reduce page load time and increase server resources.', 'anva'),
			'id' => "compress_css",
			'std' => '0',
			'type' => 'checkbox'
		),

		'compress_js' => array(
			'name' => __( 'Combine and Compress Javascript files', 'anva' ),
			'desc' => __( 'Combine and compress all Javascript files to one. Help reduce page load time and increase server resource.', 'anva'),
			'id' => "compress_js",
			'std' => '0',
			'type' => 'checkbox'
		)
	);
	anva_add_option_section( 'advanced', 'minify', __( 'Minify', 'anva' ), null, $minify_options, false );

}
add_action( 'after_setup_theme', 'eren_options' );

/**
 * Use Anva_Builder_Elements_API to add elements onto elements already
 * present in framework
 *
 * @since 1.0.0
 */
function eren_elements() {
	
	// Get framework assets path
	$image_path = anva_get_core_uri() . '/assets/images/builder';

	// Get sidebar locations
	$sidebars = array();
	foreach ( anva_get_sidebar_layouts() as $sidebar_id => $sidebar ) {
		$sidebars[$sidebar_id] = $sidebar['name'];
	}
	
	/*--------------------------------------------*/
	/* Text Sidebar
	/*--------------------------------------------*/

	$text_sidebar_icon = $image_path . '/contact_sidebar.png';
	$text_sidebar_desc = __( 'Create a text block with sidebar.', 'anva' );
	$text_sidebar_atts = array(
		'slug' => array(
			'title' => 'Slug (Optional)',
			'type' => 'text',
			'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
		),
		'sidebar' => array(
			'Title' => 'Content Sidebar',
			'type' => 'select',
			'options' => $sidebars,
			'desc' => 'You can select sidebar to display next to classic blog content',
		),
		'padding' => array(
			'title' => 'Content Padding',
			'type' => 'slider',
			"std" => "30",
			"min" => 0,
			"max" => 200,
			"step" => 5,
			'desc' => 'Select padding top and bottom value for this header block',
		),
		'custom_css' => array(
			'title' => 'Custom CSS',
			'type' => 'text',
			'desc' => 'You can add custom CSS style for this block (advanced user only)',
		)
	);
	anva_add_builder_element( 'text_sidebar', __( 'Text With Sidebar' ), $text_sidebar_icon, $text_sidebar_atts, $text_sidebar_desc, true );

	/*--------------------------------------------*/
	/* Contact Sidebar
	/*--------------------------------------------*/

	$contact_sidebar_icon = $image_path . '/contact_sidebar.png';
	$contact_sidebar_desc = __( 'Create a contact form with sidebar.', 'anva' );
	$contact_sidebar_atts = array(
		'slug' => array(
			'title' => 'Slug (Optional)',
			'type' => 'text',
			'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers and hyphens.',
		),
		'subtitle' => array(
			'title' => 'Sub Title (Optional)',
			'type' => 'text',
			'desc' => 'Enter short description for this header.',
		),
		'sidebar' => array(
			'Title' => 'Content Sidebar',
			'type' => 'select',
			'options' => $sidebars,
			'desc' => 'You can select sidebar to display next to classic blog content.',
		),
		'padding' => array(
			'title' => 'Content Padding',
			'type' => 'slider',
			"std" => "30",
			"min" => 0,
			"max" => 200,
			"step" => 5,
			'desc' => 'Select padding top and bottom value for this header block',
		),
		'custom_css' => array(
			'title' => 'Custom CSS',
			'type' => 'text',
			'desc' => 'You can add custom CSS style for this block (advanced user only)',
		),
	);
	anva_add_builder_element( 'contact_sidebar', __( 'Contact Form With Sidebar', 'anva' ), $contact_sidebar_icon, $contact_sidebar_atts, $contact_sidebar_desc, true );

}
add_action( 'after_setup_theme', 'eren_elements' );