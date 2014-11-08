<?php get_header(); ?>

<?php
	$classes = '';
	$sidebar = of_get_post_meta('_sidebar_column');

	if ( 'left' == $sidebar || 'double_left' == $sidebar ) {
		$classes = 'content-area right';

	} elseif ( 'right' == $sidebar || 'double_right' == $sidebar  ) {
		$classes = 'content-area left';

	} elseif ( 'double' == $sidebar ) {
		$classes = 'content-area center';

	} elseif ( 'fullwidth' ) {
		$classes = 'full-width';
	}
?>

<div class="grid-columns">

	<?php of_sidebar_layout_before(); ?>

	<div class="<?php echo esc_html( $classes ); ?>">
		<div class="main" role="main">

			<?php of_post_before(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>
			
			<?php of_post_after(); ?>

				<?php
					$single_comment = of_get_option( 'single_comment' );
					if ( 1 == $single_comment ) :
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					endif;
				?>

			<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php of_sidebar_layout_after(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>