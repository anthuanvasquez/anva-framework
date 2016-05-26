<?php
/**
 * This template file is a core part of the Woocommerce plugin
 * This file contain extra settings for WooCommerce plugin.
 */

if ( class_exists( 'Woocommerce' ) ) :


    function anva_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    add_action( 'after_setup_theme', 'anva_add_woocommerce_support' );
    
    anva_add_sidebar_location( 'shop', __( 'Shop', 'anva' ), __( 'Woocommerce shop sidebar.', 'anva' ) );
    anva_add_sidebar_location( 'product', __( 'Product', 'anva' ), __( 'Woocommerce Product sidebar.', 'anva' ) );

endif; // End Woocommerce Class Exists