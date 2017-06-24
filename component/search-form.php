<?php
/**
 * The default template used for search form.
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
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" name="s" class="form-control search-field" placeholder="<?php anva_local( 'search' ); ?>" value=""  title="<?php anva_local( 'search_for' ); ?>" />
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default search-submit">
				<span class="sr-only">
					<?php anva_local( 'search_for' ); ?>
				</span>
				<i class="icon-search"></i>
			</button>
		</span>
	</div>
</form><!-- .search (end) -->
