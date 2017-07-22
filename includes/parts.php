<?php
/**
 * Functions to output HTML parts to use in templates.
 *
 * @package    AnvaFramework
 * @subpackage Includes
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

/**
 * Display the page title based on the queried object.
 *
 * @see anva_get_page_title()
 *
 * @since 1.0.0
 */
function anva_the_page_title() {
	echo anva_get_page_title();
}

/**
 * Retrieve the page title based on the queried object.
 *
 * @link https://developer.wordpress.org/reference/functions/the_archive_title/
 *
 * @since  1.0.0
 * @return string $title The page title.
 */
function anva_get_page_title() {

	/* Home */

	if ( is_home() ) :
		$title = esc_html__( 'Blog', 'anva' );

	/* Single Pages */

	elseif ( is_singular( 'post' ) ) :
		$title = esc_html__( 'Blog', 'anva' );

	elseif ( is_singular( 'portfolio' ) ) :
		$title = get_the_title();

	elseif ( is_singular( 'galleries' ) ) :
		$title = get_the_title();

	elseif ( is_page() ) :
		$title = get_the_title();

	elseif ( is_attachment() ) :
		$title = esc_html__( 'Attachment', 'anva' );

	/* Archive Pages */

	elseif ( is_category() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'category' ), anva_get_attr( 'archive-description' ), single_cat_title( '', false ) );

	elseif ( is_tag() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'tag' ), anva_get_attr( 'archive-description' ), single_tag_title( '', false ) );

	elseif ( is_author() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'author' ), anva_get_attr( 'archive-description' ), get_the_author() );

	elseif ( is_year() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'year' ), anva_get_attr( 'archive-description' ), get_the_date( 'Y' ) );

	elseif ( is_month() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'month' ), anva_get_attr( 'archive-description' ), get_the_date( 'F Y' ) );

	elseif ( is_day() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'day' ), anva_get_attr( 'archive-description' ), get_the_date() );

	/* Post Format Archives */

	elseif ( is_tax( 'post_format' ) ) :

		if ( is_tax( 'post_format', 'post-format-aside' ) ) :
			$title = anva_get_local( 'asides' );

		elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
			$title = anva_get_local( 'galleries' );

		elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
			$title = anva_get_local( 'images' );

		elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
			$title = anva_get_local( 'videos' );

		elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
			$title = anva_get_local( 'quotes' );

		elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
			$title = anva_get_local( 'links' );

		elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
			$title = anva_get_local( 'status' );

		elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
			$title = anva_get_local( 'audios' );

		elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
			$title = anva_get_local( 'chats' );
		endif;

	/* Post Type Archives */

	elseif ( is_post_type_archive() ) :
		$title = sprintf( '%s <span %s>%s</span>', anva_get_local( 'archives' ), anva_get_attr( 'archive-description' ), post_type_archive_title( '', false ) );

	/* Taxonomies Archives */

	elseif ( is_tax() ) :
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf( '%s <span %s>%s</span>', $tax->labels->singular_name, anva_get_attr( 'archive-description' ), single_term_title( '', false ) );

	/* Search */

	elseif ( is_search() ) :
		$title = sprintf( '%s <span %s>%s</span>', __( 'Search results for', 'anva' ), anva_get_attr( 'archive-description' ), get_search_query() );

	/* 404 Error */

	elseif ( is_404() ) :
		$title = anva_get_local( '404_title' );

	/* Default Archives */

	else :
		$title = anva_get_local( 'archives' );
	endif;

	// Filter page title.
	return apply_filters( 'anva_page_title', $title );

}

/**
 * Posted on meta.
 *
 * @since 1.0.0
 */
function anva_posted_on() {

	// Get the time.
	$time_string = '<time ' . anva_get_attr( 'entry-published' ) . '><i class="icon-calendar3"></i> %1$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_html( get_the_date( 'jS F Y' ) )
	);

	// Get comments number.
	$num_comments = get_comments_number();

	if ( comments_open() ) {

		if ( 0 === $num_comments ) {
			$comments = esc_html__( 'No Comments', 'anva' );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . esc_html__( ' Comments', 'anva' );
		} else {
			$comments = esc_html__( '1 Comment', 'anva' );
		}

		$write_comments = sprintf( '<a href="%s"><span class="leave-reply">%s</span></a>', get_comments_link(), $comments );

	} else {
		$write_comments = esc_html__( 'Comments closed', 'anva' );
	}

	// Get post formats icon.
	$format      = get_post_format();
	$format_icon = anva_get_post_format_icon( $format, true );

	if ( $format_icon ) {
		$format_icon = sprintf( '<i class="icon-%s"></i>', $format_icon );
		if ( $format ) {
			$format_icon = sprintf( '<a href="%1$s">%2$s</a>', get_post_format_link( $format ), $format_icon );
		}
	}

	$meta  = '';
	$meta .= '<ul class="entry-meta clearfix">';
	$meta .= '<li class="posted-on">%1$s</li>';
	$meta .= '<li class="byline"><i class="icon-user"></i> %2$s</li>';
	$meta .= '<li class="category"><i class="icon-folder-open"></i> %3$s</li>';
	$meta .= '<li class="comments-link"><i class="icon-comments"></i> %4$s</li>';
	$meta .= '<li class="post-format-icon">%5$s</li>';

	if ( is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) ) {
		$meta .= '<li class="edit-link"><i class="icon-edit"></i> %6$s</li>';
	}

	$meta .= '</ul><!-- .entry-meta (end) -->';

	printf(
		$meta,
		sprintf( '%1$s', $time_string ),
		sprintf(
			'<span ' . anva_get_attr( 'entry-author' ) . '><a rel="author" title="%3$s" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() ),
			esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) )
		),
		sprintf( '%1$s', get_the_category_list( ', ' ) ),
		sprintf( '%1$s', $write_comments ),
		sprintf( '%1$s', $format_icon ),
		sprintf(
			'<a href="%1$s" title="%2$s">%2$s</a>',
			get_edit_post_link(),
			anva_get_local( 'edit_post' )
		)
	);
}

/**
 * Posted on meta for blog posts grid.
 *
 * @since 1.0.0
 */
