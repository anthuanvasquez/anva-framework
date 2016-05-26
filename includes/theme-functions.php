<?php

// Define theme constants
define( 'ANVA_THEME_ID', 'anva' );
define( 'ANVA_THEME_NAME', 'Anva' );
define( 'ANVA_THEME_VERSION', '1.0.0');

// Modify customizer options
require_once( get_template_directory() . '/includes/customizer.php' );

// Modify framework's core options
require_once( get_template_directory() . '/includes/options.php' );

/**
 * Add theme body classes.
 *
 * @since  1.0.0
 * @param  array $classes
 * @return array $classes
 */
function theme_body_classes( $classes ) {

	$base_color_style   = anva_get_option( 'base_color_style' );
	$base_color         = anva_get_option( 'base_color' );
	$layout_style       = anva_get_option( 'layout_style' );
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );
	$header_color       = anva_get_option( 'header_color', 'light' );
	$header_type        = anva_get_option( 'header_type', 'default' );
	$side_panel_type    = anva_get_option( 'side_panel_type' );
	$side_panel_display = anva_get_option( 'side_panel_display' );
	$loader             = anva_get_option( 'page_loader', 1 );

	// Get all header types
	$types = anva_get_header_types();

	// Get all primary menu styles
	$styles = anva_get_primary_menu_styles();

	// Current header type
	$type = anva_get_header_type();

	// Get side panel types
	$side_panel_types = anva_get_side_panel_types();

	// Add base color
	if ( 'dark' == $base_color ) {
		$classes[] = 'has-base-color' . $base_color;
	}

	// Add base color style
	if ( 'dark' == $base_color_style ) {
		$classes[] = $base_color_style;
	}

	// Add layout style
	if ( 'stretched' == $layout_style ) {
		$classes[] = $layout_style;
	}

	// Disable page transitions
	if ( ! $loader ) {
		$classes[] = 'no-transition';
	}

	if ( 'custom' == $header_color ) {
		$classes[] = 'header-has-custom';
	}

	// Add header type
	if ( isset( $types[ $header_type ] ) ) {
		if ( ! empty( $types[ $header_type ]['classes']['body'] ) ) {
			$classes[] = $types[ $header_type ]['classes']['body'];
		}
	}

	// Add side panel type
	if ( isset( $side_panel_types[ $side_panel_type ] ) && $side_panel_display ) {
		if ( ! empty( $side_panel_types[ $side_panel_type ]['class'] ) ) {
			$classes[] = $side_panel_types[ $side_panel_type ]['class'];
		}
	}

	// Add primary menu style
	if ( isset( $styles[ $primary_menu_style ] )  ) {
		if ( ! empty( $styles[ $primary_menu_style ]['classes']['body'] ) && 'side' != $type ) {
			$classes[] = $styles[ $primary_menu_style ]['classes']['body'];
		}
	}

	return $classes;
}
add_filter( 'body_class', 'theme_body_classes', 10 );

/**
 * Add theme header classes.
 *
 * @param  array $classes
 * @return array $classes
 */
function theme_header_classes( $classes ) {

	$header_color       = anva_get_option( 'header_color', 'light' );
	$header_image       = anva_get_option( 'header_image' );
	$header_layout      = anva_get_option( 'header_layout' );
	$header_type        = anva_get_option( 'header_type', 'default' );
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	// Get all header types
	$types = anva_get_header_types();

	// Get all primary menu styles
	$styles = anva_get_primary_menu_styles();

	// Current header type
	$type = anva_get_header_type();

	// Add header style
	if ( 'side' != $type && $header_layout ) {
		$classes[] = $header_layout;
	}

	// Add header typr
	if ( isset( $types[ $header_type ] ) ) {
		if ( ! empty( $types[ $header_type ]['classes']['header'] ) ) {
			$classes[] = $types[ $header_type ]['classes']['header'];
		}
	}

	// Add primary menu style
	if ( isset( $styles[ $primary_menu_style ] )  ) {
		if ( ! empty( $styles[ $primary_menu_style ]['classes']['header'] ) && 'side' != $type ) {
			$classes[] = $styles[ $primary_menu_style ]['classes']['header'];
		}
	}

	// Add header color
	if ( 'dark' == $header_color ) {
		$classes[] = $header_color;
	}

	if ( 'custom' == $header_color ) {
		$classes[] = 'has-custom-color';
	}

	if ( ! empty( $header_image ) ) {
		$classes[] = 'has-cusotm-image';
	}

	return $classes;
}
add_filter( 'anva_header_class', 'theme_header_classes', 10 );

