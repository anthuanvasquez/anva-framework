<?php
/**
 * The default template used for page content.
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
<div class="entry-wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content (end) -->

		<div class="entry-footer">
			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . anva_get_local( 'pages' ) . ': ',
				'after'  => '</div><!-- .page-links (end) -->',
			) ); ?>

			<?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link"><i class="icon-edit"></i> ', '</span>' ); ?>
		</div><!-- .entry-footer (end) -->
	</article><!-- #post-<?php the_ID(); ?> (end) -->
</div><!-- .entry-wrap (end) -->
