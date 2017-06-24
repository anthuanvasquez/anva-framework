<?php
/**
 * The default template used for breaking news.
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

$breaking = anva_get_option( 'breaking' );
?>
<!-- Breaking -->
<div id="breaking" class="breaking">
	<h2 class="breaking-title">
		<?php esc_html_e( 'Breaking', 'anva' ); ?>
	</h2>
	<?php
	$breaking_categories = anva_get_option( 'breaking_categories' );
	$breaking_items      = anva_get_option( 'breaking_items' );

	if ( empty( $breaking_items ) ) {
		$breaking_items = apply_filters( 'anva_breaking_items_default', 5 );
	}

	$args = array(
		'numberposts'  => $breaking_items,
		'order'        => 'DESC',
		'orderby'      => 'date',
		'category__in' => $breaking_categories,
	);

	$query = anva_get_posts( $args );

	if ( $query->have_posts() ) : ?>
		<div class="breaking-inner">
			<div class="breaking-marquee">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<p class="breaking-entry">
						<a class="breaking-entry-link" href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</p>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>
</div><!-- #breaking (end) -->
<?php
wp_reset_postdata();
