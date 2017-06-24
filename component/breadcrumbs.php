<?php
/**
 * The default template used for breadcrumbs.
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

// Get current page ID.
$page_id = anva_get_current_page_id();

// Get current breadcrumbs.
$current_breadcrumb = anva_get_post_meta_by_id( '_anva_breadcrumbs', $page_id );

// Set default breadcrumbs.
if ( empty( $current_breadcrumb ) ) {
	$current_breadcrumb = anva_get_option( 'breadcrumbs', 'inside' );
}

// Display breadcrumbs.
if ( 'hide' !== $current_breadcrumb ) {
	anva_the_breadcrumbs();
}
