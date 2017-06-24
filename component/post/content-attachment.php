<?php
/**
 * The default template used for attachment content.
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
	<article <?php anva_attr( 'post' ); ?>>

		<?php anva_get_template_part( 'post', 'entry-title' ); ?>

		<div class="bottommargin-sm"></div>

		<?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>
			<div class="entry-image">
				<a href="<?php anva_the_attachment_image_src( get_the_ID(), 'full' ); ?>" data-lightbox="image">
					<img src="<?php anva_the_attachment_image_src( get_the_ID(), 'full' ); ?>" />
				</a>
			</div><!-- .entry-image (end) -->
		<?php endif; ?>

		<div <?php anva_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
		</div><!-- .entry-content (end) -->

		<footer class="entry-footer">
			<?php wp_link_pages( array(
				'before' => '<div class="page-link">' . anva_get_local( 'pages' ) . ': ',
				'after'  => '</div><!-- .page-link (end) -->',
			) ); ?>

			<?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link"><i class="icon-edit"></i> ', '</span>' ); ?>
		</footer><!-- .entry-footer (end) -->
	</article><!-- #post-<?php the_ID(); ?> (end) -->
</div><!-- .entry-wrap (end) -->
