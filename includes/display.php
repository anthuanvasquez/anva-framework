<?php
/**
 * Functions for display content.
 *
 * @package    AnvaFramework
 * @subpackage Admin
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

/**
 * Print favicon and apple touch icons in head.
 *
 * @since 1.0.0
 */
function anva_head_apple_touch_icon() {

	$html               = '';
	$sizes              = '';
	$links              = array();
	$favicon            = anva_get_option( 'favicon' );
	$touch_icon_display = anva_get_option( 'apple_touch_icon_display' );

	if ( $favicon ) {
		$links[] = array(
			'rel' => 'shortcut icon',
			'image' => $favicon,
			'size' => '16x16',
		);
	}

	if ( $touch_icon_display ) {

		$touch_icon     = anva_get_option( 'apple_touch_icon' );
		$touch_icon76   = anva_get_option( 'apple_touch_icon_76' );
		$touch_icon120  = anva_get_option( 'apple_touch_icon_120' );
		$touch_icon152  = anva_get_option( 'apple_touch_icon_152' );

		if ( $touch_icon ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon,
			);
		}

		if ( $touch_icon76 ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon76,
				'size' => '76x76',
			);
		}

		if ( $touch_icon120 ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon120,
				'size' => '120x120',
			);
		}

		if ( $touch_icon152 ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon152,
				'size' => '152x152',
			);
		}
	} // End if().

	if ( $links ) {
		foreach ( $links as $link_id => $link ) {
			if ( isset( $link['size'] ) ) {
				$sizes = ' sizes="' . esc_attr( $link['size'] ) . '" ';
			}

			if ( isset( $link['image'] ) ) {
				$html .= sprintf( '<link rel="%s" %s href="%s" />', esc_attr( $link['rel'] ), $sizes, esc_url( $link['image'] ) );
				$sizes = ''; // Reset sizes.
			}
		}
	}

	echo $html;
}

/**
 * Print meta viewport.
 *
 * @since 1.0.0
 */
function anva_head_viewport() {
	if ( 'yes' === anva_get_option( 'responsive' ) ) : ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php
	endif;
}

/**
 * Top bar.
 *
 * @since 1.0.0
 */
function anva_top_bar_default() {
	$top_bar = anva_get_option( 'top_bar' );

	if ( ! $top_bar ) {
		return;
	}

	anva_get_template_part( 'header', 'top-bar' );
}

/**
 * Display default header custom logo.
 *
 * @since 1.0.0
 */
function anva_header_logo_default() {
	anva_get_template_part( 'header', 'site-branding' );
}

/**
 * Side Panel Default.
 *
 * @since 1.0.0
 */
function anva_side_panel_default() {
	$side_panel_display = anva_get_option( 'side_panel_display' );

	if ( ! $side_panel_display && 'side' != anva_get_header_type() ) {
		return;
	}

	anva_get_template_part( 'header', 'side-panel' );
}

/**
 * Display header content.
 *
 * @since 1.0.0
 */
function anva_header_default() {
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	switch ( $primary_menu_style ) :
		case 'style_7':
		case 'style_9':
			?>
			<div class="container clearfix">
				<?php
					/**
					 * Hooked
					 *
					 * @see anva_header_logo_default
					 */
					do_action( 'anva_header_logo' );

					/**
					 * Hooked
					 *
					 * @see anva_header_extras_default
					 */
					do_action( 'anva_header_extras' );
				?>
			</div><!-- .container (end) -->

			<div id="header-wrap" class="header-wrap">
				<?php
					/**
					 * Hooked
					 *
					 * @see anva_header_primary_menu_default
					 */
					do_action( 'anva_header_primary_menu' );
				?>
			</div><!-- .header-wrap (end) -->
			<?php
			break;

		default:
			?>
			<div id="header-wrap" class="header-wrap">
				<div class="container clearfix">
					<div id="primary-menu-trigger">
						<i class="icon-reorder"></i>
					</div>
					<?php
						/**
						 * Hooked
						 *
						 * @see anva_header_logo_default
						 */
						do_action( 'anva_header_logo' );

						/**
						 * Hooked
						 *
						 * @see anva_header_extras_default
						 */
						do_action( 'anva_header_extras' );

						/**
						 * Hooked
						 *
						 * @see anva_header_primary_menu_default
						 */
						do_action( 'anva_header_primary_menu' );
					?>
				</div>
			</div><!-- .header-wrap (end) -->
			<?php
			break;
	endswitch;
}

