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

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll' );

	// Template Defaults
	$template_defaults = array(
		'blog' => __('Classic Blog', $domain),
		'search' => __('Classic Search', $domain),
		'2col' => __('2 Columns', $domain),
		'3col' => __('3 Columns', $domain));

	// Social media buttons defautls
	$social_media_defaults = array(
		'google'		=> 'https://plus.google.com/+AnthuanVasquez',
		'twitter' 	=> 'http://twitter.com/oidoperfecto', // Follow me :)
		'rss'				=> get_feed_link()
	);

	// WordPress default credits
	$wordpress = '<a href="'.esc_url('http://wordpress.org').'" title="WordPress" target="_blank">WordPress</a>';

	// Author default credtis
	$author = '<a href="'.esc_url('http://anthuanvasquez.net').'" title="Anthuan Vasquez" target="_blank">Anthuan Vasquez</a>';

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
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

	/*
	|--------------------------------------------------------------------------
	| Styles
	|--------------------------------------------------------------------------
	*/

	$options[] = array(
		'name' => __('Styles', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __( 'Layout', $domain ),
		'desc' => __( 'This is the section of layout inputs.', $domain ),
		'class' => 'group-layout',
		'type' 	=> 'group_start');

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
		'id' => "skin",
		'std' => "blue",
		'type' => "images",
		'options' => array(
			'blue' => $skin_path . 'blue.png',
			'green' => $skin_path . 'green.png',
			'orange' => $skin_path . 'orange.png',
			'red' => $skin_path . 'red.png',
			'teal' => $skin_path . 'teal.png',
		));

	$options[] = array(
		'name' => __('Social Media Button Style', $domain),
		'desc' => __('Select the style for your social media buttons.', $domain),
		'id' => 'social_media_style',
		'std' => 'normal',
		'type' => 'select',
		'options' => array(
			'normal' => __('Normal', $domain),
			'grey' => __('Grey', $domain),
			'dark' => __('Dark', $domain),
		));

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Links', $domain ),
		'class' => 'group-links',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Link Color', $domain),
		'desc' => __('Set the link color.', $domain),
		'id' => 'link_color',
		'std' => '#ff0000',
		'type' => 'color');

	$options[] = array(
		'name' => __('Link Color (:Hover)', $domain),
		'desc' => __('Set the link color.', $domain),
		'id' => 'link_color_hover',
		'std' => '#ff0000',
		'type' => 'color');

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Background', $domain ),
		'class' => 'group-background',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Background Color', $domain),
		'desc' => __('Select the background color.', $domain),
		'id' => 'background_color',
		'std' => '#dddddd',
		'type' => 'color');

	$options[] = array(
		'name' => __('Background Image', $domain),
		'desc' => __('Select the background color.', $domain),
		'id' => 'background_image',
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
		'id' => 'background_pattern',
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
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Typography', $domain ),
		'class' => 'group-typography',
		'type' 	=> 'group_start');

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
		'name' => __('H1', $domain),
		'desc' => __('Select the size for H1 tag in px.', $domain),
		'id' => 'heading_h1',
		'std' => '27',
		'type' => 'select',
		'options' => of_recognized_font_sizes());

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __('Custom', $domain),
		'class' => 'group-custom',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Warning', $domain),
		'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', $domain),
		'id' => 'css_warning',
		'type' => 'info');

	$options[] = array(
		'name' => __('Custom CSS', $domain),
		'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', $domain),
		'id' => 'custom_css',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'type' 	=> 'group_end'
	);

	/*
	|--------------------------------------------------------------------------
	| Layout
	|--------------------------------------------------------------------------
	*/

	$options[] = array(
		'name' => __('Layout', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __( 'Header', $domain ),
		'class' => 'group-header',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Logo Image', $domain),
		'desc' => __('Configure the primary branding logo for the header of your site.', $domain),
		'id' => 'logo',
		'std' => $image_path . 'logo.png', // Get the efault logo from the theme
		'class' => 'logo-input',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Add Retina Logo', $domain),
		'desc' => __('Add retina display logo.', $domain),
		'id' => 'logo_retina_check',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Retina Logo', $domain),
		'desc' => __('Configure the primary branding logo for the header of your site.', $domain),
		'id' => 'logo_retina',
		'std' => '', // Get the efault logo from the theme
		'class' => 'logo-retina-input hidden',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Favicon', $domain),
		'desc' => __('Configure your won favicon.', $domain),
		'id' => 'favicon',
		'std' => '',
		'class' => 'input-text',
		'type' => 'upload');

	$options[] = array(
		"name" => __('Social Media', $domain),  
		"desc" => __('Enter the full URL you\'d like the button to link to in the corresponding text field that appears. Example: http://twitter.com/oidoperfecto. Note: If youre using the RSS button, your default RSS feed URL is: <strong>'.get_feed_link().'</strong>.', $domain),  
		"id" => "social_media",
		"type" => "social_media",
		"std" => $social_media_defaults);

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Slider', $domain ),
		'class' => 'group-slider',
		'type' 	=> 'group_start');

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

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Templates', $domain ),
		'class' => 'group-templates',
		'type' 	=> 'group_start');

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Footer', $domain ),
		'class' => 'group-header',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => "Columns",
		'desc' => "Choose the number of columns along.",
		'id' => "footer_columns",
		'std' => "4",
		'type' => "select",
		'options' => array(
			'hide' => __( 'Hide Columns', $domain ),
			'1' => __( ' 1 Column', $domain ),
			'2' => __( ' 2 Columns', $domain ),
			'3' => __( ' 3 Columns', $domain ),
			'4' => __( ' 4 Columns', $domain ),
		));

	$options[] = array(
		'name' => "Copyright Text",
		'desc' => "Enter the copyright text you'd like to show in the footer of your site.",
		'id' => "footer_copyright",
		'std' => sprintf( __( 'Copyright %s %s - Powered by %s, Designed by %s.', $domain ), date('Y'), get_bloginfo('name'), $wordpress, $author ),
		'type' => "textarea");

	$options[] = array(
		'type' 	=> 'group_end');

	/*
	|--------------------------------------------------------------------------
	| Content
	|--------------------------------------------------------------------------
	*/

	$options[] = array(
		'name' => __('Content', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __( 'Single Posts', $domain ),
		'desc' => __( 'These settings will only apply to vewing single posts.', $domain ),
		'class' => 'group-single-posts',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Show meta info', $domain),
		'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the post.', $domain),
		'id' => 'single_meta',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show meta info', $domain),
			'hide' => __('Hide meta info', $domain),
		));

	$options[] = array(
		'name' => __('Show featured images', $domain),
		'desc' => __('Choose how you want your featured images to show at the top of the posts.', $domain),
		'id' => 'single_thumb',
		'std' => 'hide',
		'type' => 'radio',
		'options' => array(
			'small' => __('Show small thumbnails', $domain),
			'fullwidth' => __('Show full width thumbnails', $domain),
			'hide' => __('Hide thumbnails', $domain),
		));

	$options[] = array(
		'name' => __('Show comments', $domain),
		'desc' => __('Select if you\'d like to completely hide comments or not below the post.', $domain),
		'id' => 'single_comments',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show comments', $domain),
			'hide' => __('Hide comments', $domain),
		));

	$options[] = array(
		'name' => __('Show share buttons', $domain),
		'desc' => __('Select to display socials sharing in single posts.', $domain),
		'id' => 'single_share',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show share buttons', $domain),
			'hide' => __('Hide share buttons', $domain),
		));

	$options[] = array(
		'name' => __('Show about author', $domain),
		'desc' => __('Select to display about the author in single posts.', $domain),
		'id' => 'single_author',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show about author', $domain),
			'hide' => __('Hide about author', $domain),
		));

	$options[] = array(
		'name' => __('Show related posts', $domain),
		'desc' => __('Select to display related posts in single posts.', $domain),
		'id' => 'single_related',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show related posts', $domain),
			'hide' => __('Hide related posts', $domain),
		));

	$options[] = array(
		'name' => __('Show navigation posts', $domain),
		'desc' => __('Select to display next and previous posts in single posts.', $domain),
		'id' => 'single_navigation',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show navigation posts', $domain),
			'hide' => __('Hide navigation posts', $domain),
		));

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Primary Posts', $domain ),
		'desc' => __( 'These settings apply to your primary posts page', $domain ),
		'class' => 'group-primary-posts',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Show featured images', $domain),
		'desc' => __('Choose how you want your featured images to show in primary posts.', $domain),
		'id' => 'primary_thumb',
		'std' => 'fullwidth',
		'type' => 'radio',
		'options' => array(
			'small' => __('Show small thumbnails', $domain),
			'fullwidth' => __('Show full width thumbnails', $domain),
			'hide' => __('Hide thumbnails', $domain),
		));

	$options[] = array(
		'name' => __('Show excerpt or full content', $domain),
		'desc' => __('Choose whether you want to show full content or post excerpts only.', $domain),
		'id' => 'primary_content',
		'std' => 'excerpt',
		'type' => 'radio',
		'options' => array(
			'content' => __('Show full content', $domain),
			'excerpt' => __('Show excerpt', $domain),
		));

	// Check if exists categories in database
	if ( $options_categories ) {
		$options[] = array(
			'name' => __('Exclude Categories', $domain),
			'desc' => __('Select any categories you\'d like to be excluded from your blog.', $domain),
			'id' => 'exclude_categories',
			'std' => array(),
			'type' => 'multicheck',
			'options' => $options_categories);
	}

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Archives', $domain ),
		'desc' => __( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', $domain ),
		'class' => 'group-archives',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Show titles', $domain),
		'desc' => __('Choose whether or not you want the title to show on tag archives, category archives, date archives, author archives and search result pages.', $domain),
		'id' => 'archive_title',
		'std' => 'show',
		'type' => 'radio',
		'options' => array(
			'show' => __('Show the title', $domain),
			'hide' => __('Hide title', $domain),
		));

	$options[] = array(
		'name' => __('Page Layout', $domain),
		'desc' => __('Select default layout for archive page.', $domain),
		'id' => 'archive_page',
		'std' => 'blog',
		'type' => 'select',
		'options' => $template_defaults);

	$options[] = array(
		'type' 	=> 'group_end');

	/*
	|--------------------------------------------------------------------------
	| Configuration
	|--------------------------------------------------------------------------
	*/

	$options[] = array(
		'name' => __('Configuration', $domain),
		'type' => 'heading');

	$options[] = array(
		'name' => __( 'Responsive', $domain ),
		'class' => 'group-responsive',
		'type' 	=> 'group_start');

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

	$options[] = array(
		'name' => __('Add styles to tablet devices only', $domain),
		'desc' => __('This CSS styles apply to breakpoint @media screen and (max-width: 992px).', $domain),
		'id' => 'responsive_css_992',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Add styles to mobile devices only', $domain),
		'desc' => __('This CSS styles apply to breakpoint @media screen and (max-width: 768px).', $domain),
		'id' => 'responsive_css_992',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'type' 	=> 'group_end');

	$options[] = array(
		'name' => __( 'Minify', $domain ),
		'class' => 'group-minify',
		'type' 	=> 'group_start');

	$options[] = array(
		'name' => __('Warning', $domain),
		'desc' => __('If you have a cache plugin installed in your site desactive this options.', $domain),
		'id' => 'css_warning',
		'type' => 'info');

	$options[] = array(
		'name' => __('Combine and Compress CSS files', $domain),
		'desc' => __('Combine and compress all CSS files to one. Help reduce page load time.', $domain),
		'id' => "compress_css",
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Combine and Compress Javascript files', $domain),
		'desc' => __('Combine and compress all Javascript files to one. Help reduce page load time.', $domain),
		'id' => "compress_js",
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'type' 	=> 'group_end');

	return $options;
}