<?php

/**
 * Add meta boxes fields. This function regster
 * all meta boxes on admin post types.
 *
 * @since  1.0.0
 */
function anva_add_meta_boxes_default() {

    /* ------------------------------------------ */
    /* Layout
    /* ------------------------------------------ */

	$layout = anva_setup_layout_meta();

	anva_add_meta_box(
		$layout['args']['id'],
		$layout['args'],
		$layout['options']
	);

	/* ------------------------------------------ */
	/* Page
	/* ------------------------------------------ */

    $page          = anva_setup_page_meta();
	$page_template = anva_setup_page_template_meta();

	anva_add_meta_box(
		$page['args']['id'],
		$page['args'],
		$page['options']
	);

    anva_add_meta_box(
        $page_template['args']['id'],
        $page_template['args'],
        $page_template['options']
    );

	/* ------------------------------------------ */
	/* Post
	/* ------------------------------------------ */

	$post        = anva_setup_post_meta();
	$post_format = anva_setup_post_format_meta();

	anva_add_meta_box(
		$post['args']['id'],
		$post['args'],
		$post['options']
	);

	anva_add_meta_box(
		$post_format['args']['id'],
		$post_format['args'],
		$post_format['options']
	);

	/* ------------------------------------------ */
	/* Gallery
	/* ------------------------------------------ */

	if ( post_type_exists( 'galleries' ) ) {
		$gallery       = anva_setup_gallery_meta();
		$gallery_media = anva_setup_gallery_media_meta();

		anva_add_meta_box(
			$gallery['args']['id'],
			$gallery['args'],
			$gallery['options']
		);

		new Anva_Gallery(
			$gallery_media['args']['id'],
			$gallery_media['args']
		);
	}

	/* ------------------------------------------ */
	/* Portfolio
	/* ------------------------------------------ */

	if ( post_type_exists( 'portfolio' ) ) {

		$portfolio       = anva_setup_portfolio_meta();
		$portfolio_media = anva_setup_portfolio_media_meta();

		anva_add_meta_box(
			$portfolio['args']['id'],
			$portfolio['args'],
			$portfolio['options']
		);

		anva_add_meta_box(
			$portfolio_media['args']['id'],
			$portfolio_media['args'],
			$portfolio_media['options']
		);
	}

	/* ------------------------------------------ */
	/* Slideshows
	/* ------------------------------------------ */

	if ( post_type_exists( 'slideshows' ) ) {
		$slideshow = anva_setup_slideshow_meta();
		anva_add_meta_box(
			$slideshow['args']['id'],
			$slideshow['args'],
			$slideshow['options']
		);
	}

	/* ------------------------------------------ */
	/* Content Builder
	/* ------------------------------------------ */

	$content_builder = anva_setup_content_builder_meta();

	new Anva_Content_Builder(
		$content_builder['args']['id'],
		$content_builder['args'],
		$content_builder['options']
	);


}