function anva_posted_on_mini() {

	// Get the time.
	$time_string = '<time ' . anva_get_attr( 'entry-published' ) . '><i class="icon-calendar3"></i> %1$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_html( get_the_date( 'jS F Y' ) )
	);

	// Get comments number.
	$num_comments = get_comments_number();

	if ( comments_open() ) {

		if ( 0 === $num_comments ) {
			$comments = esc_html__( 'No Comments', 'anva' );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . ' ' . esc_html__( 'Comments', 'anva' );
		} else {
			$comments = esc_html__( '1 Comment', 'anva' );
		}

		$write_comments = sprintf( '<a href="%s"><span class="leave-reply">%s</span></a>', get_comments_link(), $comments );

	} else {
		$write_comments = esc_html__( 'Comments closed', 'anva' );
	}

	// Get post formats icon.
	$format      = get_post_format();
	$format_icon = anva_get_post_format_icon( $format, true );

	if ( $format_icon ) {
		$format_icon = sprintf( '<i class="icon-%s"></i>', $format_icon );
		if ( $format ) {
			$format_icon = sprintf( '<a href="%1$s">%2$s</a>', get_post_format_link( $format ), $format_icon );
		}
	}

	$meta = '';
	$meta = '<ul class="entry-meta clearfix">';
	$meta = '<li class="posted-on">%1$s</li>';
	$meta = '<li class="comments-link"><i class="icon-comments"></i> %2$s</li>';
	$meta = '<li class="post-format-icon">%3$s</li>';
	$meta = '</ul><!-- .entry-meta (end) -->';

	printf(
		$meta,
		sprintf( '%1$s', $time_string ),
		sprintf( '%1$s', $write_comments ),
		sprintf( '%1$s', $format_icon )
	);
}

/**
 * Print Button.
 *
 * @since 1.0.0
 * @param array $args Arguments list.
 */
function anva_button( $args ) {
	echo anva_get_button( $args );
}

/**
 * Button.
 *
 * @since  1.0.0
 * @param  array $args Arguments list.
 * @return string $button HTML output for button.
 */
function anva_get_button( $args ) {

	$defaults = apply_filters( 'anva_button_default_args', array(
		'text'        => '',
		'url'         => '#',
		'target'      => '_self',
		'color'       => '',
		'size'        => null,
		'style'       => null,
		'effect'      => null,
		'transition'  => null,
		'classes'     => null,
		'title'       => null,
		'icon_before' => null,
		'icon_after'  => null,
		'addon'       => null,
		'block'       => false,
		'base'        => true,
	) );

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	$final_classes = '';

	// Classes for button.
	if ( $base ) {
		$final_classes = 'button';
	}

	if ( ! $color ) {
		$color = '';
	}

	$final_classes .= anva_get_button_class( $color, $size, $style, $effect, $transition, $block );

	if ( $classes ) {
		$final_classes .= ' ' . $classes;
	}

	// Title param.
	if ( ! $title ) {
		$title = $text;
	}

	// Add icon before text?.
	if ( $icon_before ) {
		$text = sprintf( '<i class="icon-%s before"></i>%s', $icon_before, $text );
	}

	// Make sure there's a default target.
	if ( ! $target ) {
		$target = '_self';
	}

	// Add icon after text?.
	if ( $icon_after ) {
		$text .= sprintf( '<i class="icon-%s after"></i>', $icon_after );
	}

	// Optional addon to anchor.
	if ( $addon ) {
		$addon = ' ' . $addon;
	}

	// Finalize button.
	if ( 'lightbox' === $target ) {

		// Button linking to lightbox
		$args = array(
			'item' 	=> $text,
			'link' 	=> $url,
			'title' => $title,
			'class' => $final_classes,
			'addon'	=> $addon,
		);

		// $button = anva_get_link_to_lightbox( $args );
	} else {

		$button_link = '<a href="%s" title="%s" class="%s" target="%s"%s>%s</a>';

		if ( 'reveal' === $color ) {
			$button_link = '<a href="%s" title="%s" class="%s" target="%s"%s><span>%s</span></a>';
		}

		// Standard button.
		$button = sprintf(
			$button_link,
			esc_url( $url ),
			esc_attr( $title ),
			esc_attr( $final_classes ),
			esc_attr( $target ),
			wp_kses( $addon, array() ),
			anva_get_kses( $text )
		);

	}

	// Return final button.
	return apply_filters( 'anva_button', $button, $args );
}

/**
 * Display social media icons.
 *
 * @since 1.0.0
 * @param array $args Arguments list.
 */
function anva_social_icons( $args ) {
	echo anva_get_social_icons( $args );
}

/**
 * Get social media icons.
 *
 * @since 1.0.0
 * @param array $args Arguments list.
 */
