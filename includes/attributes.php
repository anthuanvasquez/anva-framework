<?php
/**
 * Functions to output attributes in the HTML elements.
 *
 * @package    AnvaFramework
 * @subpackage Includes
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

/**
 * Add attributes filters.
 *
 * @since 1.0.0
 */
function anva_add_attributes() {
	/**
	 * Attributes for major structural elements.
	 */
	add_filter( 'anva_attr_wrapper', 'anva_attr_wrapper', 5 );
	add_filter( 'anva_attr_body', 'anva_attr_body', 5 );
	add_filter( 'anva_attr_header', 'anva_attr_header', 5 );
	add_filter( 'anva_attr_footer', 'anva_attr_footer', 5 );
	add_filter( 'anva_attr_content', 'anva_attr_content', 5 );
	add_filter( 'anva_attr_sidebar', 'anva_attr_sidebar', 5, 2 );
	add_filter( 'anva_attr_menu', 'anva_attr_menu', 5, 2 );

	/**
	 * Header attributes.
	 */
	add_filter( 'anva_attr_head', 'anva_attr_head', 5 );
	add_filter( 'anva_attr_branding', 'anva_attr_branding', 5 );
	add_filter( 'anva_attr_site-title', 'anva_attr_site_title', 5 );
	add_filter( 'anva_attr_site-description', 'anva_attr_site_description', 5 );

	/**
	 * Archive page header attributes.
	 */
	add_filter( 'anva_attr_archive-header', 'anva_attr_archive_header', 5 );
	add_filter( 'anva_attr_archive-title', 'anva_attr_archive_title', 5 );
	add_filter( 'anva_attr_archive-description', 'anva_attr_archive_description', 5 );

	/**
	 * Post-specific attributes.
	 */
	add_filter( 'anva_attr_post', 'anva_attr_post', 5 );
	add_filter( 'anva_attr_entry', 'anva_attr_entry', 5 );
	add_filter( 'anva_attr_entry-wrap', 'anva_attr_entry_wrap', 5 );
	add_filter( 'anva_attr_entry-title', 'anva_attr_entry_title', 5 );
	add_filter( 'anva_attr_entry-permalink', 'anva_attr_entry_permalink', 5 );
	add_filter( 'anva_attr_entry-author', 'anva_attr_entry_author', 5 );
	add_filter( 'anva_attr_entry-published', 'anva_attr_entry_published', 5 );
	add_filter( 'anva_attr_entry-content', 'anva_attr_entry_content', 5 );
	add_filter( 'anva_attr_entry-terms', 'anva_attr_entry_terms', 5, 2 );

	/**
	 * Comment specific attributes.
	 */
	add_filter( 'anva_attr_comment', 'anva_attr_comment', 5 );
	add_filter( 'anva_attr_comment-nav', 'anva_attr_comment_nav', 5 );
	add_filter( 'anva_attr_comment-author', 'anva_attr_comment_author', 5 );
	add_filter( 'anva_attr_comment-published', 'anva_attr_comment_published', 5 );
	add_filter( 'anva_attr_comment-permalink', 'anva_attr_comment_permalink', 5 );
	add_filter( 'anva_attr_comment-text', 'anva_attr_comment_text', 5 );
}

/**
 * Outputs an HTML element's attributes.
 *
 * @since 1.0.0
 * @param string $slug The slug/ID of the element.
 * @param array  $attr Array of attributes to pass in (overwrites filters).
 * @param string $context A specific context.
 */
function anva_attr( $slug, $attr = array(), $context = '' ) {
	echo anva_get_attr( $slug, $attr, $context );
}

/**
 * Gets an HTML element's attributes.
 *
 * @since  1.0.0
 * @param  string $slug The slug/ID of the element.
 * @param  array  $attr Array of attributes to pass in (overwrites filters).
 * @param  string $context A specific context.
 * @return string $output Output of the attrbiutes ID/value.
 */
function anva_get_attr( $slug, $attr = array(), $context = '' ) {

	$output = '';
	$attr   = wp_parse_args( $attr, apply_filters( "anva_attr_{$slug}", array(), $context ) );

	if ( empty( $attr ) ) {
		$attr['class'] = $slug;
	}

	foreach ( $attr as $name => $value ) {
		$output .= $value ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
	}

	return trim( $output );
}

