<?php
/**
 * The template for displaying the footer.
 *
 * @version 1.0.0
 */
				anva_below_layout();
				?>
				
			</div><!-- .container (end) -->
		</div><!-- .main-content (end) -->
	</section><!-- CONTENT (end) -->

	<?php anva_content_after(); ?>
	
	<!--BOTTOM (start) -->
	<footer id="bottom">

		<?php anva_footer_above(); ?>
		<?php
			$class = '';
			$footer_color = anva_get_option( 'footer_color' );
			if ( $footer_color ) {
				$class = 'class="' . esc_attr( $footer_color ) . '"';
			}
		?>
		
		<div id="footer" <?php echo $class; ?>>
			<div class="footer-content">
				<div class="container clearfix">
					<?php anva_footer_content(); ?>
				</div><!-- .footer-content (end) -->
			</div>

			<div id="copyrights">
				<div class="container clearfix">
					<?php anva_footer_copyrights(); ?>
				</div>
			</div><!-- #copyrights (end) -->
		</div><!-- #footer (end) -->

		<?php anva_footer_below(); ?>

	</footer><!-- BOTTOM (end) -->
	
	<?php anva_bottom_after(); ?>

	</div><!-- CONTAINER (end) -->
</div><!-- WRAPPER (end) -->

<?php anva_after(); ?>
<?php wp_footer(); ?>
</body>
</html>