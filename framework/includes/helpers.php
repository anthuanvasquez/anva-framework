<?php

/*-----------------------------------------------------------------------------------*/
/* Helper Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Home page args
 *
 * @since  1.0.0
 * @param  array $args
 * @return array $args
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
 * @param array  $args
 */
function anva_get_wp_nav_menu_args( $location = 'primary' ) {

	$args = array();

	switch ( $location ) {
		case 'primary' :
			$args = array(
				'theme_location'  => apply_filters( 'anva_primary_menu_location', 'primary' ),
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'menu_class'      => '',
				'menu_id'         => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'     => 'anva_primary_menu_fallback'
			);

			// Add walker to primary menu if mega menu support.
			if ( class_exists( 'Anva_Main_Menu_Walker' ) ) {
				$args['walker']   = new Anva_Main_Menu_Walker();
			}

			break;

		case 'top_bar' :
			$args = array(
				'menu_class'		=> '',
				'container' 		=> '',
				'fallback_cb' 		=> false,
				'theme_location'	=> apply_filters( 'anva_top_bar_menu_location', 'top_bar' ),
				'depth' 			=> 1
			);
			break;

		case 'footer' :
			$args = array(
				'menu_class'		=> '',
				'container' 		=> '',
				'fallback_cb' 		=> false,
				'theme_location'	=> apply_filters( 'anva_footer_menu_location', 'footer' ),
				'depth' 			=> 1
			);

	}

	return apply_filters( "anva_{$location}_menu_args", $args );
}

/**
 * Show message on main navigation when user
 * has not set one under Apperance > Menus in the
 * WordPress admin panel.
 *
 * @since  1.0.0
 * @param  array       $args
 * @return string|html $output
 */
function anva_primary_menu_fallback( $args ) {

	$output = '';

	if ( $args['theme_location'] = apply_filters( 'anva_primary_menu_location', 'primary' ) && current_user_can( 'edit_theme_options' ) ) {
		$output .= sprintf( '<div class="menu-message"><strong>%s</strong>: %s</div>', esc_html__( 'No Custom Menu', 'anva' ), anva_get_local( 'menu_message' ) );
	}

	/**
	 * If the user doesn't set a nav menu, and you want to make
	 * sure nothing gets outputted, simply filter this to false.
	 * Note that by default, we only see a message if the admin
	 * is logged in.
	 *
	 * add_filter('anva_menu_fallback', '__return_false');
	 */
	if ( $output = apply_filters( 'anva_menu_fallback', $output, $args ) ) {
		echo $output;
	}
}

/**
 * Body classes.
 *
 * @since  1.0.0
 * @return array $classes
 */
function anva_body_class( $classes ) {

	$classes[] = 'has-lang-' . strtolower( get_bloginfo( 'language' ) );

 	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$single_post_reading_bar = anva_get_option( 'single_post_reading_bar' );
	if ( is_singular( 'post' ) && 'show' == $single_post_reading_bar ) {
		$classes[] = 'has-reading-bar';
	}

	$footer = anva_get_option( 'footer_setup' );
	if (  isset( $footer['num'] ) && $footer['num'] > 0  ) {
		$classes[] = 'has-footer-content';
	}

	if ( is_page_template( 'template_builder.php' ) ) {
		$classes[] = 'page-has-content-builder';
	}

	return apply_filters( 'anva_body_classes', $classes );
}

/**
 * Browser classes.
 *
 * @since  1.0.0
 * @param  array $classes
 * @return array $classes
 */
function anva_browser_class( $classes ) {

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return $classes;
	}

	// Get current user agent
	$browser = $_SERVER['HTTP_USER_AGENT'];

	// OS class
	if ( preg_match( "/Mac/", $browser ) ) {
		$classes[] = 'mac';
	} else if ( preg_match( "/Windows/", $browser ) ) {
		$classes[] = 'windows';
	} else if ( preg_match( "/Linux/", $browser ) ) {
		$classes[] = 'linux';
	} else {
		$classes[] = 'unknown-os';
	}

	// Browser class
	if ( preg_match( "/Chrome/", $browser ) ) {
		$classes[] = 'chrome';
	} else if ( preg_match( "/Safari/", $browser ) ) {
		$classes[] = 'safari';
	} else if ( preg_match( "/Opera/", $browser ) ) {
		$classes[] = 'opera';
	} else if ( preg_match( "/MSIE/", $browser ) ) {

		// Internet Explorer... fuck IE.
		$classes[] = 'msie';

		if ( preg_match( "/MSIE 6.0/", $browser ) ) {
			$classes[] = 'ie6';
		} else if ( preg_match( "/MSIE 7.0/", $browser ) ) {
			$classes[] = 'ie7';
		} else if ( preg_match( "/MSIE 8.0/", $browser ) ) {
			$classes[] = 'ie8';
		} else if ( preg_match( "/MSIE 9.0/", $browser ) ) {
			$classes[] = 'ie9';
		} else if ( preg_match( "/MSIE 10.0/", $browser ) ) {
			$classes[] = 'ie10';
		} else if ( preg_match( "/MSIE 11.0/", $browser ) ) {
			$classes[] = 'ie11';
		}

	} else if ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
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

