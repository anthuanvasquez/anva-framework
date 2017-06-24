<?php
/**
 * General and misc functions.
 *
 * @package    AnvaFramework
 * @subpackage Admin
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Make theme available for translations.
 *
 * @since 1.0.0
 * @return void
 */
function anva_load_theme_texdomain() {
	load_theme_textdomain( 'anva', get_template_directory() . '/languages' );
}

/**
 * Add default theme support features.
 *
 * @global $wp_version
 *
 * @since  1.0.0
 * @return void
 */
function anva_add_theme_support() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'caption' ) );
	add_theme_support( 'post-formats', array( 'gallery', 'aside', 'link', 'image', 'quote', 'video', 'audio', 'chat', 'status' ) );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
}

/**
 * Add custom theme support features
 *
 * @since  1.0.0
 * @return void
 */
function anva_require_theme_supports() {
	require_if_theme_supports( 'anva-instant-search', Anva::$framework_dir_path . 'component/features/instant-search.php' );
	require_if_theme_supports( 'anva-woocommerce', Anva::$framework_dir_path . 'component/features/woocommerce.php' );
}

/**
 * Register menus.
 *
 * @since  1.0.0
 * @return void
 */
function anva_register_menus() {
	register_nav_menus( array(
		'primary'      => anva_get_local( 'menu_primary' ),
		'top_bar'      => anva_get_local( 'menu_top_bar' ),
		'side_panel'   => anva_get_local( 'menu_side_panel' ),
		'split_menu_1' => anva_get_local( 'menu_split_1' ),
		'split_menu_2' => anva_get_local( 'menu_split_2' ),
		'footer'       => anva_get_local( 'menu_footer' ),
	) );
}

/**
 * Add CSS classes to main menu list items.
 *
 * @since  1.0.0
 * @param  array  $classes
 * @param  object $item
 * @param  array  $args
 * @param  int    $depth
 * @return array  $classes
 */
function anva_nav_menu_css_class( $classes, $item, $args = array(), $depth = 0 ) {

	// Add level to menu
	$classes[] = sprintf( 'level-%s', $depth + 1 );

	// Change current menu item class
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'current';
	}

	return $classes;
}

/**
 * Get theme data.
 *
 * @since  1.0.0
 * @param  string $id Theme data ID.
 * @return string $text The given theme data ID.
 */
function anva_get_theme( $id ) {

	$text  = null;
	$theme = wp_get_theme();

	$data = apply_filters( 'anva_theme_data', array(
		'name'       => $theme->get( 'Name' ),
		'uri'        => $theme->get( 'ThemeURI' ),
		'desc'       => $theme->get( 'Description' ),
		'version'    => $theme->get( 'Version' ),
		'domain'     => $theme->get( 'TextDomain' ),
		'author'     => $theme->get( 'Author' ),
		'author_uri' => $theme->get( 'AuthorURI' ),
	) );

	if ( isset( $data[ $id ] ) ) {
		$text = $data[ $id ];
	}

	return $text;
}

/**
 * Get theme id.
 *
 * @since  1.0.0
 * @return string $id Theme ID name.
 */
function anva_get_theme_id() {

	$id = anva_get_theme( 'name' );
	$id = preg_replace( '/\W/', '_', strtolower( $id ) );

	return $id;
}

/**
 * Set allowed tags.
 *
 * @global $allowedposttags
 *
 * @since  1.0.0
 * @return array $tags
 */
function anva_get_allowed_tags() {

	global $allowedposttags;

	$tags = $allowedposttags;

	// iFrame tag.
	$tags['iframe'] = array(
		'style' 				=> true,
		'width' 				=> true,
		'height' 				=> true,
		'src' 					=> true,
		'frameborder'			=> true,
		'allowfullscreen' 		=> true,
		'webkitAllowFullScreen'	=> true,
		'mozallowfullscreen' 	=> true,
	);

	// Script tag.
	$tags['script'] = array(
		'type'					=> true,
		'src' 					=> true,
	);

	return apply_filters( 'anva_allowed_tags', $tags );
}

/**
 * Print with wp_kses().
 *
 * @since  1.0.0
 * @param  string $input
 * @return string $input
 */
function anva_kses( $input ) {
	echo anva_get_kses( $input );
}

/**
 * Apply wp_kses() to content allowed tags.
 *
 * @since  1.0.0
 * @param  string $input
 * @return string $input
 */
function anva_get_kses( $input ) {
	return wp_kses( $input, anva_get_allowed_tags() );
}

/**
 * Take in some content and display it with formatting.
 *
 * @since  1.0.0
 * @param  string $content Content to display.
 * @return string Formatted content.
 */
function anva_content( $content ) {
	echo anva_get_content( $content );
}

/**
 * Take in some content and return it with formatting.
 *
 * @since  1.0.0
 * @param  string $content Content to display.
 * @return string Formatted content.
 */
function anva_get_content( $content ) {
	return apply_filters( 'anva_the_content', $content );
}

/**
 * Use themeblvd_button() function for read more links.
 *
 * When a WP user uses the more tag <!--more-->, this filter
 * will add the class "btn" to that link. This will allow
 * Bootstrap to style the link as one of its buttons.
 *
 * @see filter "the_content_more_link"
 *
 * @since 1.0.0
 */
function anva_read_more_link( $read_more, $more_link_text ) {

	$args = apply_filters( 'anva_the_content_more_args', array(
		'text'        => $more_link_text,
		'url'         => get_permalink() . '#more-' . get_the_ID(),
		'target'      => null,
		'color'       => '',
		'size'        => null,
		'style'       => null,
		'effect'      => null,
		'transition'  => null,
		'classes'     => 'more-link',
		'title'       => null,
		'icon_before' => null,
		'icon_after'  => null,
		'addon'       => null,
		'base'        => false,
	) );

	// Construct button based on filterable $args above.
	$button = anva_get_button( $args );

	return apply_filters( 'anva_read_more_link', $button );
}

