<?php
/**
 * The default template used for serach result content.
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

		<?php do_action( 'anva_posts_meta' ); ?>
			
		<div class="entry-content">
			<?php do_action( 'anva_posts_content' ); ?>
			<div class="entry-footer clearfix">
				<?php do_action( 'anva_posts_footer' ); ?>
			</div>
		</div><!-- .entry-content (end) -->
	
	</article><!-- .entry (end) -->
</div><!-- .entry-wrap (end) -->