function anva_get_social_icons( $args ) {

	$defaults = apply_filters( 'anva_social_icons_defaults', array(
		'style'    => null,
		'shape'    => null,
		'border'   => null,
		'size'     => null,
		'position' => null,
		'icons'    => array(),
	) );

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	$classes = array();

	// Set up buttons.
	if ( ! $icons ) {
		$icons = anva_get_option( 'social_icons_profiles' );
	}

	// If buttons haven't been sanitized return nothing.
	if ( is_array( $icons ) && isset( $icons['includes'] ) ) {
		return;
	}

	if ( ! $style ) {
		$style = anva_get_option( 'social_icons_style', 'default' );
	}

	if ( ! $shape ) {
		$shape = anva_get_option( 'social_icons_shape', 'default' );
	}

	if ( ! $border ) {
		$border = anva_get_option( 'social_icons_border', 'default' );
	}

	if ( ! $size ) {
		$size = anva_get_option( 'social_icons_size', 'default' );
	}

	// Set up style.
	if ( 'default' !== $style ) {
		$classes[] = 'si-' . $style;
	}

	// Set up shape.
	if ( 'default' !== $shape ) {
		$classes[] = 'si-' . $shape;
	}

	// Set up border.
	if ( 'default' !== $border ) {
		$classes[] = 'si-' . $border;
	}

	// Set up size.
	if ( 'default' !== $size ) {
		$classes[] = 'si-' . $size;
	}

	$classes = implode( ' ', $classes );

	// Social media sources.
	$profiles = anva_get_social_icons_profiles();

	// Start output.
	$output = '';

	if ( is_array( $icons ) && ! empty( $icons ) ) {

		foreach ( $icons as $icon_id => $icon_url ) {

			// Link target.
			$target = '_blank';

			// Link Title.
			$title = '';
			if ( isset( $profiles[ $icon_id ] ) ) {
				$title = $profiles[ $icon_id ];
			}

			// Change Titles to URL.
			switch ( $icon_id ) {
				case 'call':
					$title = str_replace( 'tel:', '', $icon_url );
					break;
				case 'email3':
					$title = str_replace( 'mailto:', '', $icon_url );
					break;
				case 'skype':
					$title = str_replace( 'skype:', '', $icon_url );
					$title = str_replace( '?call', '', $title );
					break;
			}

			// Check if position is on top bar.
			if ( 'top-bar' === $position ) {
				$output .= sprintf(
					'<li><a href="%1$s" class="si-%3$s"><span class="ts-icon"><i class="icon-%3$s"></i></span><span class="ts-text">%2$s</span></a></li>',
					( 'skype' != $icon_id ? esc_url( $icon_url ) : $icon_url ),
					esc_attr( $title ),
					esc_attr( $icon_id ),
					esc_attr( $target ),
					esc_attr( $classes )
				);
			} else {
				$output .= sprintf(
					'<a href="%1$s" class="social-icon si-%3$s %5$s" target="%4$s" title="%2$s"><i class="icon-%3$s"></i><i class="icon-%3$s"></i></a>',
					( 'skype' != $icon_id ? esc_url( $icon_url ) : $icon_url ),
					esc_attr( $title ),
					esc_attr( $icon_id ),
					esc_attr( $target ),
					esc_attr( $classes )
				);
			}
}// End foreach().
	}// End if().

	return apply_filters( 'anva_social_icons', $output );
}

/**
 * Display header logo.
 *
 * @since 1.0.0
 */
function anva_site_branding() {
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );
	$option             = anva_get_option( 'custom_logo' );
	$name               = get_bloginfo( 'name' );
	$classes            = array();
	$classes[]          = 'site-branding';
	$classes[]          = 'logo-' . $option['type'];
	$attrs              = array();

	if ( $option['type'] === 'custom' || $option['type'] === 'title' || $option['type'] === 'title_tagline' ) {
		$classes[] = 'logo-text';
	}

	if ( $option['type'] === 'custom' && ! empty( $option['custom_tagline'] ) ) {
		$classes[] = 'logo-has-tagline';
	}

	if ( $option['type'] === 'title_tagline' ) {
		$classes[] = 'logo-has-tagline';
	}

	if ( $option['type'] === 'image' ) {
		$classes[] = 'logo-has-image';
	}

	if ( $primary_menu_style === 'style_9' ) {
		$classes[] = 'divcenter';
	}

	$attrs['class'] = implode( ' ', $classes );

	echo '<div ' . anva_get_attr( 'branding', $attrs ) . '>';

	if ( ! empty( $option['type'] ) ) {
		switch ( $option['type'] ) {

			case 'title' :
				echo '<div ' . anva_attr( 'site-title' ) . '><a href="' . home_url() . '">' . $name . '</a></div>';
				break;

			case 'title_tagline' :
				echo '<div ' . anva_attr( 'site-title' ) . '><a href="' . home_url() . '">' . $name . '</a></div>';
				echo '<span ' . anva_attr( 'site-description' ) . '>' . get_bloginfo( 'description' ) . '</span>';
				break;

			case 'custom' :
				echo '<div ' . anva_attr( 'site-title' ) . '><a href="' . home_url() . '">' . $option['custom'] . '</a></div>';
				if ( $option['custom_tagline'] ) {
					echo '<span' . anva_attr( 'site-description' ) . '>' . $option['custom_tagline'] . '</span>';
				}
				break;

			case 'image' :
				$image_1x   = esc_url( $option['image'] );
				$image_2x   = '';
				$logo_2x    = '';
				$logo_mini  = '';
				$image_mini = '';
				$class      = '';

				if ( $primary_menu_style == 'style_9' ) {
					$class = 'class="divcenter"';
				}

				if ( ! empty( $option['image_2x'] ) ) {
					$image_2x = $option['image_2x'];
					$logo_2x = sprintf(
						'<a class="retina-logo" href="%s"><img %s src="%s" alt="%s" /></a>',
						home_url(),
						$class,
						esc_url( $image_2x ),
						esc_attr( $name )
					);
				}

				if ( ! empty( $option['image_mini'] ) ) {
					$image_mini = $option['image_mini'];
					$logo_mini  = ' data-sticky-logo="' . esc_url( $image_mini ) . '"';
					$logo_mini .= ' data-mobile-logo="' . esc_url( $image_mini ) . '"';
				}

				printf(
					'<a class="standard-logo" href="%s" %s><img %s src="%s" alt="%s" /></a> %s',
					home_url(),
					$logo_mini,
					$class,
					esc_url( $image_1x ),
					esc_attr( $name ),
					$logo_2x
				);
				break;
		} // End switch().
	} // End if().

	echo '</div><!-- #logo (end) -->';
}

/**
 * Mini posts list
 *
 * @since 1.0.0
 */
function anva_mini_posts_list( $number = 3, $orderby = 'date', $order = 'date', $thumbnail = true ) {

	global $post;

	$output = '';

	$args = array(
		'posts_per_page' => $number,
		'post_type'      => array( 'post' ),
		'orderby'        => $orderby,
		'order'          => $order,
	);

	$query = anva_get_posts( $args );

	$output .= '<ul class="widget-posts-list">';

	while ( $query->have_posts() ) {
		$query->the_post();

		if ( $thumbnail ) {
			$output .= '<li class="sm-post small-post clearfix">';
			$output .= '<div class="entry-image">';
			$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a>';
			$output .= '</div><!-- .entry-image (end) -->';
		} else {
			$output .= '<li class="sm-post small-post clearfix">';
		}

		$output .= '<div class="entry-c">';
		$output .= '<div class="entry-title">';
		$output .= '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
		$output .= '</div><!-- .entry-title (end) -->';
		$output .= '<div class="entry-meta">';
		$output .= '<span class="date">' . get_the_time( 'jS F Y' ) . '</span>';
		$output .= '</div><!-- .entry-meta (end) -->';
		$output .= '</div><!-- .entry-c (end) -->';
		$output .= '</li><!-- .mini-posts (end) -->';
	}

	wp_reset_postdata();

	$output .= '</ul>';

	echo $output;

}