/**
 * Display default extra header information.
 *
 * @since 1.0.0
 */
function anva_header_extras_default() {
	$primary_menu_style = anva_get_option( 'primary_menu_style' );
	$header_extras      = anva_get_option( 'header_extras' );

	if ( 'show' != $header_extras || 'style_7' != $primary_menu_style ) {
		return;
	}

	anva_get_template_part( 'header', 'header-extras' );
}

/**
 * Display default main navigation.
 *
 * @since 1.0.0
 */
function anva_header_primary_menu_default() {
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' ); ?>
	<nav <?php anva_attr( 'menu', array(), 'primary' ); ?>>

		<?php if ( 'style_7' == $primary_menu_style || 'style_9' == $primary_menu_style ) : ?>
			<div class="container clearfix">
				<div id="primary-menu-trigger">
					<i class="icon-reorder"></i>
				</div>
		<?php endif; ?>

		<?php
			if ( 'split_menu' === $primary_menu_style ) {

				anva_get_template_part( 'navigation', 'split-menu' );

			} else {

				anva_get_template_part( 'navigation', 'primary-menu' );

				/**
				 * Hooked
				 *
				 * @see anva_header_primary_menu_addon_default
				 */
				do_action( 'anva_header_primary_menu_addon' );
			}
		?>

		<?php if ( 'style_7' == $primary_menu_style || 'style_9' == $primary_menu_style ) : ?>
			</div><!-- .container (end) -->
		<?php endif; ?>

	</nav><!-- #primary-menu (end) -->

	<?php
	// Show social icons in side header.
	$side_header_icons = anva_get_option( 'side_header_icons' );
	$header_type       = anva_get_header_type();

	if ( 'side' == $header_type && $side_header_icons ) : ?>
		<div class="clearfix visible-md visible-lg">
			<?php
				$args = apply_filters( 'anva_side_panel_social_icons', array(
					'style'    => null,
					'shape'    => null,
					'border'   => 'borderless',
					'size'     => 'small',
					'position' => null,
					'icons'    => array(),
				) );
				anva_social_icons( $args );
			?>
		</div>
	<?php
	endif;
}

/**
 * Display default menu addons.
 *
 * @since 1.0.0
 */
function anva_header_primary_menu_addon_default() {
	// Only show top cart, search and lang when header is not a side type.
	$header_type = anva_get_header_type();
	if ( 'side' == $header_type ) {
		return;
	}

	// Get side panel.
	$side_panel_display = anva_get_option( 'side_panel_display' );

	// Get primary menu style.
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	anva_get_template_part( 'header', 'top-cart' );
	anva_get_template_part( 'header', 'top-language' );
	anva_get_template_part( 'header', 'top-search' );
	?>

	<?php if ( $side_panel_display && 'style_10' != $primary_menu_style ) : ?>
		<div id="side-panel-trigger" class="side-panel-trigger">
			<a href="#">
				<i class="icon-reorder"></i>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( 'style_10' == $primary_menu_style ) : ?>
		<a href="#" id="overlay-menu-close" class="visible-lg-block visible-md-block">
			<i class="icon-line-cross"></i>
		</a>
	<?php
	endif;
}

/**
 * Display footer widget locations.
 *
 * @since  1.0.0
 * @return void
 */