/**
 * Grid columns
 *
 * @since  1.0.0
 * @return array  $columns
 */
function anva_get_grid_columns() {
	$columns = array(
		'1' => array(
			'name'   => '1 Column',
			'class'  => 'col-md-12',
			'column' => 1,
		),
		'2' => array(
			'name'   => '2 Columns',
			'class'  => 'col-md-6',
			'column' => 2,
		),
		'3' => array(
			'name'   => '3 Columns',
			'class'  => 'col-md-4',
			'column' => 3,
		),
		'4' => array(
			'name'   => '4 Columns',
			'class'  => 'col-md-3',
			'column' => 4,
		),
		'5' => array(
			'name'   => '5 Columns',
			'class'  => 'col-5', // Extend Boostrap Columns
			'column' => 5,
		),
		'6' => array(
			'name'   => '6 Columns',
			'class'  => 'col-md-2', // Extend Boostrap Columns
			'column' => 6,
		),
	);
	return apply_filters( 'anva_grid_columns', $columns );
}

/**
 * Sidebar layouts.
 *
 * @since  1.0.0
 * @return array $layouts
 */
function anva_get_sidebar_layouts() {
	$layouts = array(
		'fullwidth' 		=> array(
			'name' 			=> 'Full Width',
			'id'			=> 'fullwidth',
			'columns'		=> array(
				'content' 	=> 'col_full nobottommargin clearfix',
				'left' 		=> '',
				'right' 	=> '',
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/fullwidth.png',
		),
		'right' 			=> array(
			'name' 			=> 'Sidebar Right',
			'id'			=> 'sidebar_right',
			'columns'		=> array(
				'content' 	=> 'postcontent nobottommargin clearfix',
				'left' 		=> '',
				'right' 	=> 'sidebar nobottommargin col_last clearfix',
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/right.png',
		),
		'left' 				=> array(
			'name' 			=> 'Sidebar Left',
			'id'			=> 'sidebar_left',
			'columns'		=> array(
				'content' 	=> 'postcontent nobottommargin col_last clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> '',
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/left.png',
		),
		'double' 			=> array(
			'name' 			=> 'Double Sidebars',
			'id'			=> 'double',
			'columns'		=> array(
				'content' 	=> 'postcontent bothsidebar nobottommargin clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> 'sidebar nobottommargin col_last clearfix',
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/double.png',
		),
		'double_right'		=> array(
			'name' 			=> 'Double Right Sidebars',
			'id'			=> 'double_right',
			'columns'		=> array(
				'content' 	=> 'postcontent bothsidebar nobottommargin clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> 'sidebar nobottommargin col_last clearfix',
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/double_right.png',
		),
		'double_left' 		=> array(
			'name' 			=> 'Double Left Sidebars',
			'id'			=> 'double_left',
			'columns'		=> array(
				'content' 	=> 'postcontent bothsidebar nobottommargin col_last clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> 'sidebar nobottommargin clearfix',
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/double_left.png',
		),
	);
	return apply_filters( 'anva_sidebar_layouts', $layouts );
}

/**
 * Layout column classes.
 *
 * @since  1.0.0
 * @param  string $column
 */
function anva_column_class( $column ) {
	echo anva_get_column_class( $column );
}

/**
 * Get layout column classes.
 *
 * @since  1.0.0
 * @param  string $column
 * @return string $column_class
 */
function anva_get_column_class( $column ) {

	$layout         = '';
	$column_class   = '';
	$sidebar_layout = anva_get_sidebar_layouts();
	$current_layout = anva_get_post_meta( '_anva_sidebar_layout' );

	// Get sidebar location
	if ( isset( $current_layout['layout'] ) ) {
		$layout = $current_layout['layout'];
	}

	// Set default sidebar layout
	if ( empty( $layout ) ) {
		$layout = anva_get_option( 'sidebar_layout', 'right' );
	}

	// Validate if field exists
	if ( isset( $sidebar_layout[ $layout ]['columns'][ $column ] ) ) {
		$column_class = $sidebar_layout[ $layout ]['columns'][ $column ];
	}

	return apply_filters( 'anva_column_class', $column_class );
}

/**
 * Get header types.
 *
 * @since  1.0.0
 * @return array $header_types
 */
function anva_get_header_types() {
	$header_types = array(
		'default' 			=> array(
			'name' 			=> __( 'Default Type', 'anva' ),
			'id' 			=> 'default',
			'classes' 		=> array(
				'header'	=> '',
				'body'		=> '',
			),
			'type' 			=> 'sticky',
		),
		'transparent' 		=> array(
			'name'  		=> __( 'Transparent', 'anva' ),
			'id' 			=> 'transparent',
			'classes' 		=> array(
				'header'	=> 'transparent-header',
				'body'		=> '',
			),
			'type' 			=> 'sticky',
		),
		'semi_transparent' 	=> array(
			'name' 			=> __( 'Semi Transparent', 'anva' ),
			'id' 			=> 'semi_transparent',
			'classes' 		=> array(
				'header'	=> 'transparent-header semi-transparent',
				'body'		=> '',
			),
			'type' 			=> 'sticky',
		),
		'floating' 			=> array(
			'name' 			=> __( 'Floating', 'anva' ),
			'id' 			=> 'floating',
			'classes' 		=> array(
				'header'	=> 'floating-header transparent-header',
				'body'		=> '',
			),
			'type' 			=> 'sticky',
		),
		'floating_semi' 	=> array(
			'name' 			=> __( 'Floating Semi Transparent', 'anva' ),
			'id' 			=> 'floating_semi',
			'classes' 		=> array(
				'header'	=> 'floating-header transparent-header semi-transparent',
				'body'		=> '',
			),
			'type' 			=> 'sticky',
		),
		'static_sticky' 	=> array(
			'name' 			=> __( 'Static Sticky', 'anva' ),
			'id' 			=> 'static_sticky',
			'classes' 		=> array(
				'header'	=> 'static-sticky',
				'body'		=> '',
			),
			'type' 			=> 'sticky',
		),
		'responsive_sticky' => array(
			'name' 			=> __( 'Responsive Sticky', 'anva' ),
			'id' 			=> 'responsive_sticky',
			'classes' 		=> array(
				'header'	=> '',
				'body'		=> 'responsive-sticky-menu',
			),
			'type' 			=> 'sticky',
		),
		'no_sticky' => array(
			'name' 			=> __( 'No Sticky', 'anva' ),
			'id' 			=> 'no_sticky',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> '',
			),
			'type' 			=> 'static',
		),
		'left_side_fixed' 	=> array(
			'name' 			=> __( 'Left Side Fixed', 'anva' ),
			'id' 			=> 'left_side_fixed',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header',
			),
			'type' 			=> 'side',
		),
		'left_side_open' 	=> array(
			'name' 			=> __( 'Left Side Open', 'anva' ),
			'id' 			=> 'left_side_open',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header open-header close-header-on-scroll',
			),
			'type' 			=> 'side',
		),
		'left_side_push' 	=> array(
			'name' 			=> __( 'Left Side Push Content', 'anva' ),
			'id' 			=> 'left_side_push',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header open-header push-wrapper close-header-on-scroll',
			),
			'type' 			=> 'side',
		),
		'right_side_fixed' 	=> array(
			'name' 			=> __( 'Right Side Fixed', 'anva' ),
			'id' 			=> 'right_side_fixed',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header side-header-right',
			),
			'type' 			=> 'side',
		),
		'right_side_open' 	=> array(
			'name' 			=> __( 'Right Side Open', 'anva' ),
			'id' 			=> 'right_side_open',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header side-header-right open-header close-header-on-scroll',
			),
			'type' 			=> 'side',
		),
		'right_side_push' 	=> array(
			'name' 			=> __( 'Right Side Push Content', 'anva' ),
			'id' 			=> 'right_side_push',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header side-header-right open-header push-wrapper close-header-on-scroll',
			),
			'type' 			=> 'side',
		),
	);

	return apply_filters( 'anva_header_types', $header_types );
}