/**
 * Output single single pagination for blog posts.
 *
 * @since 1.0.0
 * @param string $query Query object.
 */
function anva_single_pagination( $query= '' ) {
	echo anva_get_single_pagination( $query );
}

/**
 * Get single pagination for blog posts.
 *
 * @since  1.0.0
 * @param  string $query
 * @return string $output HTML markup.
 */
function anva_get_single_pagination( $query = '' ) {

	$output = '';
	$query  = 0;

	if ( ! empty( $query ) && is_object( $query ) ) {
		$query = $query->max_num_pages;
	}

	$prev_label = anva_get_local( 'prev' );
	$next_label = anva_get_local( 'next' );

	$prev_link = get_previous_posts_link( $prev_label, $query );
	$next_link = get_next_posts_link( $next_label, $query );

	if ( $prev_link || $next_link ) {
		$output .= '<ul id="posts-navigation" class="pager clearfix">';
		$output .= '<li class="previous">' . $prev_link . '</li>';
		$output .= '<li class="next">' . $next_link . '</li>';
		$output .= '</ul>';

		return $output;
	}

	return  '';
}

/**
 * Print blog post number pagination.
 *
 * @global $paged
 * @global $wp_query
 *
 * @since 1.0.0
 * @param string  $pages
 * @param integer $range
 */
function anva_num_pagination( $pages = '', $range = 2 ) {
	echo anva_get_num_pagination( $pages, $range );
}

/**
 * Blog post number pagination.
 *
 * @global $paged
 *
 * @since 1.0.0
 * @param string  $pages
 * @param integer $range
 */
function anva_get_num_pagination( $pages = '', $range = 2 ) {

	$showitems = ( $range * 2) + 1;

	global $paged;

	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( $pages == '' ) {

		global $wp_query;

		$pages = $wp_query->max_num_pages;

		if ( ! $pages ) {
			$pages = 1;
		}
	}

	$output = '';

	if ( 1 != $pages ) {
		$output .= "<nav id='pagination'>";
		$output .= "<ul class='pagination clearfix'>";

		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
			$output .= "<li><a href='" . get_pagenum_link( 1 ) . "'>&laquo;</a></li>";
		}

		if ( $paged > 1 && $showitems < $pages ) {
			$output .= "<li><a href='" . get_pagenum_link( $paged - 1 ) . "'>&lsaquo;</a></li>";
		}

		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages &&( ! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) ) {
				$output .= ($paged == $i) ? "<li class='active'><a href='#'>" . $i . "<span class='sr-only'>(current)</span></a></li>" : "<li><a href='" . get_pagenum_link( $i ) . "'>" . $i . '</a></li>';
			}
		}

		if ( $paged < $pages && $showitems < $pages ) {
			$output .= "<li><a href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a></li>";
		}

		if ( $paged < $pages - 1 &&  $paged + $range - 1 < $pages && $showitems < $pages ) {
			$output .= "<li><a href='" . get_pagenum_link( $pages ) . "'>&raquo;</a></li>";
		}

		$output .= "</ul>\n";
		$output .= '</nav>';
	}

	return apply_filters( 'anva_num_pagination_html', $output );
}

/**
 * Blog comment pagination.
 *
 * @since 1.0.0
 */
function anva_comment_pagination() {
	if ( 1 < get_comment_pages_count() && get_option( 'page_comments' ) ) :
	?>
	<nav <?php anva_attr( 'comment-nav' ); ?>>
		<div class="previous nav-previous">
			<?php previous_comments_link( anva_get_local( 'comment_prev' ) ); ?>
		</div>

		<span class="page-numbers">
			<?php
			printf(
				esc_html__( 'Page %1$s of %2$s', 'anva' ),
				get_query_var( 'cpage' ) ? absint( get_query_var( 'cpage' ) ) : 1, get_comment_pages_count() );
			?>
		</span>

		<div class="next nav-next">
			<?php next_comments_link( anva_get_local( 'comment_next' ) ); ?>
		</div>
	</nav><!-- #comment-nav-above (end) -->
	<?php
	endif;
}

/**
 * Password form.
 *
 * @global $post
 *
 * @since  1.0.0
 * @return string|html $o
 */
function anva_password_form() {

	global $post;

	$label   = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$output  = '<form class="form-inline password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
	$output .= '<i class="icon-lock"></i>';
	$output .= '<p class="lead">' . __( 'To view this protected post, enter the password below:', 'anva' ) . '</p>';
	$output .= '<div class="form-group">';
	$output .= '<label for="' . $label . '">' . __( 'Password', 'anva' ) . ' </label>';
	$output .= '<input class="form-control" name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" />';
	$output .= '</div>';
	$output .= '<input class="btn btn-default" type="submit" name="Submit" value="' . esc_attr__( 'Submit', 'anva' ) . '" />';
	$output .= '</form>';

	return $output;
}

/**
 * Display the comment list.
 *
 * @global $comment
 *
 * @since  1.0.0
 * @param  $comment
 * @param  $args
 * @param  $depth
 */
