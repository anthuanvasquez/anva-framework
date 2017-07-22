<?php
/**
 * Generate content builder elements.
 *
 * @since  1.0.0
 * @return The element with attributes.
 */
function anva_display_elements() {

	// Get settings.
	$settings = anva_get_post_meta( '_anva_builder_options' );

	// Kill it if there's no order.
	if ( isset( $settings['order'] ) && empty( $settings['order'] ) ) {
		printf( '<div class="container clearfix"><div class="alert alert-warning topmargin-lg">%s</div></div>', __( 'There is no setup elements in the content builder, please add some elements to show the content on this page.', 'anva' ) );
		return;
	}

	// Set items order.
	$items 	 = explode( ',', $settings['order'] );
	$counter = 0;

	foreach ( $items as $key => $item ) {

		$atts      = array();
		$classes   = array();
		$data      = $settings[ $item ]['data'];
		$obj       = json_decode( $data, true );
		$content   = $obj['shortcode'] . '_content';
		$shortcode = $obj['shortcode'];

		$counter++;

		// Check if the element exists.
		if ( anva_element_exists( $shortcode ) ) {

			$shortcodes = anva_get_elements();

			// Shortcode has attributes.
			if ( isset( $shortcodes[ $shortcode ]['attr'] ) && ! empty( $shortcodes[ $shortcode ]['attr'] ) ) {

				$classes[] = 'element-has-attributes';

				// Get shortcode attributes.
				$attributes = $shortcodes[ $shortcode ]['attr'];

				foreach ( $attributes as $attribute_id => $attribute ) {

					if ( 'custom_css' == $attribute_id && ! empty( $attribute ) ) {
						$classes[] = 'element-has-custom-css';
					}

					$obj_attribute = $obj['shortcode'] . '_' . $attribute_id;

					if ( isset( $obj[ $obj_attribute ] ) ) {
						$atts[ $attribute_id ] = esc_attr( urldecode( $obj[ $obj_attribute ] ) );
					}
				}
			}

			// Shortcode has content.
			if ( isset( $obj[ $content ] ) && ! empty( $obj[ $content ] ) ) {
				$classes[] = 'element-has-content';
				$content   = urldecode( $obj[ $content ] );
			} else {
				$content = null;
			}

			$classes = implode( ' ', $classes );
			?>
			<!-- #section-<?php echo esc_attr( $counter ); ?> (end) -->
			<section id="section-<?php echo esc_attr( $counter ); ?>" class="section section-element section-<?php echo esc_attr( $item ); ?> section-<?php echo esc_attr( $shortcode ); ?> <?php echo esc_attr( $classes ); ?>">
			<div id="element-<?php echo esc_attr( $item ); ?>" class="element element-<?php echo esc_attr( $item ); ?> element-<?php echo esc_attr( $shortcode ); ?>">

			<?php
			/**
			 * Hooked
			 *
			 * @see anva_add_elements
			 */
			do_action( 'anva_element_' . $shortcode, $atts, $content );
			?>

			</div><!-- #element-<?php echo esc_attr( $item ); ?> (end) -->
			</section><!-- #section-<?php echo esc_attr( $counter ); ?> (end) -->
			<?php
		}// End if().
}// End foreach().

	return false;
}

/**
 * Add elements.
 *
 * @since 1.0.0
 */
function anva_add_elements() {
	add_action( 'anva_element_divider', 						'anva_divider', 10, 2 );
	add_action( 'anva_element_header_text', 					'anva_header_text', 10, 2 );
	add_action( 'anva_element_header_image', 					'anva_header_image', 10, 2 );
	add_action( 'anva_element_text_fullwidth', 					'anva_text_fullwidth', 10, 2 );
	add_action( 'anva_element_text_image', 						'anva_text_image', 10, 2 );
	add_action( 'anva_element_text_sidebar', 					'anva_text_sidebar', 10, 2 );
	add_action( 'anva_element_blog_grid', 						'anva_blog_grid', 10, 2 );
	add_action( 'anva_element_content_half_bg', 				'anva_content_half_bg', 10, 2 );
	add_action( 'anva_element_contact_sidebar', 				'anva_contact_sidebar', 10, 2 );
	add_action( 'anva_element_contact_map', 					'anva_contact_map', 10, 2 );
	add_action( 'anva_element_image_parallax', 					'anva_image_parallax', 10, 2 );
	add_action( 'anva_element_image_fullwidth', 				'anva_image_fullwidth', 10, 2 );
	add_action( 'anva_element_image_half_fullwidth', 			'anva_image_half_fullwidth', 10, 2 );
	add_action( 'anva_element_image_half_fixed_width', 			'anva_image_half_fixed_width', 10, 2 );
	add_action( 'anva_element_image_fixed_width', 				'anva_image_fixed_width', 10, 2 );
	add_action( 'anva_element_four_images_block', 				'anva_four_images_block', 10, 2 );
	add_action( 'anva_element_three_images_block', 				'anva_three_images_block', 10, 2 );
	add_action( 'anva_element_three_cols_images', 				'anva_three_cols_images, 10, 2' );
	add_action( 'anva_element_two_cols_images', 				'anva_two_cols_images', 10, 2 );
	// add_action( 'anva_element_gallery_slider', 				'anva_gallery_slider', 10, 2 );
	// add_action( 'anva_element_gallery_grid', 				'anva_gallery_grid', 10, 2 );
	// add_action( 'anva_element_gallery_masonry', 				'anva_gallery_masonry', 10, 2 );
	// add_action( 'anva_element_galleries', 					'anva_galleries', 10, 2 );
	// add_action( 'anva_element_animated_gallery_grid',		'anva_animated_gallery_grid', 10, 2 );
	// add_action( 'anva_element_map', 							'anva_map' );
	// add_action( 'anva_element_testimonial_column', 			'anva_testimonial_column' );
	// add_action( 'anva_element_pricing', 						'anva_pricing' );
	// add_action( 'anva_element_gallery_slider_fixed_width', 	'anva_gallery_slider_fixed_width' );
}

/*
-----------------------------------------------------------------------------------*/
/*
 Elements
/*-----------------------------------------------------------------------------------*/

/**
 * Divider.
 *
 * @since 1.0.0
 * @param string $atts
 * @param string $content
 */
function anva_divider( $atts, $content = null ) {
	$html  = '<div class="container clearfix">';
	$html .= '<div class="divider"><i class="icon-circle"></i></div>';
	$html .= '</div>';
	echo $html;
}

/**
 * Header
 *
 * @param array  $atts
 * @param string $content
 */
function anva_header_text( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'slug'       => '',
		'subtitle'   => '',
		'padding'    => 30,
		'bgcolor'    => '',
		'width'		 => '100%',
		'fontcolor'  => '',
		'custom_css' => '',
	), $atts ) );

	$html          = '';
	$id            = '';
	$fontcolor_css = '';

	if ( ! empty( $slug ) ) {
		$id = 'id="' . esc_attr( $slug ) . '"';
	}

	$custom_css .= 'padding:' . $padding . 'px 0;';

	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . $bgcolor . ';';
	}

	if ( ! empty( $fontcolor ) ) {
		$custom_css   .= 'color:' . $fontcolor . ';';
		$fontcolor_css = 'color:' . $fontcolor . ';';
	}

	$custom_css = anva_compress( $custom_css );

	$html .= '<div ' . $id . ' class="" style="' . esc_attr( $custom_css ) . '">';
	$html .= '<div class="element-wrapper">';

	if ( ! empty( $width ) ) {
		$width = 'width:' . $width;
	}

	$html .= '<div class="divcenter" style="' . esc_attr( $width ) . '">';
	$html .= '<div class="emphasis-title">';
	$html .= '<h2 style="' . esc_attr( $fontcolor_css ) . '">' . esc_html( $subtitle ) . '</h2>';
	$html .= wpautop( $content );
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div><!-- .element-wrapper (end) -->';
	$html .= '</div><!-- #' . $slug . ' (end) -->';

	echo $html;
}

