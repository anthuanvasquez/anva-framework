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
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<div class="entry-wrap">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>

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
            </div><!-- .entry-quote (end) -->

        <?php elseif ( has_post_format( 'status' ) ) : ?>

            <div class="entry-image entry-status">
                <?php anva_content_status(); ?>
            </div><!-- .entry-status (end) -->

        <?php else : ?>

            <?php anva_the_post_thumbnail( anva_get_option( 'primary_thumb' ) ); ?>

        <?php endif; ?>
        
        <?php if ( ! has_post_format( anva_post_format_filter() ) ) : ?>
            <div class="entry-title">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div><!-- .entry-title (end) -->
        <?php endif; ?>
        
        <?php do_action( 'anva_posts_meta' ); ?>
        
        <div class="entry-content">
            <?php do_action( 'anva_posts_content' ); ?>
        </div><!-- .entry-content (end) -->
        
        <div class="entry-footer clearfix">
            <?php do_action( 'anva_posts_footer' ); ?>
        </div><!-- .entry-footer (end) -->
        
    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .entry-wrap (end) -->