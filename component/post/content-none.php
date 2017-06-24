<?php
/**
 * The default template used for posts not found.
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
		<div <?php anva_attr( 'entry-content' ); ?>>
			<?php echo wpautop( anva_get_local( 'not_found' ) ); ?>
		</div>
	</article><!-- .entry (end) -->
</div><!-- .entry-wrap (end) -->