/**
 * Header Background Image
 *
 * @param  [type] $atts    [description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function anva_header_image( $atts, $content = null ) {

	extract( $atts );

	$html = '';
	$id = '';
	$parallax = '';
	$fontcolor_css = '';

	if ( ! empty( $slug ) ) {
		$id = 'id="' . esc_attr( $slug ) . '"';
	}

	if ( ! empty( $background ) ) {
		$custom_css .= 'background-image: url("' . $background . '");';
	}

	if ( ! empty( $background_parallax ) ) {
		$parallax .= 'data-stellar-background-ratio="0.5"';
	}

	if ( ! empty( $background_position ) ) {
		$custom_css .= 'background-position:' . $background_position . ';';
	}

	$custom_css .= 'padding:' . $padding . 'px;';

	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . $bgcolor . ';';
	}

	if ( ! empty( $fontcolor ) ) {
		$custom_css .= 'color:' . $fontcolor . ';';
		$fontcolor_css = 'color:' . $fontcolor . ';';
	}

	$custom_css = anva_compress( $custom_css );

	$html .= '<div ' . $id . ' class="" style="' . esc_attr( $custom_css ) . '" ' . $parallax . '>';
	$html .= '<div class="element-wrapper nobottommargin">';
	$html .= '<div class="container clearfix">';

	if ( ! empty( $width ) ) {
		$width = 'width:' . $width;
	}

	$html .= '<div class="automargin" style="' . esc_attr( $width ) . '">';
	$html .= '<h2 class="sub-title" style="' . esc_attr( $fontcolor_css ) . '">' . esc_html( $subtitle ) . '</h2>';
	$html .= wpautop( $content );
	$html .= '</div>';
	$html .= '</div><!-- .element-wrapper (end) -->';
	$html .= '</div><!-- .container (end) -->';
	$html .= '</div><!-- #' . $slug . ' (end) -->';

	echo $html;

}

/**
 * Text Fullwidth.
 *
 * @param  array  $atts
 * @param  string $content
 * @return string $html
 */
function anva_text_fullwidth( $atts, $content ) {

	extract( shortcode_atts( array(
		'slug' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'padding' => 30,
		'width' => '100%',
		'custom_css' => '',
	), $atts ) );

	$html = '';
	$id = '';

	if ( ! empty( $slug ) ) {
		$id = 'id="' . esc_attr( $slug ) . '"';
	}

	$custom_css .= 'padding:' . $padding . 'px 0;';

	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . $bgcolor . ';';
	}

	if ( ! empty( $fontcolor ) ) {
		$custom_css .= 'color:' . $fontcolor . ' !important;';
	}

	$custom_css = anva_compress( $custom_css );

	$html .= '<div ' . $id . ' class="" style="' . esc_attr( $custom_css ) . '">';
	$html .= '<div class="element-wrapper nobottommargin">';
	$html .= '<div class="container clearfix">';

	if ( ! empty( $width ) ) {
		$width = 'width:' . $width;
	}

	$html .= '<div class="divcenter" style="' . esc_attr( $width ) . '">';
	$html .= wpautop( $content );
	$html .= '</div>';

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	echo $html;

}

function anva_text_image( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'padding' => 30,
		'background' => '',
		'background_parallax' => '',
		'background_position' => '',
		'fontcolor' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . ' withsmallpadding anva_text ';

	if ( ! empty( $background ) ) {
		$html .= 'withbg ';
		$custom_css .= 'background-image:url(' . esc_url( $background ) . ');';
	}

	if ( ! empty( $background_parallax ) ) {
		$html .= 'parallax ';
	}

	if ( ! empty( $background_position ) ) {
		$custom_css .= 'background-position: center ' . esc_attr( $background_position ) . ';';
	}

	$html .= '"';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $fontcolor ) ) {
		$custom_css .= 'color:' . esc_attr( $fontcolor ) . ' !important;';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= ' style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	if ( ! empty( $background_parallax ) ) {
		$html .= ' data-stellar-background-ratio="0.5" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner" ';

	$html .= '>';
	$html .= do_shortcode( anva_apply_content( $content ) ) . '</div>';
	$html .= '</div></div>';

	return $html;

}

function anva_text_sidebar( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'slug' => '',
		'subtitle' => '',
		'sidebar' => '',
		'padding' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="one withsmallpadding" ';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . urldecode( $custom_css ) . '" ';
	}

	$html .= '>';

	$html .= '<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper"><div class="sidebar_content full_width nopadding">';

	$html .= '<div class="sidebar_content page_content">';

	$html .= do_shortcode( anva_apply_content( $content ) ) . '</div>';

	// Display Sidebar
	$html .= '<div class="sidebar_wrapper"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$html .= get_dynamic_sidebar( urldecode( $sidebar ) );
	$html .= '</ul></div></div></div>';

	$html .= '</div></div></div></div>';

	$html .= '</div>';

	return $html;
}

function anva_gallery_slider_fixed_width( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'gallery' => '',
		'autoplay' => 0,
		'caption' => 0,
		'timer' => 5,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper nopadding"><div class="inner">';

	$html .= do_shortcode( '[tg_gallery_slider gallery_id="' . esc_attr( $gallery ) . '" size="full" autoplay="' . esc_attr( $autoplay ) . '" caption="' . esc_attr( $caption ) . '"  timer="' . esc_attr( $timer ) . '"]' );

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;
}




function anva_gallery_grid_( $atts, $content ) {

	// Extract short code attr
	extract( shortcode_atts( array(
		'size' 				=> 'one',
		'slug' 				=> '',
		'gallery_id' 	=> '',
		'bgcolor' 		=> '',
	), $atts ) );

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$custom_css = '';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	$html  = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . ' nopadding" style="' . $custom_css . '">';
	$html .= anva_gallery_grid_( $gallery_id, 3, 'grid_2', 'grid' );
	// $html .= do_shortcode( '[tg_grid_gallery gallery_id="' . esc_attr( $gallery_id ) . '" margin="' . esc_attr( $margin ) . '"]' );
	$html .= '</div>';

	return $html;

	anva_gallery_grid_( 15, 3, 'grid_2' );
}


function anva_animated_gallery_grid( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'slug' => '',
		'gallery_id' => '',
		'margin' => '',
		'logo' => '',
		'bgcolor' => '',
		'opacity' => 100,
		'fontcolor' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$custom_font_css = 'style="';
	if ( ! empty( $fontcolor ) ) {
		$custom_font_css .= 'color:' . esc_attr( $fontcolor ) . ';';
	}
	$custom_font_css .= '"';

	$custom_bg_css = 'style="';
	if ( ! empty( $bgcolor ) ) {
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity / 100;
			$bgcolor = HexToRGB( $bgcolor );

			$custom_bg_css .= 'background:' . $ori_bgcolor . ';';
			$custom_bg_css .= 'background:rgb(' . $bgcolor['r'] . ',' . $bgcolor['g'] . ',' . $bgcolor['b'] . ',' . $opacity . ');';
			$custom_bg_css .= 'background:rgba(' . $bgcolor['r'] . ',' . $bgcolor['g'] . ',' . $bgcolor['b'] . ',' . $opacity . ');';
	}

	$custom_border_css = 'style="';
	if ( ! empty( $bgcolor ) ) {
			$opacity = '0.7';
			$custom_border_css .= 'border-color:' . $ori_bgcolor . ';';
			$custom_border_css .= 'border-color:rgba(' . $bgcolor['r'] . ',' . $bgcolor['g'] . ',' . $bgcolor['b'] . ',' . $opacity . ');';
	}

	$custom_bg_css .= '"';
	$custom_border_css .= '"';

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '">';

	$images_arr = get_post_meta( $gallery_id, 'wpsimplegallery_gallery', true );

	if ( ! empty( $images_arr ) ) {
		// Get contact form random ID
		$custom_id = time() . rand();

		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', false, THEMEVERSION, true );
		wp_enqueue_script( 'jquery.gridrotator', get_template_directory_uri() . '/js/jquery.gridrotator.js', false, THEMEVERSION, true );
		wp_enqueue_script( 'script-gridrotator', get_template_directory_uri() . '/templates/script-gridrotator.php?grid=' . $custom_id, false, THEMEVERSION, true );

		$html .= '<div id="' . $custom_id . '" class="ri-grid ri-grid-size-3">';

		if ( ! empty( $logo ) or ! empty( $title ) or ! empty( $subtitle ) ) {
			$html .= '<div class="ri-grid-overlay">';

			$html .= '<div class="ri-grid-wrapper"><div class="ri-grid-item"><div class="ri-grid-border" ' . $custom_border_css . '><div class="ri-grid-content" ' . $custom_bg_css . '>';
			if ( empty( $logo ) && ! empty( $title ) ) {
				$html .= '<h1 ' . $custom_font_css . '>' . urldecode( $title ) . '</h1>';
			} elseif ( ! empty( $logo ) ) {
				$html .= '<img src="' . esc_url( $logo ) . '" class="grid-logo" alt=""/>';
			}

			if ( ! empty( $subtitle ) ) {
					$html .= '<div class="or-spacer">
					<div class="mask"></div>
					<span></span>
				</div>';

						$html .= '<div class="page_tagline grid" ' . $custom_font_css . '>' . urldecode( $subtitle ) . '</div>';
				}

			$html .= '</div></div></div></div></div>';
		}

		$html .= '<ul>';

		foreach ( $images_arr as $key => $image ) {
			$image_url = wp_get_attachment_image_src( $image, 'gallery_c', true );
			$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true );

			$html .= '<li><a href="#"><img src="' . esc_url( $image_url[0] ) . '" alt="' . esc_attr( $image_alt ) . '"/></a></li>';
		}

		$html .= '</ul>';
		$html .= '</div>';
	}// End if().

	$html .= '</div>';

	return $html;
}