function anva_comment_list_callback( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	?>
	<li <?php anva_attr( 'comment' ); ?>>
		<div id="comment-wrap-<?php comment_ID() ?>" class="comment-wrap clearfix">
			<div class="comment-meta">
				<div class="comment-author vcard">
					<div class="comment-avatar clearfix">
						<a href="<?php echo comment_author_url( $comment->comment_ID ); ?>">
							<?php
								if ( $args['avatar_size'] != 0 ) {
								echo get_avatar( $comment, 64 );
								}
							?>
						</a>
					</div>
				</div>
			</div>

			<div class="comment-content clearfix">
				<div <?php anva_attr( 'comment-author' ); ?>>

					<?php echo get_comment_author_link(); ?>

					<?php
						if ( $comment->user_id === $GLOBALS['post']->post_author ) {
						printf( '<cite>%s</cite>', esc_html__( 'Post Author', 'anva' ) );
						}
					?>

					<span>
						<a <?php anva_attr( 'comment-permalink' ); ?>>
							<?php
							printf(
								'<time %4$s>%1$s %2$s %3$s</time>',
								get_comment_date(),
								esc_html__( 'at', 'anva' ),
								get_comment_time(),
								anva_get_attr( 'comment-published' )
							);

							edit_comment_link( esc_html__( 'Edit', 'anva' ), ' - ', '' );
							?>
						</a>
					</span>
				</div><!-- .comment-author (end) -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation well well-sm">
						<?php esc_html_e( 'Your comment is awaiting moderation.', 'anva' ); ?>
					</em>
				<?php endif; ?>

				<div <?php anva_attr( 'comment-text' ); ?>>
					<?php comment_text(); ?>
				</div><!-- .comment-content (end) -->

				<?php
				$comment_reply = array(
					'depth'      => intval( $GLOBALS['comment_depth'] ),
					'max_depth'  => get_option( 'thread_comments_depth' ),
					'reply_text' => '<i class="icon-reply"></i>',
				);

				$comment_reply_args = array_merge( $args, $comment_reply );

				comment_reply_link( $comment_reply_args );
				?>

			</div><!-- .comment-content (end) -->
		</div><!-- .comment-wrap (end) -->
<?php
}

/**
 * Ends the display of individual comments.
 *
 * @since  1.0.0
 * @return void
 */
function anva_comment_list_end_callback() {
	echo '</li><!-- .comment (end) -->';
}

/**
 * Display breadcrumbs.
 *
 * @since 1.0.0.
 * @param array $args
 */
function anva_the_breadcrumbs( $args = array() ) {
	echo anva_get_breadcrumbs( $args );
}

/**
 * Get breadcrumbs.
 *
 * @global $post
 *
 * @since  1.0.0.
 * @param  array $args
 * @return string $html
 */
function anva_get_breadcrumbs( $args = array() ) {

	// Don't show breadcrumns on front page.
	if ( is_front_page() ) {
		return;
	}

	global $post;

	$defaults = array(
		'separator_icon'      => '/',
		'breadcrumbs_id'      => 'breadcrumb',
		'breadcrumbs_classes' => 'breadcrumb',
		'home_title'          => __( 'Home', 'anva' ),
	);

	$args      = apply_filters( 'anva_get_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
	$separator = '<li class="separator hidden"> ' . esc_attr( $args['separator_icon'] ) . ' </li>';

	// Open the breadcrumbs
	$html = '<ol id="' . esc_attr( $args['breadcrumbs_id'] ) . '" class="' . esc_attr( $args['breadcrumbs_classes'] ) . '">';

	// Add Homepage link & separator (always present)
	$html .= '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . esc_attr( $args['home_title'] ) . '">' . esc_attr( $args['home_title'] ) . '</a></li>';
	$html .= $separator;

	// Post
	if ( is_singular( 'post' ) ) {

		$category = get_the_category();

		if ( ! empty( $category ) ) {
			$category_values = array_values( $category );
			$last_category   = end( $category_values );
			$cat_parents     = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
			$cat_parents     = explode( ',', $cat_parents );

			foreach ( $cat_parents as $parent ) {
				$html .= '<li class="item-cat">' . wp_kses( $parent, wp_kses_allowed_html( 'a' ) ) . '</li>';
				$html .= $separator;
			}
		} else {
			$html .= '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';
		}
	} elseif ( is_singular( 'page' ) ) {

		if ( $post->post_parent ) {

			$parents = get_post_ancestors( $post->ID );
			$parents = array_reverse( $parents );

			foreach ( $parents as $parent ) {
				$html .= '<li class="item-parent item-parent-' . esc_attr( $parent ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent ) . '" href="' . esc_url( get_permalink( $parent ) ) . '" title="' . get_the_title( $parent ) . '">' . get_the_title( $parent ) . '</a></li>';
				$html .= $separator;
			}
			}

		$html .= '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';

	} elseif ( is_singular( 'attachment' ) ) {

		$parent_id        = $post->post_parent;
		$parent_title     = get_the_title( $parent_id );
		$parent_permalink = esc_url( get_permalink( $parent_id ) );

		$html .= '<li class="item-parent"><a class="bread-parent" href="' . esc_url( $parent_permalink ) . '" title="' . esc_attr( $parent_title ) . '">' . esc_attr( $parent_title ) . '</a></li>';
		$html .= $separator;
		$html .= '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';

	} elseif ( is_singular() ) {

		$post_type         = get_post_type();
		$post_type_object  = get_post_type_object( $post_type );
		$post_type_archive = get_post_type_archive_link( $post_type );

		$html .= '<li class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></li>';
		$html .= $separator;
		$html .= '<li class="active item-' . $post->ID . '">' . $post->post_title . '</li>';

	} elseif ( is_category() ) {

		$parent = get_queried_object()->category_parent;

		if ( $parent !== 0 ) {

			$parent_category = get_category( $parent );
			$category_link   = get_category_link( $parent );

			$html .= '<li class="item-parent item-parent-' . esc_attr( $parent_category->slug ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent_category->slug ) . '" href="' . esc_url( $category_link ) . '" title="' . esc_attr( $parent_category->name ) . '">' . esc_attr( $parent_category->name ) . '</a></li>';
			$html .= $separator;

		}

		$html .= '<li class="active item-cat">' . single_cat_title( '', false ) . '</li>';

	} elseif ( is_tag() ) {
		$html .= '<li class="active item-tag">' . single_tag_title( '', false ) . '</li>';

	} elseif ( is_author() ) {
		$html .= '<li class="active item-author">' . get_queried_object()->display_name . '</li>';

	} elseif ( is_day() ) {
		$html .= '<li class="active item-day">' . get_the_date() . '</li>';

	} elseif ( is_month() ) {
		$html .= '<li class="active item-month">' . get_the_date( 'F Y' ) . '</li>';

	} elseif ( is_year() ) {
		$html .= '<li class="active item-year">' . get_the_date( 'Y' ) . '</li>';

	} elseif ( is_archive() ) {
		$custom_tax_name = get_queried_object()->name;
		$html .= '<li class="active item-archive">' . esc_attr( $custom_tax_name ) . '</li>';

	} elseif ( is_search() ) {
		$html .= '<li class="active item-search">' . __( 'Search results for', 'anva' ) . ': ' . get_search_query() . '</li>';

	} elseif ( is_404() ) {
		$html .= '<li class="item-404">' . __( 'Error 404', 'anva' ) . '</li>';

	} elseif ( is_home() ) {
		$html .= '<li class="item-home">' . get_the_title( get_option( 'page_for_posts' ) ) . '</li>';
	}// End if().

	$html .= '</ol>';
	$html  = apply_filters( 'anva_breadcrumbs_html', $html );

	return wp_kses_post( $html );
}

/**
 * Display gallery masonry.
 *
 * @since 1.0.0
 * @param integer $post_id
 * @param integer $columns
 * @param string  $thumbnail
 */
function anva_gallery_masonry( $post_id, $columns, $thumbnail ) {
	echo anva_get_gallery_masonry( $post_id, $columns, $thumbnail );
}

/**
 * Get gallery masonry.
 *
 * @since 1.0.0
 * @param integer $post_id
 * @param integer $columns
 * @param string  $thumbnail
 */
function anva_get_gallery_masonry( $post_id, $columns, $thumbnail ) {

	$classes   = array();
	$animate   = anva_get_option( 'gallery_animate' );
	$delay     = anva_get_option( 'gallery_delay' );
	$highlight = anva_get_post_meta( '_anva_gallery_highlight' );
	$gallery   = anva_get_post_meta( '_anva_gallery_media' );
	$gallery   = anva_sort_gallery( $gallery ); // Sort gallery attachments
	$html      = '';

	$classes[] = $columns;
	$classes = implode( ' ', $classes );

	// Kill it is not an array.
	if ( ! is_array( $gallery ) ) {
		return;
	}

	$query_args = array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image/jpeg',
		'posts_per_page' => -1,
		'post__in'       => $gallery,
		'orderby'        => 'post__in',
	);

	$query = anva_get_posts( $query_args );

	if ( $query->have_posts() ) {

		$html .= '<div class="gallery-container">';
		$html .= '<div class="masonry-thumbs ' . esc_attr( $classes ) . '" data-lightbox="gallery" data-big="' . esc_attr( $highlight ) . '">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$title      = get_the_title();
			$thumb_full = anva_get_attachment_image_src( get_the_ID(), 'full' );
			$thumb_size = anva_get_attachment_image_src( get_the_ID(), $thumbnail );

			$html .= '<a href="' . esc_url( $thumb_full ) . '" title="' . esc_attr( $title ) . '" data-animate="' . esc_attr( $animate ) . '" data-delay="' . esc_attr( $delay ) . '" data-lightbox="gallery-item">';
			$html .= '<img class="gallery-image" src="' . esc_attr( $thumb_size ) . '" alt="' . esc_attr( $title ) . '" />';
			$html .= '</a>';

		}

		wp_reset_postdata();

		$html .= '</div><!-- .masonry-thumbs (end) -->';
		$html .= '</div><!-- .gallery-container (end) -->';

	}

	return $html;
}

