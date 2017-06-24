<?php
/**
 * The default template used for post more stories.
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

$previous = get_previous_post();

if ( $previous ) :
	$thumbnail = anva_get_featured_image_src( $previous->ID, 'anva_sm' );
	?>
	<div id="more-story" class="more-story-wrap">
		<button type="button" class="more-story-close">
			<i class="icon-remove"></i>
		</button>

		<div class="more-story-title">
			<h4>
				<?php esc_html_e( 'More Story', 'anva' ); ?>
			</h4>
		</div>

		<div class="ipost clearfix">
			<?php if ( ! empty( $thumbnail ) ) : ?>
				<div class="entry-image">
					<a href="<?php the_permalink( $previous->ID ); ?>">
						<img class="image_fade" src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>" />
					</a>
				</div>
			<?php endif; ?>

			<div class="entry-title">
				<h3>
					<a href="<?php the_permalink( $previous->ID ); ?>">
						<?php echo esc_html( $previous->post_title ); ?>
					</a>
				</h3>
			</div>

			<div class="entry-content">
				<?php
					$content = strip_tags( strip_shortcodes( $previous->post_content ) );
					$content = anva_truncate_string( $content );
					echo wpautop( $content );
				?>
			</div>
		</div>

		<div class="more-story-footer">
			<span class="more-story-date">
				<?php echo date( 'jS F Y', strtotime( $previous->post_date ) ); ?>
			</span>
			<a class="more-link" href="<?php the_permalink( $previous->ID ); ?>">
				<?php anva_local( 'read_more' ); ?> <span class="screen-reader-text"><?php anva_local( 'read_more_about' ); ?></span>
			</a>
		</div>
	</div>
<?php
endif;

wp_reset_postdata();