function anva_element_gallery_masonry( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'gallery_id' => '',
		'margin' => '',
		'bgcolor' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$custom_css = '';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}
	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . ' nopadding" style="' . $custom_css . '">';

	$html .= do_shortcode( '[tg_masonry_gallery gallery_id="' . esc_attr( $gallery_id ) . '" margin="' . esc_attr( $margin ) . '"]' );

	$html .= '</div>';

	return $html;
}




function anva_image_fullwidth( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'image' => '',
		'height' => 400,
		'display_caption' => 1,
		'background_position' => 'center',
		'padding' => 0,
		'custom_css' => '',
	), $atts));

	if ( ! is_numeric( $height ) ) {
		$height = 400;
	}
	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper withbg"';

	if ( ! empty( $image ) ) {
		$html .= ' style="background-image:url(' . esc_url( $image ) . ');background-size:cover;background-position:center ' . esc_attr( $background_position ) . ';height:' . esc_attr( $height ) . 'px;position:relative;"';
	}

	$html .= '>';

	if ( ! empty( $display_caption ) ) {
		// Get image meta data
		$image_id = pp_get_image_id( $image );
		$image_caption = get_post_field( 'post_excerpt', $image_id );

		if ( ! empty( $image_caption ) ) {
			$html .= '<div id="gallery_caption" class="anva_fullwidth"><h2>' . $image_caption . '</h2></div>';
		}
	}

	$html .= '</div>';
	$html .= '</div>';

	return $html;

}




function anva_image_parallax( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'image' => '',
		'height' => 400,
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	if ( ! is_numeric( $height ) ) {
		$height = 400;
	}

	$html = '<div ' . $sec_id . ' class="parallax" ';

	if ( ! empty( $height ) ) {
		$custom_css .= 'height:' . $height . 'px;';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="background-image:url(' . esc_url( $image ) . ');' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= ' data-stellar-background-ratio="0.5">';
	$html .= '</div>';

	return $html;
}



function anva_image_fixed_width( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'image' => '',
		'display_caption' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	if ( ! empty( $image ) ) {
		$html .= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		$html .= '<a href="' . esc_url( $image ) . '" class="img_frame"><img src="' . esc_url( $image ) . '" alt="" class="portfolio_img"/></a>';
		$html .= '</div>';
	}

	if ( ! empty( $display_caption ) ) {
		// Get image meta data
		$image_id = pp_get_image_id( $image );
		$image_caption = get_post_field( 'post_excerpt', $image_id );
		$image_description = get_post_field( 'post_content', $image_id );

		if ( ! empty( $image_caption ) or ! empty( $image_description ) ) {
			$html .= '<div class="image_caption">' . $image_caption . '</div>';
			$html .= '<div class="image_description">' . $image_description . '</div>';
		}
	}

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;

}




function anva_content_half_bg( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'background' => '',
		'background_parallax' => '',
		'background_position' => '',
		'padding' => 30,
		'bgcolor' => '#ffffff',
		'opacity' => 100,
		'fontcolor' => '',
		'align' => '',
		'custom_css' => '',
	), $atts));

	if ( empty( $bgcolor ) ) {
		$bgcolor = '#ffffff';
	}

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . ' withsmallpadding anva_content_half_bg ';

	if ( ! empty( $background ) ) {
		$html .= 'withbg ';
		$custom_css .= 'background-image:url(' . esc_url( $background ) . ');';
	}

	if ( ! empty( $background_parallax ) ) {
		$html .= 'parallax ';
	}

	if ( ! empty( $background_position ) ) {
		$custom_css .= 'background-position: center ' . esc_attr( $background_position ) . ';';
	}

	$html .= '"';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $custom_css ) ) {
		$html .= ' style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	if ( ! empty( $background_parallax ) ) {
		$html .= ' data-stellar-background-ratio="0.5" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	if ( ! empty( $content ) ) {
		$custom_bgcolor_css = '';
		if ( ! empty( $bgcolor ) ) {
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity / 100;
			$bgcolor = HexToRGB( $bgcolor );

			$custom_bgcolor_css .= 'background:' . $ori_bgcolor . ';';
			$custom_bgcolor_css .= 'background:rgb(' . $bgcolor['r'] . ',' . $bgcolor['g'] . ',' . $bgcolor['b'] . ',' . $opacity . ');';
			$custom_bgcolor_css .= 'background:rgba(' . $bgcolor['r'] . ',' . $bgcolor['g'] . ',' . $bgcolor['b'] . ',' . $opacity . ');';
		}
		$custom_css_fontcolor = '';
		if ( ! empty( $fontcolor ) ) {
			$custom_css_fontcolor .= 'color:' . esc_attr( $fontcolor ) . ';';
		}

		if ( $align == 'left' ) {
			$html .= '<div class="one_half_bg" style="' . esc_attr( $custom_bgcolor_css . $custom_css_fontcolor ) . '">';
		} else {
			$html .= '<div class="one_half_bg floatright" style="' . esc_attr( $custom_bgcolor_css . $custom_css_fontcolor ) . '">';
		}

		// Add title and content
		if ( ! empty( $title ) ) {
			$html .= '<h2 class="anva_title" style="' . esc_attr( $custom_css_fontcolor ) . '">' . urldecode( $title ) . '</h2>';
			$html .= '<div class="or-spacer">
				<div class="mask"></div>
				<span></span>
			</div>';
		}

		if ( ! empty( $subtitle ) ) {
			$html .= '<div class="anva_subtitle" style="' . esc_attr( $custom_css_fontcolor ) . '">' . urldecode( $subtitle ) . '</div>';
		}

		if ( ! empty( $content ) ) {
			$html .= '' . do_shortcode( anva_apply_content( $content ) );
		}
		$html .= '</div>';
	}// End if().

	$html .= '</div></div></div>';

	return $html;

}



