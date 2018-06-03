<?php
/**
 * The default template used for top shopping cart with
 * woocommernce support.
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

$top_cart = anva_get_option( 'top_cart_display', false );

if ( $top_cart && class_exists( 'WooCommerce' ) ) : ?>
	<!-- Top Cart -->
	<div id="top-cart">
		<a href="#" id="top-cart-trigger">
			<i class="icon-shopping-cart"></i>
			<span>5</span>
		</a>
		<div class="top-cart-content">
			<div class="top-cart-title">
				<h4><?php _e( 'Shopping Cart', 'anva' ); ?></h4>
			</div>
			<div class="top-cart-items">
				<div class="top-cart-item clearfix">
					<div class="top-cart-item-image">
						<a href="#">
							<img src="http://placehold.it/150x150" alt="Blue Round-Neck Tshirt" />
						</a>
					</div>
					<div class="top-cart-item-desc">
						<a href="#">Blue Round-Neck Tshirt</a>
						<span class="top-cart-item-price">$19.99</span>
						<span class="top-cart-item-quantity">x 2</span>
					</div>
				</div>
				<div class="top-cart-item clearfix">
					<div class="top-cart-item-image">
						<a href="#">
							<img src="http://placehold.it/150x150" alt="Light Blue Denim Dress" />
						</a>
					</div>
					<div class="top-cart-item-desc">
						<a href="#">Light Blue Denim Dress</a>
						<span class="top-cart-item-price">$24.99</span>
						<span class="top-cart-item-quantity">x 3</span>
					</div>
				</div>
			</div>
			<div class="top-cart-action clearfix">
				<span class="fleft top-checkout-price">$114.95</span>
				<button class="button button-3d button-small nomargin fright">View Cart</button>
			</div>
		</div>
	</div><!-- #top-cart end -->
<?php endif; ?>