/**
 * Main wrapper element attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_wrapper( $attr ) {

	$attr['id']    = 'wrapper';
	$attr['class'] = 'clearfix';

	return $attr;
}

/**
 * <body> element attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_body( $attr ) {

	$attr['class']     = join( ' ', get_body_class() );
	$attr['dir']       = is_rtl() ? 'rtl' : 'ltr';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/WebPage';

	if ( is_singular( 'post' ) || is_home() || is_archive() ) {
		$attr['itemtype'] = 'http://schema.org/Blog';
	} elseif ( is_search() ) {
		$attr['itemtype'] = 'http://schema.org/SearchResultsPage';
	}

	// Get page transitions data values.
	$data = anva_get_page_transition();

	if ( $data && is_array( $data ) ) {
		foreach ( $data as $data_id => $value ) {
			$attr[ 'data-' . $data_id ] = $value;
		}
	}

	return $attr;
}

/**
 * Page <header> element attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_header( $attr ) {

	$attr['id']        = 'header';
	$attr['class']     = join( ' ', anva_get_header_class( 'site-header' ) );
	$attr['role']      = 'banner';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/WPHeader';

	return $attr;
}

/**
 * Page <footer> element attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_footer( $attr ) {

	$attr['id']        = 'footer';
	$attr['class']     = 'site-footer';
	$attr['role']      = 'contentinfo';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/WPFooter';

	return $attr;
}

/**
 * Main content container of the page attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_content( $attr ) {

	$attr['id']    = 'content';
	$attr['class'] = 'site-content';
	$attr['role']  = 'main';

	if ( ! is_singular( 'post' ) && ! is_home() && ! is_archive() ) {
		$attr['itemprop'] = 'mainContentOfPage';
	}

	return $attr;
}

/**
 * Sidebar attributes.
 *
 * @since  1.0.0
 * @param  array  $attr Attributes.
 * @param  string $context A specific context.
 * @return array  $attr Attributes.
 */
function anva_attr_sidebar( $attr, $context ) {

	$attr['class'] = 'widget-area';
	$attr['role']  = 'complementary';

	if ( $context ) {

		$attr['id']     = "widget-area-{$context}";
		$attr['class'] .= " widget-area-{$context}";

		$sidebar_name = anva_get_sidebar_location_name( $context );

		if ( $sidebar_name ) {
			$attr['aria-label'] = esc_attr( sprintf( _x( '%s Sidebar', 'sidebar aria label', 'anva' ), $sidebar_name ) );
		}
	}

	$attr['class']    .= ' clearfix';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/WPSideBar';

	return $attr;
}

/**
 * Nav menu attributes.
 *
 * @since  1.0.0
 * @param  array  $attr Attributes.
 * @param  string $context A specific context.
 * @return array  $attr Attributes.
 */
function anva_attr_menu( $attr, $context ) {

	$attr['class'] = 'menu';
	$attr['role']  = 'navigation';

	if ( $context ) {

		$attr['id']     = "{$context}-menu";
		$attr['class'] .= " {$context}-menu";

		if ( 'primary' == $context ) {
			$attr['class'] .= join( ' ', anva_get_primary_menu_class() );
		}

		if ( 'footer' == $context ) {
			$attr['class'] .= ' copyright-links';
		}

		if ( 'top-bar' == $context ) {
			$attr['class'] .= ' top-links';
		}

		$menu_name = anva_get_menu_location_name( $context );

		if ( $menu_name ) {
			$attr['aria-label'] = esc_attr( sprintf( _x( '%s Menu', 'nav menu aria label', 'anva' ), $menu_name ) );
		}
	}

	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/SiteNavigationElement';

	return $attr;
}

/**
 * <head> attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_head( $attr ) {

	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/WebSite';

	return $attr;
}

/**
 * Branding (usually a wrapper for logo image, title and tagline) attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_branding( $attr ) {

	$attr['id']    = 'logo';
	$attr['class'] = 'site-branding';

	return $attr;
}

/**
 * Site title attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_site_title( $attr ) {

	$attr['id']       = 'site-title';
	$attr['class']    = 'site-title text-logo';
	$attr['itemprop'] = 'headline';

	return $attr;
}

/**
 * Site description attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_site_description( $attr ) {

	$attr['id']       = 'site-description';
	$attr['class']    = 'site-description logo-tagline';
	$attr['itemprop'] = 'description';

	return $attr;
}

/**
 * Archive pages header attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_archive_header( $attr ) {

	$attr['id']        = 'page-title';
	$attr['class']     = 'page-title';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/WebPageElement';

	return $attr;
}

/**
 * Archive pages title attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_archive_title( $attr ) {

	$attr['class']     = 'page-title-heading';
	$attr['itemprop']  = 'headline';

	return $attr;
}

/**
 * Archive description attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_archive_description( $attr ) {

	$attr['class']     = 'page-title-tagline';
	$attr['itemprop']  = 'text';

	return $attr;
}

/**
 * Post <article> element attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_post( $attr ) {

	$post = get_post();

	// Make sure we have a real post first.
	if ( ! empty( $post ) ) {

		$post_type = get_post_type();

		$attr['id']        = 'post-' . get_the_ID();
		$attr['class']     = join( ' ', get_post_class() );
		$attr['itemscope'] = 'itemscope';

		if ( 'post' === $post_type ) {

			$attr['itemtype']  = 'http://schema.org/BlogPosting';

			/* Add itemprop if within the main query. */
			if ( is_main_query() && ! is_search() ) {
				$attr['itemprop'] = 'blogPost';
			}
		} elseif ( 'attachment' === $post_type && wp_attachment_is_image() ) {
			$attr['itemtype'] = 'http://schema.org/ImageObject';
		} elseif ( 'attachment' === $post_type && anva_attachment_is_audio() ) {
			$attr['itemtype'] = 'http://schema.org/AudioObject';
		} elseif ( 'attachment' === $post_type && anva_attachment_is_video() ) {
			$attr['itemtype'] = 'http://schema.org/VideoObject';
		} else {
			$attr['itemtype']  = 'http://schema.org/CreativeWork';
		}
	} else {

		$attr['id']    = 'post-0';
		$attr['class'] = join( ' ', get_post_class() );

	}

	return $attr;
}