/**
 * Add theme primary menu classes.
 *
 * @param  array $classes
 * @return array $classes
 */
function theme_primary_menu_classes( $classes ) {

	$primary_menu_color = anva_get_option( 'primary_menu_color', 'light' );
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	// Get all primary menu styles
	$styles = anva_get_primary_menu_styles();

	// Get current header type
	$type = anva_get_header_type();

	// Add primary menu color
	if ( 'dark' == $primary_menu_color && 'side' != $type ) {
		$classes[] = $primary_menu_color;
	}

	// Add primary menu style
	if ( isset( $styles[ $primary_menu_style ] )  ) {
		if ( ! empty( $styles[ $primary_menu_style ]['classes']['menu'] ) && 'side' != $type ) {
			$classes[] = $styles[ $primary_menu_style ]['classes']['menu'];
		}
	}

	return $classes;
}
add_filter( 'anva_primary_menu_class', 'theme_primary_menu_classes', 10 );

/**
 * Header trigger.
 *
 * @since  1.0.0
 * @return void
 */
function theme_header_trigger() {
	$header_type = anva_get_header_type();
	if ( 'side' == $header_type ) :
	?>
	<div id="header-trigger">
		<i class="icon-line-menu"></i>
		<i class="icon-line-cross"></i>
	</div>
	<?php
	endif;
}
add_action( 'anva_header_above', 'theme_header_trigger' );

/**
 * Scroll to top button.
 *
 * @since 1.0.0
 */
function theme_gototop() {
	if ( ! anva_get_option( 'footer_gototop' ) ) :
		return;
	endif;
	?>
	<div id="gotoTop" class="icon-angle-up"></div>
	<?php
}
add_action( 'anva_footer_below', 'theme_gototop', 100 );

/**
 * Google fonts using by the theme
 *
 * @since  1.0.0
 * @return void
 */
function theme_google_fonts() {
	anva_enqueue_google_fonts(
		anva_get_option( 'body_font' ),
		anva_get_option( 'heading_font' ),
		anva_get_option( 'meta_font' )
	);
}
add_action( 'wp_enqueue_scripts', 'theme_google_fonts' );

/**
 * Add theme support.
 *
 * @since  1.0.0
 * @return void
 */
function theme_add_theme_support() {
	// Support editor styles
	add_editor_style();

	// Framework support features
	add_theme_support( 'anva-login' );
	add_theme_support( 'anva-menu' );
	add_theme_support( 'anva-woocommerce' );
}
add_action( 'after_setup_theme', 'theme_add_theme_support', 10 );

/**
 * Include the themes stylesheets.
 *
 * @since  1.0.0
 * @return void
 */
