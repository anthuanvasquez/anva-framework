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
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<div class="entry-wrap">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>

        <div class="entry-title">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div><!-- .entry-title (end) -->

        <div class="bottommargin-sm"></div>

        <?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>
            <div class="entry-image">
                <a href="<?php anva_the_attachment_image_src( get_the_ID(), 'full' ); ?>" data-lightbox="image">
                    <img src="<?php anva_the_attachment_image_src( get_the_ID(), 'full' ); ?>" />
                </a>
            </div><!-- .featured-item(end) -->
        <?php endif; ?>

        
        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->

        <div class="entry-footer">
            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . anva_get_local( 'pages' ) . ': ', 'after' => '</div><!-- .page-link (end) -->' ) ); ?>
            <?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link"><i class="icon-edit"></i> ', '</span>' ); ?>
        </div><!-- .entry-footer (end) -->
    </article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .entry-wrap (end) -->