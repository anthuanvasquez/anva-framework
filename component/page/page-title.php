<?php
/**
 * The default template used for page titles.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

$style            = '';
$page_id          = anva_get_current_page_id();
$classes          = array();
$attrs            = array();
$mini             = anva_get_post_meta_by_id( '_anva_page_title_mini', $page_id );
$tagline          = anva_get_post_meta_by_id( '_anva_page_tagline', $page_id );
$title_align      = anva_get_post_meta_by_id( '_anva_title_align', $page_id );
$title_bg         = anva_get_post_meta_by_id( '_anva_title_bg', $page_id );
$title_bg_color   = anva_get_post_meta_by_id( '_anva_title_bg_color', $page_id );
$title_bg_image   = anva_get_post_meta_by_id( '_anva_title_bg_image', $page_id );
$title_bg_cover   = anva_get_post_meta_by_id( '_anva_title_bg_cover', $page_id );
$title_bg_text    = anva_get_post_meta_by_id( '_anva_title_bg_text', $page_id );
$title_bg_padding = anva_get_post_meta_by_id( '_anva_title_bg_padding', $page_id );

// Default page title class.
$classes[] = 'page-title';

// Remove title background.
if ( 'nobg' === $title_bg ) {
	$classes[] = 'page-title-nobg';
}

// Add dark background.
if ( 'dark' === $title_bg || ( 'custom' === $title_bg && $title_bg_text && 'yes' !== $mini ) ) {
	$classes[] = 'page-title-dark';
}

// Use page title mini version.
if ( 'yes' === $mini ) {
	$classes[] = 'page-title-mini';
}

// Add background color and parallax image.
if ( 'custom' === $title_bg && 'yes' !== $mini ) {
	$title_bg_padding = $title_bg_padding . 'px';

	$style .= 'padding:' . esc_attr( $title_bg_padding ) . ' 0;';
	$style .= 'background-color:' . esc_attr( $title_bg_color ) . ';';

	if ( ! empty( $title_bg_image ) ) {
		$classes[] = 'page-title-parallax';
		$style .= 'background-image:url("' . esc_url( $title_bg_image ) . '");';
	}

	if ( $title_bg_cover ) {
		$style .= '-webkit-background-size:cover;';
		$style .= '-moz-background-size:cover;';
		$style .= '-ms-background-size:cover;';
		$style .= 'background-size:cover;';
	}

	$attr['style'] = $style;
}

// Align title to the right.
if ( 'right' === $title_align ) {
	$classes[] = 'page-title-right';
}

// Title centered.
if ( 'center' === $title_align ) {
	$classes[] = 'page-title-center';
}

$attr['class'] = implode( ' ', $classes );
?>
<section <?php anva_attr( 'archive-header' ); ?>>
	<div class="container clearfix">
		<h1 <?php anva_attr( 'archive-title' ); ?>>
			<?php anva_the_page_title(); ?>
		</h1>
		<?php
			if ( ! empty( $tagline ) ) {
				printf( '<span %s>%s</span>', anva_get_attr( 'archive-description' ), esc_html( $tagline ) );
			}

			// Get post types for top navigation.
			$post_types = apply_filters( 'anva_post_types_top_navigation', array(
				'portfolio',
				'galleries',
			) );

			if ( is_singular( $post_types ) ) {
				/**
				 * Hooked.
				 *
				 * @see anva_post_type_navigation_default
				 */
				do_action( 'anva_post_type_navigation' );
			} else {

				$breadcrumbs = anva_get_option( 'breadcrumbs', 'inside' );

				if ( 'inside' === $breadcrumbs ) {

					/**
					 * Hooked.
					 *
					 * @see anva_breadcrumbs_default
					 */
					do_action( 'anva_breadcrumbs' );
				}
			}
		?>
	</div>
</section><!-- #page-title (end) -->
