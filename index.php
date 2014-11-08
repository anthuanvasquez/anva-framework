<?php get_header(); ?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main" role="main">

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

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
