<?php
/**
 * The default template used for read more button.
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
<a class="more-link" href="<?php the_permalink(); ?>">
	<?php
		printf(
		    '%s <span class="screen-reader-text">%s</span>',
			apply_filters( 'anva_the_content_more_text', anva_get_local( 'read_more' ) ),
			anva_get_local( 'read_more_about' )
		);
	?>
</a>
