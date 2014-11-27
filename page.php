<?php get_header(); ?>

<div id="sidebar-layout">
	<div class="sidebar-layout-inner">
		<div class="row grid-columns">
			<div class="content-area col-sm-8">
				<div class="inner">

					<?php of_post_before(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'page' ); ?>

						<?php
							$single_comment = of_get_option( 'single_comment' );
							if ( 1 == $single_comment ) :
								if ( comments_open() || '0' != get_comments_number() ) :
									comments_template();
								endif;
							endif;
						?>

					<?php endwhile; ?>

					<?php of_post_after(); ?>

				</div><!-- .inner (end) -->
			</div><!-- .content-area (end) -->

			<?php of_sidebar_layout_after(); ?>
	
		</div><!-- .grid-columns (end) -->
	</div><!-- .sidebar-layout-inner (end) -->

	<?php
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$ppb_form_data_order = '';
	$ppb_form_item_arr = array();
	$ppb_enable = get_post_meta($current_page_id, 'ppb_enable', true);
	pp_apply_builder($current_page_id);
	?>

</div><!-- #sidebar-layout (end) -->

<?php get_footer(); ?>