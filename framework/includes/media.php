<?php

/**
 * Get Image Sizes
 *
 * @since 1.0.0
 */
function anva_get_image_sizes() {

	global $content_width;

	// Content Width
	// Default width of primary content area
	$content_width = apply_filters( 'anva_content_width', 1140 );

	// Crop sizes
	$sizes = array(
		'anva_full' => array(
			'name' 		 => __( 'Anva Full Width', 'anva' ),
			'width' 	 => 2000,
			'height' 	 => 1333,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_lg' => array(
			'name' 		 => __( 'Anva Large', 'anva' ),
			'width' 	 => $content_width,
			'height' 	 => 500,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_md' => array(
			'name' 		 => __( 'Anva Medium', 'anva' ),
			'width' 	 => 860,
			'height' 	 => 400,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_sm' => array(
			'name' 		 => __( 'Anva Small', 'anva' ),
			'width' 	 => 400,
			'height' 	 => 300,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_grid_2' => array(
			'name' 		 => __( 'Anva Grid 2', 'anva' ),
			'width' 	 => 800,
			'height'	 => 600,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_grid_3' => array(
			'name' 		 => __( 'Anva Grid 3', 'anva' ),
			'width' 	 => 600,
			'height'	 => 450,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_post_grid'  => array(
			'name' 		 => __( 'Anva Post Grid', 'anva' ),
			'width' 	 => 520,
			'height'	 => 280,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_masonry' => array(
			'name' 		 => __( 'Anva Masonry', 'anva' ),
			'width' 	 => 500,
			'height'	 => 500,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
		'anva_masonry_2' => array(
			'name' 		 => __( 'Anva Masonry Vertical', 'anva' ),
			'width' 	 => 500,
			'height'	 => 700,
			'crop' 		 => true,
			'position' => array( 'center', 'top' )
		),
	);

	return apply_filters( 'anva_image_sizes', $sizes );
}

/**
 * Get media queries
 *
 * @since 1.0.0
 */
function anva_get_media_queries( $localize ) {
	$media_queries = array(
		'small' 		=> 320,
		'handheld' 	=> 480,
		'tablet' 		=> 768,
		'laptop' 		=> 992,
		'desktop' 	=> 1200
	);
	return array_merge( $localize, $media_queries );
}

/**
 * Register Image Sizes
 *
 * @since 1.0.0
 */
function anva_add_image_sizes() {
	
	// Compared wp version
	global $wp_version;

	// Get image sizes
	$sizes = anva_get_image_sizes();

	// Add image sizes
	foreach ( $sizes as $size => $atts ) {
		if ( version_compare( $wp_version, '3.9', '>=' ) ) {
			add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'], $atts['position'] );
		} else {
			add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'] );
		}
	}

}

/**
 * Show theme's image thumb sizes when inserting
 * an image in a post or page. This function gets
 * added as a filter to WP's image_size_names_choose.
 *
 * @since  1.0.0
 */
function anva_image_size_names_choose( $sizes ) {

	// Get image sizes for framework that were registered.
	$raw_sizes = anva_get_image_sizes();

	// Format sizes
	$image_sizes = array();
	
	foreach ( $raw_sizes as $id => $atts ) {
		$image_sizes[$id] = $atts['name'];
	}

	// Apply filter - Filter in filter... I know, I know.
	$image_sizes = apply_filters( 'anva_image_size_names_choose', $image_sizes );

	// Return merged with original WP sizes
	return array_merge( $sizes, $image_sizes );
}

/**
 * Get featured image src
 *
 * @since 1.0.0
 */
function anva_get_featured_image( $post_id, $thumbnail ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $post_thumbnail_id ) {
		$post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail );
		return $post_thumbnail[0];
	}
}

/**
 * Get attachment image src
 *
 * @since 1.0.0
 */
