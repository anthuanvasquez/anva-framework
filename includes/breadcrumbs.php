<?php

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
 * Display breadcrumbs.
 *
 * @since  1.0.0
 * @return void
 */
function anva_breadcrumbs_display_position( $classes ) {
	// Don't show breadcrumbs on front page or builder.
	if ( is_front_page() || is_page_template( 'template_builder.php' ) ) {
		return;
	}

	$classes = implode( ' ', $classes );
	?>
	<section id="breadcrumbs" class="<?php echo esc_attr( $classes ); ?>">
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