/**
 * Get side panel types.
 *
 * @return array $side_panels
 */
function anva_get_side_panel_types() {
	$side_panels = array(
		'left_overlay' => array(
			'name' => __( 'Left Overlay', 'anva' ),
			'class' => 'side-panel-left',
		),
		'left_push' => array(
			'name' => __( 'Left Pushed', 'anva' ),
			'class' => 'side-panel-left side-push-panel',
		),
		'right_overlay' => array(
			'name' => __( 'Right Overlay', 'anva' ),
			'class' => '',
		),
		'right_push' => array(
			'name' => __( 'Right Pushed', 'anva' ),
			'class' => 'side-push-panel',
		),
	);

	return apply_filters( 'anva_side_panel_types', $side_panels );
}

/**
 * Get primary menu styles.
 *
 * @since  1.0.0
 * @return array $menu_styles
 */
function anva_get_primary_menu_styles() {
	$menu_styles = array(
		'default' => array(
			'name' => __( 'Default Menu Style', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => '',
			),
		),
		'style_2' => array(
			'name' => __( 'Menu aligns beside the logo', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => 'style-2',
			),
		),
		'style_3' => array(
			'name' => __( 'Menu items with background color', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => 'style-3',
			),
		),
		'style_4' => array(
			'name' => __( 'Menu items with border color', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => 'style-4',
			),
		),
		'style_5' => array(
			'name' => __( 'Menu items with large icons on top', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => 'style-5',
			),
		),
		'style_6' => array(
			'name' => __( 'Menu items with a top animating border', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => 'style-6',
			),
		),
		'style_7' => array(
			'name' => __( 'Menu aligns below the logo', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => 'sticky-style-2',
				'menu' => 'style-2',
			),
		),
		'style_9' => array(
			'name' => __( 'Menu aligns below the logo centered', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => 'sticky-style-2',
				'menu' => 'style-2',
			),
		),
		'style_10' => array(
			'name' => __( 'Menu overlay', 'anva' ),
			'classes' => array(
				'body' => 'overlay-menu',
				'header' => '',
				'menu' => '',
			),
		),
		'sub_title' => array(
			'name' => __( 'Menu items with sub titles', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => '',
				'menu' => 'sub-title',
			),
		),
		'split_menu' => array(
			'name' => __( 'Split Menu', 'anva' ),
			'classes' => array(
				'body' => '',
				'header' => 'split-menu',
				'menu' => 'with-arrows',
			),
		),
	);

	return apply_filters( 'anva_primary_menu_styles', $menu_styles );
}

/**
 * Get social media share buttons.
 *
 * @since  1.0.0
 * @return array $buttons All social media buttons.
 */