function theme_stylesheets() {

	// Get curren color hex from scheme.
	$color = anva_get_current_color();
	$color = str_replace( '#', '', $color );

	// Get stylesheet API
	$api = Anva_Stylesheets_API::instance();

	// Register theme stylesheets
	wp_register_style( 'theme_styles', get_template_directory_uri() . '/assets/css/theme.css', array(), ANVA_THEME_VERSION, 'all' );
	wp_register_style( 'theme_dark', get_template_directory_uri() . '/assets/css/dark.css', array( 'theme_styles' ), ANVA_THEME_VERSION, 'all' );
	wp_register_style( 'theme_colors', get_template_directory_uri() . '/assets/css/colors.php?color=' . esc_html( $color ), array( 'theme_dark' ), ANVA_THEME_VERSION, 'all' );
	wp_register_style( 'theme_ie', get_template_directory_uri() . '/assets/css/ie.css', array( 'theme_color' ), ANVA_THEME_VERSION, 'all' );
	wp_register_style( 'theme_custom', get_template_directory_uri() . '/assets/css/custom.css', array( 'theme_color' ), ANVA_THEME_VERSION, 'all' );

	// Enqueue theme stylesheets
	wp_enqueue_style( 'theme_styles' );
	wp_enqueue_style( 'theme_dark' );
	wp_enqueue_style( 'theme_colors' );

	// Custom Stylesheet
	if ( 'yes' == anva_get_option( 'custom_css_stylesheet' ) ) {
		wp_enqueue_style( 'theme_custom' );
	}

	// IE
	$GLOBALS['wp_styles']->add_data( 'theme_ie', 'conditional', 'lt IE 9' );
	wp_enqueue_style( 'theme_ie' );

	// Inline theme styles
	wp_add_inline_style( 'theme_colors', theme_styles() );

	// Level 3
	$api->print_styles(3);

}
add_action( 'wp_enqueue_scripts', 'theme_stylesheets' );

/**
 * Include the theme scripts.
 *
 * @since  1.0.0
 * @return void
 */
