<?php
/*
 Template Name: Homepage
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

<div class="homepage-sidebar" role="complementary">
	<div class="grid-columns">
		<?php if ( dynamic_sidebar( 'home-sidebar' ) ) : endif; ?>
	</div><!-- .grid-columns (end) -->
</div><!-- .homepage-sidebar (end) -->

<?php get_footer(); ?>