function anva_get_share_buttons() {

	$buttons = array(
		'facebook' => array(
			'text'          => __( 'Share on Facebook', 'anva' ),
			'url'		    => 'https://www.facebook.com/sharer.php?u=[permalink]&amp;t=[title]',
			'network'       => 'facebook',
			'icon'			=> 'facebook',
			'target'        => '_blank',
			'encode'		=> true,
			'encode_urls' 	=> false,
		),
		'twitter' => array(
			'text'          => __( 'Share on Twitter', 'anva' ),
			'url'		    => 'https://twitter.com/intent/tweet?text=[title]&amp;url=[shortlink]&amp;via=[via]&amp;hashtags[hashtags]',
			'network'       => 'twitter',
			'icon'			=> 'twitter',
			'target'        => '_blank',
			'encode'		=> true,
			'encode_urls' 	=> false,
		),
		'google' => array(
			'text'          => __( 'Share on Google+', 'anva' ),
			'url'		    => 'https://plus.google.com/share?url=[permalink]&amp;description=[title]&amp;media=[thumbnail]',
			'network'       => 'googleplus',
			'icon'			=> 'gplus',
			'target'        => '_blank',
			'encode'		=> true,
			'encode_urls' 	=> false,
		),
		'pinterest' => array(
			'text'          => __( 'Share on Pinterest', 'anva' ),
			'url'		    => 'https://pinterest.com/pin/create/button/?url=[permalink]&amp;description=[title]&amp;media=[thumbnail]',
			'network'       => 'pinterest',
			'icon'			=> 'pinterest',
			'target'        => '_blank',
			'encode'		=> true,
			'encode_urls' 	=> true,
		),
		'email' => array(
			'text'          => __( 'Share via Email', 'anva' ),
			'url'		    => 'mailto:?subject=[title]&amp;body=[permalink]',
			'network'       => 'email',
			'icon'			=> 'email3',
			'target'        => '_blank',
			'encode'		=> true,
			'encode_urls' 	=> false,
		),
		'rss' => array(
			'text'          => __( 'Feed RSS', 'anva' ),
			'url'		    => get_feed_link( 'rss2' ),
			'network'       => 'rss',
			'icon'			=> 'rss',
			'target'        => '_blank',
			'encode'		=> true,
			'encode_urls' 	=> false,
		),
	);

	return apply_filters( 'anva_share_buttons', $buttons );
}

/**
 * Setup array classes for content.
 *
 * @since  1.0.0
 * @return array $config
 */
function anva_config() {

	$config = array(
		'featured' => array(),
		'comments' => array(),
	);

	/*
	------------------------------------------------------*/
	/*
	 Areas
	/*------------------------------------------------------*/

	if ( is_front_page() ) {
		if ( anva_get_area( 'featured', 'front' ) ) {
			$config['featured'][] = 'has-front-featured';
		}
	}

	if ( is_home() || is_page_template( 'template-list.php' ) ) {
		if ( anva_get_area( 'featured', 'blog' ) ) {
			$config['featured'][] = 'has-blog-featured';
		}
	}

	if ( is_page_template( 'template-grid.php' ) ) {
		if ( anva_get_area( 'featured', 'grid' ) ) {
			$config['featured'][] = 'has-grid-featured';
		}
	}

	if ( is_archive() || is_search() ) {
		if ( anva_get_area( 'featured', 'archive' ) ) {
			$config['featured'][] = 'has-archive-featured';
		}
	}

	if ( is_page() && ! is_page_template( 'template-builder.php' ) ) {
		if ( anva_get_area( 'featured', 'page' ) ) {
			$config['featured'][] = 'has-page-featured';
		}

		if ( anva_get_area( 'comments', 'page' ) ) {
			$config['comments'][] = 'has-page-comments';
		}
	}

	if ( is_single() ) {
		if ( anva_get_area( 'featured', 'single' ) ) {
			$config['featured'][] = 'has-single_featured';
		}

		if ( anva_get_area( 'comments', 'single' ) ) {
			$config['comments'][] = 'has-single-comments';
		}
	}

	if ( is_singular( 'portfolio' ) ) {
		if ( anva_get_area( 'featured', 'portfolio' ) ) {
			$config['featured'][] = 'has-portfolio-featured';
		}

		if ( anva_get_area( 'comments', 'portfolio' ) ) {
			$config['comments'][] = 'has-portfolio-comments';
		}
	}

	if ( is_singular( 'galleries' ) ) {
		if ( anva_get_area( 'featured', 'galleries' ) ) {
			$config['featured'][] = 'has-galleries-featured';
		}

		if ( anva_get_area( 'comments', 'galleries' ) ) {
			$config['comments'][] = 'has-galleries-comments';
		}
	}

	return $config;
}
/**
 * Get content fron the main config array.
 *
 * @since  1.0.0
 * @param  string $key
 * @return array|string|NULL
 */
function anva_get_config( $key = '' ) {

	$config = anva_config();

	if ( ! $key ) {
		return $config;
	}

	if ( isset( $config[ $key ] ) ) {
		return $config[ $key ];
	}

	return null;
}

/**
 * Set default slider areas.
 *
 * @return array $areas
 */
function anva_get_default_slider_areas() {
	$areas = array(
		'front'     => __( 'Front Page', 'anva' ),
		'archive'   => __( 'Archive Page', 'anva' ),
		'blog'      => __( 'Blog or Home Page', 'anva' ),
		'grid'      => __( 'Post Grid', 'anva' ),
		'page'      => __( 'Pages', 'anva' ),
		'single'    => __( 'Single Posts', 'anva' ),
		'portfolio' => __( 'Portfolio Pages', 'anva' ),
		'galleries' => __( 'Galleries Pages', 'anva' ),
	);

	return apply_filters( 'anva_default_slider_areas', $areas );
}

/**
 * Set default comment areas.
 *
 * @return array $areas
 */
function anva_get_default_comment_areas() {
	$areas = array(
		'page'        => __( 'Pages', 'anva' ),
		'single'      => __( 'Single Posts', 'anva' ),
		'attachments' => __( 'Attachments', 'anva' ),
		'portfolio'   => __( 'Portfolio Items', 'anva' ),
		'galleries'   => __( 'Gallery Items', 'anva' ),
	);

	return apply_filters( 'anva_default_comment_areas', $areas );
}