function anva_image_half_fixed_width( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'image' => '',
		'align' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	if ( empty( $align ) ) {
		$align = 'left';
	}

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	// Display Title
	if ( ! empty( $title ) ) {
		$html .= '<h2 class="anva_title">' . $title . '</h2>';
	}

	if ( $align == 'left' ) {
		$html .= '<div class="one_half">';
		if ( ! empty( $image ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image ) . '" class="img_frame"><img src="' . esc_url( $image ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div></div>';
		}
		$html .= '</div>';

		$html .= '<div class="one_half last content_middle animate">';
		if ( ! empty( $content ) ) {
			$html .= $content;
		}
		$html .= '</div>';
	} else {
		$html .= '<div class="one_half content_middle animate textright">';
		if ( ! empty( $content ) ) {
			$html .= $content;
		}
		$html .= '</div>';

		$html .= '<div class="one_half last">';
		if ( ! empty( $image ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image ) . '" class="img_frame"><img src="' . esc_url( $image ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div></div>';
		}
		$html .= '</div>';
	}

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;

}



function anva_image_half_fullwidth( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'image' => '',
		'height' => 500,
		'align' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'textalign' => 'center',
		'fontcolor' => '',
		'custom_css' => '',
	), $atts));

	if ( empty( $align ) ) {
		$align = 'left';
	}

	if ( ! is_numeric( $height ) ) {
		$height = 500;
	}

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}
	if ( ! empty( $fontcolor ) ) {
		$custom_css .= 'color:' . esc_attr( $fontcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper nopadding">';

	$content_custom_css = '';
	if ( $align == 'left' ) {
		$html .= '<div class="one_half_bg animate"';
		if ( ! empty( $image ) ) {
			$html .= ' style="background-image:url(' . esc_url( $image ) . ');height:' . esc_attr( $height ) . 'px;"';
		}
		$html .= '></div>';

		$content_custom_css .= 'style="padding:' . esc_attr( $padding ) . 'px;"';
		$html .= '<div class="one_half_bg content_middle animate" ' . $content_custom_css . '>';

		// Display Title
		if ( ! empty( $title ) ) {
			$html .= '<h2 class="anva_title" ';
			if ( ! empty( $fontcolor ) ) {
				$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
			}
			$html .= '>' . esc_html( urldecode( $title ) ) . '</h2>';
			$html .= '<div class="or-spacer ' . esc_attr( $textalign ) . '">
				<div class="mask"></div>
				<span></span>
			</div>';
		}
		if ( ! empty( $subtitle ) ) {
			$html .= '<div class="anva_subtitle" ';
			if ( ! empty( $fontcolor ) ) {
				$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
			}
			$html .= '>' . esc_html( urldecode( $subtitle ) ) . '</div>';
		}
		if ( ! empty( $content ) ) {
			$html .= '<div class="nicepadding">' . do_shortcode( $content ) . '</div>';
		}
		$html .= '</div>';
	} else {
		$content_custom_css .= 'style="padding:' . esc_attr( $padding ) . 'px;"';
		$html .= '<div class="one_half_bg content_middle animate textright" ' . $content_custom_css . '>';

		// Display Title
		if ( ! empty( $title ) ) {
			$html .= '<h2 class="anva_title" ';
			if ( ! empty( $fontcolor ) ) {
				$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
			}
			$html .= '>' . esc_html( urldecode( $title ) ) . '</h2>';
			$html .= '<div class="or-spacer ' . esc_attr( $textalign ) . '">
				<div class="mask"></div>
				<span></span>
			</div>';
		}
		if ( ! empty( $subtitle ) ) {
			$html .= '<div class="anva_subtitle" ';
			if ( ! empty( $fontcolor ) ) {
				$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
			}
			$html .= '>' . esc_html( urldecode( $subtitle ) ) . '</div>';
		}
		if ( ! empty( $content ) ) {
			$html .= '<div class="nicepadding">' . do_shortcode( $content ) . '</div>';
		}
		$html .= '</div>';

		$html .= '<div class="one_half_bg animate"';
		if ( ! empty( $image ) ) {
			$html .= ' style="background-image:url(' . esc_url( $image ) . ');height:' . esc_attr( $height ) . 'px;"';
		}
		$html .= '></div>';
	}// End if().

	$html .= '</div>';
	$html .= '</div>';

	return $html;

}




function anva_two_cols_images( $atts, $content ) {
	// Extract short code attr
	extract( shortcode_atts( array(
		'size' 						=> 'one',
		'slug' 						=> '',
		'title' 					=> '',
		'image1' 					=> '',
		'image2' 					=> '',
		'display_caption' => 1,
		'padding' 				=> 0,
		'bgcolor' 				=> '',
		'custom_css' 			=> '',
	), $atts ) );

	$images = array();
	$images[] = $image1;
	$images[] = $image2;
	$columns  = 2;
	$counter  = 0;

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="section-two-cols-images ' . esc_attr( $size ) . '" ';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '>';
	$html .= '<div class="images-wrapper clearfix">';

	foreach ( $images as $key => $image ) {

		if ( ! empty( $image ) ) {

			$html .= '<div class="grid_6 nobottommargin">';
			$html .= '<div class="image-wrapper" data-lightbox="gallery">';
			$html .= '<a href="' . esc_url( $image ) . '" data-lightbox="gallery-item" data-animate="fadeIn">';
			$html .= '<img src="' . esc_url( $image ) . '" alt="" />';
			$html .= '</a>';

			if ( ! empty( $display_caption ) ) {
				$image_id = pp_get_image_id( $image );
				$caption  = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image-caption">' . esc_html( $image_caption ) . '</div><!-- .image-caption (end) -->';
				}
			}
			$html .= '</div><!-- .image-wrapper (end) -->';
			$html .= '</div><!-- .grid_6 (end) -->';
		}
}

	$html .= '</div><!-- .images-wrapper (end) -->';
	$html .= '</div><!-- .section-two-cols-images (end) -->';

	return $html;
}


function anva_three_cols_images( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'image3' => '',
		'display_caption' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	// First image
	$html .= '<div class="one_third">';
	if ( ! empty( $image1 ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image1 ) . '" class="img_frame"><img src="' . esc_url( $image1 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image1 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	// Second image
	$html .= '<div class="one_third">';
	if ( ! empty( $image2 ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image2 ) . '" class="img_frame"><img src="' . esc_url( $image2 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image2 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	// Third image
	$html .= '<div class="one_third last animate">';
	if ( ! empty( $image3 ) ) {
			$html .= '<div class="image_classic_frame expand"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image3 ) . '" class="img_frame"><img src="' . esc_url( $image3 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image3 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;

}




function anva_three_images_block( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image_portrait' => '',
		'image_portrait_align' => 'left',
		'image2' => '',
		'image3' => '',
		'display_caption' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	if ( empty( $image_portrait_align ) ) {
		$image_portrait_align = 'left';
	}

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	if ( $image_portrait_align == 'left' ) {
		// First column
		$html .= '<div class="one_half">';
		if ( ! empty( $image_portrait ) ) {
				$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
				$html .= '<a href="' . esc_url( $image_portrait ) . '" class="img_frame"><img src="' . esc_url( $image_portrait ) . '" alt="" class="portfolio_img"/></a>';
				$html .= '</div>';
				if ( ! empty( $display_caption ) ) {
				// Get image meta data
				$image_id = pp_get_image_id( $image_portrait );
				$image_caption = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image_caption">' . $image_caption . '</div>';
					}
				}
				$html .= '</div>';
		}
		$html .= '</div>';

		// Second column
		$html .= '<div class="one_half last">';
		if ( ! empty( $image2 ) ) {
				$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
				$html .= '<a href="' . esc_url( $image2 ) . '" class="img_frame"><img src="' . esc_url( $image2 ) . '" alt="" class="portfolio_img"/></a>';
				$html .= '</div>';
				if ( ! empty( $display_caption ) ) {
				// Get image meta data
				$image_id = pp_get_image_id( $image2 );
				$image_caption = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image_caption">' . $image_caption . '</div>';
					}
				}
				$html .= '</div>';
		}

		$html .= '';

		if ( ! empty( $image3 ) ) {
				$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
				$html .= '<a href="' . esc_url( $image3 ) . '" class="img_frame"><img src="' . esc_url( $image3 ) . '" alt="" class="portfolio_img"/></a>';
				$html .= '</div>';
				if ( ! empty( $display_caption ) ) {
				// Get image meta data
				$image_id = pp_get_image_id( $image3 );
				$image_caption = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image_caption">' . $image_caption . '</div>';
					}
				}
				$html .= '</div>';
		}

		$html .= '</div>';
	} else {
		// First column
		$html .= '<div class="one_half">';
		if ( ! empty( $image2 ) ) {
				$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
				$html .= '<a href="' . esc_url( $image2 ) . '" class="img_frame"><img src="' . esc_url( $image2 ) . '" alt="" class="portfolio_img"/></a>';
				$html .= '</div>';
				if ( ! empty( $display_caption ) ) {
				// Get image meta data
				$image_id = pp_get_image_id( $image2 );
				$image_caption = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image_caption">' . $image_caption . '</div>';
					}
				}
				$html .= '</div>';
		}

		$html .= '';

		if ( ! empty( $image3 ) ) {
				$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
				$html .= '<a href="' . esc_url( $image3 ) . '" class="img_frame"><img src="' . esc_url( $image3 ) . '" alt="" class="portfolio_img"/></a>';
				$html .= '</div>';
				if ( ! empty( $display_caption ) ) {
				// Get image meta data
				$image_id = pp_get_image_id( $image3 );
				$image_caption = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image_caption">' . $image_caption . '</div>';
					}
				}
				$html .= '</div>';
		}

		$html .= '</div>';

		// Second column
		$html .= '<div class="one_half last">';
		if ( ! empty( $image_portrait ) ) {
				$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
				$html .= '<a href="' . esc_url( $image_portrait ) . '" class="img_frame"><img src="' . esc_url( $image_portrait ) . '" alt="" class="portfolio_img"/></a>';
				$html .= '</div>';
				if ( ! empty( $display_caption ) ) {
				// Get image meta data
				$image_id = pp_get_image_id( $image_portrait );
				$image_caption = get_post_field( 'post_excerpt', $image_id );

				if ( ! empty( $image_caption ) ) {
					$html .= '<div class="image_caption">' . $image_caption . '</div>';
					}
				}
				$html .= '</div>';
		}
		$html .= '</div>';
	}// End if().

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;

}




