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
