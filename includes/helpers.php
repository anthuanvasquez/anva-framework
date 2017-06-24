<?php
/**
 * Additional helper functions that the framework or themes may use.
 *
 * @package    AnvaFramework
 * @subpackage Includes
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

/**
 * Home page args.
 *
 * @since  1.0.0
 * @param  array $args Current arguments.
 * @return array $args Modified arguments.
 */
function anva_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

/**
 * Get args for wp_nav_menu().
 *
 * @since 1.0.0
 * @param string $location
 */
function anva_get_wp_nav_menu_args( $location = 'primary' ) {

	$args = array();

	switch ( $location ) {
		case 'primary' :
			$args = array(
				'theme_location'    => apply_filters( 'anva_primary_menu_location', 'primary' ),
				'container'         => '',
				'container_class'   => '',
				'container_id'      => '',
				'menu_class'        => '',
				'menu_id'           => '',
				'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'       => 'anva_primary_menu_fallback',
			);

			// Add walker to primary menu if mega menu support.
			if ( class_exists( 'Anva_Nav_Menu_Walker' ) ) {
				$args['walker'] = new Anva_Nav_Menu_Walker();
			}

			break;

		case 'top_bar' :
			$args = array(
				'theme_location'	=> apply_filters( 'anva_top_bar_menu_location', 'top_bar' ),
				'container' 		=> '',
				'menu_class'		=> '',
				'fallback_cb' 		=> false,
				'depth' 			=> 1,
			);
			break;

		case 'side_panel' :
			$args = array(
				'theme_location'	=> apply_filters( 'anva_side_panel_menu_location', 'side_panel' ),
				'container'         => 'nav',
				'container_class'   => 'nav-tree',
				'menu_class'		=> '',
				'fallback_cb' 		=> false,
				'depth' 			=> 3,
			);
			break;

		case 'split_menu_1' :
			$args = array(
				'theme_location'	=> apply_filters( 'anva_split_menu_location', 'split_menu_1' ),
				'container'         => '',
				'container_class'   => '',
				'menu_class'		=> '',
				'fallback_cb' 		=> false,
				'depth' 			=> 2,
			);
			break;

		case 'split_menu_2' :
			$args = array(
				'theme_location'	=> apply_filters( 'anva_split_menu_location', 'split_menu_2' ),
				'container'         => '',
				'container_class'   => '',
				'menu_class'		=> '',
				'fallback_cb' 		=> false,
				'depth' 			=> 2,
			);
			break;

		case 'footer' :
			$args = array(
				'theme_location'	=> apply_filters( 'anva_footer_menu_location', 'footer' ),
				'container' 		=> '',
				'menu_class'		=> '',
				'fallback_cb' 		=> false,
				'depth' 			=> 1,
			);
	}

	return apply_filters( "anva_{$location}_menu_args", $args );
}

/**
 * Show message on main navigation when user
 * has not set one.
 *
 * @since  1.0.0
 * @param  array  $args
 * @return string $output
 */
function anva_primary_menu_fallback( $args ) {

	$output = '';

	if ( $args['theme_location'] == apply_filters( 'anva_primary_menu_location', 'primary' ) && current_user_can( 'edit_theme_options' ) ) {
		$output .= sprintf(
			'<div class="menu-message"><strong>%s</strong>: %s</div>',
			esc_html__( 'No Custom Menu', 'anva' ),
			anva_get_local( 'menu_message' )
		);
	}

	/**
	 * If the user doesn't set a nav menu, and you want to make
	 * sure nothing gets outputted, simply filter this to false.
	 * Note that by default, we only see a message if the admin
	 * is logged in.
	 *
	 * @example add_filter( 'anva_menu_fallback', '__return_false' );
	 */
	if ( $output = apply_filters( 'anva_menu_fallback', $output, $args ) ) {
		echo $output;
	}
}

/**
 * Body classes.
 *
 * @since  1.0.0
 * @param  array $classes Current classes.
 * @return array $classes Modified classes.
 */
function anva_body_class( $classes ) {

	$classes[] = 'has-lang-' . strtolower( get_bloginfo( 'language' ) );

	// Group-blog to blogs  with
	// more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$reading_bar = anva_get_option( 'single_post_reading_bar' );
	if ( is_single() && 'show' === $reading_bar ) {
		$reading_bar_position = anva_get_option( 'single_post_reading_position', 'bottom' );
		$classes[] = 'has-reading-bar';
		$classes[] = 'has-reading-bar-' . $reading_bar_position;
	}

	$footer = anva_get_option( 'footer_setup' );
	if (  isset( $footer['num'] ) && $footer['num'] > 0  ) {
		$classes[] = 'has-footer-content';
	}

	if ( is_page_template( 'template-builder.php' ) ) {
		$classes[] = 'has-content-builder';
	}

	if ( anva_get_config( 'featured' ) ) {
		$classes[] = implode( ' ', anva_get_config( 'featured' ) );
	}

	if ( anva_get_config( 'comments' ) ) {
		$classes[] = implode( ' ', anva_get_config( 'comments' ) );
	}

	return apply_filters( 'anva_body_classes', $classes );
}