/**
 * Display gallery slider.
 *
 * @since  1.0.0
 * @param  integer $post_id
 * @param  string  $thumbnail
 */
function anva_gallery_slider( $post_id, $thumbnail ) {
	echo anva_get_gallery_slider( $post_id, $thumbnail );
}

/**
 * Get gallery slider.
 *
 * @since  1.0.0
 * @param  integer $post_id
 * @param  string  $thumbnail
 */
function anva_get_gallery_slider( $post_id, $thumbnail ) {

	$gallery = anva_get_post_meta( '_anva_gallery_media' );
	$gallery = anva_sort_gallery( $gallery ); // Sort gallery attachments.
	$html    = '';

	// Kill it is not an array.
	if ( ! is_array( $gallery ) ) {
		return;
	}

	$query_args = array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image/jpeg',
		'posts_per_page' => -1,
		'post__in'       => $gallery,
		'orderby'        => 'post__in',
	);

	$query = anva_get_posts( $query_args );

	$slider  = '<div class="fslider" data-pagi="false" data-arrows="false" data-speed="400" data-pause="4000" data-lightbox="gallery">';
	$slider .= '<div class="flexslider">';
	$slider .= '<div class="slider-wrap">';
	$slider .= "%s\n";
	$slider .= '</div><!-- .slider-wrap (end) -->';
	$slider .= '</div><!-- .flexslider (end) -->';
	$slider .= '</div><!-- .fslider (end) -->';

	$slide = '';

	while ( $query->have_posts() ) {

		$query->the_post();

		$title      = get_the_title();
		$thumb_full = anva_get_attachment_image_src( get_the_ID(), 'full' );
		$thumb_size = anva_get_attachment_image_src( get_the_ID(), $thumbnail );

		$slide .= '<div class="slide">';
		$slide .= sprintf(
			"<a href=\"%s\" data-lightbox=\"gallery-item\">%s</a>\n",
			esc_url( $thumb_full ),
			sprintf(
				"<img src=\"%s\" alt=\"%s\" />\n",
				esc_url( $thumb_size ),
				$title
			)
		);
		$slide .= '</div>';

	}

	$html .= sprintf( $slider, $slide );

	wp_reset_postdata();

	return $html;
}

/**
 * Display sliders.
 *
 * @since 1.0.0
 */
function anva_sliders( $slider ) {

	// Kill it if there's no slider.
	if ( ! $slider ) {
		if ( current_user_can( anva_admin_module_cap( 'options' ) ) ) {
			printf( '<div class="container"><div class="alert alert-warning bottommargin-sm topmargin-sm"><p>%s</p></div></div>', __( 'No slider selected.', 'anva' ) );
		}
		return;
	}

	if ( anva_slider_exists( $slider ) ) {

		// Get sliders data.
		$sliders = anva_get_sliders();

		// Get Slider ID.
		$slider_id = $slider;

		// Gather settings.
		$settings = $sliders[ $slider_id ]['options'];

		// Display slider based on its slider type.
		do_action( 'anva_slider_' . $slider_id, $slider, $settings );

	} elseif ( 'revslider' == $slider ) {
		anva_revolution_slider_default();

	} elseif ( 'layerslider' == $slider ) {
		/**
		 * anva_layer_slider_default()
		 *
		 * @todo create function to support Layer Slider.
		 */
	} else {
		printf(
			'<div class="container"><div class="alert alert-warning bottommargin-sm topmargin-sm">%s</div></div>',
			__( 'No slider found.', 'anva' )
		);
	}

}

