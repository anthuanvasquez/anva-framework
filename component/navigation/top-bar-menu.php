<?php
/**
 * The default template used for top bar menu navigation.
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
<nav <?php anva_attr( 'menu', array(), 'top-bar' ); ?>>
	<?php wp_nav_menu( anva_get_wp_nav_menu_args( 'top_bar' ) ); ?>
</nav><!-- .top-links (end) -->
<?php
