<?php
/**
 * The default template used for related posts.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

?>
<div class="related-posts-wrap">
	<h4>
		<?php esc_html_e( 'Related Posts', 'anva' ); ?>
	</h4>

	<div class="related-posts clearfix">
	<?php
		$limit          = 4;
		$count          = 1;
		$column         = 2;
		$open_row       = '<div class="col_half nobottommargin">';
		$open_row_last  = '<div class="col_half nobottommargin col_last">';
		$close_row      = '</div><!-- .col_half (end) -->';
		$single_related = anva_get_option( 'single_related', 'hide' );

		// IDs.
		$ids = array();

		// Query arguments.
		$query_args = array(
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'rand',
		);

		// Set by categories.
		if ( 'cat' === $single_related ) {
			$categories = wp_get_post_terms( get_the_ID(), 'category', array(
				'fields' => 'ids',
			) );
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'terms'    => $categories,
				),
			);
		}

		// Set by tag.
		if ( 'tag' === $single_related ) {
			$tags = wp_get_post_terms( get_the_ID(), 'post_tag', array(
				'fields' => 'ids',
			) );
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'post_tag',
					'terms'    => $tags,
				),
			);
		}

		$query = anva_get_posts( $query_args );

		if ( $query->have_posts() ) : ?>

			<?php while ( $query->have_posts() ) :
				$query->the_post(); ?>

				<?php if ( 1 == $count ) : echo $open_row; endif ?>

				<div class="mpost clearfix">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-image">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'anva_xs', array(
	'title' => get_the_title(),
) ); ?>
							</a>
						</div><!-- .entry-image (end) -->
					<?php endif; ?>
					<div class="entry-c">
						<?php anva_get_template_part( 'post', 'entry-title-mpost' ); ?>
						<ul class="entry-meta clearfix">
							<li>
								<i class="icon-calendar3"></i> <?php the_time( 'jS F Y' ); ?>
							</li>
							<li>
								<a href="<?php the_permalink(); ?>/#comments">
									<i class="icon-comments"></i> <?php echo get_comments_number(); ?>
								</a>
							</li>
						</ul><!-- entry-meta (end) -->
						<div class="entry-content">
							<?php anva_the_excerpt( 90 ); ?>
						</div><!-- .entru-content (end) -->
					</div><!-- .entry-c (end) -->
				</div><!-- .mpost (end) -->

				<?php if ( 0 == $count % $column ) : echo $close_row; endif ?>
				<?php if ( $count % $column == 0 && $limit != $count ) : echo $open_row_last;
endif; ?>

				<?php $count++; ?>

			<?php endwhile; ?>

			<?php if ( ( $count - 1 ) != $limit ) : echo $close_row;
endif; ?>

		<?php else :

			esc_html_e( 'Not Posts Found', 'anva' );

		endif;

		wp_reset_postdata();
	?>
	</div><!-- .related-posts (end) -->
</div><!-- related-posts-wrap (end) -->
