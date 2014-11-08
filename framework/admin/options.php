<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
// function optionsframework_option_name() {
	// Change this to use your theme slug
	// return 'options-framework-theme';
// }

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace $domain
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Theme domain
	$domain = OF_DOMAIN;

	// Test data
	$test_array = array(
		'one' => __('One', $domain),
		'two' => __('Two', $domain),
		'three' => __('Three', $domain),
		'four' => __('Four', $domain),
		'five' => __('Five', $domain)
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', $domain),
		'two' => __('Pancake', $domain),
		'three' => __('Omelette', $domain),
		'four' => __('Crepe', $domain),
		'five' => __('Waffle', $domain)
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

		// Social buttons defautls
	$social_media_defaults = array(
		'google'		=> 'https://plus.google.com/+AnthuanVasquez',
		'twitter' 	=> 'http://twitter.com/oidoperfecto', // fallow me
		'rss'				=> get_feed_link()
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$image_path =  get_template_directory_uri() . '/assets/images/';
	$skin_path = get_template_directory_uri() . '/assets/images/skins/';
	$ext = '.png';

	$options = array();

	// ----------------------------------------------
	// Layout Settings
	// ----------------------------------------------

	$options[] = array(
		'name' => __('Styles', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Layout Style', $domain),
		'desc' => __('Select the layout style.', $domain),
		'id' => 'layout_style',
		'std' => 'boxed',
		'class' => 'input-select',
		'type' => 'select',
		'options' => array(
			'boxed' => __( 'Boxed', $domain ),
			'wide' => __( 'Wide', $domain )
		));

	$options[] = array(
		'name' => "Schema Color",
		'desc' => "Choose schema color for the theme.",
		'id' => "schema",
		'std' => "blue",
		'type' => "images",
		'options' => array(
			'blue' => $skin_path . 'blue.png',
			'green' => $skin_path . 'green.png',
			'orange' => $skin_path . 'orange.png')
	);

	$options[] = array(
		'name' => __('Background Color', $domain),
		'desc' => __('Select the background color.', $domain),
		'id' => 'background_color',
		'std' => '#dddddd',
		'type' => 'color');

	$options[] = array(
		'name' => __('Background Image', $domain),
		'desc' => __('Select the background color.', $domain),
		'id' => 'backround_image',
		'std' => array(
			'color' => '#dddddd',
			'image' => '',
			'repeat' => 'repeat',
			'position' => 'top center',
			'attachment'=> 'scroll',
		),
		'type' => 'background');

	$options[] = array(
		'name' => __('Background Pattern', $domain),
		'desc' => __('Select the background pattern.', $domain),
		'id' => 'backround_pattern',
		'std' => '',
		'type' => 'select',
		'options' => array(
			'' => 'None',
			'binding_light' => 'Binding Light',
			'dimension_@2X' => 'Dimension',
			'hoffman_@2X' => 'Hoffman',
			'knitting250px' => 'Knitting',
			'noisy_grid' => 'Noisy Grid',
			'pixel_weave_@2X' => 'Pixel Weave',
			'struckaxiom' => 'Struckaxiom',
			'subtle_stripes' => 'Subtle Stripes',
		));

	$options[] = array(
		'name' => __('Body Font', $domain),
		'desc' => __('This applies to most of the text on your site.', $domain),
		'id' => "body_font",
		'std' => array(
			'size' => '14px',
			'face' => 'helvetica',
			'style' => 'normal',
		),
		'type' => 'typography',
		'options' => array(
			'sizes' => of_recognized_font_sizes(),
			'faces' => of_recognized_font_faces(),
			'styles' => of_recognized_font_styles(),
			'color' => false,
		));

	$options[] = array(
		'name' => __('Headings Font', $domain),
		'desc' => __('This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', $domain),
		'id' => "heading_font",
		'std' => array(
			'size' => '',
			'face' => 'helvetica',
			'style' => 'normal'
		),
		'type' => 'typography',
		'options' => array(
			'sizes' => '',
			'faces' => of_recognized_font_faces(),
			'styles' => of_recognized_font_styles(),
			'color' => false,
		));

	$options[] = array(
		'name' => __('Custom CSS', $domain),
		'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', $domain),
		'id' => 'custom_css',
		'std' => '',
		'type' => 'textarea');

	// ----------------------------------------
	// Layout
	// ----------------------------------------

	$options[] = array(
		'name' => __('Layout', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Logo Image', $domain),
		'desc' => __('Configure the primary branding logo for the header of your site.', $domain),
		'id' => 'logo',
		'std' => $image_path . 'logo.png', // use the efault logo
		'class' => 'input-text',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Social Media Button Style', $domain),
		'desc' => __('Select the style for your social media buttons.', $domain),
		'id' => 'social_media_style',
		'std' => 'color',
		'type' => 'select',
		'options' => array(
			'normal' => __('Normal', $domain),
			'grey' => __('Grey', $domain),
			'dark' => __('Dark', $domain),
		));

	$options[] = array(
		"name" => __('Social Media', $domain),  
		"desc" => __('Enter the full URL you\'d like the button to link to in the corresponding text field that appears. Example: http://twitter.com/oidoperfecto. Note: If youre using the RSS button, your default RSS feed URL is: <strong>'.get_feed_link().'</strong>.', $domain),  
		"id" => "social_media",
		"type" => "social_media",
		"std" => $social_media_defaults);

	$options[] = array(
		'name' => __('Slider Speed', $domain),
		'desc' => __('Set the slider speed. Default is 7000 in milliseconds', $domain),
		'id' => 'slider_speed',
		'std' => '7000',
		'type' => 'number');

	$options[] = array(
		'name' => __('Slider Control Navigation', $domain),
		'desc' => __('Show or hide the slider control navigation.', $domain),
		'id' => 'slider_control',
		'std' => 'show',
		'type' => 'select',
		'options' => array(
			'show' => __('Show the slider control', $domain),
			'hide' => __('Hide the slider control', $domain)
		));

	$options[] = array(
		'name' => __('Slider Direction Navigation', $domain),
		'desc' => __('Show or hide the slider direction navigation.', $domain),
		'id' => 'slider_direction',
		'std' => 'show',
		'type' => 'select',
		'options' => array(
			'show' => __('Show the slider direction', $domain),
			'hide' => __('Hide the slider direction', $domain)
		));

	$options[] = array(
		'name' => __('Slider Play/Pause', $domain),
		'desc' => __('Show or hide the slider slider play/pause button.', $domain),
		'id' => 'slider_play',
		'std' => 'show',
		'type' => 'select',
		'options' => array(
			'show' => __('Show the slider play/pause', $domain),
			'hide' => __('Hide the slider play/pause', $domain)
		));

	// if ( $options_categories ) {
	// 	$options[] = array(
	// 		'name' => __('Select a Category', $domain),
	// 		'desc' => __('Passed an array of categories with cat_ID and cat_name', $domain),
	// 		'id' => 'example_select_categories',
	// 		'type' => 'select',
	// 		'options' => $options_categories);
	// }

	// if ( $options_tags ) {
	// 	$options[] = array(
	// 		'name' => __('Select a Tag', 'options_check'),
	// 		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
	// 		'id' => 'example_select_tags',
	// 		'type' => 'select',
	// 		'options' => $options_tags);
	// }

	// $options[] = array(
	// 	'name' => __('Select a Page', $domain),
	// 	'desc' => __('Passed an pages with ID and post_title', $domain),
	// 	'id' => 'example_select_pages',
	// 	'type' => 'select',
	// 	'options' => $options_pages);

	// $options[] = array(
	// 	'name' => __('Example Info', $domain),
	// 	'desc' => __('This is just some example information you can put in the panel.', $domain),
	// 	'type' => 'info');

	// ---------------------------------------
	// Content Settings
	// ---------------------------------------

	$options[] = array(
		'name' => __('Content', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Show meta info on single posts', $domain),
		'desc' => __('Show the meta info on single psts. Defaults is true.', $domain),
		'id' => 'single_meta',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show meta', $domain),
			'hide' => __('Hide meta', $domain),
		));

	$options[] = array(
		'name' => __('Show thumbnails on single posts', $domain),
		'desc' => __('Show the thumbnails on single psts. Defaults is true.', $domain),
		'id' => 'single_thumb',
		'std' => 'full',
		'type' => 'radio',
		'options' => array(
			'mini' => __('Show thumbnails', $domain),
			'full' => __('Show thumbnails with full width', $domain),
			'hide' => __('Hide thumbnails', $domain),
		));

	$options[] = array(
		'name' => __('Check to Show a Hidden Text Input', $domain),
		'desc' => __('Click here and see what happens.', $domain),
		'id' => 'example_showhidden',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Hidden Text Input', $domain),
		'desc' => __('This option is hidden unless activated by a checkbox click.', $domain),
		'id' => 'example_text_hidden',
		'std' => 'Hello',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Uploader Test', $domain),
		'desc' => __('This creates a full size uploader that previews the image.', $domain),
		'id' => 'example_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' =>  __('Example Background', $domain),
		'desc' => __('Change the background CSS.', $domain),
		'id' => 'example_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => __('Multicheck', $domain),
		'desc' => __('Multicheck description.', $domain),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

	$options[] = array(
		'name' => __('Colorpicker', $domain),
		'desc' => __('No color selected by default.', $domain),
		'id' => 'example_colorpicker',
		'std' => '',
		'type' => 'color' );

	// --------------------------------------------
	// Configuration
	// --------------------------------------------
	
	$options[] = array(
		'name' => __('Configuration', $domain),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('Responsive', $domain),
		'desc' => __('This theme comes with a special stylesheet that will target the screen resolution of your website vistors and show them a slightly modified design if their screen resolution matches common sizes for a tablet or a mobile device.', $domain),
		'id' => "responsive",
		'std' => '1',
		'type' => 'radio',
		'options' => array(
			'1' => __('Yes, apply special styles to tablets and mobile devices', $domain),
			'0' => __('No, allow website to show normally on tablets and mobile devices', $domain),
		));

	return $options;
}