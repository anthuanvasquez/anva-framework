<?php
/*
 Template Name: Products
 */
?>

<?php get_header(); ?>

<div class="grid-columns">
	<div class="full-width">
		<div class="main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<header class="entry-header" style="display:none;">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->

		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

</div><!-- .grid-columns (end) -->

<div class="latest-products">
	<div class="special-products">
		<h2 class="h4"><?php echo of_get_local( 'product_featured' ) ?></h2>
		<?php echo do_shortcode( '[featured_products per_page="4" columns="4" orderby="rand"]' ); ?>
	</div>

	<div class="new-products">
		<h2 class="h4"><?php echo of_get_local( 'product_latest' ); ?></h2>
		<?php echo do_shortcode( '[recent_products per_page="4" columns="4" orderby="rand"]' ); ?>
	</div>
</div>

<?php get_footer(); ?>