function anva_four_images_block( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'image3' => '',
		'image4' => '',
		'display_caption' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . '" ';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	// First image
	$html .= '<div class="one_half">';
	if ( ! empty( $image1 ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image1 ) . '" class="img_frame"><img src="' . esc_url( $image1 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image1 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	// Second image
	$html .= '<div class="one_half last">';
	if ( ! empty( $image2 ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image2 ) . '" class="img_frame"><img src="' . esc_url( $image2 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image2 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	$html .= '';

	// Third image
	$html .= '<div class="one_half">';
	if ( ! empty( $image3 ) ) {
			$html .= '<div class="image_classic_frame expand animate"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image3 ) . '" class="img_frame"><img src="' . esc_url( $image3 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image3 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	// Fourth image
	$html .= '<div class="one_half last animate">';
	if ( ! empty( $image4 ) ) {
			$html .= '<div class="image_classic_frame expand"><div class="image_wrapper">';
			$html .= '<a href="' . esc_url( $image4 ) . '" class="img_frame"><img src="' . esc_url( $image4 ) . '" alt="" class="portfolio_img"/></a>';
			$html .= '</div>';
			if ( ! empty( $display_caption ) ) {
			// Get image meta data
			$image_id = pp_get_image_id( $image4 );
			$image_caption = get_post_field( 'post_excerpt', $image_id );

			if ( ! empty( $image_caption ) ) {
				$html .= '<div class="image_caption">' . $image_caption . '</div>';
				}
			}
			$html .= '</div>';
	}
	$html .= '</div>';

	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	return $html;

}



function anva_blog_grid( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'cat' => '',
		'items' => '',
		'padding' => '',
		'custom_css' => '',
		'link_title' => '',
		'link_url' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . $size . ' withsmallpadding"';
	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . urldecode( $custom_css ) . '" ';
	}

	$html .= '>';

	$html .= '<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';

	if ( ! is_numeric( $items ) ) {
		$items = 3;
	}

	// Get blog posts
	$postsperpage = get_option( 'posts_per_page' );

	$args = array(
			'numberposts' => $items,
			'order' => 'DESC',
			'orderby' => 'post_date',
			'post_type' => array( 'post' ),
			'suppress_filters' => 0,
	);

	if ( ! empty( $cat ) ) {
		$args['category'] = $cat;
	}
	$posts_arr = get_posts( $args );

	if ( ! empty( $posts_arr ) && is_array( $posts_arr ) ) {
		$html .= '<div class="blog_grid_wrapper sidebar_content full_width anva_blog_posts">';

		foreach ( $posts_arr as $key => $anva_post ) {
			$animate_layer = $key + 7;
			$image_thumb = '';

			if ( has_post_thumbnail( $anva_post->ID, 'large' ) ) {
					$image_id = get_post_thumbnail_id( $anva_post->ID );
					$image_thumb = wp_get_attachment_image_src( $image_id, 'large', true );
			}

			$html .= '<div id="post-' . $anva_post->ID . '" class="post type-post hentry status-publish">
			<div class="post_wrapper grid_layout">';

			if ( ! empty( $image_thumb ) ) {
						$small_image_url = wp_get_attachment_image_src( $image_id, 'blog_r', true );

				$html .= '<div class="post_img small">
						<a href="' . esc_url( get_permalink( $anva_post->ID ) ) . '">
							<img src="' . esc_url( $small_image_url[0] ) . '" alt="" class=""/>
						</a>
				</div>';
				}

				$html .= '<div class="blog_grid_content">';

				$html .= '<div class="post_header grid_layout">
				<div class="post_subtitle">';

					$post_categories = wp_get_post_categories( $anva_post->ID );
				if ( ! empty( $post_categories ) ) {
				foreach ( $post_categories as $c ) {
					$cat = get_category( $c );
					$html .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . $cat->name . '</a>';
					}
				}

			$html .= '</div>
					<h5><a href="' . esc_url( get_permalink( $anva_post->ID ) ) . '" title="' . get_the_title( $anva_post->ID ) . '">' . get_the_title( $anva_post->ID ) . '</a></h5>
			</div>';

			$html .= '<div class="post_grid_excerpt">' . pp_substr( strip_shortcodes( pp_get_the_excerpt( $anva_post->ID ) ), 150 ) . '</div>';

				$html .= '
			</div>
	</div>
</div>';
		}// End foreach().

		$html .= '</div>';
	}// End if().

	$html .= '</div></div></div></div>';

	if ( ! empty( $link_title ) && ! empty( $link_url ) ) {
		$html .= '<a href="' . esc_url( $link_url ) . '" class="button continue_anva_blog">' . urldecode( $link_title ) . '</a>';
	}

	return $html;
}



function anva_pricing( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'skin' => 'normal',
		'items' => 3,
		'cat' => '',
		'columns' => '3',
		'highlightcolor' => '#001d2c',
		'bgcolor' => '',
		'padding' => 30,
		'custom_css' => '',
	), $atts));

	if ( ! is_numeric( $items ) ) {
		$items = 4;
	}

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . ' anva_pricing"';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= ' style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '><div class="page_content_wrapper"><div class="inner">';

	$pricing_order = 'ASC';
	$pricing_order_by = 'menu_order';

	// Get portfolio items
	$args = array(
			'numberposts' => $items,
			'order' => $pricing_order,
			'orderby' => $pricing_order_by,
			'post_type' => array( 'pricing' ),
	);

	if ( ! empty( $cat ) ) {
		$args['pricingcats'] = $cat;
	}
	$pricing_arr = get_posts( $args );

	// Check display columns
	$count_column = 3;
	$columns_class = 'one_third';

	switch ( $columns ) {
		case 2:
			$count_column = 2;
			$columns_class = 'one_half';
		break;

		case 3:
		default:
			$count_column = 3;
			$columns_class = 'one_third';
		break;

		case 4:
			$count_column = 4;
			$columns_class = 'one_fourth';
		break;
	}

	$custom_header = '';
	$custom_button = '';
	$custom_price = '';
	switch ( $skin ) {
		case 'light':
		default:
			$custom_header = 'color:' . $highlightcolor . ';';
			$custom_price = 'color:' . $highlightcolor . ';';
			$custom_button = 'background:' . $highlightcolor . ';border-color:' . $highlightcolor . ';color:#fff;';

		break;

		case 'normal':
			$custom_header = 'background:' . $highlightcolor . ';';
			$custom_price = 'color:' . $highlightcolor . ';';
			$custom_button = 'background:' . $highlightcolor . ';border-color:' . $highlightcolor . ';color:#fff;';
		break;
	}

	if ( ! empty( $pricing_arr ) && is_array( $pricing_arr ) ) {
		$html .= '<div class="pricing_content_wrapper ' . $skin . '">';
		$last_class = '';

		foreach ( $pricing_arr as $key => $pricing ) {
			if ( ($key + 1) % $count_column == 0 ) {
				$last_class = 'last';
			} else {
				$last_class = '';
			}

			// Check if featured
			$priing_featured_class = '';
			$priing_button_class = '';
			$pricing_plan_featured = get_post_meta( $pricing->ID, 'pricing_featured', true );
			if ( ! empty( $pricing_plan_featured ) ) {
				$priing_featured_class = 'featured';
			}

			$html .= '<div class="pricing ' . esc_attr( $columns_class ) . ' ' . esc_attr( $priing_featured_class ) . ' ' . esc_attr( $last_class ) . '">';
			$html .= '<ul class="pricing_wrapper">';

			$html .= '<li class="title_row ' . esc_attr( $priing_featured_class ) . '" style="' . esc_attr( $custom_header ) . '">' . $pricing->post_title . '</li>';

			// Check price
			$pricing_plan_currency = get_post_meta( $pricing->ID, 'pricing_plan_currency', true );
			$pricing_plan_price = get_post_meta( $pricing->ID, 'pricing_plan_price', true );
			$pricing_plan_time = get_post_meta( $pricing->ID, 'pricing_plan_time', true );

			$html .= '<li class="price_row">';
			$html .= '<strong>' . $pricing_plan_currency . '</strong>';
			$html .= '<em class="exact_price" style="' . esc_attr( $custom_price ) . '">' . $pricing_plan_price . '</em>';
			$html .= '<em class="time">' . $pricing_plan_time . '</em>';
			$html .= '</li>';

			// Get pricing features
			$pricing_plan_features = get_post_meta( $pricing->ID, 'pricing_plan_features', true );
			$pricing_plan_features = trim( $pricing_plan_features );
			$pricing_plan_features_arr = explode( "\n", $pricing_plan_features );
			$pricing_plan_features_arr = array_filter( $pricing_plan_features_arr, 'trim' );

			foreach ( $pricing_plan_features_arr as $feature ) {
					$html .= '<li>' . $feature . '</li>';
			}

			// Get button
			$pricing_button_text = get_post_meta( $pricing->ID, 'pricing_button_text', true );
			$pricing_button_url = get_post_meta( $pricing->ID, 'pricing_button_url', true );

			$html .= '<li class="button_row ' . esc_attr( $priing_featured_class ) . '"><a href="' . esc_url( $pricing_button_url ) . '" class="button"  style="' . esc_attr( $custom_button ) . '">' . $pricing_button_text . '</a></li>';

			$html .= '</ul>';
			$html .= '</div>';
		}// End foreach().

		$html .= '</div>';
	}// End if().

	$html .= '</div></div></div>';

	return $html;
}

function anva_testimonial_column( $atts, $content ) {
	remove_filter( 'the_content', 'pp_formatter', 99 );

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'columns' => 2,
		'items' => 4,
		'cat' => '',
		'fontcolor' => '',
		'bgcolor' => '',
		'padding' => 30,
		'custom_css' => '',
	), $atts));

	if ( ! is_numeric( $items ) ) {
		$items = 4;
	}

	if ( ! is_numeric( $columns ) ) {
		$columns = 2;
	}

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="' . esc_attr( $size ) . ' withsmallpadding anva_testimonial_column"';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $fontcolor ) ) {
		$custom_css .= 'color:' . esc_attr( $fontcolor ) . ';';
	}
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	if ( ! empty( $custom_css ) ) {
		$html .= ' style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '>';

	$testimonials_order = 'ASC';
	$testimonials_order_by = 'menu_order';

	// Check display columns
	$count_column = 3;
	$columns_class = 'one_third';

	switch ( $columns ) {
		case 2:
			$count_column = 2;
			$columns_class = 'one_half';
		break;

		case 3:
		default:
			$count_column = 3;
			$columns_class = 'one_third';
		break;

		case 4:
			$count_column = 4;
			$columns_class = 'one_fourth';
		break;
	}

	// Get testimonial items
	$args = array(
			'numberposts' => $items,
			'order' => $testimonials_order,
			'orderby' => $testimonials_order_by,
			'post_type' => array( 'testimonials' ),
	);

	if ( ! empty( $cat ) ) {
		$args['testimonialcats'] = $cat;
	}
	$testimonial_arr = get_posts( $args );

	if ( ! empty( $testimonial_arr ) && is_array( $testimonial_arr ) ) {
		$html .= '<div class="page_content_wrapper"><div class="inner"><div class="testimonial_wrapper">';

		foreach ( $testimonial_arr as $key => $testimonial ) {
			$image_url = '';
			$testimonial_ID = $testimonial->ID;

			// Get customer picture
			if ( has_post_thumbnail( $testimonial_ID, 'thumbnail' ) ) {
					$image_id = get_post_thumbnail_id( $testimonial_ID );
					$small_image_url = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
			}

			$last_class = '';
			if ( ($key + 1) % $count_column == 0 ) {
				$last_class = 'last';
			}

			// Begin display HTML
			$html .= '<div class="' . esc_attr( $columns_class ) . ' testimonial_column_element animated' . ($key + 1) . ' ' . esc_attr( $last_class ) . '">';

			// Get testimonial meta
			$testimonial_name = get_post_meta( $testimonial_ID, 'testimonial_name', true );
			$testimonial_position = get_post_meta( $testimonial_ID, 'testimonial_position', true );
			$testimonial_company_name = get_post_meta( $testimonial_ID, 'testimonial_company_name', true );
			$testimonial_company_website = get_post_meta( $testimonial_ID, 'testimonial_company_website', true );

			if ( ! empty( $small_image_url[0] ) ) {
				$html .= '<div class="testimonial_image animated" data-animation="bigEntrance">';
				$html .= '<img class="team_pic" src="' . esc_url( $small_image_url[0] ) . '" alt="' . esc_attr( $testimonial_name ) . '"/>';
				$html .= '</div>';
			}

			if ( ! empty( $testimonial->post_content ) ) {
				$html .= '<div class="testimonial_content">';
				$html .= $testimonial->post_content;

				if ( ! empty( $testimonial_name ) ) {
					$html .= '<div class="testimonial_customer">';
					$html .= '<h6 ';

					if ( ! empty( $fontcolor ) ) {
						$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
					}

					$html .= '>' . $testimonial_name . '</h6>';

					if ( ! empty( $testimonial_position ) ) {
						$html .= '<div class="testimonial_customer_position" ';

						if ( ! empty( $fontcolor ) ) {
							$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
						}

						$html .= '>' . $testimonial_position . '</div>';
					}

					if ( ! empty( $testimonial_company_name ) ) {
						$html .= '-<div class="testimonial_customer_company">';

						if ( ! empty( $testimonial_company_website ) ) {
							$html .= '<a href="' . esc_url( $testimonial_company_website ) . '" target="_blank" ';

							if ( ! empty( $fontcolor ) ) {
								$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
							}

							$html .= '>';
						}

						$html .= $testimonial_company_name;

						if ( ! empty( $testimonial_company_website ) ) {
							$html .= '</a>';
						}

						$html .= '</div>';
					}

					$html .= '</div>';
				}// End if().

				$html .= '</div>';

			}// End if().

			$html .= '</div>';

			if ( ($key + 1) % $count_column == 0 ) {
					$html .= '';
			}
		}// End foreach().

		$html .= '</div></div></div>';
	}// End if().

	$html .= '</div>';

	return $html;
}

