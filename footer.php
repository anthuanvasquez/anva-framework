<?php
/**
 * The template file for footer.
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
			do_action( 'anva_below_layout' );
		?>
		</div><!-- .content-wrap (end) -->
	</section><!-- CONTENT (end) -->

	<?php do_action( 'anva_content_after' ); ?>

	<?php
		$class = '';
		$footer_color = anva_get_option( 'footer_color', 'dark' );
		if ( $footer_color ) {
			$class = 'class="' . esc_attr( $footer_color ) . '"';
		}
	?>

	<?php do_action( 'anva_footer_above' ); ?>

	<!-- FOOTER (start) -->
	<footer id="footer" <?php echo $class; ?>>

		<div class="container clearfix">
			<?php do_action( 'anva_footer_content' ); ?>
		</div><!-- .container (end) -->

		<div id="copyrights">
			<div class="container clearfix">
				<?php do_action( 'anva_footer_copyrights' ); ?>
			</div>
		</div><!-- #copyrights (end) -->

	</footer><!-- FOOTER (end) -->

	<?php do_action( 'anva_footer_below' ); ?>

</div><!-- WRAPPER (end) -->

<?php do_action( 'anva_after' ); ?>
<?php wp_footer(); ?>
</body>
</html>
