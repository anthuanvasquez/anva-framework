<?php
/**
 * The default template used posts not found.
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
	<article id="post-not-found" class="post post-not-found entry clearfix">
		<div class="entry-content">
			<?php echo wpautop( anva_get_local( 'not_found' ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-not-found (end) -->
</div><!-- .entry-wrap (end) -->