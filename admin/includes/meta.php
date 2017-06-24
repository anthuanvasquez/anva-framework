<?php

/**
 * Add meta boxes fields. This function regster
 * all meta boxes on admin post types.
 *
 * @since  1.0.0
 */
function anva_add_meta_boxes_default() {

	// Get metaboxes options and arguments.
	$layout          = anva_setup_layout_meta();
	$page            = anva_setup_page_meta();
	$page_template   = anva_setup_page_template_meta();
	$post            = anva_setup_post_meta();
	$post_format     = anva_setup_post_format_meta();
	$gallery         = anva_setup_gallery_meta();
	$gallery_media   = anva_setup_gallery_media_meta();
	$portfolio       = anva_setup_portfolio_meta();
	$portfolio_media = anva_setup_portfolio_media_meta();
	$slideshow       = anva_setup_slideshow_meta();
	$content_builder = anva_setup_content_builder_meta();

	// Setup metaboxes.
	new Anva_Page_Meta_Box( $layout['args']['id'], $layout['args'], $layout['options'] );
	new Anva_Page_Meta_Box( $page['args']['id'], $page['args'], $page['options'] );
	new Anva_Page_Meta_Box( $page_template['args']['id'], $page_template['args'], $page_template['options'] );
	new Anva_Page_Meta_Box( $post['args']['id'], $post['args'], $post['options'] );
	new Anva_Page_Meta_Box( $post_format['args']['id'], $post_format['args'], $post_format['options'] );
	new Anva_Page_Meta_Box( $gallery['args']['id'], $gallery['args'], $gallery['options'] );
	new Anva_Page_Meta_Box( $portfolio['args']['id'], $portfolio['args'], $portfolio['options'] );
	new Anva_Page_Meta_Box( $slideshow['args']['id'], $slideshow['args'], $slideshow['options'] );

	// Setup advanced metaboxes.
	new Anva_Page_Meta_Gallery( $gallery_media['args']['id'], $gallery_media['args'] );
	new Anva_Page_Meta_Gallery( $portfolio_media['args']['id'], $portfolio_media['args'], $portfolio_media['options'] );
	new Anva_Page_Meta_Builder( $content_builder['args']['id'], $content_builder['args'], $content_builder['options'] );

}