/**
 * Post classes.
 *
 * @since 1.0.0
 *
 * @param  array $classes Current classes.
 * @return array $classes Modified classes.
 */
function anva_post_class( $classes ) {

	$classes[] = 'entry';
	$classes[] = 'clearfix';

	return apply_filters( 'anva_post_classes', $classes );
}

/**
 * Browser classes.
 *
 * @since  1.0.0
 * @param  array $classes Current classes.
 * @return array $classes Modified classes.
 */
function anva_browser_class( $classes ) {

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return $classes;
	}

	// Get current user agent.
	$browser = $_SERVER['HTTP_USER_AGENT'];

	// OS classes.
	if ( preg_match( "/Mac/", $browser ) ) {
		$classes[] = 'mac';
	} elseif ( preg_match( "/Windows/", $browser ) ) {
		$classes[] = 'windows';
	} elseif ( preg_match( "/Linux/", $browser ) ) {
		$classes[] = 'linux';
	} else {
		$classes[] = 'unknown-os';
	}

	// Browser classes.
	if ( preg_match( "/Chrome/", $browser ) ) {
		$classes[] = 'chrome';
	} elseif ( preg_match( "/Safari/", $browser ) ) {
		$classes[] = 'safari';
	} elseif ( preg_match( "/Opera/", $browser ) ) {
		$classes[] = 'opera';
	} elseif ( preg_match( "/MSIE/", $browser ) ) {

		// Internet Explorer... fuck IE.
		$classes[] = 'msie';

		if ( preg_match( "/MSIE 6.0/", $browser ) ) {
			$classes[] = 'ie6';
		} elseif ( preg_match( "/MSIE 7.0/", $browser ) ) {
			$classes[] = 'ie7';
		} elseif ( preg_match( "/MSIE 8.0/", $browser ) ) {
			$classes[] = 'ie8';
		} elseif ( preg_match( "/MSIE 9.0/", $browser ) ) {
			$classes[] = 'ie9';
		} elseif ( preg_match( "/MSIE 10.0/", $browser ) ) {
			$classes[] = 'ie10';
		} elseif ( preg_match( "/MSIE 11.0/", $browser ) ) {
			$classes[] = 'ie11';
		}

	} elseif ( preg_match( "/Windows NT 10/i", $browser ) && preg_match( "/Edge/i", $browser ) ) {
		$classes[] = 'edge';
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
		$classes[] = 'firefox';
	} else {
		$classes[] = 'unknown-browser';
	}

	// Add "mobile" class if this actually a mobile device.
	if ( wp_is_mobile() ) {
		$classes[] = 'mobile';
	} else {
		$classes[] = 'desktop';
	}

	return apply_filters( 'anva_browser_classes', $classes, $browser );
}

/**
 * Print templates classes.
 *
 * @since  1.0.0
 * @param  string  $class
 * @param  boolean $paged
 * @return string  $classes
 */
function anva_template_class( $class, $paged = true ) {
	echo anva_get_template_class( $class, $paged );
}

/**
 * Get template classes.
 *
 * @since  1.0.0
 * @param  string  $class
 * @param  boolean $paged
 * @return string  $classes
 */