function anva_get_attachment_image_src( $attachment_id, $thumbnail ) {
	if ( $attachment_id ) {
		$attachment_img = wp_get_attachment_image_src( $attachment_id, $thumbnail, true );
		return $attachment_img[0];
	}
}

/**
 * Get featured image in posts
 *
 * @since 1.0.0
 */
function anva_the_post_thumbnail( $thumb ) {
	
	global $post;

	// Output
	$html = '';
	
	// Default thumbnail size
	$thumbnail = 'anva_lg';

	if ( 'small' == $thumb ) {
		$thumbnail = 'anva_sm';
	} elseif ( 'large' == $thumb ) {
		$thumbnail = 'anva_md';
	}

	switch ( $thumb ) {
		case 'small':
			$thumbnail = 'anva_sm';
			break;

		case 'large':
			$thumbnail = 'anva_md';
			break;

		case 'full':
			$thumbnail = 'anva_large';
			break;
	}

	if ( $thumb != 'hide' && has_post_thumbnail() ) {
		
		$html .= '<div class="entry-image">';
		
		if ( is_single() ) {
			$html .= '<a data-lightbox="image" href="' . anva_get_featured_image( $post->ID, 'full' ) . '">' . get_the_post_thumbnail( $post->ID, $thumbnail, array( 'title' => get_the_title() ) ) . '</a>';
		} else {
			$html .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, $thumbnail, array( 'title' => get_the_title() ) ) . '</a>';
		}

		$html .= '</div><!-- .entry-image (end) -->';
	}

	echo $html;

}

/**
 * Get featured image in post grid
 *
 * @since 1.0.0
 */
function anva_the_post_grid_thumbnail( $thumbnail ) {
	
	global $post;
	
	$html  = '';

	if ( has_post_thumbnail() ) {
		$html .= '<div class="entry-image">';
		$html .= '<a href="'. get_permalink( $post->ID ) .'" title="'. get_the_title( $post->ID ) .'">'. get_the_post_thumbnail( $post->ID, $thumbnail ) .'</a>';
		$html .= '</div><!-- .entry-image (end) -->';
	}
	
	echo $html;
}

/**
 * Get animations
 *
 * @since 1.0.0
 */
function anva_get_animations() {
	$animations = array(
		'bounce',
		'flash',
		'pulse',
		'rubberBand',
		'shake',
		'swing',
		'tada',
		'wobble',
		'bounceIn',
		'bounceInDown',
		'bounceInLeft',
		'bounceInRight',
		'bounceInUp',
		'bounceOut',
		'bounceOutDown',
		'bounceOutLeft',
		'bounceOutRight',
		'bounceOutUp',
		'fadeIn',
		'fadeInDown',
		'fadeInDownBig',
		'fadeInLeft',
		'fadeInLeftBig',
		'fadeInRight',
		'fadeInRightBig',
		'fadeInUp',
		'fadeInUpBig',
		'fadeOut',
		'fadeOutDown',
		'fadeOutDownBig',
		'fadeOutLeft',
		'fadeOutLeftBig',
		'fadeOutRight',
		'fadeOutRightBig',
		'fadeOutUp',
		'fadeOutUpBig',
		'flip',
		'flipInX',
		'flipInY',
		'flipOutX',
		'flipOutY',
		'lightSpeedIn',
		'lightSpeedOut',
		'rotateIn',
		'rotateInDownLeft',
		'rotateInDownRight',
		'rotateInUpLeft',
		'rotateInUpRight',
		'rotateOut',
		'rotateOutDownLeft',
		'rotateOutDownRight',
		'rotateOutUpLeft',
		'rotateOutUpRight',
		'hinge',
		'rollIn',
		'rollOut',
		'zoomIn',
		'zoomInDown',
		'zoomInLeft',
		'zoomInRight',
		'zoomInUp',
		'zoomOut',
		'zoomOutDown',
		'zoomOutLeft',
		'zoomOutRight',
		'zoomOutUp',
	);
	return apply_filters( 'anva_animations', $animations );
}