function anva_footer_content_default() {
	$footer_setup = anva_get_option( 'footer_setup' );
	if ( ! $footer_setup['num'] ) {
		return;
	}
	?>
	<div class="footer-widgets-wrap clearfix">
		<?php anva_display_footer_sidebar_locations(); ?>
	</div>
	<?php
}

/**
 * Display default footer text copyrights.
 *
 * @since 1.0.0
 */
function anva_footer_copyrights_default() {
	anva_get_template_part( 'footer', 'content-copyrights' );
}

/**
 * Display default featured area slider.
 *
 * @since 1.0.0
 */
function anva_featured_default() {
	if ( anva_get_config( 'featured' ) ) {
		$slider = anva_get_option( 'slider_id' );
		anva_sliders( $slider );
	}
}

/**
 * Display default featured area before.
 *
 * @since 1.0.0
 */
function anva_featured_before_default() {

	// Don't show if the featured area is not setup.
	if ( ! anva_get_config( 'featured' ) ) {
		return;
	}

	$slider_id       = anva_get_option( 'slider_id' );
	$slider_style    = anva_get_option( 'slider_style' );
	$slider_parallax = anva_get_option( 'slider_parallax' );

	if ( 'swiper' != $slider_id && 'full-screen' != $slider_style ) {
		$classes[] = $slider_style;
	}

	if ( 'true' == $slider_parallax ) {
		$classes[] = 'slider-parallax';
	}

	if ( 'swiper' == $slider_id ) {
		$classes[] = 'swiper_wrapper has-swiper-slider';
	}

	if ( $slider_id ) {
		$classes[] = 'has-' . $slider_id . '-slider';
	}

	$classes = implode( ' ', $classes );

	?>
	<!-- SLIDER (start) -->
	<section id="slider" class="<?php echo esc_attr( $classes ); ?> clearfix">
		<?php if ( 'slider-boxed' == $slider_style ) : ?>
			<div class="container clearfix">
		<?php endif ?>
	<?php
}

/**
 * Display default featured area after.
 *
 * @since 1.0.0
 */
function anva_featured_after_default() {

	// Don't show if the featured area is not setup.
	if ( ! anva_get_config( 'featured' ) ) {
		return;
	}

	$slider_style = anva_get_option( 'slider_style' );
	?>
		<?php if ( 'slider-boxed' == $slider_style ) : ?>
			</div><!-- .container (end) -->
		<?php endif ?>
	</section><!-- SLIDER (end) -->
	<?php
}

/**
 * Display breadcrumbs outside page titles.
 *
 * @since  1.0.0
 * @return void
 */
function anva_breadcrumbs_outside_default() {
	// Don't show breadcrumbs on front page or builder.
	if ( is_front_page() || is_page_template( 'template_builder.php' ) ) {
		return;
	}

	$breadcrumbs = anva_get_option( 'breadcrumbs', 'inside' );

	if ( 'outside' !== $breadcrumbs ) {
		return;
	}
	?>
	<section id="breadcrumbs" class="breadcrumb-wrap">
		<div class="container clearfix">
			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_breadcrumbs_default
				 */
				do_action( 'anva_breadcrumbs' );
			?>
		</div>
	</section><!-- #breadcrumbs (end) -->
	<?php

}

/**
 * Display breadcrumbs.
 *
 * @since  1.0.0
 * @return void
 */
function anva_breadcrumbs_default() {
	anva_get_template_part( 'breadcrumbs' );
}

/**
 * Display page titles.
 *
 * @since  1.0.0
 * @return void
 */
function anva_page_title_default() {
	// Don't show page titles on front page or builder.
	if ( is_front_page() || is_page_template( 'template_builder.php' ) ) {
		return;
	}

	// Hide post and page titles
	$hide_title = anva_get_post_meta( '_anva_hide_title' );

	if ( 'hide' == $hide_title && ( is_single() || is_page() ) ) {
		return;
	}

	anva_get_template_part( 'page', 'page-title' );
}

/**
 * Display portfolio or galleries navigation.
 *
 * @since 1.0.0
 */