/**
 * Get Revolution Slider ID.
 *
 * @since  1.0.0
 * @return void
 */
function anva_revolution_slider_default() {

	if ( ! class_exists( 'RevSliderFront' ) ) {
		printf(
			'<div class="container"><div class="alert alert-warning bottommargin-sm topmargin-sm">%s.</div></div>',
			__( 'Revolution Slider not found, make sure the plugin is installed and activated.', 'anva' )
		);
		return;
	}

	$revslider_id = anva_get_option( 'revslider_id' );

	if ( ! empty( $revslider_id ) ) {
		putRevSlider( $revslider_id );
	}
}

/**
 * Standard slider type.
 *
 * @since  1.0.0
 * @param  string $slider
 * @param  array  $settings
 * @return string $html
 */
function anva_slider_standard_default( $slider, $settings ) {

	// Global Options
	$pause      = anva_get_option( 'standard_pause' );
	$arrows     = anva_get_option( 'standard_arrows' );
	$animation  = anva_get_option( 'standard_fx' );
	$speed      = anva_get_option( 'standard_speed' );
	$thumbs     = anva_get_option( 'standard_thumbs' );
	$grid       = anva_get_option( 'standard_grid' );
	$thumbnail  = 'anva_lg';

	// $defaults = apply_filters( 'anva_slider_standard_defaults', array(
	// 'pause'     => null,
	// 'arrow'     => true,
	// 'animation' => 'fade',
	// 'speed'     => 5000,
	// 'thumbs'    => true,
	// 'thumbnail' => 'anva_lg'
	// );
	// $settings = wp_parse_args( $settings, $defaults );
	// Query arguments.
	$query_args = array(
		'post_type'         => array( 'slideshows' ),
		'order'             => 'ASC',
		'posts_per_page'    => -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );

	$query = anva_get_posts( $query_args );

	// Output.
	$html  = '';
	$data  = '';
	$data .= ' data-animation="' . esc_attr( $animation ) . '"';
	$data .= ' data-thumbs="' . esc_attr( $thumbs ) . '"';
	$data .= ' data-arrows="' . esc_attr( $arrows ) . '"';
	$data .= ' data-speed="' . esc_attr( $speed ) . '"';
	$data .= ' data-pause="' . esc_attr( $pause ) . '"';
	$data .= ' data-smooth-height="true"';

	$classes[] = 'fslider';

	if ( 'true' == $thumbs ) {
		$classes[] = 'flex-thumb-grid';
		$classes[] = $grid;
	}

	$classes = implode( ' ', $classes );

	if ( $query->have_posts() ) {

		$html .= '<div class="' . esc_attr( $classes ) . '" ' . $data . '>';
		$html .= '<div class="flexslider">';
		$html .= '<div class="slider-wrap">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$id      = get_the_ID();
			$title   = get_the_title();
			$desc    = anva_get_post_meta( '_anva_description' );
			$url     = anva_get_post_meta( '_anva_url' );
			$content = anva_get_post_meta( '_anva_content' );
			$image   = anva_get_featured_image_src( $id, 'anva_sm' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';

			$html .= '<div class="slide slide-' . esc_attr( $id ) . '" data-thumb="' . esc_attr( $image ) . '">';

			if ( has_post_thumbnail() ) {

				// Open anchor.
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $thumbnail , array(
					'class' => 'slide-image',
				) );

				// Close anchor.
				if ( $url ) {
					$html .= '</a>';
				}
}

			switch ( $content ) {
				case 'title':
					$html .= sprintf( '<div class="flex-caption slider-caption-bg slider-caption-top-left">%s</div>', esc_html( $title ) );
					break;

				case 'desc':
					$html .= sprintf( '<div class="flex-caption slider-caption-bg slider-caption-top-left">%s</div>', esc_html( $desc ) );
					break;

				case 'both':
					$html .= sprintf( '<div class="flex-caption slider-caption-bg slider-caption-top-left">%s <span>%s</span></div>', esc_html( $title ), esc_html( $desc ) );
					break;
			}

			$html .= '</div>';
		}// End while().

		wp_reset_postdata();

		$html .= '</div><!-- .slider-wrap (end) -->';
		$html .= '</div><!-- .flexslider (end) -->';
		$html .= '</div><!-- .fslider (end) -->';
	}// End if().

	echo $html;
}

/**
 * OWL slider type.
 *
 * @since 1.0.0
 */
function anva_slider_owl_default( $slider, $settings ) {

	$margin         = anva_get_option( 'owl_margin', 0 );
	$items          = anva_get_option( 'owl_items', 1 );
	$pagi           = anva_get_option( 'owl_pagi', 'false' );
	$loop           = anva_get_option( 'owl_loop', 'true' );
	$animate_in     = anva_get_option( 'owl_animate_in' );
	$animate_out    = anva_get_option( 'owl_animate_out' );
	$speed          = anva_get_option( 'owl_speed', 450 );
	$autoplay       = anva_get_option( 'owl_autoplay', 5000 );
	$thumbnail      = 'anva_lg';

	$data = '';

	// Query arguments.
	$query_args = array(
		'post_type'         => array( 'slideshows' ),
		'order'             => 'ASC',
		'posts_per_page'    => -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );

	$query = anva_get_posts( $query_args );

	// Output.
	$html  = '';
	$data  = '';
	$data .= ' data-margin="' . esc_attr( $margin ) . '"';
	$data .= ' data-items="' . esc_attr( $items ) . '"';
	$data .= ' data-pagi="' . esc_attr( $pagi ) . '"';
	$data .= ' data-loop="' . esc_attr( $loop ) . '"';
	$data .= ' data-animate-in="' . esc_attr( $animate_in ) . '"';
	$data .= ' data-animate-out="' . esc_attr( $animate_out ) . '"';
	$data .= ' data-speed="' . esc_attr( $speed ) . '"';
	$data .= ' data-autoplay="' . esc_attr( $autoplay ) . '"';

	$classes[] = 'owl-carousel';
	$classes[] = 'carousel-widget';

	$classes = implode( ' ', $classes );

	if ( $query->have_posts() ) {

		$html .= '<div id="oc-slider" class="' . esc_attr( $classes ) . '" ' . $data . '>';

		while ( $query->have_posts() ) {

			$query->the_post();

			$id      = get_the_ID();
			$title   = get_the_title();
			$desc    = anva_get_post_meta( '_anva_description' );
			$url     = anva_get_post_meta( '_anva_url' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';

			if ( has_post_thumbnail() ) {

				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $thumbnail , array(
					'class' => 'slide-image',
				) );

				if ( $url ) {
					$html .= '</a>';
				}
			}
}

		wp_reset_postdata();

		$html .= '</div><!-- #oc-slider (end) -->';

	}

	echo $html;

}