function anva_get_template_class( $class, $paged = true ) {

	$classes = array();
	$small_thumb = anva_get_option( 'small_thumb_alt', 'no' );

	// Set default post classes
	$default_classes = array(
		'index' => array(
			'default' => 'primary-post-list post-list',
			'paged'   => 'post-list-paginated',
		),
		'archive' => array(
			'default' => 'archive-post-list post-list',
			'paged'   => 'post-list-paginated',
		),
		'search' => array(
			'default' => 'search-post-list post-list',
			'paged'   => 'post-list-paginated',
		),
		'grid' => array(
			'default' => 'template-post-grid post-grid grid-container',
			'paged'   => 'post-grid-paginated',
		),
		'list' => array(
			'default' => 'template-post-list post-list post-list-container',
			'paged'   => 'post-list-paginated',
		),
		'small' => array(
			'default' => 'template-post-small post-small post-small-container small-thumbs',
			'paged'   => 'post-small-paginated',
		),
		'masonry' => array(
			'default' => 'template-post-masonry post-masonry post-masonry-container',
			'paged'   => 'post-masonry-paginated',
		),
		'gallery' => array(
			'default' => 'archive-galleries gallery-list gallery-container post-grid',
			'paged'   => 'gallery-paginated',
		),
		'portfolio' => array(
			'default' => 'archive-portfolio portfolio grid-container portfolio-2 clearfix',
			'paged'   => 'portfolio-paginated',
		),
		/**
		 * Add post timeline classes to the list.
		 * @todo timeline classes.
		 */
	);

	// Add default.
	if ( isset( $default_classes[ $class ]['default'] ) ) {
		$classes[] = $default_classes[ $class ]['default'];
	}

	// Posts using pagination.
	if ( isset( $default_classes[ $class ]['paged'] ) && $paged ) {
		$classes[] = $default_classes[ $class ]['paged'];
	}

	if ( 'yes' === $small_thumb ) {
		$classes[] = 'alt';
	}

	$classes = implode( ' ', $classes );

	return apply_filters( 'anva_template_class', $classes );
}