function anva_post_type_navigation_default() {

	// Don't print empty markup if there's nowhere to navigate.
	$previous = get_previous_post();
	$next = get_next_post();

	if ( ! $next && ! $previous ) {
		return;
	}

	$post_type = get_post_type( get_the_ID() );

	?>
	<div id="portfolio-navigation">
		<?php
			if ( $previous ) {
				previous_post_link( '%link', '<i class="icon-angle-left"></i>' );
			}

			printf( '<a href="%s"><i class="icon-line-grid"></i></a>', get_post_type_archive_link( $post_type ) );

			if ( $next ) {
				next_post_link( '%link', '<i class="icon-angle-right"></i>' );
			}
		?>
	</div><!-- #portfolio-navigation (end) -->
	<?php
	wp_reset_postdata();
}

/**
 * Wrapper layout content start.
 *
 * @since  1.0.0
 * @return void
 */
function anva_above_layout_default() {
	?>
	<div id="sidebar-layout-wrap">
	<?php
}

/**
 * Wrapper layout content end.
 *
 * @since  1.0.0
 * @return void
 */
function anva_below_layout_default() {
	?>
	</div><!-- #sidebar-layout-wrap (end) -->
	<?php
}

/**
 * Display sidebars location.
 *
 * @since  1.0.0
 * @param  string $position
 * @return void
 */
function anva_sidebars_default( $position ) {

	$layout        = '';
	$sidebar_right = '';
	$sidebar_left  = '';
	$right         = apply_filters( 'anva_default_sidebar_right', 'sidebar_right' );
	$left          = apply_filters( 'anva_default_sidebar_left', 'sidebar_left' );

	// Get sidebar layout meta
	$sidebar_layout = anva_get_post_meta( '_anva_sidebar_layout' );

	// Get sidebar locations
	if ( isset( $sidebar_layout['layout'] ) ) {
		$layout        = $sidebar_layout['layout'];
		$sidebar_right = $sidebar_layout['right'];
		$sidebar_left  = $sidebar_layout['left'];
	}

	// Set default layout
	if ( empty( $layout ) ) {
		$layout        = anva_get_option( 'sidebar_layout', 'right' );
		$sidebar_right = $right;
		$sidebar_left  = $left;
	}

	// Set default sidebar right
	if ( empty( $sidebar_right ) ) {
		$sidebar_right = $right;
	}

	// Set default sidebar left
	if ( empty( $sidebar_left ) ) {
		$sidebar_left = $left;
	}

	// Sidebar Left, Sidebar Right, Double Sidebars
	if ( $layout == $position || $layout == 'double' ) {

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_before_default
		 */
		do_action( 'anva_sidebar_before', $position  );

		if ( 'right' == $position ) {
			anva_display_sidebar( $sidebar_right );
		} elseif ( 'left' == $position ) {
			anva_display_sidebar( $sidebar_left );
		}

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_after_default
		 */
		do_action( 'anva_sidebar_after', $position );

	}

	// Double Left Sidebars
	if ( $layout === 'double_left' && $position === 'left' ) {

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_before_default
		 */
		do_action( 'anva_sidebar_before', 'left'  );

		// Left sidebar.
		anva_display_sidebar( $sidebar_left );

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_after_default
		 */
		do_action( 'anva_sidebar_after', 'left' );

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_after_default
		 */
		do_action( 'anva_sidebar_before', 'right'  );

		// Right sidebar.
		anva_display_sidebar( $sidebar_right );

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_after_default
		 */
		do_action( 'anva_sidebar_after', 'right' );

	}

	// Double Right Sidebars
	if ( $layout == 'double_right' && $position == 'right' ) {

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_before_default
		 */
		do_action( 'anva_sidebar_before', 'left' );

		// Left sidebar.
		anva_display_sidebar( $sidebar_left );

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_after_default
		 */
		do_action( 'anva_sidebar_after', 'left' );

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_before_default
		 */
		do_action( 'anva_sidebar_before', 'right' );

		// Right sidebar.
		anva_display_sidebar( $sidebar_right );

		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_after_default
		 */
		do_action( 'anva_sidebar_after', 'right' );

	}
}

