<?php get_header(); ?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							$string = of_get_local( 'search_for_post' ) . ' %s';
							$query =  get_search_query();
							echo sprintf( $string, $query );
						?>
					</h1>
				</header><!-- .page-header -->
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>
				<?php of_num_pagination(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>