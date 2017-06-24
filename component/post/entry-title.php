<?php
/**
 * The default template used for posts title.
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
<div <?php anva_attr( 'entry-title' ); ?>>
	<h2 class="entry-title-heading">
		<a <?php anva_attr( 'entry-permalink' ); ?>>
			<?php the_title(); ?>
		</a>
	</h2>
</div><!-- .entry-title (end) -->
