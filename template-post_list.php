<?php
/*
 Template Name: Post List
 */

 get_header(); ?>

<div class="grid-columns">

	<div class="content-area">
		<div class="main" role="main">
			<?php
				
				$the_query = of_get_post_query();
					
				if ( $the_query->have_posts() ) :
					while ($the_query->have_posts()) : $the_query->the_post();
						get_template_part( 'content', 'post' );
					endwhile;
					
					of_num_pagination($the_query->max_num_pages);
					wp_reset_query();

				endif;
			?>	

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>