<?php
//Get all galleries
$args = array(
	'numberposts' => -1,
	'post_type' => array('galleries'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
	$galleries_select[$gallery->ID] = $gallery->post_title;
}

//Get all categories
$categories_arr = get_categories();
$categories_select = array();
$categories_select[''] = '';

foreach ($categories_arr as $cat) {
	$categories_select[$cat->cat_ID] = $cat->cat_name;
}

//Get activate, deactivate options
$activated_arr = array(
	0	=> 	'Deactivated',
	1	=> 	'Activated',
);

$ppb_shortcodes = array(
	'ppb_text' => array(
		'title' =>  'Text Block',
		'attr' => array(),
		'desc' => array(),
		'content' => TRUE
	),
	'ppb_divider' => array(
		'title' =>  'Divider',
		'attr' => array(),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_classic_blog' => array(
		'title' =>  'Classic Blog',
		'attr' => array(
			'description' => array(
				'type' => 'text',
				'desc' => 'Enter short description. It displays under the title',
			),
			'category' => array(
				'Title' => 'Filter by category',
				'type' => 'select',
				'options' => $categories_select,
				'desc' => 'You can choose to display only some posts from selected category',
			),
			'items' => array(
				'type' => 'text',
				'desc' => 'Enter number of posts to display (number value only)',
			),
			'link' => array(
				'Title' => 'Link title to selected category page',
				'type' => 'select',
				'options' => $activated_arr,
				'desc' => 'If you activate this option. Title will link to selected category page',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_category_blog' => array(
		'title' =>  'Category Blog',
		'attr' => array(
			'description' => array(
				'type' => 'text',
				'desc' => 'Enter short description. It displays under the title',
			),
			'category' => array(
				'Title' => 'Filter by category',
				'type' => 'select',
				'options' => $categories_select,
				'desc' => 'You can choose to display only some posts from selected category',
			),
			'items' => array(
				'type' => 'text',
				'desc' => 'Enter number of posts to display (number value only)',
			),
			'link' => array(
				'Title' => 'Link title to selected category page',
				'type' => 'select',
				'options' => $activated_arr,
				'desc' => 'If you activate this option. Title will link to selected category page',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_category_carousel' => array(
		'title' =>  'Category Carousel',
		'attr' => array(
			'description' => array(
				'type' => 'text',
				'desc' => 'Enter short description. It displays under the title',
			),
			'category' => array(
				'Title' => 'Filter by category',
				'type' => 'select',
				'options' => $categories_select,
				'desc' => 'You can choose to display only some posts from selected category',
			),
			'items' => array(
				'type' => 'text',
				'desc' => 'Enter number of posts to display (number value only)',
			),
			'link' => array(
				'Title' => 'Link title to selected category page',
				'type' => 'select',
				'options' => $activated_arr,
				'desc' => 'If you activate this option. Title will link to selected category page',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_gallery_carousel' => array(
		'title' =>  'Gallery Carousel',
		'attr' => array(
			'description' => array(
				'type' => 'text',
				'desc' => 'Enter short description. It displays under the title',
			),
			'gallery' => array(
				'Title' => 'Filter by gallery',
				'type' => 'select',
				'options' => $galleries_select,
				'desc' => 'You can choose to display only some images from selected gallery',
			),
			'items' => array(
				'type' => 'text',
				'desc' => 'Enter number of images to display (number value only)',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_columns_blog' => array(
		'title' =>  'Columns Blog',
		'attr' => array(
			'description' => array(
				'type' => 'text',
				'desc' => 'Enter short description. It displays under the title',
			),
			'category' => array(
				'Title' => 'Filter by category',
				'type' => 'select',
				'options' => $categories_select,
				'desc' => 'You can choose to display only some posts from selected category',
			),
			'items' => array(
				'type' => 'text',
				'desc' => 'Enter number of posts to display (number value only)',
			),
			'link' => array(
				'Title' => 'Link title to selected category page',
				'type' => 'select',
				'options' => $activated_arr,
				'desc' => 'If you activate this option. Title will link to selected category page',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_filter_blog' => array(
		'title' =>  'Filterable Blog',
		'attr' => array(
			'category' => array(
				'Title' => 'Filter by category',
				'type' => 'select_multiple',
				'options' => $categories_select,
				'desc' => 'You can choose to display only some posts from selected category',
			),
			'items' => array(
				'type' => 'text',
				'desc' => 'Enter number of posts to display (number value only)',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_parallax_bg' => array(
		'title' =>  'Parallax Background Image',
		'attr' => array(
			'description' => array(
				'type' => 'textarea',
				'desc' => 'Enter short description. It displays under the title',
			),
			'background' => array(
				'Title' => 'Background Image',
				'type' => 'file',
				'desc' => 'Upload background image you want to display for this content',
			),
			'height' => array(
				'type' => 'text',
				'desc' => 'Enter number of height for background image (in pixel)',
			),
			'link_text' => array(
				'type' => 'text',
				'desc' => 'Enter background link text (For example "Read Full Story")',
			),
			'link_url' => array(
				'type' => 'text',
				'desc' => 'Enter background link URL',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_video_bg' => array(
		'title' =>  'Video Background',
		'attr' => array(
			'description' => array(
				'type' => 'textarea',
				'desc' => 'Enter short description. It displays under the title',
			),
			'video_url' => array(
				'Title' => 'Video URL',
				'type' => 'file',
				'desc' => 'Upload video file you want to display for this content (Recommended .webm to support all major browsers)',
			),
			'preview_img' => array(
				'title' => 'Preview Image URL',
				'type' => 'file',
				'desc' => 'Upload preview image for this video',
			),
			'height' => array(
				'type' => 'text',
				'desc' => 'Enter number of height for background image (in pixel)',
			),
			'link_text' => array(
				'type' => 'text',
				'desc' => 'Enter video link text (For example "Read Full Story")',
			),
			'link_url' => array(
				'type' => 'text',
				'desc' => 'Enter video link URL',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
	'ppb_transparent_video_bg' => array(
		'title' =>  'Transparent Video Background',
		'attr' => array(
			'description' => array(
				'type' => 'textarea',
				'desc' => 'Enter short description. It displays under the title',
			),
			'video_url' => array(
				'Title' => 'Video URL',
				'type' => 'file',
				'desc' => 'Upload video file you want to display for this content (Recommended .webm to support all major browsers)',
			),
			'preview_img' => array(
				'title' => 'Preview Image URL',
				'type' => 'file',
				'desc' => 'Upload preview image for this video',
			),
			'height' => array(
				'type' => 'text',
				'desc' => 'Enter number of height for background image (in pixel)',
			),
			'link_text' => array(
				'type' => 'text',
				'desc' => 'Enter video link text (For example "Read Full Story")',
			),
			'link_url' => array(
				'type' => 'text',
				'desc' => 'Enter video link URL',
			),
		),
		'desc' => array(),
		'content' => FALSE
	),
);

ksort( $ppb_shortcodes );