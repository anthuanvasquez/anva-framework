<?php
/**
 * The default template used for posts terms.
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

$categories_args = array(
	'taxonomy' => 'category',
	'text'     => esc_html__( 'Posted in', 'anva' ),
	'sep'      => '',
);

$tags_args = array(
	'taxonomy' => 'post_tag',
	'text'     => esc_html__( 'Tagged', 'anva' ),
	'sep'      => '',
);

anva_post_terms( $categories_args );
anva_post_terms( $tags_args );