function anva_contact_map( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'slug' => '',
		'subtitle' => '',
		'lat' => 0,
		'long' => 0,
		'zoom' => 8,
		'type' => '',
		'popup' => '',
		'address' => '',
		'marker' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'buttonbgcolor' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="one nopadding" ';

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . esc_attr( urldecode( $custom_css ) ) . '" ';
	}

	$html .= '>';

	$html .= '<div class="page_content_wrapper floatleft nopadding"><div class="one_half_bg contact_form" ';

	$contact_form_custom_css = '';
	if ( ! empty( $bgcolor ) ) {
		$contact_form_custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}
	if ( ! empty( $fontcolor ) ) {
		$contact_form_custom_css .= 'color:' . esc_attr( $fontcolor ) . ';';
	}

	if ( ! empty( $contact_form_custom_css ) ) {
		$html .= 'style="' . esc_attr( $contact_form_custom_css ) . '"';
	}

	$html .= '>';

	// Display Title
	if ( ! empty( $title ) ) {
		$html .= '<h2 class="anva_title" ';
		if ( ! empty( $fontcolor ) ) {
			$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
		}
		$html .= '>' . esc_html( urldecode( $title ) ) . '</h2>';
		$html .= '<div class="or-spacer">
			<div class="mask"></div>
			<span></span>
		</div>';
	}

	// Display Content
	if ( ! empty( $subtitle ) ) {
		$html .= '<div class="anva_subtitle" ';
		if ( ! empty( $fontcolor ) ) {
			$html .= 'style="color:' . esc_attr( $fontcolor ) . ';"';
		}
		$html .= '>' . esc_html( urldecode( $subtitle ) ) . '</div>';
	}

	// Display Content
	if ( ! empty( $content ) ) {
		$html .= '<div class="anva_content">' . urldecode( $content ) . '</div>';
	}

	// Display contact form
	// Get contact form random ID
	$custom_id = time() . rand();
		$pp_contact_form = unserialize( get_option( 'pp_contact_form_sort_data' ) );

		if ( ! is_ssl() ) {
		wp_enqueue_script( 'google_maps', 'http://maps.google.com/maps/api/js?sensor=false', false, THEMEVERSION, true );
	} else {
			wp_enqueue_script( 'google_maps', 'https://maps.google.com/maps/api/js?sensor=false', false, THEMEVERSION, true );
	}

		wp_enqueue_script( 'jquery.validate', get_template_directory_uri() . '/js/jquery.validate.js', false, THEMEVERSION, true );

		wp_register_script( 'script-contact-form', get_template_directory_uri() . '/templates/script-contact-form.php?form=' . $custom_id, false, THEMEVERSION, true );
	$params = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'ajax_nonce' => wp_create_nonce( 'tgajax-post-contact-nonce' ),
	);
	wp_localize_script( 'script-contact-form', 'tgAjax', $params );
	wp_enqueue_script( 'script-contact-form', get_template_directory_uri() . '/templates/script-contact-form.php?form=' . $custom_id, false, THEMEVERSION, true );

		$html .= '<div id="reponse_msg_' . $custom_id . '" class="contact_form_response"><ul></ul></div>';

		$html .= '<form id="contact_form_' . $custom_id . '" class="contact_form_wrapper" method="post" action="/wp-admin/admin-ajax.php">';
	$html .= '<input type="hidden" id="action" name="action" value="pp_contact_mailer"/>';

		if ( is_array( $pp_contact_form ) && ! empty( $pp_contact_form ) ) {
		foreach ( $pp_contact_form as $form_input ) {
			switch ( $form_input ) {
				case 1:

				$html .= '<label for="your_name">' . __( 'Name *', 'anva' ) . '</label>
						<input id="your_name" name="your_name" type="text" class="required_field" placeholder="' . __( 'Name *', 'anva' ) . '"/>
						';

				break;

				case 2:

				$html .= '<label for="email">' . __( 'Email *', 'anva' ) . '</label>
						<input id="email" name="email" type="text" class="required_field email" placeholder="' . __( 'Email *', 'anva' ) . '"/>
						';

				break;

				case 3:

				$html .= '<label for="message">' . __( 'Message *', 'anva' ) . '</label>
						<textarea id="message" name="message" rows="7" cols="10" class="required_field" placeholder="' . __( 'Message *', 'anva' ) . '"></textarea>
						';

				break;

				case 4:

				$html .= '<label for="address">' . __( 'Address', 'anva' ) . '</label>
						<input id="address" name="address" type="text" placeholder="' . __( 'Address', 'anva' ) . '"/>
						';

				break;

				case 5:

				$html .= '<label for="phone">' . __( 'Phone', 'anva' ) . '</label>
						<input id="phone" name="phone" type="text" placeholder="' . __( 'Phone', 'anva' ) . '"/>
						';

				break;

				case 6:

				$html .= '<label for="mobile">' . __( 'Mobile', 'anva' ) . '</label>
						<input id="mobile" name="mobile" type="text" placeholder="' . __( 'Mobile', 'anva' ) . '"/>
						';

				break;

				case 7:

				$html .= '<label for="company">' . __( 'Company Name', 'anva' ) . '</label>
						<input id="company" name="company" type="text" placeholder="' . __( 'Company Name', 'anva' ) . '"/>
						';

				break;

				case 8:

				$html .= '<label for="country">' . __( 'Country', 'anva' ) . '</label>
						<input id="country" name="country" type="text" placeholder="' . __( 'Country', 'anva' ) . '"/>
						';
				break;
			}// End switch().
			}// End foreach().
			}// End if().

			$pp_contact_enable_captcha = get_option( 'pp_contact_enable_captcha' );

			if ( ! empty( $pp_contact_enable_captcha ) ) {

	$html .= '<div id="captcha-wrap">
				<div class="captcha-box">
					<img src="' . get_template_directory_uri() . '/get_captcha.php" alt="" id="captcha" />
				</div>
				<div class="text-box">
					<label>Type the two words:</label>
					<input name="captcha-code" type="text" id="captcha-code">
				</div>
				<div class="captcha-action">
					<img src="' . get_template_directory_uri() . '/images/refresh.jpg"  alt="" id="captcha-refresh" />
				</div>
			</div>';

		}

		$html .= '<br/><br/><div class="contact_submit_wrapper">
			<input id="contact_submit_btn' . $custom_id . '" name="contact_submit_btn' . $custom_id . '" type="submit" class="solidbg" value="' . __( 'Send Message', 'anva' ) . '" ';

	if ( ! empty( $buttonbgcolor ) ) {
		$html .= 'style="background-color:' . esc_attr( $buttonbgcolor ) . ';border-color:' . esc_attr( $buttonbgcolor ) . '"';
	}

		$html .= '/>
		</div>';

	$html .= '</form>';

	$html .= '</div>';

	// Display Map
	$html .= '<div class="one_half_bg nopadding" style="height:100%">';
	$html .= '<div id="map' . $custom_id . '" class="map_shortcode_wrapper" style="width:100%;height:100%">';
	$html .= '<div class="map-marker" ';

	if ( ! empty( $popup ) ) {
		$html .= 'data-title="' . esc_attr( urldecode( $popup ) ) . '" ';
	}

	if ( ! empty( $lat ) && ! empty( $long ) ) {
		$html .= 'data-latlng="' . esc_attr( urldecode( $lat ) ) . ',' . esc_attr( urldecode( $long ) ) . '" ';
	}

	if ( ! empty( $address ) ) {
		$html .= 'data-address="' . esc_attr( urldecode( $address ) ) . '" ';
	}

	if ( ! empty( $marker ) ) {
		$html .= 'data-icon="' . esc_attr( urldecode( $marker ) ) . '" ';
	}

	$html .= '>';

	if ( ! empty( $popup ) ) {
		$html .= '<div class="map-infowindow">' . urldecode( $popup ) . '</div>';
	}

	$html .= '</div>';
	$html .= '</div>';

	$ext_attr = array(
		'id' => 'map' . $custom_id,
		'zoom' => $zoom,
		'type' => 'ROADMAP',
	);

	$ext_attr_serialize = serialize( $ext_attr );

	wp_enqueue_script( 'simplegmaps', get_template_directory_uri() . '/js/jquery.simplegmaps.min.js', false, THEMEVERSION, true );
	wp_enqueue_script( 'script-contact-map' . $custom_id, get_template_directory_uri() . '/templates/script-map-shortcode.php?fullheight=true&data=' . $ext_attr_serialize, false, THEMEVERSION, true );
	$html .= '</div>';

	$html .= '</div>';

	$html .= '</div>';

	return $html;
}

