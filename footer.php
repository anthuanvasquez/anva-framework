	<?php
/**
 * The Footer for our theme.
 *
 * WARNING: It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @author		Anthuan Vasquez
 * @copyright	Copyright (c) Anthuan Vasquez
 * @link			http://anthuanvasquez.net
 * @package  	WordPress Framework
 */

// After main
of_main_after();

$footer_columns = of_get_option( 'footer_columns', '4' );

?>
	
	<div id="bottom">
		<footer id="footer">
			<div class="footer-inner">
				<div class="footer-content">
					<div class="footer-widget widget-columns-<?php echo $footer_columns; ?>">
						<div class="grid-columns">
							<?php if ( ! dynamic_sidebar( 'footer_sidebar' ) ) : endif; ?>
						</div>
					</div>
				</div>

				<div class="footer-copyright">
					<?php do_action( 'of_footer_copyright' ); ?>
				</div>

			</div><!-- .footer-inner -->
		</footer><!-- #footer (end) -->
	</div><!-- #bottom (end) -->

	</div><!-- #container (end) -->
</div><!-- #wrapper (end) -->

<?php of_layout_after(); ?>
<?php wp_footer(); ?>
</body>
</html>