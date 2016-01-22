<?php

/*
 * Shortcodes
 */
function anva_shortcodes_init() {
	
	add_shortcode( 'dropcap', 'anva_dropcap' );
	add_shortcode( 'button', 	'anva_button' );
	add_shortcode( 'toggle', 	'anva_toggle' );
	add_shortcode( 'counter', 'anva_counter' );	
	add_shortcode( 'column', 	'anva_column' );
	add_shortcode( 'slides', 	'anva_slides' );
	
}

function anva_clearfix() {
	echo '<div class="clearfix"></div>';
}

/*
 * Remove br and p tags from shortcodes.
 */
// function anva_fix_shortcodes( $content ) {
// 	$array = array (
// 		'<p>[' 		=> '[', 
// 		']</p>' 	=> ']', 
// 		']<br />' => ']'
// 	);
// 	$content = strtr($content, $array);
// 	return $content;
// }

/*
 * Buttons
 */
function anva_button( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'href' 		=> '',
		'align' 	=> '',
		'icon'		=> '',
		'size' 		=> '',
		'color'		=> '',
		'style'		=> '',
		'text'		=> '',
		'target' 	=> '',
	), $atts ));

	$classes = array();

	if ( ! empty( $icon ) ) {
		$icon = '<i class="fa fa-'. $icon .'"></i>';
	}

	if ( ! empty( $align ) ) {
		$classes[] = 'align'. $align;
	}

	if ( ! empty( $href ) ) {
		$href	= 'href="'. esc_url( $href ) .'"';
	}

	if ( ! empty( $text ) ) {
		$classes[] = 'button-desc';
		$text = '<span>'. esc_html( $text ) .'</span>';
	}

	if ( ! empty( $target ) ) {
		$target = 'target="'. esc_attr( $target ) .'"';
	}

	// Sizes
	switch ( $size ) {
		case 'mini':
			$classes[] = 'button-mini';
			break;
		
		case 'small':
			$classes[] = 'button-small';
			break;

		case 'large':
			$classes[] = 'button-large';
			break;

		case 'xlarge':
			$classes[] = 'button-xlarge';
			break;
	}

	switch ( $style ) {
		case 'round':
			$classes[] = 'button-rounded';
			break;

		case '3d':
			$classes[] = 'button-3d';
			break;
	}

	// Colors
	switch ( $color ) {
		case 'dark':
			$classes[] = 'button-dark';
			break;
		case 'light':
			$classes[] = 'button-light';
			break;
	}

	$classes = implode( ' ', $classes );
	
	$html  = '<a class="button '. esc_attr( $classes ) .'" '. $href .' '. $target .'>';
	$html .= $icon;
	$html .= $content;
	$html .= $text;
	$html .= '</a>';

	return $html;
}

/*
 * Columns
 */
function anva_column( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'id'		=> '',
		'class' => '',
		'col'		=> '',
		'last'	=> false,
	), $atts));

	$classes = array();

	if ( ! empty( $id ) ) {
		$id = 'id="'. esc_attr( $id ) .'"';
	}

	if ( ! empty( $col ) ) {
		$classes[] = 'grid_' . $col;
	}

	if ( ! empty( $class ) ) {
		$classes[] = $class;
	}

	if ( true == $last ) {
		$classes[] = 'grid_last';
	}

	$classes = implode( ' ', $classes );

	$html = '<div '. $id .' class="'. esc_attr( $classes ) .'">'. $content .'</div>';
	return $html;
}

/*
 * Dropcap
 */
function anva_dropcap( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'style' => ''
	), $atts ));

	$first_char = substr( $content, 0, 1 );
	$text_len 	= strlen( $content );
	$rest_text 	= substr( $content, 1, $text_len );
	$classes 		= '';

	switch ( $style ) {
		case 'bg':
			$classes .= 'dropcap-bg';
			break;
		case 'border':
			$classes .= 'dropcap-border';
			break;
	}

	$html  = '<span class="dropcap '. $classes .'">' . $first_char . '</span>';
	$html .= wpautop( $rest_text );
	return $html;
}

/*
 * Toggle
 */
function anva_toggle( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract( shortcode_atts( array(
		'title' 	=> __( 'Click para ver el Contenido', ANVA_DOMAIN ),
		'id' 			=> '',
		'style'		=> ''
	), $atts ));

	$classes = '';

	if ( ! empty( $id ) ) {
		$id = 'id="'. esc_attr( $id ) . '"';
	}

	switch ( $style ) {
		case 'bg':
			$classes .= 'toggle-bg';
			break;
		case 'border':
			$classes .= 'toggle-border';
			break;
	}

	$html  = '<div class="toggle '. esc_attr( $classes ) .'" '. $id .'>';
	$html .= '<div class="toggle-title" "><i class="toggle-closed fa fa-minus-circle"></i><i class="toggle-open fa fa-plus-circle"></i>'. esc_html( $title ) .'</div>';
	$html .= '<div class="toggle-content">'. $content . '</div>';
	$html .= '</div>';	
	return $html;
}

/*
 * Counter
 */
function anva_counter( $atts, $content = null ) {
	
	$content = wpautop( trim( $content ) );
	
	extract( shortcode_atts( array(
		'from' 			=> 0,
		'to' 				=> 100,
		'interval'	=> 100,  // Refresh interval
		'speed' 		=> 2000, // Speed animation
		'size'			=> ''
	), $atts ));

	$classes = '';

	switch ( $size ) {
		case 'small':
			$classes = 'counter-small';
			break;
		case 'large':
			$classes = 'counter-large';
			break;
	}

	$html  = '<div class="counter text-center '. $classes .'">';
	$html .= '<span data-from="'. $from .'" data-to="'. $to .'" data-refresh-interval="'. $interval .'" data-speed="'. $speed .'"></span>';
	$html .= '</div>';

	return $html;
}

/*
 * Create slideshows shortcode
 */
function anva_slides( $atts, $content = null ) {
	
	extract(shortcode_atts( array(
		'id' => '', // Default ID
	), $atts ));

	$html = '<div class="alert alert-warning">Please install the plugin <strong>Anva Sideshows</strong> to use the slides shortcode.</div>';
	
	if ( function_exists( 'anva_put_slideshows' ) ) {
		if ( ! empty( $id ) ) {
			return anva_put_slideshows( $id );
		}
	} else {
		return $html;
	}
}
