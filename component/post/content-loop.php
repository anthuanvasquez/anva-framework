<?php
/**
 * The default template used for posts loop.
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

if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/**
		 * Include the template for the content.
		 */
		anva_get_template_part( 'post', 'content' );

	endwhile;

	/**
	 * Include the template for pagination.
	 */
	anva_get_template_part( 'post', 'pagination' );

else :

	/**
	 * Include the template for none content.
	 */
	anva_get_template_part( 'post', 'content-none' );

endif;
