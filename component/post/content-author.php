<?php
/**
 * The default template used for author info.
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
<div class="author-wrap">
	<?php
	$avatar_size = apply_filters( 'anva_author_avatar_size', '96' );
	$post_id     = get_the_ID();
	$id          = get_post_field( 'post_author', $post_id );
	$avatar      = get_avatar( $id, $avatar_size );
	$url         = get_author_posts_url( $id );
	$name        = get_the_author_meta( 'display_name', $id );
	$desc        = get_the_author_meta( 'description', $id );
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php printf( '%1$s <span><a href="%2$s">%3$s</a></span>', esc_html__( 'Posted by', 'anva' ), esc_url( $url ), esc_html( $name ) ); ?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="author-image">
				<?php echo $avatar; ?>
			</div>
			<div class="author-description">
				<?php echo esc_html( $desc ); ?>
			</div>
		</div>
	</div><!-- .panel (end) -->
</div><!-- .author-wrap (end) -->

<div class="line"></div>
