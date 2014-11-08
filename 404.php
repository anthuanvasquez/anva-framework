<?php get_header(); ?>

<div class="sidebar-layout">
	<div class="grid-columns">
		<div class="content-area">
			<div class="main" role="main">
				<?php get_template_part( 'content', 'error' ); ?>
			</div><!-- .main (end) -->
		</div><!-- .content-area (end) -->

		<?php get_sidebar(); ?>
		
	</div><!-- .grid-columns (end) -->
</div><!-- .sidebar-layout (end) -->

<?php get_footer(); ?>