function anva_post_class( $class, $paged = true ) {
	echo anva_get_post_class( $class, $paged );
}

/**
 * Get post list classes.
 *
 * @since  1.0.0
 * @param  string  $class
 * @param  boolean $paged
 * @return string  $classes
 */
function anva_get_post_class( $class, $paged = true ) {

	$classes = array();

	// Set default post classes
	$default_classes = array(
		'index' => array(
			'default' => 'primary-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'archive' => array(
			'default' => 'archive-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'search' => array(
			'default' => 'search-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'grid' => array(
			'default' => 'template-post-grid post-grid grid-container',
			'paged' => 'post-grid-paginated',
		),
		'list' => array(
			'default' => 'template-post-list post-list post-list-container',
			'paged' => 'post-list-paginated',
		),
		'small' => array(
			'default' => 'template-post-small post-small post-small-container small-thumbs',
			'paged' => 'post-small-paginated',
		),
		'masonry' => array(
			'default' => 'template-post-masonry post-masonry post-masonry-container',
			'paged' => 'post-masonry-paginated',
		),
        'gallery' => array(
            'default' => 'archive-galleries gallery-list gallery-container post-grid',
            'paged' => 'gallery-paginated',
        ),
        'portfolio' => array(
            'default' => 'archive-portfolio portfolio grid-container portfolio-2 clearfix',
            'paged' => 'portfolio-paginated',
        )
		// @TODO timeline classes
	);

	// Add default
	if ( isset( $default_classes[ $class ]['default'] ) ) {
		$classes[] = $default_classes[ $class ]['default'];
	}

	// Posts using pagination.
	if ( isset( $default_classes[ $class ]['paged'] ) && $paged ) {
		$classes[] = $default_classes[ $class ]['paged'];
	}

	$classes = implode( ' ', $classes );

	$classes = apply_filters( 'anva_post_class', $classes );

	return esc_attr( $classes );
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
		if ( ! is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
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
	echo 'class="' . join( ' ', anva_get_primary_menu_class( $class ) ) . '"';
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

    if ( empty ( $terms ) ) {
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
 * Print page transition data.
 *
 * @return string $data
 */
function anva_page_transition_data() {

	// Get loader data
	$loader        = anva_get_option( 'page_loader', 1 );
	$color         = anva_get_option( 'page_loader_color' );
	$timeout       = anva_get_option( 'page_loader_timeout', 1000 );
	$speed_in      = anva_get_option( 'page_loader_speed_in', 800 );
	$speed_out     = anva_get_option( 'page_loader_speed_out', 800 );
	$animation_in  = anva_get_option( 'page_loader_animation_in', 'fadeIn' );
	$animation_out = anva_get_option( 'page_loader_animation_out', 'fadeOut' );
	$html          = anva_get_option( 'page_loader_html' );
	$data          = '';

	if ( $loader ) {
		$data .= 'data-loader="' . esc_attr( $loader ) . '"';
		$data .= 'data-loader-color="' . esc_attr( $color ) . '"';
		$data .= 'data-loader-timeout="' . esc_attr( $timeout ) . '"';
		$data .= 'data-speed-in="' . esc_attr( $speed_in ) . '"';
		$data .= 'data-speed-out="' . esc_attr( $speed_out ) . '"';
		$data .= 'data-animation-in="' . esc_attr( $animation_in ) . '"';
		$data .= 'data-animation-out="' . esc_attr( $animation_out ) . '"';

		if ( $html ) {
			$data .= 'data-loader-html="' . $html . '"';
		}
	}

	echo $data;
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
 * Limit chars in string.
 *
 * @since  1.0.0
 * @param  $string
 * @param  $length
 * @return $string
 */
function anva_truncate_string( $string, $length = 100 ) {
	$string = trim( $string );
	if ( strlen( $string ) <= $length ) {
		return $string;
	} else {
		$string = substr( $string, 0, $length ) . '...';
		return $string;
	}
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
	} else if ( strlen( $hex ) == 6 ) {
		$color['r'] = hexdec( substr( $hex, 0, 2 ) );
		$color['g'] = hexdec( substr( $hex, 2, 2 ) );
		$color['b'] = hexdec( substr( $hex, 4, 2 ) );
	}

	return $color;
}

/**
 * Get the excerpt and limit chars.
 *
 * @since 1.0.0
 */
function anva_get_excerpt( $length = '' ) {
	if ( ! empty( $length ) ) {
		$content = get_the_excerpt();
		$content = anva_truncate_string( $content, $length );
		return $content;
	}
	$content = get_the_excerpt();
	$content = wpautop( $content );
	return $content;
}

/**
 * Output excerpt.
 *
 * @since 1.0.0
 */
function anva_the_excerpt( $length = '' ) {
	echo anva_get_excerpt( $length );
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
 * Process any icons passed in as %icon%.
 *
 * @since  1.0.0
 * @param  string $string
 * @return string $string
 */
function anva_extract_icon( $string ) {

	preg_match_all( '/\%(.*?)\%/', $string, $icons );

	if ( ! empty( $icons[0] ) ) {

		$list = true;

		if ( substr_count( trim( $string ), "\n" ) ) {
			// If text has more than one line, we won't make into an inline list
			$list = false;
		}

		$total = count( $icons[0] );

		if ( $list ) {
			$string = sprintf( "<ul class=\"list-inline nobottommargin\">\n<li>%s</li>\n</ul>", $string );
		}

		foreach ( $icons[0] as $key => $val ) {

			$html = apply_filters( 'anva_extract_icon_html', '<i class="icon-%s"></i>', $string );

			if ( $list && $key > 0 ) {
				$html = "<li>\n" . $html;
			}

			$string = str_replace( $val, sprintf( $html, $icons[1][ $key ] ), $string );
		}
	}

	return $string;
}

/**
 * Get font stacks
 *
 * @since  1.0.0
 * @return array $stacks
 */
function anva_get_font_stacks() {
	$stacks = array(
		'default'     => 'Arial, sans-serif', // Used to chain onto end of google font
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
 * Remove trailing char.
 *
 * @since  1.0.0
 * @param  string $string
 * @param  string $char
 * @return string $string
 */
function anva_remove_trailing_char( $string, $char = ' ' ) {

	if ( ! $string ) {
		return NULL;
	}

	$offset = strlen( $string ) - 1;

	$trailing_char = strpos( $string, $char, $offset );
	if ( $trailing_char ) {
		$string = substr( $string, 0, -1 );
	}

	return $string;
}

/**
 * Get font face
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

function anva_the_font_face( $option ) {
	echo anva_get_font_face( $option );
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

function anva_the_font_size( $option ) {
	echo anva_get_font_size( $option );
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

function anva_the_font_style( $option ) {
	echo anva_get_font_style( $option );
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

	if ( ! empty( $option['weight'] ) ){
		$weight = $option['weight'];
	}

	if ( ! $weight ) {
		$weight = '400';
	}

	return apply_filters( 'anva_get_font_weight', $weight, $option );
}

function anva_the_font_weight( $option ) {
	echo anva_get_font_weight( $option );
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

function anva_the_text_transform( $option ) {
	echo anva_get_text_transform( $option );
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

function anva_the_background_pattern( $option ) {
	echo anva_get_background_pattern( $option );
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

		// Include each font file from google
		foreach ( $fonts as $font => $atts ) {

			// Create handle
			$handle = strtolower( $font );
			$handle = str_replace( ' ', '-', $handle );

			if ( ! empty( $atts['style'] ) ) {
				$font .= sprintf( ':%s', implode( ',', $atts['style'] ) );
			}

			if ( ! empty( $atts['subset'] ) ) {
				$font .= sprintf( '&subset=%s', implode( ',', $atts['subset'] ) );
			}

			wp_enqueue_style( $handle, $protocol . 'fonts.googleapis.com/css?family=' . $font, array(), ANVA_FRAMEWORK_VERSION, 'all' );

		}

	}
}

/**
 * Get social media sources and their respective names.
 *
 * @since  1.0.0
 * @return array $profiles
 */
function anva_get_social_icons_profiles() {
	$profiles = array(
		'bitbucket'		=> 'Bitbucket',
		'codepen'		=> 'Codepen',
		'delicious' 	=> 'Delicious',
		'deviantart' 	=> 'DeviantArt',
		'digg' 			=> 'Digg',
		'dribbble' 		=> 'Dribbble',
		'email3' 		=> 'Email',
		'facebook' 		=> 'Facebook',
		'flickr' 		=> 'Flickr',
		'foursquare' 	=> 'Foursquare',
		'github' 		=> 'Github',
		'gplus' 		=> 'Google+',
		'instagram' 	=> 'Instagram',
		'linkedin' 		=> 'Linkedin',
		'paypal' 		=> 'Paypal',
		'pinterest' 	=> 'Pinterest',
		'reddit' 		=> 'Reddit',
		'skype'			=> 'Skype',
		'soundcloud' 	=> 'Soundcloud',
		'tumblr' 		=> 'Tumblr',
		'twitter' 		=> 'Twitter',
		'vimeo-square'	=> 'Vimeo',
		'yahoo' 		=> 'Yahoo',
		'youtube' 		=> 'YouTube',
		'call'			=> 'Call',
		'rss' 			=> 'RSS',
	);

	// Backwards compat filter
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

	// Setup default capabilities
	$module_caps = array(
		'builder' 	=> 'edit_theme_options', // Role: Administrator
		'options' 	=> 'edit_theme_options', // Role: Administrator
		'backup' 	=> 'manage_options', 	 // Role: Administrator
		'updates' 	=> 'manage_options', 	 // Role: Administrator
	);

	$module_caps = apply_filters( 'anva_admin_module_caps', $module_caps );

	// Setup capability
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
 * Compress a chunk of code to output
 *
 * @since 1.0.0
 */
function anva_compress( $buffer ) {

	// Remove comments
	$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );

	return $buffer;
}

/**
 * Get template framework part.
 *
 * @since 1.0.0
 * @param string $name
 * @param string $slug
 */
function anva_get_template_part( $name, $slug = 'content' ) {
	$path = trailingslashit( 'templates' );
	if ( empty( $slug ) ) {
		get_template_part( $path . $name );
		return;
	}
	get_template_part( $path . $slug, $name );
}

/**
 * Get core framework url.
 *
 * @since  1.0.0
 * @return string $uri
 */
function anva_get_core_uri() {
	$uri = trailingslashit( get_template_directory_uri() . '/framework' );
	if ( defined( 'ANVA_FRAMEWORK_URI' ) ) {
		$uri = ANVA_FRAMEWORK_URI;
	}
	return $uri;
}

/**
 * Get core framework admin url.
 *
 * @since  1.0.0
 * @return string $uri
 */
function anva_get_core_admin_uri() {
	$uri = trailingslashit( get_template_directory_uri() . '/framework/admin' );
	if ( defined( 'ANVA_FRAMEWORK_ADMIN_URI' ) ) {
		$uri = ANVA_FRAMEWORK_ADMIN_URI;
	}
	return $uri;
}

/**
 * Get core framework directory.
 *
 * @since  1.0.0
 * @return string $path
 */
function anva_get_core_directory() {
	$path = trailingslashit( get_template_directory() . '/framework' );
	if ( defined( 'ANVA_FRAMEWORK_DIR' ) ) {
		$path = ANVA_FRAMEWORK_DIR;
	}
	return $path;
}

/**
 * Get core framework admin directory.
 *
 * @since  1.0.0
 * @return string $path
 */
function anva_get_core_admin_directory() {
	$path = trailingslashit( get_template_directory() . '/framework/admin' );
	if ( defined( 'ANVA_FRAMEWORK_ADMIN' ) ) {
		$path = ANVA_FRAMEWORK_ADMIN;
	}
	return $path;
}

/**
 * Insert a key in array.
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

		// INSERT BEFORE THE CURRENT KEY?
		// ONLY IF CURRENT KEY IS THE KEY WE ARE SEARCHING FOR, AND WE WANT TO INSERT BEFORE THAT FOUNDED KEY
		if ( $key === $search_key && ! $insert_after ) {
			$new_array[ $insert_key ] = $insert_value; }

		// COPY THE CURRENT KEY/VALUE FROM OLD ARRAY TO A NEW ARRAY
		$new_array[ $key ] = $value;

		// INSERT AFTER THE CURRENT KEY?
		// ONLY IF CURRENT KEY IS THE KEY WE ARE SEARCHING FOR, AND WE WANT TO INSERT AFTER THAT FOUNDED KEY
		if ( $key === $search_key && $insert_after ) {
			$new_array[ $insert_key ] = $insert_value; }
	}

	// APPEND IF KEY ISNT FOUNDED
	if ( $append && count( $array ) == count( $new_array ) ) {
		$new_array[ $insert_key ] = $insert_value; }

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