/**
 * Display sidebar location before.
 *
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_before_default( $side ) {
	?>
	<div class="sidebar-<?php echo esc_attr( $side ); ?> <?php anva_column_class( $side ); ?>">
		<div class="sidebar-widgets-wrap">
	<?php
}

/**
 * Display sidebar location after.
 *
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_after_default() {
	?>
		</div><!-- .sidebar-widgets-wrap (end) -->
	</div><!-- .sidebar (end) -->
	<?php
}

/**
 * Display sidebar above header.
 *
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_above_header() {
	?>
	<div id="above-header">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'above_header' ); ?>
		</div>
	</div><!-- #above-header (end) -->
	<?php
}

/**
 * Display sidebar above content.
 *
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_above_content() {
	?>
	<div id="above-content">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'above_content' ); ?>
		</div>
	</div><!-- #above-content (end) -->
	<?php
}

/**
 * Display sidebar below content.
 *
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_below_content() {
	?>
	<div id="below-content">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'below_content' ); ?>
		</div>
	</div><!-- #below-content (end) -->
	<?php
}

/**
 * Display sidebar below footer.
 *
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_below_footer() {
	?>
	<div id="below-footer">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'below_footer' ); ?>
		</div>
	</div><!-- #below-footer (end) -->
	<?php
}

/**
 * Display on single posts or primary posts.
 *
 * @since  1.0.0
 * @return void
 */
function anva_post_meta_default() {
	if ( is_single() && 'show' == anva_get_option( 'single_meta', 'show' ) ) {
		anva_get_template_part( 'post', 'content-meta' );
		return;
	}

	if ( 'show' == anva_get_option( 'prmary_meta', 'show' ) ) {
		if ( is_page_template( 'template-grid' ) ) {
			anva_get_template_part( 'post', 'content-meta-mini' );
		} else {
			anva_get_template_part( 'post', 'content-meta' );
		}
	}
}

/**
 * Display posts content default.
 *
 * @since  1.0.0
 * @return void
 */
function anva_post_content_default() {

	// Don't show content or excerpt if the post has these formats.
	if ( has_post_format( anva_post_format_not_titles() ) ) {
		return;
	}

	$primary_content = anva_get_option( 'primary_content', 'excerpt' );

	if ( 'excerpt' == $primary_content ) {

		// Show excerpt and read more button.
		$args = apply_filters( 'anva_the_excerpt_more_args', array(
			'text'        => anva_get_local( 'read_more' ),
			'url'         => get_permalink(),
			'target'      => '_self',
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
			'p'           => false,
		) );

		// Excerpt.
		anva_the_excerpt();

		// Button.
		$button = anva_get_button( $args );

		if ( $args['p'] ) {
			$button = '<p>' . $button . '</p>';
		}

		echo $button;

		return;
	}

	the_content( apply_filters( 'anva_the_content_more_text', anva_get_local( 'read_more' ) ) );
}

/**
 * Display post tags.
 *
 * @since 1.0.0
 */
function anva_post_terms_default() {
	anva_get_template_part( 'post', 'content-terms' );
}

/**
 * Display post share icons links.
 *
 * @since 1.0.0
 */
function anva_post_share_default() {
	$single_share = anva_get_option( 'single_share', 'show' );

	if ( 'show' != $single_share || ! is_single() ) {
		return;
	}

	anva_get_template_part( 'post', 'content-share' );
}

/**
 * Display post navigation links.
 *
 * @since 1.0.0
 */
function anva_post_nav_default() {
	$single_navigation = anva_get_option( 'single_navigation', 'show' );

	if ( 'show' != $single_navigation ) {
		return;
	}

	anva_get_template_part( 'post', 'content-nav' );
}

