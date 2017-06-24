<?php
/**
 * The default template used for search result content.
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

		<?php anva_get_tenplate_part( 'post', 'entry-title' ); ?>

		<?php
			/**
			 * Hooked
			 *
			 * @see anva_post_meta_default
			 */
			do_action( 'anva_post_meta' );
		?>

		<div <?php anva_attr( 'entry-content' ); ?>>
			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_post_content_default
				 */
				do_action( 'anva_post_content' );
			?>

			<footer class="entry-footer clearfix">
				<?php
					/**
					 * Hooked
					 *
					 * @see anva_post_tags_default, anva_post_share_default
					 */
					do_action( 'anva_post_footer' );
				?>
			</footer>
		</div><!-- .entry-content (end) -->

	</article><!-- .entry (end) -->
</div><!-- .entry-wrap (end) -->