/**
 * Layout meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_layout_meta() {
	$setup = array(
		'args' => array(
			'id'       => 'anva_layout_options',
			'title'    => __( 'Layout Options', 'anva' ),
			'page'     => array( 'post', 'page', 'portfolio' ),
			'context'  => 'side',
			'priority' => 'high',
			'desc'     => __( 'This is the default placeholder for sidebar layout options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => array(
			'sidebar_layout' => array(
				'name' => __( 'Sidebar Layout', 'anva' ),
				'desc' => __( 'Select a sidebar layout.', 'anva' ),
				'id'   => 'sidebar_layout',
				'type' => 'layout',
				'std'  => array(
					'layout' => '',
					'right'  => '',
					'left'   => ''
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
			'title'    => __( 'Post Options', 'anva' ),
			'page'     => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => __( 'This is the default placeholder for post options.', 'anva' ),
			'prefix'   => '_anva_', // Option Prefix
		),
		'options' => array(
			'hide_title' => array(
				'name' 		=> __( 'Post Title', 'anva' ),
				'desc'		=> __( 'Show or hide post\'s titles.', 'anva' ),
				'id'		=> 'hide_title',
				'type' 		=> 'select',
				'std'		=> 'show',
				'options'	=> array(
					'show' 	=> __( 'Show post\'s title', 'anva' ),
					'hide'	=> __( 'Hide post\'s title', 'anva' )
				)
			),
			'breadcrumbs' 	=> array(
				'name' 		=> __( 'Breadcrumbs', 'anva' ),
				'desc'		=> __( 'Select to show or hide breadcrumbs on this page.', 'anva' ),
				'id'		=> 'breadcrumbs',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> __( 'Default Setting', 'anva' ),
					'show' 	=> __( 'Show breadcrumbs', 'anva' ),
					'hide'	=> __( 'Hide breadcrumbs', 'anva' ),
				),
			),
			'post_share' 	=> array(
				'name' 		=> __( 'Share Links', 'anva' ),
				'desc'		=> __( 'Select to show or hide post share links on this page.', 'anva' ),
				'id'		=> 'post_share',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> __( 'Default Setting', 'anva' ),
					'show' 	=> __( 'Show post share links', 'anva' ),
					'hide'	=> __( 'Hide post share links', 'anva' ),
				),
			),
			'post_nav' 	=> array(
				'name' 		=> __( 'Post Navigation', 'anva' ),
				'desc'		=> __( 'Select to show or hide post navigation on this page.', 'anva' ),
				'id'		=> 'post_nav',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> __( 'Default Setting', 'anva' ),
					'show' 	=> __( 'Show post navigation', 'anva' ),
					'hide'	=> __( 'Hide post navigation', 'anva' ),
				),
			),
			'post_author' 	=> array(
				'name' 		=> __( 'Author Box', 'anva' ),
				'desc'		=> __( 'Select to show or hide post author box.', 'anva' ),
				'id'		=> 'post_author',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> __( 'Default Setting', 'anva' ),
					'show' 	=> __( 'Show post author box', 'anva' ),
					'hide'	=> __( 'Hide post author box', 'anva' ),
				),
			),
			'post_related' 	=> array(
				'name' 		=> __( 'Related Posts', 'anva' ),
				'desc'		=> __( 'Select to show or hide related posts.', 'anva' ),
				'id'		=> 'post_related',
				'type' 		=> 'select',
				'std'		=> '',
				'options'   => array(
					'' 		=> __( 'Default Setting', 'anva' ),
					'show' 	=> __( 'Show related posts', 'anva' ),
					'hide'	=> __( 'Hide related posts', 'anva' ),
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
	foreach ( range(2, 6) as $col ) {
		$columns[ $col ] = $col . ' ' . __( 'Columns', 'anva' );
	}

	$setup = array(
		'args' => array(
			'id'       => 'anva_post_format_options',
			'title'    => __( 'Post Format Options', 'anva' ),
			'page'     => array( 'post' ),
			'context'  => 'side',
			'priority' => 'high',
			'desc'     => __( 'This is the default placeholder for post format options.', 'anva' ),
			'prefix'   => '_anva_', // Option Prefix
		),
		'options' => array(
			'gallery' => array(
				'name' 		=> __( 'Post Format Gallery', 'anva' ),
				'desc'		=> __( 'Select the type you want to show in the post format gallery.', 'anva' ),
				'id'		=> 'gallery',
				'type' 		=> 'select',
				'std'		=> 'slider',
				'options'	=> array(
					'slider' 	=> __( 'Gallery Slider', 'anva' ),
					'masonry'	=> __( 'Gallery Masonry', 'anva' )
				),
				'trigger' => 'slider',
				'receivers' => 'gallery_slider',
			),
			'gallery_slider' => array(
				'name' 		=> __( 'Gallery Slider Type', 'anva' ),
				'desc'		=> __( 'Select the slider type to show the gallery images.', 'anva' ),
				'id'		=> 'gallery_slider',
				'type' 		=> 'select',
				'std'		=> 'standard',
				'options'	=> array(
					'standard' => __( 'Standard Slider', 'anva' ),
					'nivo'     => __( 'Nivo Slider', 'anva' )
				),
			),
			'gallery_highlight' => array(
				'name' 		=> __( 'Gallery Masonry Highlight', 'anva' ),
				'desc'		=> __( 'Enter the gallery image to want to highlight.', 'anva' ),
				'id'		=> 'gallery_highlight',
				'type' 		=> 'number',
				'std'		=> '',
			),
			'gallery_columns' => array(
				'name' 		=> __( 'Gallery Masonry Columns', 'anva' ),
				'desc'		=> __( 'Select the gallery masonry columns.', 'anva' ),
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
			'title' 		=> __( 'Page Options', 'anva' ),
			'page'			=> array( 'page' ),
			'context' 		=> 'normal',
			'priority'		=> 'high',
			'desc'			=> __( 'This is the default placeholder for page options.', 'anva' ),
			'prefix'		=> '_anva_',
		),
		'options' => array(
            'hide_title'    => array(
                'name'      => __( 'Page Title', 'anva' ),
                'desc'      => __( 'Select to show or hide page\'s titles on this page. This option will be ignore in "Builder" template.', 'anva' ),
                'id'        => 'hide_title',
                'type'      => 'select',
                'std'       => 'show',
                'options'   => array(
                    'show'  => __( 'Show page\'s title', 'anva' ),
                    'hide'  => __( 'Hide page\'s title', 'anva' ),
                )
            ),
            'page_tagline'  => array(
                'name'      => __( 'Page Tagline', 'anva' ),
                'desc'      => __( 'Enter s ahort page tagline for this page.', 'anva' ),
                'id'        => 'page_tagline',
                'type'      => 'text',
                'std'       => '',
            ),
            'title_align'   => array(
                'name'      => __( 'Title Align', 'anva' ),
                'desc'      => __( 'Select the page title align.', 'anva' ),
                'id'        => 'title_align',
                'type'      => 'select',
                'std'       => '',
                'options'   => array(
                    ''      => __( 'Left', 'anva' ),
                    'right' => __( 'Right', 'anva' ),
                    'center'=> __( 'Center', 'anva' ),
                ),
            ),
            'title_bg'  => array(
                'name'      => __( 'Title Background', 'anva' ),
                'desc'      => __( 'Use background in page titles.', 'anva' ),
                'id'        => 'title_bg',
                'type'      => 'select',
                'std'       => 'default',
                'options'   => array(
                    'light' => __( 'Light', 'anva' ),
                    'dark'  => __( 'Dark', 'anva' ),
                    'custom'=> __( 'Custom', 'anva' ),
                    'nobg'  => __( 'No Background', 'anva' ),

                ),
                'trigger'   => 'custom',
                'receivers' => 'title_bg_color title_bg_image title_bg_cover title_bg_text title_bg_padding'
            ),
            'title_bg_color' => array(
                'name'      => __( 'Background Color', 'anva' ),
                'desc'      => __( 'Select a background color for page title.', 'anva' ),
                'id'        => 'title_bg_color',
                'type'      => 'color',
                'std'       => '#cccccc',
                'class'     => 'hidden',
            ),
            'title_bg_image' => array(
                'name'      => __( 'Background Image', 'anva' ),
                'desc'      => __( 'Select a background image for page title. Use a large image for better experience.', 'anva' ),
                'id'        => 'title_bg_image',
                'type'      => 'upload',
                'std'       => '',
                'class'     => 'hidden',
            ),
            'title_bg_cover' => array(
                'name'      => NULL,
                'desc'      => sprintf( '<strong>%s:</strong> %s', __( 'Cover', 'anva' ), __( 'Fill background with the image.', 'anva' ) ),
                'id'        => 'title_bg_cover',
                'type'      => 'checkbox',
                'std'       => '0',
                'class'     => 'hidden',
            ),
            'title_bg_text' => array(
                'name'      => NULL,
                'desc'      => sprintf( '<strong>%s:</strong> %s', __( 'Text', 'anva' ), __( 'Apply light color.', 'anva' ) ),
                'id'        => 'title_bg_text',
                'type'      => 'checkbox',
                'std'       => '0',
                'class'     => 'hidden',
            ),
            'title_bg_padding' => array(
                'name'      => __( 'Padding' , 'anva' ),
                'desc'      => __( 'Apply padding to background when using a image. Default is 120px.', 'anva' ),
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
                'name'      => __( 'Breadcrumbs', 'anva' ),
                'desc'      => __( 'Select to show or hide breadcrumbs on this page.', 'anva' ),
                'id'        => 'breadcrumbs',
                'type'      => 'select',
                'std'       => '',
                'options'   => array(
                    ''      => __( 'Default Setting', 'anva' ),
                    'show'  => __( 'Show breadcrumbs', 'anva' ),
                    'hide'  => __( 'Hide breadcrumbs', 'anva' ),
                ),
            ),
            'post_share'    => array(
                'name'      => __( 'Share Links', 'anva' ),
                'desc'      => __( 'Select to show or hide post share links on this page.', 'anva' ),
                'id'        => 'post_share',
                'type'      => 'select',
                'std'       => '',
                'options'   => array(
                    ''      => __( 'Default Setting', 'anva' ),
                    'show'  => __( 'Show post share links', 'anva' ),
                    'hide'  => __( 'Hide post share links', 'anva' ),
                ),
            ),
            'post_nav'  => array(
                'name'      => __( 'Post Navigation', 'anva' ),
                'desc'      => __( 'Select to show or hide post navigation on this page.', 'anva' ),
                'id'        => 'post_nav',
                'type'      => 'select',
                'std'       => '',
                'options'   => array(
                    ''      => __( 'Default Setting', 'anva' ),
                    'show'  => __( 'Show post navigation', 'anva' ),
                    'hide'  => __( 'Hide post navigation', 'anva' ),
                ),
            ),
            'post_author'   => array(
                'name'      => __( 'Author Box', 'anva' ),
                'desc'      => __( 'Select to show or hide post author box.', 'anva' ),
                'id'        => 'post_author',
                'type'      => 'select',
                'std'       => '',
                'options'   => array(
                    ''      => __( 'Default Setting', 'anva' ),
                    'show'  => __( 'Show post author box', 'anva' ),
                    'hide'  => __( 'Hide post author box', 'anva' ),
                ),
            ),
            'post_related'  => array(
                'name'      => __( 'Related Posts', 'anva' ),
                'desc'      => __( 'Select to show or hide related posts.', 'anva' ),
                'id'        => 'post_related',
                'type'      => 'select',
                'std'       => '',
                'options'   => array(
                    ''      => __( 'Default Setting', 'anva' ),
                    'show'  => __( 'Show related posts', 'anva' ),
                    'hide'  => __( 'Hide related posts', 'anva' ),
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

    // Fill columns array
    $columns = array();
    $columns[''] = esc_html__( 'Default Grid Columns', 'anva' );
    foreach ( anva_get_grid_columns() as $key => $value ) {
        $columns[$key] = esc_html( $value['name'] );
    }

    $setup = array(
        'args' => array(
            'id'            => 'anva_page_template_options',
            'title'         => __( 'Page Template Options', 'anva' ),
            'page'          => array( 'page' ),
            'context'       => 'side',
            'priority'      => 'high',
            'desc'          => __( 'This is the default placeholder for page options.', 'anva' ),
            'prefix'        => '_anva_',
        ),
        'options' => array(
            'grid_column'   => array(
                'name'      => __( 'Post Grid', 'anva' ),
                'desc'      => __( 'Setup the grid columns for "Posts Grid" template.', 'anva' ),
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
			'id' 		=> 'anva_gallery_options',
			'title' 	=> __( 'Gallery Options', 'anva' ),
			'page'		=> array( 'galleries' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
			'desc'		=> __( 'This is the default placeholder for gallery options.', 'anva' ),
			'prefix'	=> '_anva_',
		),
		'options' => array(
            'hide_title'        => array(
                'name'          => __( 'Gallery Title', 'anva' ),
                'desc'          => __( 'Show or hide gallery\'s titles.', 'anva' ),
                'id'            => 'hide_title',
                'type'          => 'select',
                'std'           => 'show',
                'options'       => array(
                    'show'      => __( 'Show gallery\'s title', 'anva' ),
                    'hide'      => __( 'Hide gallery\'s title', 'anva' )
                )
            ),
            'page_tagline'      => array(
                'name'          => __( 'Gallery Tagline', 'anva' ),
                'desc'          => __( 'Enter s ahort gallery tagline.', 'anva' ),
                'id'            => 'page_tagline',
                'type'          => 'text',
                'std'           => '',
            ),
            'gallery_highlight' => array(
                'id'            => 'gallery_highlight',
                'name'          => __( 'Highlight Image', 'anva' ),
                'desc'          => __( 'Enter the number of image than want to highlight.', 'anva' ),
                'type'          => 'number',
                'std'           => ''
            ),
            'gallery_template'  => array(
                'id'            => 'gallery_template',
                'name'          => __( 'Gallery Columns', 'anva' ),
                'desc'          => __( 'Select gallery template for this gallery.', 'anva' ),
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
			'id'       => 'anva_portfolio_options',
			'title'    => __( 'Portfolio Options', 'anva' ),
			'page'     => array( 'portfolio' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => __( 'This is the default placeholder for portfolio options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => array(
            'hide_title' => array(
                'id'        => 'hide_title',
                'name'      => __( 'Portfolio Title', 'anva' ),
                'desc'      => __( 'Show or hide portfolio\'s item titles.', 'anva' ),
                'type'      => 'select',
                'std'       => 'show',
                'options'   => array(
                    'show'  => __( 'Show portfolio\'s item title', 'anva' ),
                    'hide'  => __( 'Hide portfolio\'s item title', 'anva' )
                ),
            ),
            'author' => array(
                'id'        => 'author',
                'name'      => __( 'Author', 'anva' ),
                'desc'      => __( 'Enter the porfolio item author.', 'anva' ),
                'type'      => 'text',
                'std'       => ''
            ),
            'client' => array(
                'id'        => 'client',
                'name'      => __( 'Client', 'anva' ),
                'desc'      => __( 'Enter the porfolio client.', 'anva' ),
                'type'      => 'text',
                'std'       => ''
            ),
            'client_url' => array(
                'id'        => 'client_url',
                'name'      => __( 'Client URL', 'anva' ),
                'desc'      => __( 'Enter the client URL.', 'anva' ),
                'type'      => 'text',
                'std'       => 'http://'
            ),
            'date' => array(
                'id'        => 'date',
                'name'      => __( 'Date', 'anva' ),
                'desc'      => __( 'Select the date on which the project was completed.', 'anva' ),
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
			'id'       => 'anva_portfolio_media',
			'title'    => __( 'Portfolio Media', 'anva' ),
			'page'     => array( 'portfolio' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => 'Portfolio Media',
			'prefix'   => '_anva_',
		),
		'options' => array(
            'audio'             => array(
                'id'            => 'audio',
                'name'          => NULL,
                'desc'          => sprintf( '<strong>%s:</strong> %s', __( 'Audio', 'anva' ), __( 'Show audio content in portfolio.', 'anva' ) ),
                'type'          => 'checkbox',
                'std'           => '0',
                'trigger'       => 1,
                'receivers'     => 'audio_image audio_mp3 audio_ogg'
            ),
            'audio_image'       => array(
                'id'            => 'audio_image',
                'name'          => __( 'Audio Featured Image', 'anva' ),
                'desc'          => __( 'Add a poster image to your audio player (optional).', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'audio_mp3'         => array(
                'id'            => 'audio_mp3',
                'name'          => __( 'Audio MP3', 'anva' ),
                'desc'          => __( 'Insert an .mp3 file, if desired.', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'audio_ogg'         => array(
                'id'            => 'audio_ogg',
                'name'          => __( 'Audio OGG', 'anva' ),
                'desc'          => __( 'Insert an .ogg file, if desired.', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'video'             => array(
                'id'            => 'video',
                'name'          => NULL,
                'desc'          => sprintf( '<strong>%s:</strong> %s', __( 'Video', 'anva' ), __( 'Show video content in portfolio.', 'anva' ) ),
                'type'          => 'checkbox',
                'std'           => '0',
                'trigger'       => 1,
                'receivers'     => 'video_image video_m4v video_ogv video_mp4 video_embed'
            ),
            'video_image'       => array(
                'id'            => 'video_image',
                'name'          => __( 'Video Featured Image', 'anva' ),
                'desc'          => __( 'Add a poster image for your video player (optional).', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'video_m4v'         => array(
                'id'            => 'video_m4v',
                'name'          => __( 'Video M4V', 'anva' ),
                'desc'          => __( 'Insert an .m4v file, if desired..', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'video_ogv'         => array(
                'id'            => 'video_ogv',
                'name'          => __( 'Video OGV', 'anva' ),
                'desc'          => __( 'Insert an .ogv file, if desired.', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'video_mp4'         => array(
                'id'            => 'video_mp4',
                'name'          => __( 'Video MP4', 'anva' ),
                'desc'          => __( 'Insert an .mp4 file, if desired.', 'anva' ),
                'type'          => 'upload',
                'std'           => ''
            ),
            'video_embed'       => array(
                'id'            => 'video_embed',
                'name'          => __( 'Video Embed', 'anva' ),
                'desc'          => __( 'Embed iframe code from YouTube, Vimeo or other trusted source. HTML tags are limited to iframe, div, img, a, em, strong and br. Note: This field overrides the previous fields.', 'anva' ),
                'type'          => 'textarea',
                'std'           => ''
            ),
            'gallery'           => array(
                'id'            => 'gallery',
                'name'          => NULL,
                'desc'          => sprintf( '<strong>%s:</strong> %s', __( 'Gallery', 'anva' ), __( 'Show gallery content in portfolio.', 'anva' ) ),
                'type'          => 'checkbox',
                'std'           => '0',
            ),
        )
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
            'id'            => 'anva_slider_options',
            'title'         => __( 'Slide Options', 'anva' ),
            'page'          => array( 'slideshows' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ),
        'options' => $slider_fields
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
			'id' 		=> '_anva_gallery_media',
			'title' 	=> __( 'Gallery', 'anva' ),
			'page'		=> array( 'galleries', 'portfolio' ), // Use gallery in portfolio?
			'context' 	=> 'normal',
			'priority'	=> 'default'
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
			'id' 		=> '_anva_builder_options',
			'title' 	=> __( 'Content Builder', 'anva' ),
			'page'		=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
		),
		'options'		=> anva_get_elements() // Get content builder elements
	);

	return apply_filters( 'anva_content_buider_meta', $setup );
}