function theme_scripts() {

	// Get scripts API
	$api = Anva_Scripts_API::instance();

	wp_register_script( 'css3-mediaqueries-js', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js', array(), '1.0.0' );
	wp_register_script( 'theme_js', get_template_directory_uri() . '/assets/js/theme.js', $api->get_framework_deps(), ANVA_THEME_VERSION, true );

	// IE
	$GLOBALS['wp_scripts']->add_data( 'css3-mediaqueries-js', 'conditional', 'lt IE 9' );

	// Enqueue Scripts
	//wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'css3-mediaqueries-js' );
	wp_enqueue_script( 'theme_js' );
	wp_localize_script( 'anva_main', 'ANVA_VARS', anva_get_js_locals() );

	// Enqueue Thread Commens on Single Posts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Level 3
	$api->print_scripts(3);

}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

/**
 * Theme custom styles options.
 *
 * @since  1.0.0
 * @return string $styles
 */
function theme_styles() {

	// Styles output
	$styles 			= '';

	// Get styles options
	$custom_css          = anva_get_option( 'custom_css' );
	$body_font           = anva_get_option( 'body_font' );
	$heading_font        = anva_get_option( 'heading_font' );
	$meta_font           = anva_get_option( 'meta_font' );
	$heading_h1          = anva_get_option( 'heading_h1', '36' );
	$heading_h2          = anva_get_option( 'heading_h2', '30' );
	$heading_h3          = anva_get_option( 'heading_h3', '24' );
	$heading_h4          = anva_get_option( 'heading_h4', '18' );
	$heading_h5          = anva_get_option( 'heading_h5', '14' );
	$heading_h6          = anva_get_option( 'heading_h6', '12' );
	$background_color    = anva_get_option( 'background_color', '#cccccc' );
	$background_image    = anva_get_option( 'background_image', array( 'image' => '' ) );
	$background_cover    = anva_get_option( 'background_cover' );
	$background_pattern  = anva_get_option( 'background_pattern' );
	$link_color          = anva_get_option( 'link_color' );
	$link_color_hover    = anva_get_option( 'link_color_hover' );
	$header_color        = anva_get_option( 'header_color' );
	$header_bg_color     = anva_get_option( 'header_bg_color' );
	$header_image     	 = anva_get_option( 'header_image' );
	$header_border_color = anva_get_option( 'header_border_color' );
	$header_text_color   = anva_get_option( 'header_text_color' );
	$side_panel_color    = anva_get_option( 'side_panel_color' );
	$side_panel_bg_color = anva_get_option( 'side_panel_bg_color' );
	ob_start();
	?>
	/* ---------------------------------------- */
	/* Typography
	/* ---------------------------------------- */

	/* Body */
	body,
	small,
	#primary-menu ul ul li > a,
	.wp-caption,
	.feature-box.fbox-center.fbox-italic p,
	.skills li .progress-percent .counter,
	.nav-tree ul ul a,
	.font-body { font-family: <?php anva_the_font_face( $body_font ); ?>; }

	body {
		font-size: <?php anva_the_font_size( $body_font ); ?>;
		font-style: <?php anva_the_font_style( $body_font ); ?>;
		font-weight: <?php anva_the_font_weight( $body_font ); ?>;
		text-transform: <?php anva_the_text_transform( $body_font ); ?>
	}

	/* Headers */
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	#logo,
	#primary-menu ul li > a,
	#primary-menu ul li .mega-menu-content.style-2 ul.mega-menu-column > li.mega-menu-title > a,
	#top-search form input,
	.entry-link,
	.entry.entry-date-section span,
	.button.button-desc,
	.counter,
	label,
	.nav-tree li a,
	.wedding-head .first-name,
	.wedding-head .last-name,
	.font-primary {
		font-family: <?php anva_the_font_face( $heading_font ); ?>;
	}

	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.entry-title h2,
	.widget > h4 {
		font-weight: <?php anva_the_font_weight( $heading_font ); ?>;
		text-transform: <?php anva_the_text_transform( $heading_font ); ?>;
	}


	h1 { font-size: <?php echo $heading_h1 . 'px'; ?>; }
	h2 { font-size: <?php echo $heading_h2 . 'px'; ?>; }
	h3 { font-size: <?php echo $heading_h3 . 'px'; ?>; }
	h4 { font-size: <?php echo $heading_h4 . 'px'; ?>; }
	h5 { font-size: <?php echo $heading_h5 . 'px'; ?>; }
	h6 { font-size: <?php echo $heading_h6 . 'px'; ?>; }

	/* Meta */
	.entry-meta li,
	.entry-link span,
	.entry blockquote p,
	.more-link,
	.comment-content .comment-author span,
	.button.button-desc span,
	.testi-content p,
	.team-title span,
	.before-heading,
	.wedding-head .first-name span,
	.wedding-head .last-name span,
	.font-secondary {
		font-family: <?php anva_the_font_face( $meta_font ); ?>
	}

	/* ---------------------------------------- */
	/* Background
	/* ---------------------------------------- */

	/* Background Image */
	body {
		background-color: <?php echo esc_html( $background_color ); ?>;
		<?php if ( ! empty( $background_image['image'] ) ) : ?>
			background-image: url("<?php echo esc_url( $background_image['image'] );?>");
			background-repeat: <?php echo esc_html( $background_image['repeat'] );?>;
			background-position: <?php echo esc_html( $background_image['position'] );?>;
			background-attachment: <?php echo esc_html( $background_image['attachment'] );?>;
		<?php endif; ?>
	}

	/* Background Image Cover Size */
	<?php if ( $background_cover && ! empty( $background_image['image'] ) ) : ?>
		body {
			background: url("<?php echo esc_url( $background_image['image'] ); ?>") no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
	<?php endif; ?>

	/* Background Image Patterns */
	<?php if ( empty( $background_image['image'] ) && ! empty( $background_pattern ) ) : ?>
		body {
			background-image: url("<?php echo anva_get_background_pattern( $background_pattern ); ?>");
			background-repeat: repeat;
		}
	<?php endif; ?>

	/* ---------------------------------------- */
	/* Links
	/* ---------------------------------------- */

	a { color: <?php echo $link_color; ?> }
	a:hover { color: <?php echo $link_color_hover; ?> }

	/* ---------------------------------------- */
	/* Header
	/* ---------------------------------------- */

	<?php if ( 'custom' == $header_color ) : ?>
		/* Header Background */
		body.header-has-custom #header,
		body.header-has-custom #header.sticky-header #header-wrap {
			background-color: <?php echo $header_bg_color; ?>;
			border-color: <?php echo $header_border_color; ?>;
		}

		<?php if ( ! empty( $header_image ) ) : ?>
			body.header-has-custom #header,
			body.header-has-custom #header.sticky-header #header-wrap {
				background-image: url("<?php echo esc_url( $header_image ); ?>");
				background-repeat: repeat;
				background-position: top center;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
		<?php endif; ?>

		/* Text Color */
		body.header-has-custom #primary-menu > ul > li > a,
		body.header-has-custom #primary-menu > ul > li > span a,
		body.header-has-custom #primary-menu > ul > li > a:hover,
		body.header-has-custom #primary-menu > ul > li > span a:hover,
		body.header-has-custom #top-search > a,
		body.header-has-custom #top-lang > a,
		body.header-has-custom #top-cart > a,
		body.header-has-custom #side-panel-trigger > a,
		body.header-has-custom #primary-menu-trigger,
		body.header-has-custom #page-submenu-trigger {
			color: <?php echo $header_text_color; ?>;
		}

	<?php endif; ?>

	/* ---------------------------------------- */
	/* Side Panel
	/* ---------------------------------------- */

	<?php if ( 'custom' == $side_panel_color ) : ?>
		body.side-panel-has-custom #side-panel,
		body.side-panel-has-custom #side-panel.dark { background-color: <?php echo $side_panel_bg_color; ?>; }
	<?php endif; ?>

	<?php
	$styles = ob_get_clean();

	// Add custom CSS
	if ( $custom_css ) {
		$styles .= "\n/* Custom CSS */\n";
		$styles .= $custom_css;
	}

	// Compress Output
	return anva_compress( $styles );
}
add_action( 'wp_enqueue_scripts', 'theme_styles', 20 );

