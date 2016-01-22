<?php
/**
 * This template file is a core part of the Woocommerce plugin
 * This file contain extra settings for WooCommerce plugin.
 */

if ( class_exists( 'Woocommerce' ) ) :

add_action( 'after_setup_theme', 'anva_add_woocommerce_support' );

/* ---------------------------------------------------------------- */
/* Acitions
/* ---------------------------------------------------------------- */

function anva_woocommerce_sidebar_before() {
	do_action( 'anva_woocommerce_sidebar_before' );
}

function anva_woocommerce_sidebar_after() {
	do_action( 'anva_woocommerce_sidebar_after' );
}

/* ---------------------------------------------------------------- */
/* Add Theme Support
/* ---------------------------------------------------------------- */

function anva_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/* ---------------------------------------------------------------- */
/* Sidebars
/* ---------------------------------------------------------------- */

anva_add_sidebar_location( 'shop', 'Shop', 'Woocommerce shop sidebar.' );

endif; // End Woocommerce Class Exists