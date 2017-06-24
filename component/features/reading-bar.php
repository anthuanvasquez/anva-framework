<?php
/**
 * The default template used for post reading bar.
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

$reading_bar_position = anva_get_option( 'single_post_reading_bar_position', 'bottom' );
$class = '';
if ( 'top' === $reading_bar_position ) {
	$class = ' bar-top';
}
?>
<div id="post-reading-wrap">
	<div class="post-reading-bar<?php echo esc_attr( $class ); ?>">
		<div class="post-reading-indicator-container">
			<span class="post-reading-indicator-bar"></span>
		</div>

		<div class="container clearfix">
			<div class="spost clearfix notopmargin nobottommargin">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-image">
						<?php the_post_thumbnail( 'thumbnail' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-c">
					<div class="post-reading-label">
						<?php esc_html_e( 'You Are Reading', 'anva' ); ?>
					</div>
					<div class="entry-title">
						<h4><?php the_title(); ?></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- #post-reading-wrap (end) -->
