<?php
	get_header();
?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main" role="main">
		
		<?php of_post_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php get_template_part( 'content', 'single' ); ?>
		
		<?php of_post_after(); ?>

			<?php
				$single_comment = of_get_option( 'single_comment' );
				if( 1 == $single_comment ) :
					if( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				endif;
			?>

		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>