/**
 * Display post author information.
 *
 * @since 1.0.0
 */
function anva_post_author_default() {
	$single_author = anva_get_option( 'single_author', 'hide' );

	if ( 'show' != $single_author ) {
		return;
	}

	anva_get_template_part( 'post', 'content-author' );
}

/**
 * Display related posts.
 *
 * @since 1.0.0
 */
function anva_post_related_default() {
	$single_related = anva_get_option( 'single_related', 'hide' );

	if ( 'hide' === $single_related ) {
		return;
	}

	anva_get_template_part( 'post', 'content-related' );
}

/**
 * Display post more stories.
 *
 * @since  1.0.0
 * @return void
 */
function anva_post_more_stories_default() {
	$more_story = anva_get_option( 'single_more_story' );

	if ( ! $more_story ) {
		return;
	}

	anva_get_template_part( 'post', 'more-stories' );
}

/**
 * Display posts comments default.
 *
 * @since  1.0.0
 * @return void
 */
function anva_post_comments_default() {
	if ( comments_open() || '0' != get_comments_number() ) {
		comments_template( '', true );
	}
}

/**
 * Display post reading bar indicator.
 *
 * @since  1.0.0
 * @return void
 */
function anva_post_reading_bar() {
	$single_post_reading_bar = anva_get_option( 'single_post_reading_bar' );

	if ( ! is_singular( 'post' ) || 'show' != $single_post_reading_bar ) {
		return;
	}

	anva_get_template_part( 'features', 'reading-bar' );
}

/**
 * Display breaking news posts.
 *
 * @since  1.0.0
 * @return void
 */
function anva_breaking_news_default() {
	$breaking_display = anva_get_option( 'breaking_display' );

	if ( ! $breaking_display ) {
		return;
	}

	anva_get_template_part( 'features', 'breaking-news' );
}

/**
 * Display contact form.
 *
 * @since 1.0.0
 */
function anva_contact_form_default() {
	anva_get_template_part( 'contact-form' );
}

/**
 * Display debug information.
 *
 * Only if WP_DEBUG is enabled and current user is an administrator.
 *
 * @since  1.0.0
 * @return void
 */
function anva_debug() {
	$debug = anva_get_option( 'debug', 0 );
	if ( defined( 'WP_DEBUG' ) && true == WP_DEBUG && current_user_can( 'manage_options' ) && $debug ) :
	?>
	<div id="debug-info">
		<div class="container clearfix">
			<div class="style-msg2 infomsg topmargin bottommargin">
				<div class="msgtitle">
					<i class="icon-info-sign"></i><?php esc_html_e( 'Debug Info', 'anva' ); ?>
				</div>
				<div class="sb-msg">
					<ul>
						<li><span><?php esc_html_e( 'Queries', 'anva' ); ?>:</span> <?php echo get_num_queries(); ?> <?php esc_html_e( 'database queries', 'anva' ); ?>.</li>
						<li><span><?php esc_html_e( 'Speed', 'anva' ); ?>:</span> <?php printf( __( 'Page generated in %s seconds.', 'anva' ), timer_stop(1) ); ?></li>
						<li><span><?php esc_html_e( 'Memory Usage', 'anva' ); ?>:</span> <?php echo anva_convert_memory_use( memory_get_usage( true ) ); ?></li>
						<li><span><?php esc_html_e( 'Theme Name', 'anva' ); ?>:</span> <?php echo anva_get_theme( 'name' ); ?></li>
						<li><span><?php esc_html_e( 'Theme Version', 'anva' ); ?>:</span> <?php echo anva_get_theme( 'version' ); ?></li>
						<li><span><?php esc_html_e( 'Framework Name', 'anva' ); ?>:</span> <?php echo Anva::get_name(); ?></li>
						<li><span><?php esc_html_e( 'Framework Version', 'anva' ); ?>:</span> <?php echo Anva::get_version(); ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
	endif;
}
