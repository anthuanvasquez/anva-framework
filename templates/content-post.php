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
		
		<?php anva_the_post_thumbnail( anva_get_option( 'primary_thumb' ) ); ?>
		
		<div class="entry-title">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</div><!-- .entry-title (end) -->
		
		<?php do_action( 'anva_posts_meta' ); ?>
		
		<div class="entry-content">
			<?php do_action( 'anva_posts_content' ); ?>
		</div><!-- .entry-content (end) -->
		
		<div class="entry-footer clearfix">
			<?php do_action( 'anva_posts_footer' ); ?>
		</div><!-- .entry-footer (end) -->
		
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .entry-wrap (end) -->