/**
* Display the classes for the header element.
*
* @since 1.0.0
* @param string|array $class
*/
function anva_header_class( $class = '' ) {
	echo 'class="' . join( ' ', anva_get_header_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * @since  1.0.0
 * @param  string|array $class
 * @return array        $classes
 */
function anva_get_header_class( $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
		}
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	// Filter the header class.
	$classes = apply_filters( 'anva_header_class', $classes, $class );

	return array_unique( $classes );
}

/**
* Display the classes for the header element.
*
* @since 1.0.0
* @param string|array $class
*/
function anva_primary_menu_class( $class = '' ) {
	echo 'class="primary-menu ' . join( ' ', anva_get_primary_menu_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * @since  1.0.0
 * @param  string|array $class
 * @return array        $classes
 */
function anva_get_primary_menu_class( $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	// Filter the header class.
	$classes = apply_filters( 'anva_primary_menu_class', $classes, $class );

	return array_unique( $classes );
}

/**
 * Get header styles.
 *
 * @since  1.0.0
 * @return string|boolean
 */
function anva_get_header_type() {

	$types = anva_get_header_types();
	$header_type = anva_get_option( 'header_type', 'default' );

	if ( isset( $types[ $header_type ] ) ) {
		 return $types[ $header_type ]['type'];
	}

	return false;
}

/**
 * Post terms links.
 *
 * @since  1.0.0
 * @param  string $implode
 * @return array  $output
 */
function anva_the_terms_links( $taxonomy, $implode = ' ' ) {
	echo anva_get_terms_links( $taxonomy, $implode );
}

/**
 * Get post terms links.
 *
 * @since  1.0.0
 * @param  string $implode
 * @return array  $output
 */
function anva_get_terms_links( $taxonomy, $implode = ' ', $links = true, $type = 'name' ) {

	// Get post ID.
	$id = get_the_ID();

	// Get post terms by taxonomy and post ID.
	$terms = wp_get_post_terms( $id, $taxonomy, array( 'fields' => 'all' ) );

	if ( empty( $terms ) ) {
		return false;
	}

	$output = array();

	foreach ( $terms as $term ) {

		// Set term type, id, name. slug, etc.
		$term_type = $term->$type;

		// Check if terms will print the links.
		if ( $links ) {
			$output[] = sprintf( '<a href="%1$s">%2$s</a>',
				get_term_link( $term ),
				$term_type
			);
		} else {
			$output[] = $term_type;
		}
	}

	return implode( $implode, $output );

}

/**
 * Print title in WP 4.0-.
 * Enable support in existing themes without breaking backwards compatibility.
 *
 * @since  1.0.0
 * @return string The site title.
 */
function anva_wp_title_compat() {
	// If WP 4.1+
	if ( function_exists( '_wp_render_title_tag' ) ) {
		return;
	}

	add_filter( 'wp_head', 'anva_wp_title' );
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
}
/**
 * Display name and description in title.
 *
 * @since  1.0.0
 * @param  string $title
 * @param  string $sep
 * @return string $title
 */
function anva_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( anva_get_local( 'page' ) .' %s', max( $paged, $page ) );
	}

	return apply_filters( 'anva_wp_title', $title );
}

/**
 * Grabbing a WP nav menu theme location name.
 *
 * @since  1.0.0
 * @param  string $location
 * @return string $location
 */
function anva_get_menu_location_name( $location ) {
	$locations = get_registered_nav_menus();
	return isset( $locations[ $location ] ) ? $locations[ $location ] : '';
}

/**
 * Grabbing a WP nav menu name based on theme location.
 *
 * @since  1.0.0
 * @param  string  $location
 * @return string
 */
function anva_get_menu_name( $location ) {
	$locations = get_nav_menu_locations();
	return isset( $locations[ $location ] ) ? wp_get_nav_menu_object( $locations[ $location ] )->name : '';
}

/**
 * Gets page transition data.
 *
 * @return string $data
 */
function anva_get_page_transition() {

	// Get loader data.
	$data          = '';
	$loader        = anva_get_option( 'page_loader', 1 );
	$color         = anva_get_option( 'page_loader_color' );
	$timeout       = anva_get_option( 'page_loader_timeout', 1000 );
	$speed_in      = anva_get_option( 'page_loader_speed_in', 800 );
	$speed_out     = anva_get_option( 'page_loader_speed_out', 800 );
	$animation_in  = anva_get_option( 'page_loader_animation_in', 'fadeIn' );
	$animation_out = anva_get_option( 'page_loader_animation_out', 'fadeOut' );
	$html          = anva_get_option( 'page_loader_html', '' );

	if ( $loader ) {
		$data['loader']         = esc_attr( $loader );
		$data['loader-color']   = esc_attr( $color );
		$data['loader-timeout'] = esc_attr( $timeout );
		$data['speed-in']       = esc_attr( $speed_in );
		$data['speed-out']      = esc_attr( $speed_out );
		$data['animation-in']   = esc_attr( $animation_in );
		$data['animation-out']  = esc_attr( $animation_out );

		if ( $html ) {
			$data['loader-html'] = anva_get_kses( $html );
		}
	}

	return $data;
}

/**
 * Setup author page.
 *
 * @global $wp_query
 *
 * @since  1.0.0
 */
function anva_setup_author() {
	global $wp_query;
	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}


/**
 * This function is attached to the filter wp_link_pages_args,
 * but won't do anything unless WP version is 3.6+.
 *
 * @since 1.0.0
 * @param array $args Default arguments of wp_link_pages() to filter
 * @return array $args Args for wp_link_pages() after we've altered them
 */
function anva_link_pages_args( $args ) {

	global $wp_version;

	// Before WP 3.6, this filter can't be applied because the
	// wp_link_pages_link filter did not exist yet. Our changes
	// need to come together.
	if ( version_compare( $wp_version, '3.6-alpha', '<' ) ) {
		return $args;
	}

	// Add TB Framework/Bootstrap surrounding markup
	$args['before'] = '<nav class="pagination-wrap"><ul class="pagination page-links">';
	$args['after'] = "</ul></nav>\n";

	return $args;
}

/**
 * This function is attached to the wp_link_pages_link filter,
 * which only exists in WP 3.6+.
 *
 * @since 1.0.0
 * @param string $link Markup of individual link to be filtered
 * @param int $i Page number of link being filtered
 * @return string $link Markup for individual link after being filtered
 */
function anva_link_pages_link( $link, $i ) {

	global $page;

	$class = 'page-link';

	// If is current page
	if ( $page == $i ) {
		$class = ' active';
		$link = sprintf( '<li class="%s"><a href="%s">%s</a></li>', $class, get_pagenum_link( $i ), $i );
	} else {
		$link = '<li>' . $link . '</li>'; // Fuck Link
	}

	return $link;
}

/**
 * Check if a feature is supported by the theme.
 *
 * @since  1.0.0
 * @param  string  $feature
 * @return boolean current theme supprot feature
 */
function anva_support_feature( $feature ) {
	return current_theme_supports( $feature );
}

/**
 * Convert HEX to RGB.
 *
 * @param  string $hex
 * @return array  $color
 */
function anva_hex_to_rgb( $hex ) {

	$hex = str_replace( '#', '', $hex );
	$color = array();

	if ( strlen( $hex ) == 3 ) {
		$color['r'] = hexdec( substr( $hex, 0, 1 ) . $r );
		$color['g'] = hexdec( substr( $hex, 1, 1 ) . $g );
		$color['b'] = hexdec( substr( $hex, 2, 1 ) . $b );
	} elseif ( strlen( $hex ) == 6 ) {
		$color['r'] = hexdec( substr( $hex, 0, 2 ) );
		$color['g'] = hexdec( substr( $hex, 2, 2 ) );
		$color['b'] = hexdec( substr( $hex, 4, 2 ) );
	}

	return $color;
}

/**
 * Print excerpt.
 *
 * @since 1.0.0
 */
function anva_the_excerpt( $length = '' ) {
	echo anva_get_excerpt( $length );
}

/**
 * Get the excerpt and limit chars.
 *
 * @since 1.0.0
 */
function anva_get_excerpt( $length = '' ) {
	$content = get_the_excerpt();
	if ( ! empty( $length ) ) {
		$content = anva_truncate_string( $content, $length );
	}
	$content = wpautop( $content );
	return $content;
}

/**
 * Filter applied on copyright text to allow dynamic variables.
 *
 * @since  1.0.0
 * @param  string $text
 * @return string $text
 */
function anva_footer_copyright_helpers( $text ) {
	$text = str_replace( '%year%', esc_attr( date( 'Y' ) ), $text );
	$text = str_replace( '%site_title%', esc_html( get_bloginfo( 'site_title' ) ), $text );
	return $text;
}

/**
 * Process any font icons passed in as %icon%.
 *
 * @since  1.0.0
 * @param  string $str String to search
 * @return string $str Filtered original string
 */
function anva_do_icon( $string ) {

	preg_match_all( '/\%(.*?)\%/', $string, $icons );

	if ( ! empty( $icons[0] ) ) {

		$list = true;

		if ( substr_count( trim( $string ), "\n" ) ) {
			$list = false; // If text has more than one line, we won't make into an inline list
		}

		$total = count( $icons[0] );

		if ( $list ) {
			$str = sprintf( "<ul class=\"list-inline nobottommargin\">\n<li>%s</li>\n</ul>", $string );
		}

		foreach ( $icons[0] as $key => $val ) {

			$html = apply_filters( 'anva_do_icon_html', '<i class="icon-%s"></i>', $string );

			if ( $list && $key > 0 ) {
				$html = "<li>\n" . $html;
			}

			$str = str_replace( $val, sprintf( $html, $icons[1][$key] ), $string );
		}
	}

	return $string;
}

/**
 * Get font stacks.
 *
 * @since  1.0.0
 * @return array $stacks
 */
function anva_get_font_stacks() {
	$stacks = array(
		'default'     => 'Arial, sans-serif', // Used to chain onto end of google font.
		'arial'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
		'baskerville' => 'Baskerville, "Baskerville Old Face", "Hoefler Text", Garamond, "Times New Roman", serif',
		'georgia'     => 'Georgia, Times, "Times New Roman", serif',
		'helvetica'   => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'lucida'      => '"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif',
		'palatino'    => 'Palatino, "Palatino Linotype", "Palatino LT STD", "Book Antiqua", Georgia, serif',
		'tahoma'      => 'Tahoma, Verdana, Segoe, sans-serif',
		'times'       => 'TimesNewRoman, "Times New Roman", Times, Baskerville, Georgia, serif',
		'trebuchet'   => '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif',
		'verdana'     => 'Verdana, Geneva, sans-serif',
		'google'      => 'Google Font'
	);
	return apply_filters( 'anva_font_stacks', $stacks );
}

/**
 * Limit chars in string.
 *
 * @since  1.0.0
 * @param  $string
 * @param  $length
 * @return $string
 */
function anva_truncate_string( $string, $length = 100 ) {

	if ( ! $string ) {
		return null;
	}

	$string = trim( $string );

	if ( strlen( $string ) <= $length ) {
		return $string;
	}

	$string = substr( $string, 0, $length ) . '...';

	return $string;
}

/**
 * Remove trailing char.
 *
 * @since  1.0.0
 * @param  string $string
 * @param  string $char
 * @return string $string
 */
function anva_remove_trailing_char( $string, $char = ' ' ) {

	if ( ! $string ) {
		return null;
	}

	$offset        = strlen( $string ) - 1;
	$trailing_char = strpos( $string, $char, $offset );

	if ( $trailing_char ) {
		$string = substr( $string, 0, -1 );
	}

	return $string;
}

/**
 * Print font face.
 *
 * @since  1.0.0
 * @param  array $option
 * @return font face name
 */
function anva_the_font_face( $option ) {
	echo anva_get_font_face( $option );
}

/**
 * Get font face.
 *
 * @since  1.0.0
 * @param  array $option
 * @return font face name
 */
function anva_get_font_face( $option ) {

	$stack = '';
	$stacks = anva_get_font_stacks();
	$face = 'helvetica'; // Default font face

	if ( isset( $option['face'] ) && $option['face'] == 'google'  ) {

		// Grab font face, making sure they didn't do the
		// super, sneaky trick of including font weight or type.
		$name = explode( ':', $option['google'] );

		// Check for accidental space at end
		$name = anva_remove_trailing_char( $name[0] );

		// Add the deafult font stack to the end of the google font.
		$stack = $name . ', ' . $stacks['default'];

	} elseif ( isset( $option['face'] ) && isset( $stacks[ $option['face'] ] ) ) {
		$stack = $stacks[ $option['face'] ];

	} else {
		$stack = $stacks[ $face ];
	}

	return apply_filters( 'anva_get_font_face', $stack, $option, $stacks );
}

/**
 * Print font size.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $size
 */
function anva_the_font_size( $option ) {
	echo anva_get_font_size( $option );
}

/**
 * Get font size and set the default value.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $size
 */
function anva_get_font_size( $option ) {

	$size = '14px'; // Default font size

	if ( isset( $option['size'] ) ) {
		$size = $option['size'] . 'px';
	}

	return apply_filters( 'anva_get_font_size', $size, $option );
}

/**
 * Print font style.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $style
 */

function anva_the_font_style( $option ) {
	echo anva_get_font_style( $option );
}

/**
 * Get font style and set the default value.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $style
 */
function anva_get_font_style( $option ) {

	$style = 'normal'; // Default font style

	if ( isset( $option['style'] ) && ( $option['style'] == 'italic' || $option['style'] == 'uppercase-italic' ) ) {
		$style = 'italic';
	}

	return apply_filters( 'anva_get_font_style', $style, $option );
}

/**
 * Print font weight.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $weight
 */
function anva_the_font_weight( $option ) {
	echo anva_get_font_weight( $option );
}

/**
 * Get font weight and set the default value.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $weight
 */
function anva_get_font_weight( $option ) {

	$weight = 'normal';

	if ( ! empty( $option['weight'] ) ) {
		$weight = $option['weight'];
	}

	if ( ! $weight ) {
		$weight = '400';
	}

	return apply_filters( 'anva_get_font_weight', $weight, $option );
}

/**
 * Print font text transform.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $transform
 */
function anva_the_text_transform( $option ) {
	echo anva_get_text_transform( $option );
}

/**
 * Get font text transform.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $transform
 */
function anva_get_text_transform( $option ) {

	$tranform = 'none';

	if ( ! empty( $option['style'] ) && in_array( $option['style'], array('uppercase', 'uppercase-italic') ) ) {
		$tranform = 'uppercase';
	}

	return apply_filters( 'anva_text_transform', $tranform, $option );
}

/**
 * Print background patterns url fron option value.
 *
 * @since  1.0.0
 * @param  string $option
 * @return string $output
 */
function anva_the_background_pattern( $option ) {
	echo anva_get_background_pattern( $option );
}

/**
 * Get background patterns url fron option value.
 *
 * @since  1.0.0
 * @param  string $option
 * @return string $output
 */
function anva_get_background_pattern( $option ) {
	$image = esc_url( get_template_directory_uri() . '/assets/images/patterns/' . $option . '.png' );
	return apply_filters( 'anva_background_pattern', $url );
}

/**
 * Include font from google. Accepts unlimited amount of font arguments.
 *
 * @since  1.0.0
 * @return void
 */
function anva_enqueue_google_fonts() {

	$input = func_get_args();
	$used = array();

	if ( ! empty( $input ) ) {

		// Before including files, determine if SSL is being
		// used because if we include an external file without https
		// on a secure server, they'll get an error.
		$protocol = is_ssl() ? 'https://' : 'http://';

		// Build fonts to include
		$fonts = array();

		foreach ( $input as $font ) {

			if ( $font['face'] == 'google' && ! empty( $font['google'] ) ) {

				$font = explode( ':', $font['google'] );
				$name = trim ( str_replace( ' ', '+', $font[0] ) );

				if ( ! isset( $fonts[ $name ] ) ) {
					$fonts[ $name ] = array(
						'style'		=> array(),
						'subset'	=> array()
					);
				}

				if ( isset( $font[1] ) ) {

					$parts = explode( '&', $font[1] );

					foreach ( $parts as $part ) {
						if ( strpos( $part, 'subset' ) === 0 ) {
							$part = str_replace( 'subset=', '', $part );
							$part = explode( ',', $part );
							$part = array_merge( $fonts[ $name ]['subset'], $part );
							$fonts[ $name ]['subset'] = array_unique( $part );
						} else {
							$part = explode( ',', $part );
							$part = array_merge( $fonts[ $name ]['style'], $part );
							$fonts[ $name ]['style'] = array_unique( $part );
						}
					}
				}
			}
		}

		// Include each font file from google.
		foreach ( $fonts as $font => $atts ) {

			// Create handle.
			$handle = strtolower( $font );
			$handle = str_replace( ' ', '-', $handle );

			if ( ! empty( $atts['style'] ) ) {
				$font .= sprintf( ':%s', implode( ',', $atts['style'] ) );
			}

			if ( ! empty( $atts['subset'] ) ) {
				$font .= sprintf( '&subset=%s', implode( ',', $atts['subset'] ) );
			}

			wp_enqueue_style( $handle, $protocol . 'fonts.googleapis.com/css?family=' . $font, array(), Anva::get_version(), 'all' );

		}
	}
}

/**
 * Get class for buttons.
 *
 * @since  1.0.0
 * @param  string $color Color of button.
 * @param  string $size Size of button.
 * @param  bool   $block Whether the button displays as block (true) or inline (false).
 * @return string $class HTML Class to be outputted into button <a> markup.
 */
function anva_get_button_class( $color = '', $size = '', $style = '', $effect = '', $transition = '', $block = false ) {

	$class = '';

	// Button Size.
	$sizes = apply_filters( 'anva_button_sizes_classes', array(
		'mini',
		'small',
		'medium',
		'large',
		'xlarge',
		'desc'
	) );

	if ( in_array( $size, $sizes ) ) {
		$class .= sprintf( ' button-%s', $size );
	}

	// Buttons styles.
	$styles = apply_filters( 'anva_button_sizes_classes', array(
		'3d',
		'rounded',
		'circle',
		'border',
		'border-thin',
	) );

	if ( in_array( $style, $styles ) ) {
		$class .= sprintf( ' button-%s', $style );
	}

	// Button effects.
	$effects = apply_filters( 'anva_button_effect_classes', array(
		'fill',
		'reveal',
	) );

	if ( in_array( $effect, $effects ) ) {
		$class .= sprintf( ' button-%s', $effect );
	}

	if ( 'fill' === $effect ) {
		$class .= ' ' . $effect . '-from-' . $transition;
	} else {
		if ( 'right' === $transition ) {
			$class .= ' ' . $transition;
		}
	}

	// Button Color.
	if ( ! $color ) {
		$color = '';
	}

	$colors = anva_get_button_colors();
	$colors = array_keys( $colors );

	if ( in_array( $color, apply_filters( 'anva_button_colors_classes', $colors ) ) ) {
		$class .= sprintf( ' button-%s', $color );
	} elseif ( $color == 'custom' ) {
		$class .= ' anva-custom-button';
	} else {
		$class .= sprintf( ' %s', $color );
	}

	// Check is contain a light color.
	if ( in_array( $color, array( 'yellow', 'lime', 'white' ) ) ) {
		$class .= ' button-light';
	}

	// Block Button.
	if ( $block ) {
		$class .= ' button-block';
	}

    return apply_filters( 'anva_button_class', $class, $color, $size );
}

/**
 * Get social media sources and their respective names.
 *
 * @since  1.0.0
 * @return array $profiles
 */
function anva_get_social_icons_profiles() {
	$profiles = array(
		'bitbucket'		=> esc_html__( 'Bitbucket', 'anva' ),
		//'codepen'		=> esc_html__( 'Codepen', 'anva' ),
		'delicious' 	=> esc_html__( 'Delicious', 'anva' ),
		//'deviantart' 	=> esc_html__( 'DeviantArt', 'anva' ),
		'digg' 			=> esc_html__( 'Digg', 'anva' ),
		'dribbble' 		=> esc_html__( 'Dribbble', 'anva' ),
		'facebook' 		=> esc_html__( 'Facebook', 'anva' ),
		'flickr' 		=> esc_html__( 'Flickr', 'anva' ),
		'foursquare' 	=> esc_html__( 'Foursquare', 'anva' ),
		'github' 		=> esc_html__( 'Github', 'anva' ),
		'gplus' 		=> esc_html__( 'Google+', 'anva' ),
		'instagram' 	=> esc_html__( 'Instagram', 'anva' ),
		'linkedin' 		=> esc_html__( 'Linkedin', 'anva' ),
		'paypal' 		=> esc_html__( 'Paypal', 'anva' ),
		'pinterest' 	=> esc_html__( 'Pinterest', 'anva' ),
		'reddit' 		=> esc_html__( 'Reddit', 'anva' ),
		'skype'			=> esc_html__( 'Skype', 'anva' ),
		'soundcloud' 	=> esc_html__( 'Soundcloud', 'anva' ),
		'tumblr' 		=> esc_html__( 'Tumblr', 'anva' ),
		'twitter' 		=> esc_html__( 'Twitter', 'anva' ),
		'vimeo'			=> esc_html__( 'Vimeo', 'anva' ),
		'yahoo' 		=> esc_html__( 'Yahoo', 'anva' ),
		'youtube' 		=> esc_html__( 'YouTube', 'anva' ),
		'call'			=> esc_html__( 'Call', 'anva' ),
		'email3' 		=> esc_html__( 'Email', 'anva' ),
		'rss' 			=> esc_html__( 'RSS', 'anva' ),
	);

	return apply_filters( 'anva_social_icons_profiles', $profiles );
}

/**
 * Get capability for admin module.
 *
 * @since  1.0.0
 * @param  string $module
 * @return string $cap
 */
function anva_admin_module_cap( $module ) {

	// Setup default capabilities.
	$module_caps = array(
		'builder' 	=> 'edit_theme_options', // Role: Administrator
		'options' 	=> 'edit_theme_options', // Role: Administrator
		'backup' 	=> 'manage_options', 	 // Role: Administrator
		'updates' 	=> 'manage_options', 	 // Role: Administrator
	);

	$module_caps = apply_filters( 'anva_admin_module_caps', $module_caps );

	// Setup capability.
	$cap = '';
	if ( isset( $module_caps[ $module ] ) ) {
		$cap = $module_caps[ $module ];
	}

	return $cap;
}

/**
 * Get current year in footer copyright.
 *
 * @since 1.0.0
 */
function anva_get_current_year( $year ) {
	$current_year = date( 'Y' );
	return $year . ( ( $year != $current_year ) ? ' - ' . $current_year : '' );
}

/**
 * Gets the current page ID.
 *
 * @since  1.0.0
 * @return bool|int
 */
function anva_get_current_page_id() {
	$object_id = get_queried_object_id();

	$page_id = false;

	if ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) {
		$page_id = get_option( 'page_for_posts' );
	} else {
		// Use the $object_id if available.
		if ( isset( $object_id ) ) {
			$page_id = $object_id;
		}

		// If we're not on a singular post, set to false.
		if ( ! is_singular() ) {
			$page_id = false;
		}

		// Front page is the posts page.
		if ( isset( $object_id ) && 'posts' == get_option( 'show_on_front' ) && is_home() ) {
			$page_id = $object_id;
		}

		// The woocommerce shop page.
		if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
			$page_id = get_option( 'woocommerce_shop_page_id' );
		}
	}

	return $page_id;
}