/**
 * Setup page areas for display content.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_areas() {

	// Check areas from DB
	$slider_area  = anva_get_option( 'slider_area' );
	$comment_area = anva_get_option( 'comments' );

	// Defaults slider areas
	$slider_defaults = apply_filters( 'anva_slider_areas_defaults', array(
		'front'     => true,
		'archive'   => false,
		'blog'      => false,
		'grid'      => false,
		'page'      => false,
		'single'    => false,
		'portfolio' => true,
		'galleries' => true,
	) );

	// Defaults comment areas
	$comment_defaults = apply_filters( 'anva_comment_areas_defaults', array(
		'page'       	=> false,
		'single'       	=> true,
		'attachments' 	=> false,
		'portfolio' 	=> false,
		'galleries' 	=> false,
	) );

	$slider_args  = wp_parse_args( $slider_area, $slider_defaults );
	$comment_args = wp_parse_args( $comment_area, $comment_defaults );

	// Setup array
	$setup = array(
		'featured' => $slider_args,
		'comments' => $comment_args,
	);

	return apply_filters( 'anva_setup_areas', $setup );
}

/**
 * Get the page area is supported.
 *
 * @since  1.0.0
 * @return boolan $support
 */
function anva_get_area( $group, $area ) {

	$setup   = anva_setup_areas();
	$support = false;

	if ( ! empty( $setup ) && ! empty( $setup[ $group ][ $area ] ) ) {
		$support = true;
	}

	return $support;
}

/**
 * Run warning if function is deprecated and WP_DEBUG is on.
 *
 * @since  1.0.0
 * @param  string $function
 * @param  string $version
 * @param  string $replacement
 * @param  string $message
 * @return string trigger_error()
 */
function anva_deprecated_function( $function, $version, $replacement = null, $message = null ) {
	if ( WP_DEBUG && apply_filters( 'deprecated_function_trigger_error', true ) ) {
		if ( ! is_null( $message ) ) {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework! %3$s', 'anva' ), $function, $version, $message ) );
		} elseif ( ! is_null( $replacement ) ) {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework! Use %3$s instead.', 'anva' ), $function, $version, $replacement ) );
		} else {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework with no alternative available.', 'anva' ), $function, $version ) );
		}
	}
}

/**
 * Generates default column widths for column element.
 *
 * @since  1.0.0
 * @return array $widths
 */
function anva_column_widths() {
	$widths = array(
		'1-col' => array(
			array(
				'name' 	=> '100%',
				'value' => 'col_full',
			),
		),
		'2-col' => array(
			array(
				'name' 	=> '20% | 80%',
				'value' => 'col_one_sixth,col_five_sixth',
			),
			array(
				'name' 	=> '25% | 75%',
				'value' => 'col_one_fifth,col_four_fifth',
			),
			array(
				'name' 	=> '30% | 70%',
				'value' => 'col_one_fourth,col_three_fourth',
			),
			array(
				'name' 	=> '33% | 66%',
				'value' => 'col_one_third,col_two_third',
			),
			array(
				'name' 	=> '50% | 50%',
				'value' => 'col_half,col_half',
			),
			array(
				'name' 	=> '66% | 33%',
				'value' => 'col_two_third,col_one_third',
			),
			array(
				'name' 	=> '70% | 30%',
				'value' => 'col_three_fourth,col_one_fourth',
			),
			array(
				'name' 	=> '75% | 25%',
				'value' => 'col_four_fifth,col_one_fifth',
			),
			array(
				'name' 	=> '80% | 20%',
				'value' => 'col_five_sixth,col_one_sixth',
			),
		),
		'3-col' => array(
			array(
				'name' 	=> '33% | 33% | 33%',
				'value' => 'col_one_third,col_one_third,col_one_third',
			),
			array(
				'name' 	=> '25% | 25% | 50%',
				'value' => 'col_one_fourth,col_one_fourth,col_half',
			),
			array(
				'name' 	=> '25% | 50% | 25%',
				'value' => 'col_one_fourth,col_half,col_one_fourth',
			),
			array(
				'name' 	=> '50% | 25% | 25% ',
				'value' => 'col_half,col_one_fourth,col_one_fourth',
			),
			array(
				'name' 	=> '20% | 20% | 60%',
				'value' => 'col_one_fifth,col_one_fifth,col_three_fifth',
			),
			array(
				'name' 	=> '20% | 60% | 20%',
				'value' => 'col_one_fifth,col_three_fifth,col_one_fifth',
			),
			array(
				'name' 	=> '60% | 20% | 20%',
				'value' => 'col_three_fifth,col_one_fifth,col_one_fifth',
			),
			array(
				'name' 	=> '40% | 40% | 20%',
				'value' => 'col_two_fifth,col_two_fifth,col_one_fifth',
			),
			array(
				'name' 	=> '40% | 20% | 40%',
				'value' => 'col_two_fifth,col_one_fifth,col_two_fifth',
			),
			array(
				'name' 	=> '20% | 40% | 40%',
				'value' => 'col_one_fifth,col_two_fifth,col_two_fifth',
			),
			array(
				'name' 	=> '30% | 30% | 40%',
				'value' => 'col_tenth_three,col_tenth_three,col_tenth_fourth',
			),
			array(
				'name' 	=> '30% | 40% | 30%',
				'value' => 'col_tenth_three,col_tenth_fourth,col_tenth_three',
			),
			array(
				'name' 	=> '40% | 30% | 30%',
				'value' => 'col_tenth_fourth,col_tenth_three,col_tenth_three',
			),
		),
		'4-col' => array(
			array(
				'name' 	=> '25% | 25% | 25% | 25%',
				'value' => 'col_one_fourth,col_one_fourth,col_one_fourth,col_one_fourth',
			),
			array(
				'name' 	=> '20% | 20% | 20% | 40%',
				'value' => 'col_one_fifth,col_one_fifth,col_one_fifth,col_two_fifth',
			),
			array(
				'name' 	=> '20% | 20% | 40% | 20%',
				'value' => 'col_one_fifth,col_one_fifth,col_two_fifth,col_one_fifth',
			),
			array(
				'name' 	=> '20% | 40% | 20% | 20%',
				'value' => 'col_one_fifth,col_two_fifth,col_one_fifth,col_one_fifth',
			),
			array(
				'name' 	=> '40% | 20% | 20% | 20%',
				'value' => 'col_two_fifth,col_one_fifth,col_one_fifth,col_one_fifth',
			),
		),
		'5-col' => array(
			array(
				'name' 	=> '20% | 20% | 20% | 20% | 20%',
				'value' => 'col_one_fifth,col_one_fifth,col_one_fifth,col_one_fifth,col_one_fifth',
			),
		),
	);
	return apply_filters( 'anva_column_widths', $widths );
}

