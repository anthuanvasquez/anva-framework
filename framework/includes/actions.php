<?php

/* ---------------------------------------------------------------- */
/* Site: Before / After
/* ---------------------------------------------------------------- */

/**
 * Before site
 *
 * @since 1.0.0
 */
function anva_before() {
	do_action( 'anva_before' );
}

/**
 * After site
 *
 * @since 1.0.0
 */
function anva_after() {
	do_action( 'anva_after' );
}

/* ---------------------------------------------------------------- */
/* Header
/* ---------------------------------------------------------------- */

/**
 * Before top
 *
 * @since 1.0.0
 */
function anva_top_before() {
	do_action( 'anva_top_before' );
}

/**
 * After top
 *
 * @since 1.0.0
 */
function anva_top_after() {
	do_action( 'anva_top_after' );
}

/**
 * Header above
 *
 * @since 1.0.0
 */
function anva_header_above() {
	do_action( 'anva_header_above' );
}

/**
 * Header below
 *
 * @since 1.0.0
 */
function anva_header_below() {
	do_action( 'anva_header_below' );
}

/**
 * Header logo
 *
 * @since 1.0.0
 */
function anva_header_logo() {
	do_action( 'anva_header_logo' );
}

/**
 * Header extras addons
 *
 * @since 1.0.0
 */
function anva_header_extras() {
	do_action( 'anva_header_extras' );
}

/**
 * Primary menu
 *
 * @since 1.0.0
 */
function anva_header_primary_menu() {
	do_action( 'anva_header_primary_menu' );
}

/**
 * Primary menu addons
 *
 * @since 1.0.0
 */
function anva_header_primary_menu_addon() {
	do_action( 'anva_header_primary_menu_addon' );
}

/**
 * Secondary menu
 *
 * @since 1.0.0
 */
function anva_header_secondary_menu() {
	do_action( 'anva_header_secondary_menu' );
}

/* ---------------------------------------------------------------- */
/* Featured
/* ---------------------------------------------------------------- */

/**
 * Before featured content
 *
 * @since 1.0.0
 */
function anva_featured_before() {
	do_action( 'anva_featured_before' );
}

/**
 * After featured content
 *
 * @since 1.0.0
 */
function anva_featured_after() {
	do_action( 'anva_featured_after' );
}

/**
 * Featured content
 *
 * @since 1.0.0
 */
function anva_featured() {
	do_action( 'anva_featured' );
}

/* ---------------------------------------------------------------- */
/* Footer
/* ---------------------------------------------------------------- */

function anva_bottom_before() {
	do_action( 'anva_bottom_before' );
}

function anva_bottom_after() {
	do_action( 'anva_bottom_after' );
}

function anva_footer_above() {
	do_action( 'anva_footer_above' );
}

function anva_footer_below() {
	do_action( 'anva_footer_below' );
}

function anva_footer_content() {
	do_action( 'anva_footer_content' );
}

function anva_footer_copyrights() {
	do_action( 'anva_footer_copyrights' );
}

/* ---------------------------------------------------------------- */
/* Sidebars
/* ---------------------------------------------------------------- */

function anva_sidebars( $position ) {
	do_action( 'anva_sidebars', $position );
}

/* ---------------------------------------------------------------- */
/* Content
/* ---------------------------------------------------------------- */

function anva_breadcrumbs() {
	do_action( 'anva_breadcrumbs' );
}

function anva_content_before() {
	do_action( 'anva_content_before' );
}

function anva_content_after() {
	do_action( 'anva_content_after' );
}

function anva_above_layout() {
	do_action( 'anva_above_layout' );
}

function anva_below_layout() {
	do_action( 'anva_below_layout' );
}

/* ---------------------------------------------------------------- */
/* Posts
/* ---------------------------------------------------------------- */

function anva_posts_title() {
	do_action( 'anva_posts_title' );
}

function anva_posts_meta() {
	do_action( 'anva_posts_meta' );
}

function anva_posts_content() {
	do_action( 'anva_posts_content' );
}

function anva_posts_footer() {
	do_action( 'anva_posts_footer' );
}

function anva_posts_related() {
	do_action( 'anva_posts_related' );
}

function anva_posts_content_before() {
	do_action( 'anva_posts_content_before' );
}

function anva_posts_content_after() {
	do_action( 'anva_posts_content_after' );
}

function anva_posts_comments() {
	do_action( 'anva_posts_comments' );
}

function anva_comments_before() {
	do_action( 'anva_comments_before' );
}

function anva_comments_after() {
	do_action( 'anva_comments_after' );
}

