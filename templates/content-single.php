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
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>

	<div class="entry-title">
		<h2><?php the_title(); ?></h2>
	</div><!-- .entry-title (end) -->

	<?php do_action( 'anva_posts_meta' ); ?>

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

        <?php anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>

    <?php endif; ?>

	<div class="entry-content notopmargin">
		<?php the_content(); ?>
	</div><!-- .entry-content (end) -->

	<div class="entry-footer">
		<?php do_action( 'anva_posts_footer' ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . anva_get_local( 'pages' ) . ': ', 'after' => '</div><!-- .page-links (end) -->' ) ); ?>
		<?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link"><i class="icon-edit"></i> ', '</span>' ); ?>
	</div><!-- .entry-footer (end) -->

</article><!-- .entry (end) -->

<?php anva_post_nav(); ?>
<?php anva_post_author(); ?>
<?php anva_post_related(); ?>
