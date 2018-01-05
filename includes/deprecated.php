<?php

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Run warning if function is deprecated and WP_DEBUG is on.
 *
 * @since  1.0.0
 * @param  string $function
 * @param  string $version
 * @param  string $replacement
 * @param  string $message
 * @return string trigger_error()
 */
function anva_deprecated_function( $function, $version, $replacement = null, $message = null ) {
	if ( WP_DEBUG && apply_filters( 'deprecated_function_trigger_error', true ) ) {
		if ( ! is_null( $message ) ) {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework! %3$s', 'anva' ), $function, $version, $message ) );
		} elseif ( ! is_null( $replacement ) ) {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework! Use %3$s instead.', 'anva' ), $function, $version, $replacement ) );
		} else {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework with no alternative available.', 'anva' ), $function, $version ) );
		}
	}
}