/**
 * Theme colors pallete for scheme.
 *
 * @since 1.0.0
 */
function theme_base_colors() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {

			'use_strict';

			var blue                 		= new Array();
			blue['link_color']       		= '#e41222';
			blue['link_color_hover'] 		= '#e4ff31';

			var light_blue                 	= new Array();
			light_blue['link_color']       	= '#123231';
			light_blue['link_color_hover'] 	= '#e4ff31';

			var navy_blue                 	= new Array();
			navy_blue['link_color']       	= '#12a334';
			navy_blue['link_color_hover'] 	= '#e4ff31';

			// When the select box #base_color_scheme changes
			// it checks which value was selected and calls anva_update_color()
			$('#section-base_color .anva-radio-img-box').click( function() {
			    var colorscheme = $(this).find('.anva-radio-img-radio').val();
			    if ( colorscheme == 'blue' ) { colorscheme = blue; }
			    if ( colorscheme == 'light_blue' ) { colorscheme = light_blue; }
			    if ( colorscheme == 'navy_blue' ) { colorscheme = navy_blue; }
			    for ( id in colorscheme ) {
			        anva_update_color( id, colorscheme[ id ] );
			    }
			});

			// This does the heavy lifting of updating all the colorpickers.
	        function anva_update_color( id, hex ) {
	            $('#' + id).wpColorPicker( 'color', hex );
	        }
		});
	</script>
	<?php
}


/**
 * Remove camera and swiper scripts if their not uses.
 *
 * @since  1.0.0
 * @return void
 */
function theme_remove_scripts() {
	$slider = anva_get_option( 'slider_id' );
	// Camera
	if ( 'camera' != $slider ) {
		anva_remove_stylesheet( 'camera' );
		anva_remove_script( 'jquery_camera' );
	}
	// Swiper
	if ( 'swiper' != $slider ) {
		anva_remove_stylesheet( 'swiper' );
	}
}
add_action( 'after_setup_theme', 'theme_remove_scripts', 11 );

/**
 * Remove grid columns that are not needed.
 *
 * @global $pagenow
 *
 * @since  1.0.0
 * @param  array $columns
 * @return array $columns
 */
function theme_remove_grid_columns( $columns ) {

	if ( is_admin() ) {
		global $pagenow;

		// Admin Pages
		if ( ( $pagenow == 'post.php' ) && ( isset( $_GET['post_type'] ) ) && ( $_GET['post_type'] == 'page' ) ) {
			unset( $columns[1] );
			unset( $columns[5] );
			unset( $columns[6] );
		}

		// Admin Nav Menu
		if ( ( $pagenow == 'nav-menus.php' ) ) {
			unset( $columns[1] );
			unset( $columns[6] );
		}
	}

	return $columns;
}
add_filter( 'anva_grid_columns', 'theme_remove_grid_columns' );
