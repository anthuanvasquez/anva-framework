<?php
/**
 * The default template used for posts share buttons.
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
<div class="si-share-wrap">
	<?php
	$output    = '';
	$permalink = get_permalink();
	$shortlink = wp_get_shortlink();
	$title     = get_the_title();
	$excerpt   = get_the_excerpt();
	$thumb_url = esc_url( anva_get_featured_image_src( get_the_ID(), 'medium' ) );
	$buttons   = anva_get_share_buttons();
	?>
	<div class="clear"></div>

	<div class="si-share noborder clearfix">
		<span>
			<?php esc_html_e( 'Share this Post', 'anva' ); ?>:
		</span>
		<div class="si-share-inner">
			<?php
			foreach ( $buttons as $button_id => $button ) {

				// Link URL
				$link = '';

				if ( isset( $buttons[ $button_id ] ) ) {

					$link = $buttons[ $button_id ]['url'];

					if ( $buttons[ $button_id ]['encode_urls'] ) {
						$link = str_replace( '[permalink]', rawurlencode( $permalink ), $link );
						$link = str_replace( '[shortlink]', rawurlencode( $shortlink ), $link );
						$link = str_replace( '[thumbnail]', rawurlencode( $thumb_url ), $link );
					} else {
						$link = str_replace( '[permalink]', $permalink, $link );
						$link = str_replace( '[shortlink]', $shortlink, $link );
						$link = str_replace( '[thumbnail]', $thumb_url, $link );
					}

					if ( $buttons[ $button_id ]['encode'] ) {
						$link = str_replace( '[title]', rawurlencode( $title ), $link );
						$link = str_replace( '[excerpt]', rawurlencode( $excerpt ), $link );
					} else {
						$link = str_replace( '[title]', $title, $link );
						$link = str_replace( '[excerpt]', $excerpt, $link );
					}
				}

				$output .= sprintf(
					'<button type="button" class="si-share-button social-icon si-borderless si-%1$s" data-network="%2$s" data-url="%3$s" title="%4$s" data-target="%5$s">
						<i class="icon-%1$s"></i>
						<i class="icon-%1$s"></i>
					</button>',
					esc_attr( $button['icon'] ),
					esc_attr( $button_id ),
					esc_url( $link ),
					esc_attr( $button['text'] ),
					esc_attr( $button['target'] )
				);

			}

			echo $output;
			?>
		</div><!-- .si-share-inner (end) -->
	</div><!-- .si-share (end) -->
</div><!-- .si-share-wrap (end) -->