function anva_contact_sidebar( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'slug' => '',
		'subtitle' => '',
		'sidebar' => '',
		'padding' => '',
		'custom_css' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="one withsmallpadding" ';

	$custom_css .= 'padding:' . esc_attr( $padding ) . 'px 0 ' . esc_attr( $padding ) . 'px 0;';
	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . urldecode( $custom_css ) . '" ';
	}

	$html .= '>';

	$html .= '<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper"><div class="sidebar_content full_width nopadding">';

	$html .= '<div class="sidebar_content page_content">';

	// Display Title
	if ( ! empty( $title ) ) {
		$html .= '<h2 class="anva_title">' . esc_html( urldecode( $title ) ) . '</h2>';
		$html .= '<div class="or-spacer">
			<div class="mask"></div>
			<span></span>
		</div>';
	}

	// Display Content
	if ( ! empty( $subtitle ) ) {
		$html .= '<div class="anva_subtitle">' . esc_html( urldecode( $subtitle ) ) . '</div>';
	}

	// Display Content
	if ( ! empty( $content ) ) {
		$html .= '<div class="anva_content">' . urldecode( $content ) . '</div>';
	}

	// Display contact form
	// Get contact form random ID
	$custom_id = time() . rand();
		$pp_contact_form = unserialize( get_option( 'pp_contact_form_sort_data' ) );
		wp_enqueue_script( 'jquery.validate', get_template_directory_uri() . '/js/jquery.validate.js', false, THEMEVERSION, true );

		wp_register_script( 'script-contact-form', get_template_directory_uri() . '/templates/script-contact-form.php?form=' . $custom_id, false, THEMEVERSION, true );
	$params = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'ajax_nonce' => wp_create_nonce( 'tgajax-post-contact-nonce' ),
	);
	wp_localize_script( 'script-contact-form', 'tgAjax', $params );
	wp_enqueue_script( 'script-contact-form', get_template_directory_uri() . '/templates/script-contact-form.php?form=' . $custom_id, false, THEMEVERSION, true );

		$html .= '<div id="reponse_msg_' . $custom_id . '" class="contact_form_response"><ul></ul></div>';

		$html .= '<form id="contact_form_' . $custom_id . '" class="contact_form_wrapper" method="post" action="/wp-admin/admin-ajax.php">';
	$html .= '<input type="hidden" id="action" name="action" value="pp_contact_mailer"/>';

		if ( is_array( $pp_contact_form ) && ! empty( $pp_contact_form ) ) {
		foreach ( $pp_contact_form as $form_input ) {
			switch ( $form_input ) {
				case 1:

				$html .= '<label for="your_name">' . __( 'Name *', 'anva' ) . '</label>
						<input id="your_name" name="your_name" type="text" class="required_field" placeholder="' . __( 'Name *', 'anva' ) . '"/>
						';

				break;

				case 2:

				$html .= '<label for="email">' . __( 'Email *', 'anva' ) . '</label>
						<input id="email" name="email" type="text" class="required_field email" placeholder="' . __( 'Email *', 'anva' ) . '"/>
						';

				break;

				case 3:

				$html .= '<label for="message">' . __( 'Message *', 'anva' ) . '</label>
						<textarea id="message" name="message" rows="7" cols="10" class="required_field" placeholder="' . __( 'Message *', 'anva' ) . '"></textarea>
						';

				break;

				case 4:

				$html .= '<label for="address">' . __( 'Address', 'anva' ) . '</label>
						<input id="address" name="address" type="text" placeholder="' . __( 'Address', 'anva' ) . '"/>
						';

				break;

				case 5:

				$html .= '<label for="phone">' . __( 'Phone', 'anva' ) . '</label>
						<input id="phone" name="phone" type="text" placeholder="' . __( 'Phone', 'anva' ) . '"/>
						';

				break;

				case 6:

				$html .= '<label for="mobile">' . __( 'Mobile', 'anva' ) . '</label>
						<input id="mobile" name="mobile" type="text" placeholder="' . __( 'Mobile', 'anva' ) . '"/>
						';

				break;

				case 7:

				$html .= '<label for="company">' . __( 'Company Name', 'anva' ) . '</label>
						<input id="company" name="company" type="text" placeholder="' . __( 'Company Name', 'anva' ) . '"/>
						';

				break;

				case 8:

				$html .= '<label for="country">' . __( 'Country', 'anva' ) . '</label>
						<input id="country" name="country" type="text" placeholder="' . __( 'Country', 'anva' ) . '"/>
						';
				break;
			}// End switch().
			}// End foreach().
			}// End if().

			$pp_contact_enable_captcha = get_option( 'pp_contact_enable_captcha' );

			if ( ! empty( $pp_contact_enable_captcha ) ) {

	$html .= '<div id="captcha-wrap">
				<div class="captcha-box">
					<img src="' . get_template_directory_uri() . '/get_captcha.php" alt="" id="captcha" />
				</div>
				<div class="text-box">
					<label>Type the two words:</label>
					<input name="captcha-code" type="text" id="captcha-code">
				</div>
				<div class="captcha-action">
					<img src="' . get_template_directory_uri() . '/images/refresh.jpg"  alt="" id="captcha-refresh" />
				</div>
			</div>';

		}

		$html .= '<br/><br/><div class="contact_submit_wrapper">
			<input id="contact_submit_btn' . $custom_id . '" name="contact_submit_btn' . $custom_id . '" type="submit" class="solidbg" value="' . __( 'Send Message', 'anva' ) . '"/>
		</div>';

	$html .= '</form>';

	$html .= '</div>';

	// Display Sidebar
	$html .= '<div class="sidebar_wrapper"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$html .= get_dynamic_sidebar( urldecode( $sidebar ) );
	$html .= '</ul></div></div></div>';

	$html .= '</div></div></div></div>';

	$html .= '</div>';

	return $html;
}

