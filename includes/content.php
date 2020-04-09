<?php
/**
 * Functions for post content.
 *
 * @package    AnvaFramework
 * @subpackage Includes
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

/**
 * Blog posts filter by categories.
 *
 * @since 1.0.0.
 */
function anva_blog_post_filters() {

	$column  = apply_filters( 'anva_template_filter_ajax_columns', 3 );
	$items   = apply_filters( 'anva_template_filter_ajax_items', 6 );
	$counter = 0;

	if ( isset( $_POST['items'] ) ) {
		$items = $_POST['items'];
	}

	if ( isset( $_POST['grid'] ) ) {
		$column = $_POST['grid'];
	}

	// Get recent posts
	$args = array(
		'order'       => 'DESC',
		'orderby'     => 'date',
		'post_type'   => array( 'post' ),
		'numberposts' => $items,
	);

	if ( isset( $_POST['cat'] ) && ! empty( $_POST['cat'] ) && 'all' !== $_POST['cat'] ) {
		$args['category_name'] = $_POST['cat'];
	}

	$query = anva_get_posts( $args );

	while ( $query->have_posts() ) : $query->the_post();
		anva_get_template_part( 'grid' );
	endwhile;

	wp_reset_postdata();

	die();
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
 * @return string $content Formatted content.
 */
function anva_get_content( $content ) {
	return apply_filters( 'anva_the_content', $content );
}

/**
 * Use anva_button() function for read more links.
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
 * Outputs a post's taxonomy terms.
 *
 * @since  1.0.0
 * @param  array $args
 * @return void
 */
function anva_post_terms( $args = array() ) {
	echo anva_get_post_terms( $args );
}

/**
 * This funcion is a wrapper for the WordPress `get_the_terms_list()` function.
 * It uses that to build a better post terms list.
 *
 * @since  1.0.0
 * @param  array $args
 * @return string
 */
function anva_get_post_terms( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id'  => get_the_ID(),
		'taxonomy' => 'category',
		'text'     => '%s',
		'before'   => '',
		'after'    => '',
		'wrap'     => '<div %s>%s</div>',
		'sep'      => _x( ', ', 'taxonomy terms separator', 'anva' ),
	);

	$args = wp_parse_args( $args, $defaults );

	$terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

	if ( $terms ) {
		$html .= $args['before'];
		$html .= sprintf(
			$args['wrap'],
			anva_get_attr( 'entry-terms', array(), $args['taxonomy'] ),
			sprintf(
				"<span>{$args['text']}</span> <div class='entry-terms-wrap'>%s</div>",
				$terms
			)
		);
		$html .= $args['after'];
	}

	return $html;
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
