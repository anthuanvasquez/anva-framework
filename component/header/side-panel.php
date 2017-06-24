<?php
/**
 * The default template used for side panel.
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

$class            = '';
$side_panel_color = anva_get_option( 'side_panel_color' );

if ( 'dark' === $side_panel_color ) {
	$class = 'dark';
}

if ( 'custom' === $side_panel_color ) {
	$class = 'dark side-panel-has-custom';
}
?>
<div class="body-overlay"></div>

<div id="side-panel" class="<?php echo esc_attr( $class ); ?>">
	<div id="side-panel-trigger-close" class="side-panel-trigger">
		<a href="#">
			<i class="icon-line-cross"></i>
		</a>
	</div>

	<div class="side-panel-wrap">
		<?php wp_nav_menu( anva_get_wp_nav_menu_args( 'side_panel' ) );  ?>
		<?php anva_display_sidebar( 'side_panel_sidebar' ); ?>
	</div>
</div>
