<?php get_header(); ?>

<div id="sidebar-layout">
	<div class="sidebar-layout-inner">
		<div class="row grid-columns">
			<div class="content-area col-sm-8">
				<div class="inner">

				<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'post' );
						endwhile;
						
						of_num_pagination();
						
					else :
						get_template_part( 'content', 'none' );
					endif;
				?>

				</div><!-- .inner (end) -->
			</div><!-- .content-area (end) -->
			
			<?php get_sidebar(); ?>
			
		</div><!-- .grid-columns (end) -->
	</div><!-- .sidebar-layout-inner (end) -->
</div><!-- #sidebar-layout (end) -->

<?php get_footer(); ?>