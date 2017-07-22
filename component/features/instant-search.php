<?php

/**
 * Ajax Search Auto Complete.
 *
 * @global $wpdb
 *
 * @since  1.0.0
 */
function anva_ajax_search() {

	global $wpdb;

	if ( strlen( $_POST['s'] ) > 0 ) {

		$limit  = apply_filters( 'anva_ajax_search_limits', 5 );
		$search = strtolower( addslashes( $_POST['s'] ) );
		$query  = "
			SELECT $wpdb->posts.*
			FROM $wpdb->posts
			WHERE 1 = 1 AND ( ( lower( $wpdb->posts.post_title ) like %s ) )
			AND $wpdb->posts.post_type IN ( 'post', 'page', 'attachment', 'projects', 'galleries' )
			AND ( post_status = 'publish' )
			ORDER BY $wpdb->posts.post_date DESC
			LIMIT $limit;
		";

		$html  = '';
		$posts = $wpdb->get_results(
			$wpdb->prepare( $query, '%' . $wpdb->esc_like( $search ) . '%' ),
			OBJECT
		);

		if ( ! empty( $posts ) ) {

			$html .= '<ul>';

			foreach ( $posts as $post ) {

				$html .= '<li class="spost clearfix">';

				if ( has_post_thumbnail( $post->ID ) ) {
					$html .= '<div class="entry-image">';
					$html .= sprintf( '<a class="nobg" href="%s"><img src="%s" alt="%s" /></a>', get_permalink( $post->ID ), anva_get_featured_image_src( $post->ID, 'thumbnail' ), esc_attr( $post->post_title ) );
					$html .= '</div>';
				}

				$html .= '<div class="entry-c">';
				$html .= '<div class="entry-title">';
				$html .= '<h4><a href="' . get_permalink( $post->ID ) . '">' . esc_html( $post->post_title ) . '</h4>';
				$html .= '</div><!-- .entry-title (end)-->';
				$html .= '<div class="entry-meta clearfix">';
				$html .= '<span>' . get_the_date( 'F j, Y', $post->ID ) . '</span>';
				$html .= '</div>';
				$html .= '</div><!-- .entry-c (end) -->';
				$html .= '</li>';
			}

			$html .= '<li class="view-all"><a href="javascript:jQuery(\'#searchform\').submit()">' . __( 'View All Results', 'anva' ) . '</a></li>';
			$html .= '</ul>';
		}

		echo $html;
	}// End if().

	die();
}