/**
 * Get footer widget columns.
 *
 * @since  1.0.0
 * @return array  $columns
 */
function anva_get_footer_widget_columns() {
	$columns = array(
		'footer_1' => array(
			'id'   => 'footer_1',
			'name' => __( 'Footer 1', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 1' ),
			'col'  => 1,
		),
		'footer_2' => array(
			'id'   => 'footer_2',
			'name' => __( 'Footer 2', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 2' ),
			'col'  => 2,
		),
		'footer_3' => array(
			'id'   => 'footer_3',
			'name' => __( 'Footer 3', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 3' ),
			'col'  => 3,
		),
		'footer_4' => array(
			'id'   => 'footer_4',
			'name' => __( 'Footer 4', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 4' ),
			'col'  => 4,
		),
		'footer_5' => array(
			'id'   => 'footer_5',
			'name' => __( 'Footer 5', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 5' ),
			'col'  => 5,
		),
	);
	return apply_filters( 'anva_get_footer_widget_columns', $columns );
}

/**
 * Register footer sidebars based on number of columns.
 *
 * @since  1.0.0
 * @return void
 */
function anva_register_footer_sidebar_locations() {

	$footer = anva_get_option( 'footer_setup' );

	// Register footer locations
	if ( isset( $footer['num'] ) && $footer['num'] > 0 ) {

		$columns = anva_get_footer_widget_columns();

		foreach ( $columns as $key => $value ) {
			if ( isset( $value['col'] ) ) {
				anva_add_sidebar_location( $value['id'], $value['name'] );
				if ( $footer['num'] == $value['col'] ) {
					break;
				}
			}
		}
	}
}

/**
 * Display footer sidebat locations.
 *
 * @since  1.0.0
 * @return void
 */
function anva_display_footer_sidebar_locations() {

	$footer_setup = anva_get_option( 'footer_setup' );
	$widgets_columns = anva_get_footer_widget_columns();

	// Make sure there's actually a footer option in the theme setup
	if ( is_array( $footer_setup ) ) {

		// Only move forward if user has selected for columns to show
		if ( $footer_setup['num'] > 0 ) {

			// Build array of columns
			$i = 1;
			$columns = array();
			$num = $footer_setup['num'];
			while ( $i <= $num ) {
				if ( isset( $widgets_columns[ 'footer_' . $i ] ) ) {
					$columns[] = $widgets_columns[ 'footer_' . $i ]['id'];
				}
				$i++;
			}
			anva_columns( $num, $footer_setup['width'][ $num ], $columns );
		}
	}

}

/**
 * Display set of columns
 *
 * @since  1.0.0
 * @param  integer $num
 * @param  array   $widths
 * @param  array   $columns
 * @return void
 */
function anva_columns( $num, $widths, $columns ) {

	// Kill it if number of columns doesn't match the number of widths exploded from the string.
	$widths = explode( ',', $widths );
	if ( $num != count( $widths ) ) {
		return;
	}

	// Kill it if number of columns doesn't match the number of columns feed into the function.
	if ( $num != count( $columns ) ) {
		return;
	}

	// Last column's key
	$last = $num - 1;

	foreach ( $columns as $key => $column ) {
		// Set CSS classes for column
		$classes = 'column ' . $widths[ $key ];
		if ( $last == $key ) {
			$classes .= ' col_last';
		}

		echo '<div class="' . esc_attr( $classes ) . '">';
		anva_display_sidebar( $column );
		echo '</div><!-- .column (end) -->';
	}
}

/**
 * Get gallery templates.
 *
 * @since  1.0.0
 * @return array  $templates
 */
function anva_gallery_templates() {
	$templates = array(
		'grid_2'  => array(
			'name'   => __( 'Gallery 2 Columns', 'anva' ),
			'id'     => 'grid_2',
			'layout' => array(
				'size' => 'anva_grid_2',
				'col'  => 'col-2',
			),
		),
		'grid_3'  => array(
			'name' => __( 'Gallery 3 Columns', 'anva' ),
			'id'	 => 'grid_3',
			'layout' => array(
				'size' => 'anva_grid_3',
				'col'	 => 'col-3',
			),
		),
		'grid_4'  => array(
			'name' => __( 'Gallery 4 Columns', 'anva' ),
			'id'	 => 'grid_4',
			'layout' => array(
				'size' => 'anva_sm',
				'col'	 => 'col-4',
			),
		),
		'grid_5'  => array(
			'name' => __( 'Gallery 5 Columns', 'anva' ),
			'id'	 => 'grid_5',
			'layout' => array(
				'size' => 'anva_sm',
				'col'	 => 'col-5',
			),
		),
		'grid_6'  => array(
			'name' => __( 'Gallery 6 Columns', 'anva' ),
			'id'	 => 'grid_6',
			'layout' => array(
				'size' => 'anva_sm',
				'col'	 => 'col-6',
			),
		),
	);
	return apply_filters( 'anva_gallery_templates', $templates );
}

/**
 * Post meta field.
 *
 * @param  string $field Custom field stored.
 * @return string Custom field content.
 */
function anva_the_post_meta( $field ) {
	echo anva_get_post_meta( $field );
}

/**
 * Get the post meta field.
 *
 * @global $post
 *
 * @since  1.0.0
 * @param  string $field Custom field stored.
 * @return string Custom field content.
 */
function anva_get_post_meta( $field ) {

	global $post;

	if ( ! is_object( $post ) ) {
		return false;
	}

	return get_post_meta( $post->ID, $field, true );
}

/**
 * Print custom post meta by page ID outside the loop.
 *
 * @param  string $field Custom field stored.
 * @param  string $page_id Current page ID.
 * @return string Custom field content.
 */
function anva_the_post_meta_by_id( $field, $page_id ) {
	echo anva_get_post_meta_by_id( $field, $page_id );
}

/**
 * Get custom post meta by page ID outside the loop.
 *
 * @param  string $field Custom field stored.
 * @param  string $page_id Current page ID.
 * @return string Custom field content.
 */
function anva_get_post_meta_by_id( $field, $page_id ) {
	if ( ! empty( $page_id ) ) {
		return get_post_meta( $page_id, $field, true );
	}

	return false;
}

/**
 * Sort galleries
 *
 * @since  1.0.0
 * @param  array $gallery
 * @return array  $gallery  The sorted galleries
 */
function anva_sort_gallery( $gallery ) {

	$sorted = array();
	$order  = anva_get_option( 'gallery_sort' );

	if ( ! empty( $order ) && ! empty( $gallery ) ) {

		switch ( $order ) {

			case 'drag':
				foreach ( $gallery as $key => $attachment_id ) {
					$sorted[ $key ] = $attachment_id;
				}
				break;

			case 'desc':
				foreach ( $gallery as $key => $attachment_id ) {
					$meta = get_post( $attachment_id );
					$date = strtotime( $meta->post_date );
					$sorted[ $date ] = $attachment_id;
					krsort( $sorted );
				}
				break;

			case 'asc':
				foreach ( $gallery as $key => $attachment_id ) {
					$meta = get_post( $attachment_id );
					$date = strtotime( $meta->post_date );
					$sorted[ $date ] = $attachment_id;
					ksort( $sorted );
				}
				break;

			case 'rand':
				shuffle( $gallery );
				$sorted = $gallery;
				break;

			case 'title':
				foreach ( $gallery as $key => $attachment_id ) {
					$meta = get_post( $attachment_id );
					$title = $meta->post_title;
					$sorted[ $title ] = $attachment_id;
					ksort( $sorted );
				}
				break;
		}// End switch().

		return $sorted;

	}// End if().

	return $gallery;
}

/**
 * Get query posts args.
 *
 * @since  1.0.0
 * @return array The post list
 */
function anva_get_posts( $query_args ) {

	$number = get_option( 'posts_per_page' );
	$page 	= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$offset = ( $page - 1 ) * $number;

	$defaults = apply_filters( 'anva_posts_query_args_defaults', array(
		'post_type'      => array( 'post' ),
		'post_status'    => 'publish',
		'posts_per_page' => $number,
		'orderby'        => 'date',
		'order'          => 'desc',
		'number'         => $number,
		'page'           => $page,
		'offset'         => $offset,
	) );

	$query_args = wp_parse_args( $query_args, $defaults );

	$query = new WP_Query( $query_args );

	return $query;
}


/**
 * Get admin modules.
 *
 * @since  1.0.0
 * @return array $modules
 */
function anva_get_admin_modules() {

	// Options page.
	$page = sprintf( 'themes.php?page=%s', anva_get_option_name() );

	// Admin modules
	$modules = array(
		'options'	=> $page,
		'demos'		=> $page . '_demos',
		'plugins'	=> $page . '_plugins',
	);

	return apply_filters( 'anva_admin_modules', $modules );
}

/**
 * Add items to admin menu bar.
 *
 * @global $awp_admin_bar
 *
 * @since  1.0.0
 * @return void
 */
function anva_admin_menu_bar() {

	global $wp_admin_bar;

	if ( is_admin() || ! method_exists( $wp_admin_bar, 'add_node' ) ) {
		return;
	}

	// Get all admin modules.
	$modules = anva_get_admin_modules();

	if ( ! $modules ) {
		return;
	}

	// Get option name.
	$name = anva_get_option_name();

	// Node ID.
	$node = $name . '_node_optons';

	$default_node = array(
		'id'    => $node,
		'title' => esc_html__( 'Anva Options', 'anva' ),
		'meta'  => array(
			'class' => 'anva-admin-bar-node',
		),
	);

	$wp_admin_bar->add_node( $default_node );

	// Theme Options
	if ( isset( $modules['options'] ) && current_user_can( anva_admin_module_cap( 'options' ) ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'		=> $name . '_theme_options',
				'title'		=> sprintf( '%1$s', __( 'Theme Options', 'anva' ) ),
				'href'		=> admin_url( $modules['options'] ),
				'parent' 	=> $node,
			)
		);
	}

	// Theme Recommended Plugins
	if ( current_user_can( 'install_plugins' ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'		=> $name . '_theme_plugins',
				'title'		=> sprintf( '%1$s', __( 'Theme Plugins', 'anva' ) ),
				'href'		=> admin_url( $modules['plugins'] ),
				'parent' 	=> $node,
			)
		);
	}
}

/**
 * Filter framework items into wp_nav_menu() output.
 *
 * @since  1.0.0
 * @param  string $item_output
 * @param  string $item Object
 * @param  int    $depth
 * @param  array  $args
 * @return string $item_output
 */
function anva_nav_menu_start_el( $item_output, $item, $depth, $args ) {

	// Get primary menu style
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	// Wrap all menu item title with "div" tag
	if ( is_a( $args->walker, 'Anva_Main_Menu_Walker' ) ) {
		$item_output = str_replace( $item->title, sprintf( '<div>%s</div>', $item->title ), $item_output );

		// Add "description" to all menu items
		// Note: For primary menu will only work on level 1
		if ( 'sub_title' == $primary_menu_style ) {
			if ( strpos( $item_output, $item->title . '</div>' ) !== false && $depth == 0 ) {
				$item_output = str_replace( $item->title . '</div>', sprintf( '%s</div><span>%s</span>', $item->title, $item->description ), $item_output );
			}
		}

		// Add "menu-btn" to all menu items in main navigation.
		// Note: If menu item's link was disabled in the walker, the
		// item will already be setup as <span class="menu-btn">Title</span>,
		// which allows styling to match all anchor links with .menu-btn
		$item_output = str_replace( '<a', '<a class="menu-btn"', $item_output );
	}

	// Add "bold" class
	if ( get_post_meta( $item->ID, '_anva_bold', true ) ) {
		if ( strpos( $item_output, 'menu-btn' ) !== false ) {
			$item_output = str_replace( 'menu-btn', 'menu-btn bold', $item_output );
		} else {
			$item_output = str_replace( '<a', '<a class="bold"', $item_output );
		}
	}

	// Allow bootstrap "nav-header" class in menu items.
	// Note: For primary navigation will only work on levels 2-3
	//
	// (1) ".sf-menu li li.nav-header" 	=> Primary nav dropdowns
	// (2) ".menu li.nav-header" 		=> Standard custom menu widget
	// (3) ".subnav li.nav-header" 		=> Theme Blvd Horizontal Menu widget
	if ( in_array( 'nav-header', $item->classes ) ) {

		$header = sprintf( '<span>%s</span>', apply_filters( 'the_title', $item->title, $item->ID ) );

		if ( strpos( $args->menu_class, 'sf-menu' ) !== false ) {
			// Primary Navigation
			if ( $depth > 0 ) {
				$item_output = $header;
			}
		} else {
			$item_output = $header;
		}
	}

	// Allow bootstrap "divider" class in menu items.
	// Note: For primary navigation will only work on levels 2-3
	if ( in_array( 'divider', $item->classes ) ) {

		if ( strpos( $args->menu_class, 'sf-menu' ) !== false ) {
			// Primary Navigation
			if ( $depth > 0 ) {
				$item_output = '';
			}
		} else {
			$item_output = '';
		}
	}

	// Font icons in menu items
	$icon = '';

	foreach ( $item->classes as $class ) {
		if ( strpos( $class, 'menu-icon-' ) !== false ) {
			$icon = str_replace( 'menu-icon-', '', $class );
		}
	}

	if ( $icon ) {

		$text = apply_filters( 'the_title', $item->title, $item->ID );
		$icon_output = sprintf( '<i class="icon-%s"></i>', $icon );
		$icon_output = apply_filters( 'anva_menu_icon', $icon_output, $icon );

		if ( ! $args->theme_location ) {

			// Random custom menu, probably sidebar widget, insert icon outside <a>.
			$item_output = $icon_output . $item_output;

		} else {

			// Theme location, insert icon within <a>.
			$item_output = str_replace( $text, $icon_output . $text, $item_output );

		}
	}

	return $item_output;
}

/**
 * Filter menus ID.
 *
 * @param  string $menu_id Filter menu ID.
 * @param  object $item    Item object from nav menu.
 * @param  array  $args    Arguments list.
 * @param  int    $depth   Depth.
 * @return string          Filter menu item.
 */
function anva_nav_menu_item_id( $menu_id, $item, $args, $depth ) {
	return $args->theme_location . '-menu-item-' . $item->ID;
}

/**
 * Contact email.
 *
 * @todo Move to extensions
 *
 * @global $_email_sended_message
 *
 * @since 1.0.0
 */
function anva_contact_send_email() {

	global $_email_sended_message;

	// Submit form
	if ( isset( $_POST['contact-submission'] ) && 1 == $_POST['contact-submission'] && wp_verify_nonce( 'contact_form_nonce', 'contact_form' ) ) {

		// Fields
		$name 		= $_POST['cname'];
		$email 		= $_POST['cemail'];
		$subject 	= $_POST['csubject'];
		$message 	= $_POST['cmessage'];
		$captcha 	= $_POST['ccaptcha'];

		// Validate name
		if ( sanitize_text_field( $name ) == '' ) {
			$has_error = true;
		}

		// Validate email
		if ( sanitize_email( $email ) == '' || ! is_email( $email ) ) {
			$has_error = true;
		}

		// Validate subject
		if ( sanitize_text_field( $subject ) == '' ) {
			$has_error = true;
		}

		// Validate message
		if ( sanitize_text_field( $message ) == '' ) {
			$has_error = true;
		}

		// Validate answer
		if ( sanitize_text_field( $captcha ) == '' ) {
			$has_error = true;
		}

		// Body Mail
		if ( ! isset( $has_error ) ) {

			// Change to dynamic
			$email_to = apply_filters( 'anva_email_to', '' );

			if ( empty( $email_to ) ) {
				$email_to = get_option( 'admin_email' );
			}

			$email_body		 = '';
			$email_body 	.= "Name: $name\n\n";
			$email_body 	.= "E-email: $email\n\n";
			$email_body 	.= "Message: \n\n$message";
			$email_subject 	 = '[' . $subject . '] From ' . $name;
			$headers 		 = 'From: ' . $name . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email;

			wp_mail( $email_to, $email_subject, $email_body, $headers );

			$email_sent = true;
		}
	}// End if().

	if ( isset( $email_sent ) && $email_sent === true ) :

		$_email_sended_message = anva_get_local( 'submit_message' );

		// Clear form after submit
		unset(
			$_POST['cname'],
			$_POST['cemail'],
			$_POST['csubject'],
			$_POST['cmessage'],
			$_POST['ccaptcha']
		);

	else :
		if ( isset( $has_error ) ) :
			$_email_sended_message = anva_get_local( 'submit_error' );
		endif;
	endif;
}
