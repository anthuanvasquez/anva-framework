<?php
/**
 * The default template used for footer copyrights.
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

$footer_copyright = anva_get_option( 'footer_copyright' );
$footer_copyright = anva_footer_copyright_helpers( $footer_copyright );
$display          = anva_get_option( 'footer_extra_display' );
?>
<div id="copyrights">
	<div class="container clearfix">
		<div class="col_half">
			<div class="copyright-text">
				<?php anva_kses( $footer_copyright ); ?>
			</div>

			<?php anva_get_template_part( 'navigation', 'footer-menu' ); ?>
		</div>

		<div class="col_half col_last tright">
			<div class="fright clearfix">
				<?php
					$args = apply_filters( 'anva_footer_social_icons', array(
						'style'    => null,
						'shape'    => null,
						'border'   => 'borderless',
						'size'     => 'small',
						'position' => null,
						'icons'    => array(),
					) );
					anva_social_icons( $args );
				?>
			</div>

			<div class="clear"></div>

			<?php
			if ( $display ) :
				$text = anva_get_option( 'footer_extra_info' );
				$text = anva_do_icon( $text );
				anva_kses( $text );
			endif;
			?>
		</div>
	</div>
</div><!-- #copyrights (end) -->