function anva_map( $atts ) {
	// extract short code attr
	extract(shortcode_atts(array(
		'height' => 600,
		'slug' => '',
		'lat' => 0,
		'long' => 0,
		'zoom' => 8,
		'type' => '',
		'popup' => '',
		'address' => '',
		'marker' => '',
	), $atts));

	$sec_id = '';
	if ( ! empty( $slug ) ) {
		$sec_id = 'id="' . esc_attr( $slug ) . '"';
	}

	$html = '<div ' . $sec_id . ' class="one nopadding">';

	$custom_id = time() . rand();
	$html = '<div class="map_shortcode_wrapper" id="map' . $custom_id . '" style="width:100%;height:' . esc_attr( $height ) . 'px">';
	$html .= '<div class="map-marker" ';

	if ( ! empty( $popup ) ) {
		$html .= 'data-title="' . esc_attr( urldecode( $popup ) ) . '" ';
	}

	if ( ! empty( $lat ) && ! empty( $long ) ) {
		$html .= 'data-latlng="' . esc_attr( urldecode( $lat ) ) . ',' . esc_attr( urldecode( $long ) ) . '" ';
	}

	if ( ! empty( $address ) ) {
		$html .= 'data-address="' . esc_attr( urldecode( $address ) ) . '" ';
	}

	if ( ! empty( $marker ) ) {
		$html .= 'data-icon="' . esc_attr( urldecode( $marker ) ) . '" ';
	}

	$html .= '>';

	if ( ! empty( $popup ) ) {
		$html .= '<div class="map-infowindow">' . urldecode( $popup ) . '</div>';
	}

	$html .= '</div>';
	$html .= '</div>';

	$ext_attr = array(
		'id' => 'map' . $custom_id,
		'zoom' => $zoom,
		'type' => 'ROADMAP',
	);

	$ext_attr_serialize = serialize( $ext_attr );

	if ( ! is_ssl() ) {
			wp_enqueue_script( 'google_maps', 'http://maps.google.com/maps/api/js?sensor=false', false, THEMEVERSION, true );
	} else {
			wp_enqueue_script( 'google_maps', 'https://maps.google.com/maps/api/js?sensor=false', false, THEMEVERSION, true );
	}

	wp_enqueue_script( 'simplegmaps', get_template_directory_uri() . '/js/jquery.simplegmaps.min.js', false, THEMEVERSION, true );
	wp_enqueue_script( 'script-contact-map' . $custom_id, get_template_directory_uri() . '/templates/script-map-shortcode.php?data=' . $ext_attr_serialize, false, THEMEVERSION, true );

	return $html;

}

function anva_galleries( $atts, $content ) {

	// extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'cat' => '',
		'items' => '',
		'bgcolor' => '',
		'custom_css' => '',
	), $atts));

	if ( ! is_numeric( $items ) ) {
		$items = 3;
	}
	if ( ! empty( $bgcolor ) ) {
		$custom_css .= 'background-color:' . esc_attr( $bgcolor ) . ';';
	}

	$html = '<div class="' . esc_attr( $size ) . ' anva_galleries nopadding" ';

	if ( ! empty( $custom_css ) ) {
		$html .= 'style="' . urldecode( esc_attr( $custom_css ) ) . '" ';
	}

	$html .= '>';

	// Display galleries items
	$args = array(
			'numberposts' => $items,
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'post_type' => array( 'galleries' ),
			'suppress_filters' => 0,
	);

	if ( ! empty( $cat ) ) {
		$args['gallerycat'] = $cat;
	}
	$galleris_arr = get_posts( $args );

	if ( ! empty( $galleris_arr ) && is_array( $galleris_arr ) ) {
		// Check if disable slideshow hover effect
		$pp_gallery_disable_hover_slide = get_option( 'pp_gallery_disable_hover_slide' );

		if ( empty( $pp_gallery_disable_hover_slide ) ) {
			wp_enqueue_script( 'jquery.cycle2.min', get_template_directory_uri() . '/js/jquery.cycle2.min.js', false, THEMEVERSION, true );
			wp_enqueue_script( 'custom_cycle', get_template_directory_uri() . '/js/custom_cycle.js', false, THEMEVERSION, true );
		}

		$html .= '<div class="photo_wall_wrapper">';

		foreach ( $galleris_arr as $key => $gallery ) {
			$image_url = '';
			$gallery_ID = $gallery->ID;

			if ( has_post_thumbnail( $gallery_ID, 'original' ) ) {
					$image_id = get_post_thumbnail_id( $gallery_ID );
					$small_image_url = wp_get_attachment_image_src( $image_id, 'gallery_c', true );
			}

			$permalink_url = get_permalink( $gallery_ID );

			$html .= '<div class="wall_entry masonry">';
			if ( ! empty( $small_image_url[0] ) ) {
				$all_photo_arr = array();

				if ( empty( $pp_gallery_disable_hover_slide ) ) {
						// Get gallery images
						$all_photo_arr = get_post_meta( $gallery_ID, 'wpsimplegallery_gallery', true );

						// Get only 5 recent photos
						$all_photo_arr = array_slice( $all_photo_arr, 0, 5 );
				}

					$html .= '<div class="image_grid_frame">
						<div class="wall_thumbnail post_archive">
							<a href="' . esc_url( $permalink_url ) . '" class="gallery_wrapper">
								<img src="' . esc_url( $small_image_url[0] ) . '" alt="" class="portfolio_img static"/>
										<div class="mask transparent">
									<div class="mask_frame galleries">
									<h3>' . $gallery->post_title . '</h3>
								<div class="excerpt">' . strip_tags( pp_get_the_excerpt( $gallery_ID ) ) . '</div>
							</div>';

				if ( ! empty( $all_photo_arr ) ) {

					 $html .= '<ul class="gallery_img_slides">';

					foreach ( $all_photo_arr as $photo ) {
						$slide_image_url = wp_get_attachment_image_src( $photo, 'gallery_c', true );
						$html .= '<li><img src="' . esc_url( $slide_image_url[0] ) . '" alt="" class="static"/></li>';
					}

					$html .= '</ul>';
				}

				$html .= '
							</div>
						</a>
						</div>
					</div>';
			}// End if().
			$html .= '</div>';
		}// End foreach().

		$html .= '</div>';
	}// End if().

	$html .= '</div>';

	return $html;

}
