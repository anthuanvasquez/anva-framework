<?php
/**
 * The default template used for top search.
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
<!-- Top Search -->
<div id="top-search">
	<a href="#" id="top-search-trigger">
		<i class="icon-search3"></i>
		<i class="icon-line-cross"></i>
	</a>
	<form role="search" id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" name="s" id="s" class="form-control" autocomplete="off" value="" placeholder="<?php esc_attr_e( 'Type & Hit Enter..', 'anva' ); ?>">
		<?php if ( anva_support_feature( 'anva-instant-search' ) ) : ?>
			<div id="instantsearch" class="hidden"></div>
		<?php endif; ?>
	</form>
</div><!-- #top-search end -->