/**
 * Nivo slider type.
 *
 * @since 1.0.0
 */
function anva_slider_nivo_default( $slider, $settings ) {

	$thumbnail = 'anva_lg';

	// Query arguments.
	$query_args = array(
		'post_type'      => array( 'slideshows' ),
		'order'          => 'ASC',
		'posts_per_page' => -1,
	);

	$query_args = apply_filters( 'anva_slideshows_nivo_query_args', $query_args );

	$query = anva_get_posts( $query_args );

	// Output.
	$html = '';
	$caption = '';

	if ( $query->have_posts() ) {

		$count = 0;
		$html .= '<div class="nivoSlider">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_id = get_the_ID();
			$title   = get_the_title();

			$count++;

			if ( has_post_thumbnail() ) {
				$html .= get_the_post_thumbnail( $post_id, $thumbnail , array(
					'class' => 'slide-image',
					'title' => '#nivocaption' . esc_attr( $count ),
				) );
			}

			$caption .= '<div id="nivocaption' . esc_attr( $count ) . '" class="nivo-html-caption">' . esc_html( $title ) . ' </div>';

		}

		wp_reset_postdata();

		$html .= '</div><!-- .nivoSlider (end) -->';
		$html .= $caption;

	}

	echo $html;
}

/**
 * Boostrap carousel slider type.
 *
 * @since 1.0.0
 */
function anva_slider_bootstrap_default( $slider, $settings ) {

	$thumbnail = 'anva_lg';

	// Query arguments.
	$query_args = array(
		'post_type'      => array( 'slideshows' ),
		'order'          => 'ASC',
		'posts_per_page' => -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );

	$query = anva_get_posts( $query_args );

	// Output.
	$html  = '';
	$count = 0;
	$li    = '';
	$class = '';

	$post_count = count( $query->posts );

	for ( $i = 0; $i < $post_count; $i++ ) {
		if ( 0 == $i ) {
			$class = 'class="' . esc_attr( $class ) . '"';
		}
		$li .= '<li data-target="#bootstrap-carousel" data-slide-to="' . esc_attr( $i ) . '" ' . $class . '></li>';
	}

	// Reset class.
	$class = '';

	if ( $query->have_posts() ) {

		$html .= '<div id="bootstrap-carousel" class="boostrap-carousel carousel slide" data-ride="carousel">';

		$html .= '<ol class="carousel-indicators">';
		$html .= $li;
		$html .= '</ol><!-- .carousel-indicators (end) -->';

		$html .= '<div class="carousel-inner" role="listbox">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_id = get_the_ID();
			$title   = get_the_title();
			$desc    = anva_get_post_meta( '_anva_description' );

			if ( 0 == $count ) {
				$class = 'active';
			}

			$html .= '<div class="item ' . esc_attr( $class ) . '">';

			if ( has_post_thumbnail() ) {
				$html .= get_the_post_thumbnail( $post_id, $thumbnail );
			}

			// $html .= '<div class="carousel-caption">';
			// $html .= '<h3>' . $title . '</h3>';
			// if ( ! empty( $desc ) ) {
			// $html .= '<p>' . $desc . '</p>';
			// }
			// $html .= '</div>';
			$html .= '</div>';

			// Reset class
			$class = '';

			$count++;

		}

		wp_reset_postdata();

		$html .= '</div><!-- .carousel-inner (end) -->';

		$html .= '<a class="left carousel-control" href="#bootstrap-carousel" role="button" data-slide="prev">';
		$html .= '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
		$html .= '<span class="sr-only">Previous</span>';
		$html .= '</a>';
		$html .= '<a class="right carousel-control" href="#bootstrap-carousel" role="button" data-slide="next">';
		$html .= '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
		$html .= '<span class="sr-only">Next</span>';
		$html .= '</a>';

		$html .= '</div><!-- .boostrap-carousel (end) -->';

	}// End if().

	echo $html;

}

/**
 * Swiper slider type.
 *
 * @since 1.0.0
 */
function anva_slider_swiper_default() {
	?>
	<div class="swiper-container swiper-parent">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')"></div>
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')"></div>
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')">
				<div class="slide-container clearfix">
					<div class="slider-caption slider-caption-center">
						<h2 data-caption-animate="fadeInUp">Welcome to Canvas</h2>
						<p data-caption-animate="fadeInUp" data-caption-delay="200">Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on our Canvas.</p>
					</div>
				</div>
			</div>
		</div>

		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>

		<!-- If we need navigation buttons -->
		<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
		<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
	</div>
	<?php
}

/**
 * Camera slider type.
 *
 * @since 1.0.0
 */
function anva_slider_camera_default() {
	?>
	 <div class="camera_wrap" id="camera_wrap_1">
		<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
			<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
				<div class="container">Powerful Layout with Responsive functionality that can be adapted to any screen size.</div>
			</div>
		</div>
		<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
			<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
				<div class="container">Looks beautiful &amp; ultra-sharp on Retina Screen Displays.</div>
			</div>
		</div>
		<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
			<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
				<div class="container">Included 20+ custom designed Slider Pages with Premium Sliders like Layer, Revolution, Swiper &amp; others.</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#camera_wrap_1').camera();
		});
	</script>
	<?php
}
