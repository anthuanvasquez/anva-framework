<?php get_header(); ?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main" role="main">
		
		<?php woocommerce_content(); ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php if ( ! is_single() ) : ?>
		
		<div class="widget-area shop-sidebar" role="complementary">
			<?php if ( dynamic_sidebar( 'shop-sidebar' ) ) : endif; ?>
		</div><!-- .widget-area (end) -->
	
	<?php else : ?>
		
		<div class="widget-area product-sidebar" role="complementary">
			<?php if ( dynamic_sidebar( 'product-sidebar' ) ) : endif; ?>
		</div><!-- .widget-area (end) -->

	<?php endif; ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
