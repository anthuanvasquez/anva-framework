<?php

include_once( 'class-anva-menu-options.php' );
include_once( 'class-anva-main-menu-walker.php' );

add_filter( 'walker_nav_menu_start_el', 'anva_nav_menu_start_el', 10, 4 );
add_action( 'after_setup_theme', 'anva_admin_menu_init', 1001 );

/**
 * Initialize the Anva_Menu_Options instance.
 * 
 * @since 1.0.0
 */
function anva_admin_menu_init() {
	Anva_Menu_Options::get_instance();
}

/**
 * Filter framework items into wp_nav_menu() output.
 *
 * @since  1.0.0
 * @param  string $item_output
 * @param  string $item Object
 * @param  int    $depth
 * @param  array  $args
 * @return string $item_output
 */
function anva_nav_menu_start_el( $item_output, $item, $depth, $args ) {

	// Get primary menu style
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	$primary = apply_filters( 'anva_primary_menu_location', 'primary' );

	// Wrap all menu item title with "div" tag
	if ( is_a( $args->walker, 'Anva_Main_Menu_Walker' ) ) {
		$item_output = str_replace( $item->title, sprintf( '<div>%s</div>', $item->title ), $item_output );

		// Add "description" to all menu items
		// Note: For primary menu will only work on level 1
		if ( 'sub_title' == $primary_menu_style ) {
			if ( strpos( $item_output, $item->title . '</div>' ) !== false && $depth == 0 ) {
				$item_output = str_replace( $item->title . '</div>', sprintf( '%s</div><span>%s</span>', $item->title, $item->description ), $item_output );
			}
		}
		
		// Add "menu-btn" to all menu items in main navigation.
		// Note: If menu item's link was disabled in the walker, the
		// item will already be setup as <span class="menu-btn">Title</span>,
		// which allows styling to match all anchor links with .menu-btn
		$item_output = str_replace( '<a', '<a class="menu-btn"', $item_output );
	}

	// Add "bold" class
	if ( get_post_meta( $item->ID, '_anva_bold', true ) ) {
		if ( strpos( $item_output, 'menu-btn' ) !== false ) {
			$item_output = str_replace( 'menu-btn', 'menu-btn bold', $item_output );
		} else {
			$item_output = str_replace( '<a', '<a class="bold"', $item_output );
		}
	}

	// Allow bootstrap "nav-header" class in menu items.
	// Note: For primary navigation will only work on levels 2-3
	// 
	// (1) ".sf-menu li li.nav-header" 	=> Primary nav dropdowns
	// (2) ".menu li.nav-header" 		=> Standard custom menu widget
	// (3) ".subnav li.nav-header" 		=> Theme Blvd Horizontal Menu widget
	if ( in_array( 'nav-header', $item->classes )  ) {

		$header = sprintf( '<span>%s</span>', apply_filters( 'the_title', $item->title, $item->ID ) );

		if ( strpos( $args->menu_class, 'sf-menu' ) !== false ) {
			// Primary Navigation
			if ( $depth > 0 ) {
				$item_output = $header;
			}
		} else {
			$item_output = $header;
		}
	}

	// Allow bootstrap "divider" class in menu items.
	// Note: For primary navigation will only work on levels 2-3
	if ( in_array( 'divider', $item->classes )  ) {

		if ( strpos( $args->menu_class, 'sf-menu' ) !== false ) {
			// Primary Navigation
			if ( $depth > 0 ) {
				$item_output = '';
			}
		} else {
			$item_output = '';
		}
	}

	// Font icons in menu items
	$icon = '';

	foreach ( $item->classes as $class ) {
		if ( strpos( $class, 'menu-icon-' ) !== false ) {
			$icon = str_replace( 'menu-icon-', '', $class );
		}
	}

	if ( $icon ) {

		$text = apply_filters( 'the_title', $item->title, $item->ID );
		$icon_output = sprintf( '<i class="icon-%s"></i>', $icon );
		$icon_output = apply_filters( 'anva_menu_icon', $icon_output, $icon );

		if ( ! $args->theme_location ) {

			// Random custom menu, probably sidebar widget, insert icon outside <a>
			$item_output = $icon_output . $item_output;

		} else {

			// Theme location, insert icon within <a>
			$item_output = str_replace( $text, $icon_output . $text, $item_output );

		}
	}

	return $item_output;
}