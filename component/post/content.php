<?php
/**
 * The default template used for post content.
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
<div <?php anva_attr( 'entry-wrap' ); ?>>
	<article <?php anva_attr( 'post' ); ?>>

		<header class="entry-header">
			<?php if ( has_post_format( 'gallery' ) ) : ?>

				<div class="entry-image entry-gallery">
					<?php anva_gallery_content(); ?>
				</div><!-- .entry-gallery (end) -->

			<?php elseif ( has_post_format( 'video' ) ) : ?>

				<div class="entry-image entry-video">
					<?php anva_content_video(); ?>
				</div><!-- .entry-video (end) -->

			<?php elseif ( has_post_format( 'audio' ) ) : ?>

				<div class="entry-image entry-audio">
					<?php anva_content_audio(); ?>
				</div><!-- .entry-audio (end) -->

			<?php elseif ( has_post_format( 'quote' ) ) : ?>

				<div class="entry-image entry-quote">
					<?php anva_content_quote(); ?>
				</div><!-- .entry-quote (end) -->

			<?php elseif ( has_post_format( 'link' ) ) : ?>

				<div class="entry-image entry-link-format">
					<?php anva_content_link(); ?>
				</div><!-- .entry-link (end) -->

			<?php elseif ( has_post_format( 'status' ) ) : ?>

				<div class="entry-image entry-status">
					<?php anva_content_status(); ?>
				</div><!-- .entry-status (end) -->

			<?php else : ?>

				<?php anva_the_post_thumbnail( anva_get_option( 'primary_thumb' ) ); ?>

			<?php endif; ?>

			<?php
			if ( ! has_post_format( anva_post_format_not_titles() ) ) :
				anva_get_template_part( 'post', 'entry-title' );
			endif;
			?>

			<?php
				/**
				 * Hooked
				 *
				 * @see anva_post_meta_default
				 */
				do_action( 'anva_post_meta' );
			?>
		</header><!-- .entry-header (end) -->

		<div <?php anva_attr( 'entry-content' ); ?>>
			<?php
				/**
				 * Hooked
				 *
				 * @see anva_post_content_default
				 */
				do_action( 'anva_post_content' );
			?>
		</div><!-- .entry-content (end) -->

		<footer class="entry-footer clearfix">
			<?php
				/**
				 * Hooked
				 *
				 * @see anva_post_tags_default, anva_post_share_default
				 */
				do_action( 'anva_post_footer' );
			?>
		</footer><!-- .entry-footer (end) -->

	</article><!-- #post-<?php the_ID(); ?> (end) -->
</div><!-- .entry-wrap (end) -->