/**
 * Post wrap attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_entry_wrap( $attr ) {

	$attr['class'] = 'entry-wrap';

	return $attr;
}

/**
 * Post title attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_entry_title( $attr ) {

	$attr['class']    = 'entry-title';
	$attr['itemprop'] = 'headline';

	return $attr;
}

/**
 * Post link attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_entry_permalink( $attr ) {

	$attr['href']     = get_the_permalink();
	$attr['rel']      = 'bookmark';
	$attr['class']    = 'entry-title-link';
	$attr['itemprop'] = 'url';

	return $attr;
}

/**
 * Post author attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_entry_author( $attr ) {

	$attr['class']     = 'entry-author';
	$attr['itemprop']  = 'author';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/Person';

	return $attr;
}

/**
 * Post time/published attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_entry_published( $attr ) {

	$attr['class']    = 'entry-published entry-date updated';
	$attr['datetime'] = get_the_time( 'Y-m-d\TH:i:sP' );
	$attr['itemprop'] = 'datePublished';
	$attr['title']    = get_the_time( _x( 'l, F j, Y, g:i a', 'post time format', 'anva' ) );

	return $attr;
}

/**
 * Post content (not excerpt) attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_entry_content( $attr ) {

	$attr['class'] = 'entry-content';

	if ( is_single() ) {
		$attr['class'] .= ' notopmargin';
	}

	if ( 'post' === get_post_type() ) {
		$attr['itemprop'] = 'articleBody';
	} else {
		$attr['itemprop'] = 'text';
	}

	return $attr;
}

/**
 * Post terms (tags, categories, etc.) attributes.
 *
 * @since  1.0.0
 * @param  array  $attr Attributes.
 * @param  string $context A specific context.
 * @return array  $attr Attributes.
 */
function anva_attr_entry_terms( $attr, $context ) {

	if ( ! empty( $context ) ) {

		$attr['class'] = 'entry-terms ' . sanitize_html_class( $context );

		if ( is_single() ) {
			$attr['class'] .= ' bottommargin';
		}

		if ( 'category' === $context ) {
			$attr['itemprop'] = 'articleSection';
		} elseif ( 'post_tag' === $context ) {
			$attr['itemprop'] = 'keywords';
		}
	}

	return $attr;
}

/**
 * Comment wrapper attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_comment( $attr ) {

	$attr['id']    = 'comment-' . get_comment_ID();
	$attr['class'] = join( ' ', get_comment_class() );

	if ( in_array( get_comment_type(), array( '', 'comment' ) ) ) {
		$attr['itemprop']  = 'comment';
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'http://schema.org/Comment';
	}

	return $attr;
}

/**
 * Comment nav attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_comment_nav( $attr ) {

	$attr['id']              = 'comment-nav';
	$attr['class']           = 'comment-navigation pager';
	$attr['role']            = 'navigation';
	$attr['itemscope']       = 'itemscope';
	$attr['itemtype']        = 'http://schema.org/SiteNavigationElement';
	$attr['aria-labelledby'] = 'comments-nav-title';

	return $attr;
}

/**
 * Comment author attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_comment_author( $attr ) {

	$attr['class']     = 'comment-author';
	$attr['itemprop']  = 'author';
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/Person';

	return $attr;
}

/**
 * Comment time/published attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_comment_published( $attr ) {

	$attr['class']    = 'comment-published';
	$attr['datetime'] = get_comment_time( 'Y-m-d\TH:i:sP' );
	$attr['title']    = get_comment_time( _x( 'l, F j, Y, g:i a', 'comment time format', 'anva' ) );
	$attr['itemprop'] = 'datePublished';

	return $attr;
}

/**
 * Comment permalink attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_comment_permalink( $attr ) {

	$attr['class']    = 'comment-permalink';
	$attr['href']     = get_comment_link();
	$attr['itemprop'] = 'url';

	return $attr;
}

/**
 * Comment content/text attributes.
 *
 * @since  1.0.0
 * @param  array $attr Attributes.
 * @return array $attr Attributes.
 */
function anva_attr_comment_text( $attr ) {

	$attr['class']    = 'comment-text';
	$attr['itemprop'] = 'text';

	return $attr;
}
