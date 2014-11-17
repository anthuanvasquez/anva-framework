<?php


/*------------------------------------------------------------*/
/* Header
/*------------------------------------------------------------*/

/**
 * Before any HTML markup for the header.
 */
function of_header_before() {
	do_action( 'of_header_before' );
}

function of_header_after() {
	do_action( 'of_header_after' );
}

function of_header_top() {
	do_action( 'of_header_top' );
}

function of_header_content() {
	do_action( 'of_header_content' );
}

function of_header_menu() {
	do_action( 'of_header_menu' );
}

/*------------------------------------------------------------*/
/* Featured
/*------------------------------------------------------------*/

/**
 * Before any HTML markup for the featured.
 */

function of_featured_before() {
	do_action( 'of_featured_before' );
}

function of_featured_after() {
	do_action( 'of_featured_after' );
}

function of_featured() {
	do_action( 'of_featured' );
}


/*------------------------------------------------------------*/
/* Layout
/*------------------------------------------------------------*/

function of_layout_before() {
	do_action( 'of_layout_before' );
}

function of_layout_after() {
	do_action( 'of_layout_after' );
}

/*------------------------------------------------------------*/
/* Main
/*------------------------------------------------------------*/

function of_main_before() {
	do_action( 'of_main_before' );
}

function of_main_after() {
	do_action( 'of_main_after' );
}

function of_breadcrumbs() {
	do_action( 'of_breadcrumbs' );
}

/*------------------------------------------------------------*/
/* Posts
/*------------------------------------------------------------*/

function of_post_before() {
	do_action( 'of_post_before' );
}

function of_post_after() {
	do_action( 'of_post_after' );
}

/*------------------------------------------------------------*/
/* Sidebars
/*------------------------------------------------------------*/

function of_sidebar_layout_before() {
	do_action( 'of_sidebar_layout_before' );
}

function of_sidebar_layout_after() {
	do_action( 'of_sidebar_layout_after' );
}