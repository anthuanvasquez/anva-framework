<?php

// Hook Shortcodes
add_filter( 'after_setup_theme', 'of_shortcodes_setup'  );

function of_shortcodes_setup() {
	
	add_shortcode( 'dropcap', 'dropcap_func' );
	add_shortcode( 'button', 'button_func' );
	add_shortcode( 'toggle', 'toggle_func' );
	
	add_shortcode( 'column_six', 'column_six_func' );
	add_shortcode( 'column_six_last', 'column_six_last_func' );
	
	add_shortcode( 'column_five', 'column_five_func' );
	add_shortcode( 'column_five_last', 'column_five_last_func' );
	
	add_shortcode( 'column_four', 'column_four_func' );
	add_shortcode( 'column_four_last', 'column_four_last_func' );
	
	add_shortcode( 'column_three', 'column_three_func' );
	add_shortcode( 'column_three_last', 'column_three_last_func' );
	
	add_shortcode( 'column_two', 'column_two_func' );
	add_shortcode( 'column_two_last', 'column_two_last_func' );

	add_shortcode( 'column_one', 'column_one_func' );
	add_shortcode( 'column_one_last', 'column_one_last_func' );
	
}

// [dropcap foo="foo-value"]
function dropcap_func($atts, $content) {
	// Extract short code attr
	extract(shortcode_atts(array(
		'style' => 1
	), $atts));

	// Get first char
	$first_char = substr($content, 0, 1);
	$text_len = strlen($content);
	$rest_text = substr($content, 1, $text_len);

	$html = '<span class="dropcap">'. $first_char .'</span>';
	$html.= do_shortcode($rest_text);
	$html.= '';
	return $html;
}

// [button foo="foo-value"]
function button_func($atts, $content) {
	// Eextract short code attr
	extract(shortcode_atts(array(
		'href' => '',
		'align' => '',
		'bg_color' => '',
		'text_color' => '',
		'size' => 'small',
		'style' => '',
		'color' => '',
		'target' => '_self',
	), $atts));

	if( !empty( $color ) ) {
		switch( strtolower( $color ) ) {
			case 'black':
				$bg_color 	= '#000000';
				$text_color = '#ffffff';
			break;
			case 'grey':
				$bg_color 	= '#666666';
				$text_color = '#ffffff';
			break;
			case 'white':
				$bg_color	= '#f5f5f5';
				$text_color = '#444444';
			break;
			case 'blue':
				$bg_color 	= '#3498DB';
				$text_color = '#ffffff';
			break;
			case 'yellow':
				$bg_color 	= '#F1C40F';
				$text_color = '#ffffff';
			break;
			case 'red':
				$bg_color 	= '#ff0000';
				$text_color = '#ffffff';
			break;
			case 'orange':
				$bg_color 	= '#ff9900';
				$text_color = '#ffffff';
			break;
			case 'green':
				$bg_color 	= '#2ECC71';
				$text_color = '#ffffff';
			break;
			case 'pink':
				$bg_color 	= '#ed6280';
				$text_color = '#ffffff';
			break;
			case 'purple':
				$bg_color 	= '#9B59B6';
				$text_color = '#ffffff';
			break;
		}
	}
	
	if( !empty( $bg_color ) ) {
		$border_color = $bg_color;
	}
	else {
		$border_color = 'transparent';
	}
	
	if(!empty($bg_color)) { 
		$html = '<a class="button '.$size.' '.$align.'" style="background-color:'.$bg_color.';border:1px solid '.$border_color.';color:'.$text_color.';'.$style.'"';
	}
	else {
		$html = '<a class="button '.$size.' '.$align.'"';
	}
	
	if( ! empty( $href ) ) {
		$html.= ' onclick="window.open(\''.$href.'\', \''.$target.'\')"';
	}
	$html.= '>'.do_shortcode($content).'</a>';
	return $html;
}

/* Columns 6 */
function column_six_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$html = '<div class="column-6 '. $class .'">'. do_shortcode($content) .'</div>';
	return $html;
}

function column_six_last_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$html = '<div class="column-6 column-last '. $class .'">'. do_shortcode($content) .'</div><div class="clear"></div>';
	return $html;
}

/* Columns 4 */
function column_four_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$html = '<div class="column-4 '. $class .'">'. do_shortcode($content) .'</div>';
	return $html;
}

function column_four_last_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$html = '<div class="column-4 column-last '. $class .'">'. do_shortcode($content) .'</div><div class="clear"></div>';
	return $html;
}

/* Columns 3 */
function column_three_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$html = '<div class="column-3 '. $class .'">'. do_shortcode($content) .'</div>';
	return $html;
}

function column_three_last_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$html = '<div class="column-3 column-last '. $class .'">'. do_shortcode($content) .'</div><div class="clear"></div>';
	return $html;
}

/* Columns 2 */
function column_two_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$html = '<div class="column-2 '. $class .'">'. do_shortcode($content) .'</div>';
	return $html;
}

function column_two_last_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$html = '<div class="column-2 column-last '. $class .'">'. do_shortcode($content) .'</div><div class="clear"></div>';
	return $html;
}

/* Columns 1 */
function column_one_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$html = '<div class="column-1 '. $class .'">'. do_shortcode($content) .'</div>';
	return $html;
}

function column_one_last_func($atts, $content) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$html = '<div class="column-1 column-last '. $class .'">'. do_shortcode($content) .'</div><div class="clear"></div>';
	return $html;
}

function toggle_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	// Extract short code attr
	extract(shortcode_atts(array(
			'title' => __('Click para Abrir', of_THEME_DOMAIN ),
			'color' => ''
	), $atts));

	$html  = '<div class="toggle-container">';
	$html .= '<h3 class="toggle-trigger toggle-'. $color .'">';
	$html .= '<a href="#">'. $title .'</a>';
	$html .= '</h3>';
	$html .= '<div class="toggle-info">'. do_shortcode($content) .'</div>';
	$html .= '</div>';

	return $html;
}