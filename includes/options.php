<?php
/**
 * WARNING: This file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, and filters.
 */

/**
 * Use Anva_Options_API to add options onto options already
 * present in framework.
 *
 * @since  1.0.0
 * @return void
 */
function anva_options() {

	// Assets
	$skin_path = trailingslashit( get_template_directory_uri() . '/assets/images/skins' );

	// Skin Colors
	$schemes = array();
	foreach ( anva_get_colors_scheme( $skin_path, 'jpg' ) as $color_id => $color ) {
		$schemes[ $color_id ] = $color['image'];
	}

	// Background defaults
	$background_defaults = array(
		'image' 		=> '',
		'repeat' 		=> 'repeat',
		'position' 		=> 'top center',
		'attachment' 	=> 'scroll'
	);

	// Transitions
	$transitions = array();
	foreach ( range( 0, 14 ) as $key ) {
		$transitions[ $key ] = __( 'Loader Style', 'anva' ) . ' ' . $key;
	}
	$transitions[0] = __( 'Disable Transition', 'anva' );
	$transitions[1] = __( 'Default Loader Style', 'anva' );

	// Animations
	$animations = array();
	foreach ( anva_get_animations() as $animation_id => $animation ) {
		$animations[ $animation ] = $animation;
	}

	$transition_animations = array(
		'fadeIn'    => 'fadeIn',
		'fadeOut'   => 'fadeOut',
		'fadeDown'  => 'fadeDown',
		'fadeUp'    => 'fadeUp',
		'fadeLeft'  => 'fadeLeft',
		'fadeRight' => 'fadeRight',
		'rotate'    => 'rotate',
		'flipX'     => 'flipX',
		'flipY'     => 'flipY',
		'zoom'      => 'zoom',
	);

	/* ---------------------------------------------------------------- */
	/* Styles Tab
	/* ---------------------------------------------------------------- */

	$styles = array(
		'main' => array(
			'layout_style' => array(
				'name' => __('Site Layout Style', 'anva'),
				'desc' => __('Select the layout style of the site, you can use boxed or stretched.', 'anva'),
				'id' => 'layout_style',
				'std' => 'stretched',
				'class' => 'input-select',
				'type' => 'select',
				'options' => array(
					'boxed' => __( 'Boxed', 'anva' ),
					'stretched' => __( 'Stretched', 'anva' )
				)
			),
			'base_color' => array(
				'name' => __( 'Site Color Scheme', 'anva' ),
				'desc' => sprintf(
					__( 'Select the color scheme of the site. Check live preview in the %s.', 'anva' ),
					sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=base_color' ) . '">%s</a>', __( 'Customizer', 'anva' ) )
				),
				'id' => 'base_color',
				'std' => 'blue',
				'type' => 'images',
				'options' => $schemes
			),
			'base_color_style' => array(
				'name' => __( 'Site Color Style', 'anva' ),
				'desc' => sprintf(
					__( 'Select the color style of the theme. Check live preview in the %s.', 'anva' ),
					sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=base_color_style' ) . '">%s</a>', __( 'Customizer', 'anva' ) )
				),
				'id' => 'base_color_style',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => __( 'Light', 'anva' ),
					'dark' => __( 'Dark', 'anva' ),
				)
			),
		),
		'links' => array(
			'link_color' => array(
				'name' => __( 'Link Color', 'anva' ),
				'desc' => __( 'Choose the link color.', 'anva' ),
				'id' => 'link_color',
				'std' => '#3498db',
				'type' => 'color'
			),
			'link_color_hover' => array(
				'name' => __( 'Link Color (:Hover)', 'anva' ),
				'desc' => __( 'Choose the link color on :Hover state.', 'anva' ),
				'id' => 'link_color_hover',
				'std' => '#222222',
				'type' => 'color'
			),
		),
		'header' => array(
			'top_bar_display' => array(
				'name' => NULL,
				'desc' => sprintf( '<strong>%s:</strong> %s', __( 'Top Bar', 'anva' ), __( 'Display top bar above header.', 'anva' ) ),
				'id' => 'top_bar',
				'std' => '0',
				'type' => 'checkbox',
				'trigger' => '1',
				'receivers' => 'top_bar_color',
			),
			'top_bar_color' => array(
				'name' => __( 'Top Bar Color', 'anva' ),
				'desc' => __( 'Select the color of the top bar.', 'anva' ),
				'id' => 'top_bar_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => __( 'Light', 'anva' ),
					'dark' => __( 'Dark', 'anva' ),
					'custom' => __( 'Custom Color', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'top_bar_bg_color top_bar_text_color',
			),
			'top_bar_bg_color' => array(
				'name' => __( 'Top Bar Color', 'anva' ),
				'desc' => __( 'Select the background color of the top bar.', 'anva' ),
				'id' => 'top_bar_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
			),
			'top_bar_text_color' => array(
				'name' => NULL,
				'desc' => __( 'Use light text color for background.', 'anva' ),
				'id' => 'top_bar_text_color',
				'std' => '0',
				'type' => 'checkbox',
			),
			'header_color' => array(
				'name' => __( 'Header Color', 'anva' ),
				'desc' => __( 'Select the color of the header.', 'anva' ),
				'id' => 'header_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => __( 'Light', 'anva' ),
					'dark' => __( 'Dark', 'anva' ),
					'custom' => __( 'Custom Color', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'header_bg_color header_image header_border_color header_text_color',
			),
			'header_bg_color' => array(
				'name' => __( 'Background Color', 'anva' ),
				'desc' => __( 'Select the custom color of the header background', 'anva' ),
				'id' => 'header_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'class' => 'hidden',
			),
			'header_image' => array(
				'name' => __( 'Background Image', 'anva' ),
				'desc' => __( 'Select the backgrund image of the header, will replace the option above.', 'anva' ),
				'id' => 'header_image',
				'std' => '',
				'type' => 'upload',
				'class' => 'hidden',
			),
			'header_border_color' => array(
				'name' => __( 'Border Color', 'anva' ),
				'desc' => __( 'Select the border color of the header.', 'anva' ),
				'id' => 'header_border_color',
				'std' => '#f5f5f5',
				'type' => 'color',
				'class' => 'hidden',
			),
			'header_text_color' => array(
				'name' => __( 'Text Color', 'anva' ),
				'desc' => __( 'Select the text color if you have a header using a custom background color or image.', 'anva' ),
				'id' => 'header_text_color',
				'std' => '#ffffff',
				'type' => 'color',
				'class' => 'hidden',
			),
		),
		'navigation' => array(
			'primary_menu_color' => array(
				'name' => __( 'Primary Menu Color', 'anva' ),
				'desc' => __( 'Select the color style of the primary navigation. Note: changes will not applied when header type is side.', 'anva' ),
				'id' => 'primary_menu_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => __( 'Light', 'anva' ),
					'dark' => __( 'Dark', 'anva' ),
				),
			),
			'primary_menu_font_check' => array(
				'name' => NULL,
				'desc' => sprintf( '<strong>%s:</strong> %s', __( 'Font', 'anva' ), __( 'Apply font to primary navigation.', 'anva' ) ),
				'id' => 'primary_menu_font_check',
				'std' => '0',
				'type' => 'checkbox',
				'trigger' => 1,
				'receivers' => 'primary_menu_font'
			),
			'primary_menu_font' => array(
				'name' => __( 'Headings Font', 'anva' ),
				'desc' => __( 'This applies to all of the primary menu links.', 'anva' ),
				'id' => 'primary_menu_font',
				'std' => array(
					'face'   => 'google',
					'style'  => 'uppercase',
					'weight' => '700',
					'google' => 'Raleway:400,600,700',
					'color'  => '#444444'
				),
				'type' => 'typography',
				'options' => array( 'style', 'weight', 'face', 'color' )
			),
			'side_panel_display' => array(
				'name' => NULL,
				'desc' => sprintf( '<strong>%s:</strong> %s', __( 'Side Panel', 'anva' ), __( 'Display the side panel content.', 'anva' ) ),
				'id' => 'side_panel_display',
				'std' => '0',
				'type' => 'checkbox',
				'trigger' => '1',
				'receivers' => 'side_panel_color',
			),
			'side_panel_color' => array(
				'name' => __( 'Side Panel Color', 'anva' ),
				'desc' => __( 'Select the color style of the side panel. Note: changes will not applied when header type is side.', 'anva' ),
				'id' => 'side_panel_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => __( 'Light', 'anva' ),
					'dark' => __( 'Dark', 'anva' ),
					'custom' => __( 'Custom', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'side_panel_bg_color',
			),
			'side_panel_bg_color' => array(
				'name' => __( 'Background Color', 'anva' ),
				'desc' => __( 'Select the custom color of the side panel background.', 'anva' ),
				'id' => 'side_panel_bg_color',
				'std' => '#f8f8f8',
				'type' => 'color',
				'class' => 'hidden',
			),
		),
		'footer' => array(
			'footer_color' => array(
				'name' => __( 'Color Style', 'anva' ),
				'desc' => __( 'Select the color style of the footer.', 'anva' ),
				'id' => 'footer_color',
				'std' => 'dark',
				'type' => 'select',
				'options' => array(
					'light' => __( 'Light', 'anva' ),
					'dark' 	=> __( 'Dark', 'anva' ),
					'custom' => __( 'Custom', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'footer_bg_color footer_bg_image footer_text_color',
			),
			'footer_bg_color' => array(
				'name' => __( 'Background Color', 'anva' ),
				'desc' => __( 'Select the custom color of the footer background.', 'anva' ),
				'id' => 'footer_bg_color',
				'std' => '#333333',
				'type' => 'color',
			),
			'footer_bg_image' => array(
				'name' => __( 'Background Image', 'anva' ),
				'desc' => __( 'Select the backgrund image of the footer, will replace the option above.', 'anva' ),
				'id' => 'footer_bg_image',
				'std' => '',
				'type' => 'upload',
			),
			'footer_text_color' => array(
				'name' => __( 'Text Color', 'anva' ),
				'desc' => __( 'Select the text color if footer use a custom background color or image.', 'anva' ),
				'id' => 'footer_text_color',
				'std' => '',
				'type' => 'color',
			),
			'footer_link_color' => array(
				'name' => __( 'Link Color', 'anva' ),
				'desc' => __( 'Choose the footer link color.', 'anva' ),
				'id' => 'footer_link_color',
				'std' => '#555555',
				'type' => 'color'
			),
			'footer_link_color_hover' => array(
				'name' => __( 'Link Color (:Hover)', 'anva' ),
				'desc' => __( 'Choose the footer link color on :Hover state.', 'anva' ),
				'id' => 'footer_link_color_hover',
				'std' => '#555555',
				'type' => 'color'
			),
			'footer_dark_link_color' => array(
				'name' => __( 'Dark Link Color', 'anva' ),
				'desc' => __( 'Choose the footer link color when the footer is dark.', 'anva' ),
				'id' => 'footer_dark_link_color',
				'std' => '#555555',
				'type' => 'color'
			),
			'footer_dark_link_color_hover' => array(
				'name' => __( 'Dark Link Color (:Hover)', 'anva' ),
				'desc' => __( 'Choose the footer link color on :Hover state when the footer is dark.', 'anva' ),
				'id' => 'footer_dark_link_color_hover',
				'std' => '#ffffff',
				'type' => 'color'
			),
		),
		'social_icons' => array(
			'social_icons_style' => array(
				'name' => __('Social Icons Style', 'anva'),
				'desc' => __('choose the style for your social icons.', 'anva'),
				'id' => 'social_icons_style',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> __('Default Style', 'anva'),
					'light' 	=> __('Light', 'anva'),
					'dark' 		=> __('Dark', 'anva'),
					'text-color' => __('Text Colored', 'anva'),
					'colored' => __('Colored', 'anva'),
				)
			),
			'social_icons_shape' => array(
				'name' => __('Social Icons Shape', 'anva'),
				'desc' => __('choose the shape for your social icons.', 'anva'),
				'id' => 'social_icons_shape',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> __('Default Shape', 'anva'),
					'rounded' 	=> __('Rounded', 'anva'),
				)
			),
			'social_icons_border' => array(
				'name' => __('Social Icons Border', 'anva'),
				'desc' => __('Choose the shape for your social icons.', 'anva'),
				'id' => 'social_icons_border',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> __('Default Border', 'anva'),
					'borderless' 	=> __('Without Border', 'anva'),
				)
			),
			'social_icons_size' => array(
				'name' => __('Social Icons Size', 'anva'),
				'desc' => __('Choose the size for your social icons.', 'anva'),
				'id' => 'social_icons_size',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> __('Default Size', 'anva'),
					'small' 	=> __('Small', 'anva'),
					'large' 	=> __('Large', 'anva'),
				)
			),
		),
		'background' => array(
			'background_color' => array(
				'name' => __('Background Color', 'anva'),
				'desc' => __('Choose the background color.', 'anva'),
				'id' => 'background_color',
				'std' => '#dddddd',
				'type' => 'color'
			),
			'background_image' => array(
				'name' => __('Background Image', 'anva'),
				'desc' => __('Choose the background image. Note: this option only take effect if layout style is boxed.', 'anva'),
				'id' => 'background_image',
				'std' => $background_defaults,
				'type' => 'background'
			),
			'background_cover' => array(
				'name' => NULL,
				'desc' => sprintf( '<strong>%s:</strong> %s', __( 'Cover', 'anva' ), __( 'Fill background screen with the image.', 'anva' ) ),
				'id' => 'background_cover',
				'std' => '0',
				'type' => 'checkbox'
			),
			'background_pattern' => array(
				'name' => __( 'Background Pattern', 'anva' ),
				'desc' => sprintf( __( 'Choose the background pattern. Note: this option is only applied if the braclground image option is empty. Check live preview in the %s.', 'anva' ), sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=background_pattern' ) . '">%s</a>', __( 'Customizer', 'anva' ) ) ),
				'id' => 'background_pattern',
				'std' => '',
				'type' => 'select',
				'options' => array(
					''                     => __( 'None', 'anva' ),
					'binding_light'        => 'Binding Light',
					'dimension_@2X'        => 'Dimension',
					'hoffman_@2X'          => 'Hoffman',
					'knitting250px'        => 'Knitting',
					'noisy_grid'           => 'Noisy Grid',
					'pixel_weave_@2X'      => 'Pixel Weave',
					'struckaxiom'          => 'Struckaxiom',
					'subtle_stripes'       => 'Subtle Stripes',
					'white_brick_wall_@2X' => 'White Brick Wall',
					'gplaypattern'         => 'G Play Pattern',
					'blackmamba'           => 'Black Mamba',
					'carbon_fibre'         => 'Carbon Fibre',
					'congruent_outline'    => 'Congruent Outline',
					'moulin'               => 'Moulin',
					'wild_oliva'           => 'Wild Oliva',
				),
				'pattern_preview' => 'show',
			),
		),
		'typography' => array(
			'body_font' => array(
				'name' => __( 'Body Font', 'anva' ),
				'desc' => __( 'This applies to most of the text on your site.', 'anva' ),
				'id' => 'body_font',
				'std' => array(
					'size'   => '14',
					'style'  => 'normal',
					'weight' => '400',
					'face'   => 'google',
					'google' => 'Lato:300,400,400italic,600,700',
					'color'  => '#555555'
				),
				'type' => 'typography',
				'options' => array( 'size', 'weight', 'style', 'face', 'color' )
			),
			'heading_font' => array(
				'name' => __( 'Headings Font', 'anva' ),
				'desc' => __( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', 'anva' ),
				'id' => 'heading_font',
				'std' => array(
					'face'   => 'google',
					'style'  => 'uppercase',
					'weight' => '600',
					'google' => 'Raleway:300,400,500,600,700',
					'color'  => '#444444'
				),
				'type' => 'typography',
				'options' => array( 'style', 'weight', 'face', 'color' )
			),
			'meta_font' => array(
				'name' => __( 'Meta Font', 'anva' ),
				'desc' => __( 'This applies to all of the meta information of your site.', 'anva' ),
				'id' => 'meta_font',
				'std' => array(
					'face' => 'google',
					'google' => 'Crete Round:400italic',
				),
				'type' => 'typography',
				'options' => array( 'face' )
			),
			'heading_h1' => array(
				'name' => __( 'H1', 'anva' ),
				'desc' => __( 'Select the size for H1 tag in px.', 'anva' ),
				'id' => 'heading_h1',
				'std' => '36',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h2' => array(
				'name' => __( 'H2', 'anva' ),
				'desc' => __( 'Select the size for H2 tag in px.', 'anva' ),
				'id' => 'heading_h2',
				'std' => '30',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h3' => array(
				'name' => __('H3', 'anva'),
				'desc' => __('Select the size for H3 tag in px.', 'anva'),
				'id' => 'heading_h3',
				'std' => '24',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h4' => array(
				'name' => __('H4', 'anva'),
				'desc' => __('Select the size for H4 tag in px.', 'anva'),
				'id' => 'heading_h4',
				'std' => '18',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h5' => array(
				'name' => __('H5', 'anva'),
				'desc' => __('Select the size for H5 tag in px.', 'anva'),
				'id' => 'heading_h5',
				'std' => '14',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h6' => array(
				'name' => __('H6', 'anva'),
				'desc' => __('Select the size for H6 tag in px.', 'anva'),
				'id' => 'heading_h6',
				'std' => '12',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
		),
		'custom' => array(
			'css_warning' => array(
				'name' => __( 'Info', 'anva'),
				'desc' => __( 'If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva'),
				'id' => 'css_warning',
				'type' => 'info',
			),
			'custom_css' => array(
				'name' => __( 'Custom CSS', 'anva'),
				'desc' => __( 'Use custom CSS to override the theme styles.', 'anva'),
				'id' => 'custom_css',
				'std' => '',
				'type' => 'code',
				'mode' => 'css', // CSS Code
			),
			'custom_css_stylesheet' => array(
				'name' => NULL,
				'desc' => __( 'Add a custom css stylesheet to the head, custom.css.', 'anva' ),
				'id' => 'custom_css_stylesheet',
				'std' => '0',
				'type' => 'checkbox',
			)
		),
	);

	anva_add_option_tab( 'styles', __( 'Styles', 'anva'), true, 'admin-appearance' );
	anva_add_option_section( 'styles', 'main', 			__( 'Main', 'anva' ), 		  NULL, $styles['main'] );
	anva_add_option_section( 'styles', 'links', 	 	__( 'Links', 'anva' ), 		  NULL, $styles['links'], false );
	anva_add_option_section( 'styles', 'header',	  	__( 'Header', 'anva' ), 	  NULL, $styles['header'], false  );
	anva_add_option_section( 'styles', 'navigation',  	__( 'Navigation', 'anva' ),   NULL, $styles['navigation'], false  );
	anva_add_option_section( 'styles', 'footer', 	 	__( 'Footer', 'anva' ), 	  NULL, $styles['footer'], false );
	anva_add_option_section( 'styles', 'social_icons',  __( 'Social Icons', 'anva' ), NULL, $styles['social_icons'], false );
	anva_add_option_section( 'styles', 'background',  	__( 'Background', 'anva' ),   NULL, $styles['background'], false );
	anva_add_option_section( 'styles', 'typography',  	__( 'Typography', 'anva' ),   NULL, $styles['typography'], false );
	anva_add_option_section( 'styles', 'custom', 		__( 'Custom', 'anva' ), 	  NULL, $styles['custom'], false );

	/* ---------------------------------------------------------------- */
	/* Layout Tab
	/* ---------------------------------------------------------------- */

	// Get header types
	$header_types = array();
	foreach ( anva_get_header_types() as $type_id => $type ) {
		$header_types[ $type_id ] = $type['name'];
	}

	// Get menu styles
	$menu_styles = array();
	foreach ( anva_get_primary_menu_styles() as $style_id => $style ) {
		$menu_styles[ $style_id ] = $style['name'];
	}

	// Get side panel types
	$side_panel_types = array();
	foreach ( anva_get_side_panel_types() as $type_id => $type ) {
		$side_panel_types[ $type_id ] = $type['name'];
	}

	$animations = array();
	foreach ( anva_get_animations() as $key => $value ) {
		$animations[ $value ] = $value;
	}

	// Pull all gallery templates
	$galleries = array();
	foreach ( anva_gallery_templates() as $key => $gallery ) {
		$galleries[$key] = $gallery['name'];
	}

	// Get all sliders
	$sliders = anva_get_sliders();

	// Pull all sliders
	$slider_select = array();
	foreach ( $sliders as $slider_id => $slider ) {
		$slider_select[ $slider_id ] = $slider['name'];
	}

	// Revolution Slider
	if ( class_exists( 'RevSliderAdmin' ) ) {
		$slider_select['revslider'] = 'Revolution Slider';
	}

	$layout = array(
		'header_type' => array(
			'name' => __( 'Header Type', 'anva' ),
			'desc' => __( 'Select the type of the header.', 'anva' ),
			'id' => 'header_type',
			'std' => 'default',
			'type' => 'select',
			'options' => $header_types,
		),
		'header_layout' => array(
			'name' => __( 'Header Layout', 'anva' ),
			'desc' => __( 'Select the layout of the header.', 'anva' ),
			'id' => 'header_layout',
			'std' => '',
			'type' => 'select',
			'options' => array(
				'' => __( 'Boxed', 'anva' ),
				'full-header' => __( 'Full Header', 'anva' ),
			),
		),
		'top_bar_layout' => array(
			'name' => __( 'Top bar Layout', 'anva' ),
			'desc' => __( 'Select the top bar layout you want to show.', 'anva' ),
			'id' => 'top_bar_layout',
			'std' => 'menu_icons',
			'type' => 'select',
			'options' => array(
				'menu_icons' => __( 'Menu + Social Icons', 'anva' ),
				'icons_menu' => __( 'Social Icons + Menu', 'anva' ),
			)
		),
		'side_panel_type' => array(
			'name' => __( 'Side Panel', 'anva' ),
			'desc' => __( 'Select the side panel you want to show in the site. Note: changes will not applied when header type is side.', 'anva' ),
			'id' => 'side_panel_type',
			'std' => 'left_overlay',
			'type' => 'select',
			'options' => $side_panel_types,
			'class' => 'hidden'
		),
		'side_header_icons' => array(
			'name' => NULL,
			'desc' => __( 'Display social media icons below primary menu in side header type.', 'anva' ),
			'id' => 'side_header_icons',
			'std' => '1',
			'type' => 'checkbox',
		),
		'primary_menu_style' => array(
			'name' => __( 'Primary Menu Style', 'anva' ),
			'desc' => __( 'Select the style of the primary navigation. Note: changes will not applied when header type is side.', 'anva' ),
			'id' => 'primary_menu_style',
			'std' => 'default',
			'type' => 'select',
			'options' => $menu_styles,
			'trigger' => 'style_7',
			'receivers' => 'header_extras header_extras_info',
		),
		'header_extras' => array(
			'name' => __( 'Header Extra Info', 'anva' ),
			'desc' => __( 'Select if you want to show the header extra info in the right.', 'anva' ),
			'id' => 'header_extras',
			'std' => 'hide',
			'type' => 'select',
			'options' => array(
				'show' => __( 'Show header extras', 'anva' ),
				'hide' => __( 'Hide header extras', 'anva' ),
			),
			'class' => 'hidden'
		),
		'header_extras_text' => array(
			'name' => __( 'Header Extra Info Text', 'anva' ),
			'desc' => __( 'Enter the text you want show in extra info.', 'anva' ),
			'id' => 'header_extras_info',
			'std' => '',
			'type' => 'text',
			'class' => 'hidden',
		),
		'footer_extra_display' => array(
			'name' => NULL,
			'desc' => __( 'Display extra information in footer.', 'anva' ),
			'id' => 'footer_extra_display',
			'std' => '1',
			'type' => 'checkbox',
			'trigger' => '1',
			'receivers' => 'footer_extra_info',
		),
		'footer_extra_info' => array(
			'name' => __( 'Extra Information Text', 'anva' ),
			'desc' => __( 'Enter the extra information text you\'d like to show in the footer below the social icons. You can use basic HTML, or any icon ID formatted like %name%.', 'anva' ),
			'id' => 'footer_extra_info',
			'std' => '%call% 1-800-999-999 %email3% admin@yoursite.com',
			'type' => 'textarea',
		),
		'footer_gototop' => array(
			'name' => NULL,
			'desc' => __( 'Add a Go To Top to allow your users to scroll to the Top of the page.', 'anva' ),
			'id' => 'footer_gototop',
			'std' => '1',
			'type' => 'checkbox',
		),
		'footer_icons' => array(
			'name' => NULL,
			'desc' => __( 'Display social icons on the footer.', 'anva' ),
			'id' => 'footer_icons',
			'std' => '1',
			'type' => 'checkbox',
		),
		'page_transition' => array(
			'page_loader' => array(
				'name' => __( 'Loader', 'anva' ),
				'desc' => __( 'Choose the loading styles of the Animation you want to show to your visitors while the pages of you Website loads in the background.', 'anva' ),
				'id' => 'page_loader',
				'std' => '1',
				'type' => 'select',
				'options' => $transitions
			),
			'page_loader_color' => array(
				'name' => __( 'Color', 'anva' ),
				'desc' => __( 'Choose the loader color.', 'anva' ),
				'id' => 'page_loader_color',
				'std' => '#dddddd',
				'type' => 'color',
			),
			'page_loader_timeout' => array(
				'name' => __( 'Timeout', 'anva' ),
				'desc' => __( 'Enter the timeOut in milliseconds to end the page preloader immaturely. Default is 1000.', 'anva' ),
				'id' => 'page_loader_timeout',
				'std' => 1000,
				'type' => 'number',
			),
			'page_loader_speed_in' => array(
				'name' => __( 'Speed In', 'anva' ),
				'desc' => __( 'Enter the speed of the animation in milliseconds on page load. Default is 800.', 'anva' ),
				'id' => 'page_loader_speed_in',
				'std' => 800,
				'type' => 'number',
			),
			'page_loader_speed_out' => array(
				'name' => __( 'Speed Out', 'anva' ),
				'desc' => __( 'Enter the speed of the animation in milliseconds on page load. Default is 800.', 'anva' ),
				'id' => 'page_loader_speed_out',
				'std' => 800,
				'type' => 'number',
			),
			'page_loader_animation_in' => array(
				'name' => __( 'Animation In', 'anva' ),
				'desc' => __( 'Choose the animation style on page load.', 'anva' ),
				'id' => 'page_loader_animation_in',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $transition_animations,
			),
			'page_loader_animation_out' => array(
				'name' => __( 'Animation Out', 'anva' ),
				'desc' => __( 'Choose the animation style on page out.', 'anva' ),
				'id' => 'page_loader_animation_out',
				'std' => 'fadeOut',
				'type' => 'select',
				'options' => $transition_animations
			),
		),
		'gallery' => array(
			'gallery_sort' => array(
				'name' => __('Images Sorting', 'anva'),
				'desc' => __('Select how you want to sort gallery images.', 'anva'),
				'id' => 'gallery_sort',
				'std' => 'drag',
				'type' => 'select',
				'options' => array(
					'drag' => __('Drag & Drop', 'anva'),
					'desc' => __('Newest', 'anva'),
					'asc' => __('Oldest', 'anva'),
					'rand' => __('Random', 'anva'),
					'title' => __('Title', 'anva')
				)
			),
			'gallery_template' => array(
				'name' => __('Default Template', 'anva'),
				'desc' => __('Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', 'anva'),
				'id' => 'gallery_template',
				'std' => '3-col',
				'type' => 'select',
				'options' => $galleries
			),
			'gallery_animate' => array(
				'name' => __( 'Animate', 'anva' ),
				'desc' => sprintf(
					__( 'Choose the default animation for gallery images. Get a %s of the animations.', 'anva' ),
					sprintf( '<a href="' . esc_url( 'https://daneden.github.io/animate.css/' ) . '" target="_blank">%s</a>', __( 'preview', 'anva' ) )
				),
				'id' => 'gallery_animate',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $animations
			),
			'gallery_delay' => array(
				'name' => __( 'Delay', 'anva' ),
				'desc' => __( 'Choose the default delay for animation.', 'anva' ),
				'id' => 'gallery_delay',
				'std' => 400,
				'type' => 'number'
			),
		),
		'slideshows' => array(
			'slider_id' => array(
				'name' => __( 'Slider', 'anva'),
				'desc' => __( 'Select the main slider. Based on the slider you select, the options below may change.', 'anva'),
				'id' => 'slider_id',
				'std' => 'standard',
				'type' => 'select',
				'options' => $slider_select
			),
			'slider_style' => array(
				'name' => __( 'Style', 'anva'),
				'desc' => __( 'Select the slider style.', 'anva'),
				'id' => 'slider_style',
				'std' => 'full-screen',
				'type' => 'select',
				'options' => array(
					'slider-boxed' => __( 'Boxed', 'anva' ),
					'full-screen'  => __( 'Full Screen', 'anva' ),
				)
			),
			'slider_parallax' => array(
				'name' => __( 'Parallax', 'anva'),
				'desc' => __( 'If you use the parallax effect for sliders enable this option.', 'anva'),
				'id' => 'slider_parallax',
				'std' => 'false',
				'type' => 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable parallax',
					'false'	=> 'No, disable parallax'
				),
			),
			'slider_thumbnails' => array(
				'name' => __( 'Parallax', 'anva'),
				'desc' => __( 'Select the image size you want to show in featured content.', 'anva'),
				'id' => 'slider_thumbnails',
				'std' => 'anva_xl',
				'type' => 'select',
				'options' => anva_get_image_sizes_thumbnail(),
			),
			'revslider_id' => array(
				'name' => __( 'Revolution Slider ID', 'anva' ),
				'desc' => __( 'Show or hide the slider direction navigation.', 'anva' ),
				'id' => 'revslider_id',
				'std' => '',
				'type' => 'text',
				'class' => 'slider-item revslider hide'
			),
		),
		'login' => array(
			'login_style' => array(
				'name' => __( 'Style', 'anva'),
				'desc' => __( 'Select the login style.', 'anva'),
				'id' => 'login_style',
				'std' => '',
				'type' => 'select',
				'options' => array(
					'' 	     => __( 'None', 'anva' ),
					'style1' => __( 'Style 1', 'anva' ),
					'style2' => __( 'Style 2', 'anva' ),
					'style3' => __( 'Style 3', 'anva' )
				)
			),
			'login_copyright' => array(
				'name' => __( 'Copyright Text', 'anva'),
				'desc' => __( 'Enter the copyright text you\'d like to show in the footer of your login page.', 'anva'),
				'id' => 'login_copyright',
				'std' => sprintf( __( 'Copyright %s %s. Designed by %s.', 'anva' ), date( 'Y' ), anva_get_theme( 'name' ), '<a href="' . esc_url( 'http://anthuanvasquez.net' ) . '" target="_blank">Anthuan Vasquez</a>' ),
				'type' => 'textarea',
			),
		),
	);

	anva_add_option( 'layout', 'header', 'header_type', 		 $layout['header_type'] );
	anva_add_option( 'layout', 'header', 'header_layout', 		 $layout['header_layout'] );
	anva_add_option( 'layout', 'header', 'top_bar_layout', 		 $layout['top_bar_layout'] );
	anva_add_option( 'layout', 'header', 'side_panel_type', 	 $layout['side_panel_type'] );
	anva_add_option( 'layout', 'header', 'side_header_icons', 	 $layout['side_header_icons'] );
	anva_add_option( 'layout', 'header', 'primary_menu_style', 	 $layout['primary_menu_style'] );
	anva_add_option( 'layout', 'header', 'header_extras', 		 $layout['header_extras'] );
	anva_add_option( 'layout', 'header', 'header_extras_text', 	 $layout['header_extras_text'] );
	anva_add_option( 'layout', 'footer', 'footer_extra_display', $layout['footer_extra_display'] );
	anva_add_option( 'layout', 'footer', 'footer_extra_info', 	 $layout['footer_extra_info'] );
	anva_add_option( 'layout', 'footer', 'footer_gototop', 		 $layout['footer_gototop'] );
	anva_add_option( 'layout', 'footer', 'footer_icons', 		 $layout['footer_icons'] );

	anva_add_option_section( 'layout', 'page_transition', __( 'Page Transition', 'anva' ),  NULL, $layout['page_transition'], false );
	anva_add_option_section( 'layout', 'gallery', 		  __( 'Galleries', 'anva' ), 		NULL, $layout['gallery'], false );
	anva_add_option_section( 'layout', 'slideshows', 	  __( 'Slideshows', 'anva' ), 	 	NULL, $layout['slideshows'], false );

	// Add slider options
	foreach ( $sliders as $slider_id => $slider ) {
		foreach ( $slider['options'] as $option_id => $option ) {
			anva_add_option( 'layout', 'slideshows', $option_id, $option );
		}
	}

	if ( anva_support_feature( 'anva-login' ) ) {
		anva_add_option_section( 'layout', 'login', __( 'Login', 'anva' ), NULL, $layout['login'], false );
	}

	/* ---------------------------------------------------------------- */
	/* Advanced Tab
	/* ---------------------------------------------------------------- */

	$advanced = array(
		'main' => array(
			'responsive' => array(
				'name' => __( 'Responsive', 'anva' ),
				'desc' => __( '<strong>Responsive:</strong> Apply special styles to tablets and mobile devices.', 'anva' ),
				'id' => "responsive",
				'std' => '1',
				'type' => 'checkbox',
			),
			'debug' => array(
				'name' => NULL,
				'desc' => __( 'Display debug information in the footer.', 'anva' ),
				'id' => 'debug',
				'std' => '0',
				'type' => 'checkbox',
			),
		),
	);

	anva_add_option_tab( 'advanced', __( 'Advanced', 'anva'), false, 'admin-settings' );
	anva_add_option_section( 'advanced', 'main', __( 'Main', 'anva' ), NULL, $advanced['main'], false );

}
add_action( 'after_setup_theme', 'anva_options', 9 );
