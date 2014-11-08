<?php

/**
 * Get image sizes.
 *
 * @since 1.0.0
 */
function of_get_image_sizes() {

	global $content_width;

	// Set Content Width
	$content_width = apply_filters( 'of_content_width', 980 );

	$sizes = array(
		'blog_large' 		=> 	array( 'name' => __( 'Blog Large', OF_DOMAIN ), 'width' => $content_width, 'height' => 9999, 'crop' => false ),
		'blog_medium' 	=>	array( 'name' => __( 'Blog Medium', OF_DOMAIN ), 'width' => 240, 'height' => 240, 'crop' => true ),
		'blog_small' 		=> 	array( 'name' => __( 'Blog Large', OF_DOMAIN ), 'width' => 150, 'height' => 150, 'crop' => true ),
		'thumb_grid_2' 	=> 	array( 'name' => __( 'Grid 2 Columns', OF_DOMAIN ), 'width' => 472, 'height' => 295, 'crop' => true ),
		'thumb_grid_3' 	=> 	array( 'name' => __( 'Grid 2 Columns', OF_DOMAIN ), 'width' => 320, 'height' => 200, 'crop' => true ),
		'thumb_grid_4' 	=> 	array( 'name' => __( 'Grid 2 Columns', OF_DOMAIN ), 'width' => 240, 'height' => 150, 'crop' => true ),
		'featured' 			=> 	array( 'name' => __( 'Featured', OF_DOMAIN ), 'width' => $content_width, 'height' => 350, 'crop' => true ),
	);

	return apply_filters( 'of_get_image_sizes', $sizes );

}

/* Add image sizes to media uploader */
function of_add_image_sizes() {

	// Get image sizes
	$sizes = of_get_image_sizes();

	// Add image sizes
	foreach ( $sizes as $size => $atts ) {
		add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'] );
	}

}

/* Add image sizes to media uploader */
function of_image_sizes_choose( $images ){
	$sizes = of_get_image_sizes();
	return $images;
	// return array_merge( $images, $sizes );
}

function of_get_featured_image( $post_id, $thumbnail ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $post_thumbnail_id ) {
		$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail );
		return $post_thumbnail_img[0];
	}
}