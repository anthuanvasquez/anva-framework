<?php
/**
 * The default template used for posts navigation.
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

?>
<div class="post-navigation-wrapp">
	<?php
	// Don't print empty markup if there's nowhere to navigate.
	$previous = get_previous_post();
	$next     = get_next_post();

	if ( ! $next && ! $previous ) {
		return;
	}

	$class = '';

	// Align to right.
	if ( ! $previous ) {
		$class = ' fright';
	}
	?>
	<div class="post-navigation clearfix">
		<?php
			if ( $previous ) {
				$previous_title = $previous->post_title;
				previous_post_link( '<div class="post-previous col_half nobottommargin">%link</div>', '&lArr; ' . $previous_title );
			}

			if ( $next ) {
				$next_title = $next->post_title;
				next_post_link( '<div class="post-next col_half col_last nobottommargin tright' . esc_attr( $class ) . '">%link</div>', $next_title . ' &rArr;' );
			}
		?>
	</div><!-- .post-navigation (end) -->
	<div class="line"></div>
</div><!-- .post-navigation-wrap -->
