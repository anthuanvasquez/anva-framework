<?php
/*
 Template Name: Post Grid
 */

get_header();

$grid_columns = of_get_post_meta('_grid_columns');
$classes = 'blog-'.$grid_columns.'-cols';
$size = 'thumbnail_grid_'. $grid_columns;
?>

<div class="grid-columns">
	<div class="full-width">
		<div class="main <?php echo $classes; ?> group" role="main">
			<?php

				$the_query = of_get_post_query();
					
				if ( $the_query->have_posts() ) :
					
					while ( $the_query->have_posts()) : $the_query->the_post();						
					?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								<div class="entry-meta">
									<?php
										$single_meta = of_get_option( 'single_meta' );
										if ( 1 == $single_meta ) :
											of_posted_on();
										endif;
									?>
								</div>
							</header>

							<div class="entry-container group">
								<?php echo of_post_grid_thumbnails( $size ); ?>
								<div class="entry-summary">
									<?php of_excerpt_limit(); ?>
									<a class="button" href="<?php the_permalink(); ?>">
										<?php echo of_get_local( 'read_more' ); ?>
									</a>
								</div>
							</div>
						</article>
					<?php
					endwhile;
					
					of_num_pagination($the_query->max_num_pages);
					wp_reset_query();

				endif;
			?>	

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>