/**
 * Compress a chunk of code to output
 *
 * @since 1.0.0
 */
function anva_compress( $buffer ) {

	// Remove comments.
	$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );

	return $buffer;
}

/**
 * Get template framework part component.
 *
 * @since 1.0.0
 * @param string $name
 * @param string $slug
 */
function anva_get_template_part( $slug = 'post', $name = 'content' ) {

	$components = apply_filters( 'anva_components_list', array(
		'page',
		'post',
		'header',
		'footer',
		'navigation',
		'features',
	) );

	$path = apply_filters( 'anva_components_path', trailingslashit( 'framework/component' ) );

	if ( in_array( $slug, $components ) ) {
		$file = trailingslashit( $path . $slug ) . $name;
		get_template_part( $file );
		return;
	}

	get_template_part( $path . $slug );
}

/**
 * Insert a key into array.
 *
 * @param  array   $array
 * @param  string  $search_key
 * @param  string  $insert_key
 * @param  string  $insert_value
 * @param  boolean $insert_after
 * @param  boolean $append
 * @return array   $new_array
 */
function anva_insert_array_key( $array, $search_key, $insert_key, $insert_value, $insert_after = true, $append = false ) {

	if ( ! is_array( $array ) ) {
		return;
	}

	$new_array = array();

	foreach ( $array as $key => $value ) {
		if ( $key === $search_key && ! $insert_after ) {
			$new_array[ $insert_key ] = $insert_value;
		}

		$new_array[ $key ] = $value;

		if ( $key === $search_key && $insert_after ) {
			$new_array[ $insert_key ] = $insert_value;
		}
	}

	if ( $append && count( $array ) == count( $new_array ) ) {
		$new_array[ $insert_key ] = $insert_value;
	}

	return $new_array;

}

/**
 * Convert memory use.
 *
 * @param  int $size
 * @return int $size
 */
function anva_convert_memory_use( $size ) {
	$unit = array( 'b', 'kb', 'mb', 'gb', 'tb', 'pb' );
	return @round( $size / pow( 1024, ( $i = floor( log( $size, 1024 ) ) ) ), 2 ) . ' ' . $unit[ $i ];
}

/**
 * Show debug information.
 *
 * @param  object $object The object given
 * @return void
 */
function anva_dump( $object ) {
	if ( ! is_object( $object ) ) {
		return;
	}

	echo '<pre>';
	print_r( $object );
	echo '</pre>';
}