/**
 * Layout meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_layout_meta() {

	// Get header types.
	$header_types   = array();
	$header_types[] = esc_html__( 'Default Setting', 'anva' );
	foreach ( anva_get_header_types() as $type_id => $type ) {
		$header_types[ $type_id ] = $type['name'];
	}

	$setup = array(
		'args' => array(
			'id'       => 'anva_layout_options',
			'title'    => esc_html__( 'Layout Options', 'anva' ),
			'page'     => array( 'post', 'page', 'portfolio' ),
			'context'  => 'side',
			'priority' => 'default',
			'desc'     => esc_html__( 'This is the default placeholder for sidebar layout options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => array(
			'sidebar_layout' => array(
				'name' => esc_html__( 'Sidebar Layout', 'anva' ),
				'desc' => esc_html__( 'Select a sidebar layout.', 'anva' ),
				'id'   => 'sidebar_layout',
				'type' => 'layout',
				'std'  => array(
					'layout' => '',
					'right'  => '',
					'left'   => ''
				),
			),
			'header_type' => array(
				'name' => esc_html__( 'Header Type', 'anva' ),
				'desc' => esc_html__( 'Select the type of the header.', 'anva' ),
				'id'   => 'header_type',
				'std'  => '',
				'type' => 'select',
				'options' => $header_types,
			),
			'header_sticky' => array(
				'name' => esc_html__( 'Header Sticky', 'anva' ),
				'desc' => esc_html__( 'Select if you want the header sticky or not.', 'anva' ),
				'id'   => 'header_sticky',
				'std'  => '',
				'type' => 'select',
				'options' => array(
					'' => esc_html__( 'Default Setting', 'anva' ),
					'no_sticky' => esc_html__( 'Remove Sticky Header', 'anva' ),
				),
			),
		),
	);

	return apply_filters( 'anva_layout_meta', $setup );
}

/**
 * Post meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_post_meta() {
	$setup = array(
		'args' => array(
			'id'       => 'anva_post_options',
			'title'    => esc_html__( 'Post Options', 'anva' ),
			'page'     => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'default',
			'desc'     => esc_html__( 'This is the default placeholder for post options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => array(
			'hide_title' => array(
				'name' 		=> esc_html__( 'Post Title', 'anva' ),
				'desc'		=> esc_html__( 'Show or hide post\'s titles.', 'anva' ),
				'id'		=> 'hide_title',
				'type' 		=> 'select',
				'std'		=> 'show',
				'options'	=> array(
					'show' 	=> esc_html__( 'Show post\'s title', 'anva' ),
					'hide'	=> esc_html__( 'Hide post\'s title', 'anva' ),
				),
			),
			'breadcrumbs' 	=> array(
				'name' 		=> esc_html__( 'Breadcrumbs', 'anva' ),
				'desc'		=> esc_html__( 'Select to show or hide breadcrumbs on this page.', 'anva' ),
				'id'		=> 'breadcrumbs',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> esc_html__( 'Default Setting', 'anva' ),
					'show' 	=> esc_html__( 'Show breadcrumbs', 'anva' ),
					'hide'	=> esc_html__( 'Hide breadcrumbs', 'anva' ),
				),
			),
			'post_share' 	=> array(
				'name' 		=> esc_html__( 'Share Links', 'anva' ),
				'desc'		=> esc_html__( 'Select to show or hide post share links on this page.', 'anva' ),
				'id'		=> 'post_share',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> esc_html__( 'Default Setting', 'anva' ),
					'show' 	=> esc_html__( 'Show post share links', 'anva' ),
					'hide'	=> esc_html__( 'Hide post share links', 'anva' ),
				),
			),
			'post_nav' 	=> array(
				'name' 		=> esc_html__( 'Post Navigation', 'anva' ),
				'desc'		=> esc_html__( 'Select to show or hide post navigation on this page.', 'anva' ),
				'id'		=> 'post_nav',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> esc_html__( 'Default Setting', 'anva' ),
					'show' 	=> esc_html__( 'Show post navigation', 'anva' ),
					'hide'	=> esc_html__( 'Hide post navigation', 'anva' ),
				),
			),
			'post_author' 	=> array(
				'name' 		=> esc_html__( 'Author Box', 'anva' ),
				'desc'		=> esc_html__( 'Select to show or hide post author box.', 'anva' ),
				'id'		=> 'post_author',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> esc_html__( 'Default Setting', 'anva' ),
					'show' 	=> esc_html__( 'Show post author box', 'anva' ),
					'hide'	=> esc_html__( 'Hide post author box', 'anva' ),
				),
			),
			'post_related' 	=> array(
				'name' 		=> esc_html__( 'Related Posts', 'anva' ),
				'desc'		=> esc_html__( 'Select to show or hide related posts.', 'anva' ),
				'id'		=> 'post_related',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> esc_html__( 'Default Setting', 'anva' ),
					'show' 	=> esc_html__( 'Show related posts', 'anva' ),
					'hide'	=> esc_html__( 'Hide related posts', 'anva' ),
				),
			),
		),
	);

	return apply_filters( 'anva_post_meta', $setup );
}
/**
 * Post format meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_post_format_meta() {

	// Get gallery columns.
	$columns = array();
	foreach ( range( 2, 6 ) as $col ) {
		$columns[ $col ] = $col . ' ' . esc_html__( 'Columns', 'anva' );
	}

	$setup = array(
		'args' => array(
			'id'       => 'anva_post_format_options',
			'title'    => esc_html__( 'Post Format Options', 'anva' ),
			'page'     => array( 'post' ),
			'context'  => 'side',
			'priority' => 'default',
			'desc'     => esc_html__( 'This is the default placeholder for post format options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => array(
			'gallery' => array(
				'name' 		=> esc_html__( 'Post Format Gallery', 'anva' ),
				'desc'		=> esc_html__( 'Select the type you want to show in the post format gallery.', 'anva' ),
				'id'		=> 'gallery',
				'type' 		=> 'select',
				'std'		=> 'slider',
				'options'	=> array(
					'slider' 	=> esc_html__( 'Gallery Slider', 'anva' ),
					'masonry'	=> esc_html__( 'Gallery Masonry', 'anva' )
				),
				'trigger' => 'slider',
				'receivers' => 'gallery_slider',
			),
			'gallery_slider' => array(
				'name' 		=> esc_html__( 'Gallery Slider Type', 'anva' ),
				'desc'		=> esc_html__( 'Select the slider type to show the gallery images.', 'anva' ),
				'id'		=> 'gallery_slider',
				'type' 		=> 'select',
				'std'		=> 'standard',
				'options'	=> array(
					'standard' => esc_html__( 'Standard Slider', 'anva' ),
					'nivo'     => esc_html__( 'Nivo Slider', 'anva' )
				),
			),
			'gallery_highlight' => array(
				'name' 		=> esc_html__( 'Gallery Masonry Highlight', 'anva' ),
				'desc'		=> esc_html__( 'Enter the gallery image to want to highlight.', 'anva' ),
				'id'		=> 'gallery_highlight',
				'type' 		=> 'number',
				'std'		=> '',
			),
			'gallery_columns' => array(
				'name' 		=> esc_html__( 'Gallery Masonry Columns', 'anva' ),
				'desc'		=> esc_html__( 'Select the gallery masonry columns.', 'anva' ),
				'id'		=> 'gallery_columns',
				'type' 		=> 'select',
				'std'		=> '3',
				'options' 	=> $columns
			),
		),
	);

	return apply_filters( 'anva_post_format_meta', $setup );
}

/**
 * Page meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_page_meta() {
	$setup = array(
		'args' => array(
			'id' 			=> 'anva_page_options',
			'title' 		=> esc_html__( 'Page Options', 'anva' ),
			'page'			=> array( 'page' ),
			'context' 		=> 'normal',
			'priority'		=> 'default',
			'desc'			=> esc_html__( 'This is the default placeholder for page options.', 'anva' ),
			'prefix'		=> '_anva_',
		),
		'options' => array(
			'hide_title'    => array(
				'name'      => esc_html__( 'Page Title', 'anva' ),
				'desc'      => esc_html__( 'Select to show or hide page\'s titles on this page. This option will be ignore in "Builder" template.', 'anva' ),
				'id'        => 'hide_title',
				'type'      => 'select',
				'std'       => 'show',
				'options'   => array(
					'show'  => esc_html__( 'Show page\'s title', 'anva' ),
					'hide'  => esc_html__( 'Hide page\'s title', 'anva' ),
				)
			),
			'page_title_mini'  => array(
				'name'      => esc_html__( 'Page Title Mini', 'anva' ),
				'desc'      => esc_html__( 'Use a mini version of the page titles.', 'anva' ),
				'id'        => 'page_title_mini',
				'type'      => 'select',
				'std'       => 'no',
				'options'   => array(
				    'yes'   => esc_html__( 'Yes, use mini version of pages title', 'anva' ),
					'no'    => esc_html__( 'Don\'t use the mini version of pages title', 'anva' ),
				),
			),
			'page_tagline'  => array(
				'name'      => esc_html__( 'Page Tagline', 'anva' ),
				'desc'      => esc_html__( 'Enter a ahort page tagline for this page. Note: if page title mini is active, , the tagline will not show.', 'anva' ),
				'id'        => 'page_tagline',
				'type'      => 'text',
				'std'       => '',
			),
			'title_align'   => array(
				'name'      => esc_html__( 'Title Align', 'anva' ),
				'desc'      => esc_html__( 'Select the page title align.', 'anva' ),
				'id'        => 'title_align',
				'type'      => 'select',
				'std'       => '',
				'options'   => array(
					''      => esc_html__( 'Left', 'anva' ),
					'right' => esc_html__( 'Right', 'anva' ),
					'center'=> esc_html__( 'Center', 'anva' ),
				),
			),
			'title_bg'  => array(
				'name'      => esc_html__( 'Title Background', 'anva' ),
				'desc'      => esc_html__( 'Use background in page titles.', 'anva' ),
				'id'        => 'title_bg',
				'type'      => 'select',
				'std'       => 'default',
				'options'   => array(
					'light' => esc_html__( 'Light', 'anva' ),
					'dark'  => esc_html__( 'Dark', 'anva' ),
					'custom'=> esc_html__( 'Custom', 'anva' ),
					'nobg'  => esc_html__( 'No Background', 'anva' ),

				),
				'trigger'   => 'custom',
				'receivers' => 'title_bg_color title_bg_image title_bg_cover title_bg_text title_bg_padding'
			),
			'title_bg_color' => array(
				'name'      => esc_html__( 'Background Color', 'anva' ),
				'desc'      => esc_html__( 'Select a background color for page title.', 'anva' ),
				'id'        => 'title_bg_color',
				'type'      => 'color',
				'std'       => '#cccccc',
				'class'     => 'hidden',
			),
			'title_bg_image' => array(
				'name'      => esc_html__( 'Background Image', 'anva' ),
				'desc'      => esc_html__( 'Select a background image for page title. Use a large image for better experience.', 'anva' ),
				'id'        => 'title_bg_image',
				'type'      => 'upload',
				'std'       => '',
				'class'     => 'hidden',
			),
			'title_bg_cover' => array(
				'name'      => NULL,
				'desc'      => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Cover', 'anva' ), esc_html__( 'Fill background with the image.', 'anva' ) ),
				'id'        => 'title_bg_cover',
				'type'      => 'checkbox',
				'std'       => '0',
				'class'     => 'hidden',
			),
			'title_bg_text' => array(
				'name'      => NULL,
				'desc'      => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Text', 'anva' ), esc_html__( 'Apply light color.', 'anva' ) ),
				'id'        => 'title_bg_text',
				'type'      => 'checkbox',
				'std'       => '0',
				'class'     => 'hidden',
			),
			'title_bg_padding' => array(
				'name'      => esc_html__( 'Padding' , 'anva' ),
				'desc'      => esc_html__( 'Apply padding to background when using a image. Default is 120px.', 'anva' ),
				'id'        => 'title_bg_padding',
				'type'      => 'range',
				'std'       => 120,
				'options'   => array(
					'min'   => 60,
					'max'   => 200,
					'step'  => 1,
					'units' => 'px',
				),
				'class'     => 'hidden',
			),
			'breadcrumbs'   => array(
				'name'      => esc_html__( 'Breadcrumbs', 'anva' ),
				'desc'      => esc_html__( 'Select to show or hide breadcrumbs on this page.', 'anva' ),
				'id'        => 'breadcrumbs',
				'type'      => 'select',
				'std'       => '',
				'options'   => array(
					''      => esc_html__( 'Default Setting', 'anva' ),
					'show'  => esc_html__( 'Show breadcrumbs', 'anva' ),
					'hide'  => esc_html__( 'Hide breadcrumbs', 'anva' ),
				),
			),
			'post_share'    => array(
				'name'      => esc_html__( 'Share Links', 'anva' ),
				'desc'      => esc_html__( 'Select to show or hide post share links on this page.', 'anva' ),
				'id'        => 'post_share',
				'type'      => 'select',
				'std'       => '',
				'options'   => array(
					''      => esc_html__( 'Default Setting', 'anva' ),
					'show'  => esc_html__( 'Show post share links', 'anva' ),
					'hide'  => esc_html__( 'Hide post share links', 'anva' ),
				),
			),
			'post_nav'  => array(
				'name'      => esc_html__( 'Post Navigation', 'anva' ),
				'desc'      => esc_html__( 'Select to show or hide post navigation on this page.', 'anva' ),
				'id'        => 'post_nav',
				'type'      => 'select',
				'std'       => '',
				'options'   => array(
					''      => esc_html__( 'Default Setting', 'anva' ),
					'show'  => esc_html__( 'Show post navigation', 'anva' ),
					'hide'  => esc_html__( 'Hide post navigation', 'anva' ),
				),
			),
			'post_author'   => array(
				'name'      => esc_html__( 'Author Box', 'anva' ),
				'desc'      => esc_html__( 'Select to show or hide post author box.', 'anva' ),
				'id'        => 'post_author',
				'type'      => 'select',
				'std'       => '',
				'options'   => array(
					''      => esc_html__( 'Default Setting', 'anva' ),
					'show'  => esc_html__( 'Show post author box', 'anva' ),
					'hide'  => esc_html__( 'Hide post author box', 'anva' ),
				),
			),
			'post_related'  => array(
				'name'      => esc_html__( 'Related Posts', 'anva' ),
				'desc'      => esc_html__( 'Select to show or hide related posts.', 'anva' ),
				'id'        => 'post_related',
				'type'      => 'select',
				'std'       => '',
				'options'   => array(
					''      => esc_html__( 'Default Setting', 'anva' ),
					'show'  => esc_html__( 'Show related posts', 'anva' ),
					'hide'  => esc_html__( 'Hide related posts', 'anva' ),
				),
			),
		),
	);

	return apply_filters( 'anva_page_meta', $setup );
}

/**
 * Page template meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_page_template_meta() {

	// Fill columns array.
	$columns = array();
	$columns[''] = esc_html__( 'Default Grid Columns', 'anva' );
	foreach ( anva_get_grid_columns() as $key => $value ) {
		$columns[ $key ] = esc_html( $value['name'] );
	}

	$setup = array(
		'args' => array(
			'id'            => 'anva_page_template_options',
			'title'         => esc_html__( 'Page Template Options', 'anva' ),
			'page'          => array( 'page' ),
			'context'       => 'side',
			'priority'      => 'default',
			'desc'          => esc_html__( 'This is the default placeholder for page options.', 'anva' ),
			'prefix'        => '_anva_',
		),
		'options' => array(
			'grid_column'   => array(
				'name'      => esc_html__( 'Post Grid', 'anva' ),
				'desc'      => esc_html__( 'Setup the grid columns for "Posts Grid" template.', 'anva' ),
				'id'        => 'grid_column',
				'type'      => 'select',
				'std'       => '',
				'options'   => $columns
			),
		),
	);

	return apply_filters( 'anva_page_template_meta', $setup );
}

/**
 * Gallery meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_gallery_meta() {

	$galleries = array();
	$galleries[''] = esc_html__( 'Default Gallery Columns', 'anva' );

	foreach ( anva_gallery_templates() as $key => $value ) {
		$galleries[ $key ] = esc_html( $value['name'] );
	}

	$setup = array(
		'args' => array(
			'id' 		        => 'anva_gallery_options',
			'title' 	        => esc_html__( 'Gallery Options', 'anva' ),
			'page'		        => array( 'galleries' ),
			'context' 	        => 'normal',
			'priority'	        => 'default',
			'desc'		        => esc_html__( 'This is the default placeholder for gallery options.', 'anva' ),
			'prefix'	        => '_anva_',
		),
		'options'               => array(
			'hide_title'        => array(
				'name'          => esc_html__( 'Gallery Title', 'anva' ),
				'desc'          => esc_html__( 'Show or hide gallery\'s titles.', 'anva' ),
				'id'            => 'hide_title',
				'type'          => 'select',
				'std'           => 'show',
				'options'       => array(
					'show'      => esc_html__( 'Show gallery\'s title', 'anva' ),
					'hide'      => esc_html__( 'Hide gallery\'s title', 'anva' )
				)
			),
			'page_tagline'      => array(
				'name'          => esc_html__( 'Gallery Tagline', 'anva' ),
				'desc'          => esc_html__( 'Enter s ahort gallery tagline.', 'anva' ),
				'id'            => 'page_tagline',
				'type'          => 'text',
				'std'           => '',
			),
			'gallery_highlight' => array(
				'id'            => 'gallery_highlight',
				'name'          => esc_html__( 'Highlight Image', 'anva' ),
				'desc'          => esc_html__( 'Enter the number of image than want to highlight.', 'anva' ),
				'type'          => 'number',
				'std'           => ''
			),
			'gallery_template'  => array(
				'id'            => 'gallery_template',
				'name'          => esc_html__( 'Gallery Columns', 'anva' ),
				'desc'          => esc_html__( 'Select gallery template for this gallery.', 'anva' ),
				'type'          => 'select',
				'std'           => '',
				'options'       => $galleries
			),
		)
	);

	return apply_filters( 'anva_gallery_meta', $setup );
}

/**
 * Portfolio meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_portfolio_meta() {

	$setup = array(
		'args' => array(
			'id'            => 'anva_portfolio_options',
			'title'         => esc_html__( 'Portfolio Options', 'anva' ),
			'page'          => array( 'portfolio' ),
			'context'       => 'normal',
			'priority'      => 'default',
			'desc'          => esc_html__( 'This is the default placeholder for portfolio options.', 'anva' ),
			'prefix'        => '_anva_',
		),
		'options' => array(
			'hide_title' => array(
				'id'        => 'hide_title',
				'name'      => esc_html__( 'Portfolio Title', 'anva' ),
				'desc'      => esc_html__( 'Show or hide portfolio\'s item titles.', 'anva' ),
				'type'      => 'select',
				'std'       => 'show',
				'options'   => array(
					'show'  => esc_html__( 'Show portfolio\'s item title', 'anva' ),
					'hide'  => esc_html__( 'Hide portfolio\'s item title', 'anva' )
				),
			),
			'author' => array(
				'id'        => 'author',
				'name'      => esc_html__( 'Author', 'anva' ),
				'desc'      => esc_html__( 'Enter the porfolio item author.', 'anva' ),
				'type'      => 'text',
				'std'       => ''
			),
			'client' => array(
				'id'        => 'client',
				'name'      => esc_html__( 'Client', 'anva' ),
				'desc'      => esc_html__( 'Enter the porfolio client.', 'anva' ),
				'type'      => 'text',
				'std'       => ''
			),
			'client_url' => array(
				'id'        => 'client_url',
				'name'      => esc_html__( 'Client URL', 'anva' ),
				'desc'      => esc_html__( 'Enter the client URL.', 'anva' ),
				'type'      => 'text',
				'std'       => 'http://'
			),
			'date' => array(
				'id'        => 'date',
				'name'      => esc_html__( 'Date', 'anva' ),
				'desc'      => esc_html__( 'Select the date on which the project was completed.', 'anva' ),
				'type'      => 'date',
				'std'       => ''
			),
		)
	);

	return apply_filters( 'anva_portfolio_meta', $setup );
}

/**
 * Portfolio media meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_portfolio_media_meta() {

	$setup = array(
		'args' => array(
			'id'            => 'anva_portfolio_media',
			'title'         => esc_html__( 'Portfolio Media', 'anva' ),
			'page'          => array( 'portfolio' ),
			'context'       => 'advanced',
			'priority'      => 'default',
			'desc'          =>esc_html__( 'Portfolio Media', 'anva' ),
			'prefix'        => '_anva_',
		),
		'options' => array(
			'audio' => array(
				'id'        => 'audio',
				'name'      => null,
				'desc'      => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Audio', 'anva' ), esc_html__( 'Show audio content in portfolio.', 'anva' ) ),
				'type'      => 'checkbox',
				'std'       => '0',
				'trigger'   => 1,
				'receivers' => 'audio_image audio_mp3 audio_ogg',
			),
			'audio_image' => array(
				'id'        => 'audio_image',
				'name'      => esc_html__( 'Audio Featured Image', 'anva' ),
				'desc'      => esc_html__( 'Add a poster image to your audio player (optional).', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'audio_mp3' => array(
				'id'        => 'audio_mp3',
				'name'      => esc_html__( 'Audio MP3', 'anva' ),
				'desc'      => esc_html__( 'Insert an .mp3 file, if desired.', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'audio_ogg' => array(
				'id'        => 'audio_ogg',
				'name'      => esc_html__( 'Audio OGG', 'anva' ),
				'desc'      => esc_html__( 'Insert an .ogg file, if desired.', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'video' => array(
				'id'        => 'video',
				'name'      => null,
				'desc'      => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Video', 'anva' ), esc_html__( 'Show video content in portfolio.', 'anva' ) ),
				'type'      => 'checkbox',
				'std'       => '0',
				'trigger'   => 1,
				'receivers' => 'video_image video_m4v video_ogv video_mp4 video_embed'
			),
			'video_image' => array(
				'id'        => 'video_image',
				'name'      => esc_html__( 'Video Featured Image', 'anva' ),
				'desc'      => esc_html__( 'Add a poster image for your video player (optional).', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'video_m4v' => array(
				'id'        => 'video_m4v',
				'name'      => esc_html__( 'Video M4V', 'anva' ),
				'desc'      => esc_html__( 'Insert an .m4v file, if desired..', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'video_ogv' => array(
				'id'        => 'video_ogv',
				'name'      => esc_html__( 'Video OGV', 'anva' ),
				'desc'      => esc_html__( 'Insert an .ogv file, if desired.', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'video_mp4' => array(
				'id'        => 'video_mp4',
				'name'      => esc_html__( 'Video MP4', 'anva' ),
				'desc'      => esc_html__( 'Insert an .mp4 file, if desired.', 'anva' ),
				'type'      => 'upload',
				'std'       => ''
			),
			'video_embed' => array(
				'id'        => 'video_embed',
				'name'      => esc_html__( 'Video Embed', 'anva' ),
				'desc'      => esc_html__( 'Embed iframe code from YouTube, Vimeo or other trusted source. HTML tags are limited to iframe, div, img, a, em, strong and br. Note: This field overrides the previous fields.', 'anva' ),
				'type'      => 'textarea',
				'std'       => ''
			),
			'gallery' => array(
				'id'        => 'gallery',
				'name'      => NULL,
				'desc'      => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Gallery', 'anva' ), esc_html__( 'Show gallery content in portfolio.', 'anva' ) ),
				'type'      => 'checkbox',
				'std'       => '0',
			),
		),
	);

	return apply_filters( 'anva_portfolio_media_meta', $setup );
}

/**
 * Slideshow meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_slideshow_meta() {

	$slider        = anva_get_option( 'slider_id' );
	$sliders       = anva_get_sliders( $slider );
	$slider_fields = array();

	if ( isset( $sliders['fields'] ) ) {
		$slider_fields = $sliders['fields'];
	}

	$setup = array(
		'args' => array(
			'id'       => 'anva_slider_options',
			'title'    => esc_html__( 'Slide Options', 'anva' ),
			'page'     => array( 'slideshows' ),
			'context'  => 'normal',
			'priority' => 'default',
		),
		'options'      => $slider_fields
	);

	return apply_filters( 'anva_slideshow_meta', $setup );
}

/**
 * Gallery attachements meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_gallery_media_meta() {

	$setup = array(
		'args' => array(
			'id'       => '_anva_gallery_media',
			'title'    => esc_html__( 'Gallery', 'anva' ),
			'page'     => array( 'galleries', 'portfolio' ), // Use gallery in portfolio?
			'context'  => 'advanced',
			'priority' => 'default'
		)
	);

	return apply_filters( 'anva_gallery_media_meta', $setup );
}

/**
 * Page builder meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_content_builder_meta() {

	$setup = array(
		'args' => array(
			'id'       => '_anva_builder_options',
			'title'    => esc_html__( 'Content Builder', 'anva' ),
			'page'     => array( 'page' ),
			'context'  => 'advanced',
			'priority' => 'default',
		),
		'options'	   => anva_get_elements(),
	);

	return apply_filters( 'anva_content_buider_meta', $setup );
}
