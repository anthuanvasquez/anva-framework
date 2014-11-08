	<?php of_content_after(); ?>
	
	<footer id="footer">
		<div class="footer-inner inner">
			
			<div class="footer-content">
				<div class="footer-widget">
					<div class="grid-columns">
						<?php if ( ! dynamic_sidebar( 'footer-sidebar' ) ) : endif; ?>
					</div>
				</div>
			</div>

			<div class="footer-copyright">
				<?php do_action( 'of_footer_copyright' ); ?>
			</div>

		</div>
	</footer><!-- #footer (end) -->

</div><!-- #container (end) -->

<?php wp_footer(); ?>

<?php of_layout_after(); ?>

</body>
</html>