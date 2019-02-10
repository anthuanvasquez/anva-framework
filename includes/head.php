<?php
/**
 * Functions for outputting common site data in the `<head>` area of a site.
 *
 * @package    AnvaFramework
 * @subpackage Includes
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Adds the meta charset to the header.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function anva_meta_charset() {
	printf( '<meta charset="%s" test="h" />' . "\n", esc_attr( get_bloginfo( 'charset' ) ) );
}

/**
 * Adds the meta viewport to the header.
 *
 * @since  1.0.0
 * @access public
 */
function anva_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
}

/**
 * Adds the theme generator meta tag.  This is particularly useful for checking theme users' version
 * when handling support requests.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function anva_meta_generator() {
	$theme     = wp_get_theme( get_template() );
	$generator = sprintf( '<meta name="generator" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );

	echo apply_filters( 'anva_meta_generator', $generator );
}

/**
 * Adds the pingback link to the header.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function anva_link_pingback() {
	if ( 'open' === get_option( 'default_ping_status' ) ) {
        printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}

/**
 * Add the profile link to header.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function anva_link_profile() {
    echo '<link rel="profile" href="https://gmpg.org/xfn/11">' . "\n";
}

/**
 * Print favicon and apple touch icons in head.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function anva_link_apple_touch_icon() {

	$html               = '';
	$sizes              = '';
	$links              = array();
	$favicon            = anva_get_option( 'favicon' );
	$touch_icon_display = anva_get_option( 'apple_touch_icon_display' );

	if ( $favicon ) {
		$links[] = array(
			'rel' => 'shortcut icon',
			'image' => $favicon,
			'size' => '16x16',
		);
	}

	if ( $touch_icon_display ) {

		$touch_icon    = anva_get_option( 'apple_touch_icon' );
		$touch_icon76  = anva_get_option( 'apple_touch_icon_76' );
		$touch_icon120 = anva_get_option( 'apple_touch_icon_120' );
		$touch_icon152 = anva_get_option( 'apple_touch_icon_152' );

		if ( $touch_icon ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon,
			);
		}

		if ( $touch_icon76 ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon76,
				'size' => '76x76',
			);
		}

		if ( $touch_icon120 ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon120,
				'size' => '120x120',
			);
		}

		if ( $touch_icon152 ) {
			$links[] = array(
				'rel' => 'apple-touch-icon',
				'image' => $touch_icon152,
				'size' => '152x152',
			);
		}
	} // End if().

	if ( $links ) {
		foreach ( $links as $link_id => $link ) {
			if ( isset( $link['size'] ) ) {
				$sizes = ' sizes="' . esc_attr( $link['size'] ) . '" ';
			}

			if ( isset( $link['image'] ) ) {
				$html .= sprintf( '<link rel="%s" %s href="%s" />', esc_attr( $link['rel'] ), $sizes, esc_url( $link['image'] ) );
				$sizes = ''; // Reset sizes.
			}
		}
	}

	echo $html;
}
