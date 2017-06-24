<?php
/**
 * The default template used for top bar.
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

$top_bar_color  = anva_get_option( 'top_bar_color' );
$top_bar_layout = anva_get_option( 'top_bar_layout', 'menu_icons' );

$class = '';
if ( 'dark' === $top_bar_color ) {
	$class = ' dark';
}
?>
<!-- Top Bar -->
<div id="top-bar" class="top-bar<?php echo esc_attr( $class ); ?>">
	<div class="container clearfix">
		<?php
		$args = apply_filters( 'anva_top_bar_social_icons', array(
			'style'    => null,
			'shape'    => null,
			'border'   => null,
			'size'     => null,
			'position' => 'top-bar',
			'icons'    => array(),
		) );
		switch ( $top_bar_layout ) :
			case 'menu_icons':
			?>
				<!-- Top Links -->
				<div class="col_half nobottommargin">
					<?php anva_get_template_part( 'navigation', 'top-bar-menu' );  ?>
				</div>

				<!-- Top Social -->
				<div class="col_half fright col_last nobottommargin">
					<div id="top-social" class="top-social">
						<ul>
							<?php anva_social_icons( $args ); ?>
						</ul>
					</div><!-- #top-social (end) -->
				</div>
				<?php
				break;

			case 'icons_menu':
			?>
				<!-- Top Social -->
				<div class="col_half nobottommargin">
					<div id="top-social" class="top-social">
						<ul>
							<?php anva_social_icons( $args ); ?>
						</ul>
					</div><!-- #top-social (end) -->
				</div>

				<!-- Top Links -->
				<div class="col_half fright col_last nobottommargin">
					<?php anva_get_template_part( 'navigation', 'top-bar-menu' );  ?>
				</div>
				<?php break;
		endswitch;
		?>
	</div>
</div><!-- #top-bar (end) -->
