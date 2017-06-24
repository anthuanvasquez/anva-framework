<?php
/**
 * The default template used for single post content.
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

$single_thumb = anva_get_option( 'single_thumb' );

/**
 * Single above not hooked by default.
 */
do_action( 'anva_post_single_above' );
?>
<div class="entry-wrap">
	<article <?php anva_attr( 'post' ); ?>>

		<div class="entry-title">
			<h2><?php the_title(); ?></h2>
		</div><!-- .entry-title (end) -->

		<?php
			/**
			 * Hooked
			 *
			 * @see anva_post_meta_default
			 */
			do_action( 'anva_post_meta' );
		?>

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

		<?php else : ?>

			<?php
				if ( 'small' !== $single_thumb ) {
					anva_the_post_thumbnail( $single_thumb );
				}
			?>

		<?php endif; ?>

		<div <?php anva_attr( 'entry-content' ); ?>>
			<?php
				if ( 'small' == $single_thumb ) {
					anva_the_post_thumbnail( $single_thumb );
				}

				the_content();
			?>
		</div><!-- .entry-content (end) -->

		<footer class="entry-footer">
			<?php
				/**
				 * Hooked
				 *
				 * @see anva_post_tags_default, anva_post_share_default
				 */
				do_action( 'anva_post_footer' );
			?>

			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . anva_get_local( 'pages' ) . ': ',
				'after'  => '</div><!-- .page-links (end) -->',
			) ); ?>
		</footer><!-- .entry-footer (end) -->
	</article><!-- .entry (end) -->
</div><!-- .entry-wrap (end) -->

<?php
	/**
	 * Hooked
	 *
	 * @see anva_post_nav_default, anva_post_author_default, anva_post_related_default
	 */
	do_action( 'anva_post_single_below' );
?>
