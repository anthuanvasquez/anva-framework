<?php

// Customizer Extensions
include_once ( 'customizer/custom-controls.php' );

// Customizer Previews
include_once ( 'customizer/preview.php' );

/**
 * Add option section for theme customizer added in WP 3.4
 *
 * @since 1.0.0
 */
function anva_add_customizer_section( $section_id, $section_name, $options, $priority = null ) {

	global $_anva_customizer_sections;

	$_anva_customizer_sections[$section_id] = array(
		'id' 				=> $section_id,
		'name' 			=> $section_name,
		'options' 	=> $options,
		'priority'	=> $priority
	);

}

/**
 * Format options for customizer into array
 * organized with all sections together
 *
 * @since 1.0.0
 */
function anva_registered_customizer_options( $sections ) {
	$registered_options = array();
	if ( $sections ) {
		foreach ( $sections as $section ) {
			if ( $section['options'] ) {
				foreach ( $section['options'] as $option ) {
					$registered_options[$option['id']] = $option;
				}
			}
		}
	}
	return $registered_options;
}

/**
 * Setup everything we need for WordPress customizer
 *
 * @since 1.0.0
 */
function anva_customizer_init( $wp_customize ) {

	global $_anva_customizer_sections;

	// Get current theme settings
	$option_name = anva_get_option_name();
	$theme_settings = anva_get_options();

	// Register sections of options
	if ( $_anva_customizer_sections ) {
		foreach ( $_anva_customizer_sections as $section ) {

			// Add section
			$wp_customize->add_section( $section['id'], array(
				'title'    => $section['name'],
				'priority' => $section['priority'],
			) );

			$font_counter = 1;

			// Add Options
			if ( $section['options'] ) {
				foreach ( $section['options'] as $option ) {

					if ( $option['type'] == 'logo' ) {

						// LOGO

						// Setup defaults
						$defaults = array(
							'type' 						=> '',
							'custom' 					=> '',
							'custom_tagline' 	=> '',
							'image' 					=> ''
						);

						if ( isset( $theme_settings[$option['id']] ) ) {
							foreach ( $defaults as $key => $value ) {
								if ( isset( $theme_settings[$option['id']][$key] ) ) {
									$defaults[$key] = $theme_settings[$option['id']][$key];
								}
							}
						}

						// Transport
						$transport = '';
						if ( isset( $option['transport'] ) ) {
							$transport = $option['transport'];
						}

						// Logo Type
						$wp_customize->add_setting( $option_name.'['.$option['id'].'][type]', array(
							'default'    	=> esc_attr( $defaults['type'] ),
							'type'       	=> 'option',
							'capability' 	=> 'edit_theme_options',
							'transport'		=> $transport
						) );

						$wp_customize->add_control( $option['id'].'_type', array(
							'priority'		=> 1,
							'settings'		=> $option_name.'['.$option['id'].'][type]',
							'label'   		=> $option['name'].' '.__( 'Type', 'anva' ),
							'section'    	=> $section['id'],
							'type'       	=> 'select',
							'choices'    	=> array(
								'title' 		=> __( 'Site Title', 'anva' ),
								'title_tagline'	=> __( 'Site Title + Tagline', 'anva' ),
								'custom' 		=> __( 'Custom Text', 'anva' ),
								'image' 		=> __( 'Image', 'anva' )
							)
						) );

						// Custom Title
						$wp_customize->add_setting( $option_name.'['.$option['id'].'][custom]', array(
							'default'    	=> esc_attr( $defaults['custom'] ),
							'type'       	=> 'option',
							'capability' 	=> 'edit_theme_options',
							'transport'		=> $transport
						) );
						$wp_customize->add_control( $option['id'].'_custom', array(
							'priority'		=> 2,
							'settings'		=> $option_name.'['.$option['id'].'][custom]',
							'label'      	=> __( 'Custom Title', 'anva' ),
							'section'    	=> $section['id']
						) );

						// Custom Tagline
						$wp_customize->add_setting( $option_name.'['.$option['id'].'][custom_tagline]', array(
							'default'    	=> esc_attr( $defaults['custom_tagline'] ),
							'type'       	=> 'option',
							'capability' 	=> 'edit_theme_options',
							'transport'		=> $transport
						) );
						$wp_customize->add_control( $option['id'].'_custom_tagline', array(
							'priority'		=> 3,
							'settings'		=> $option_name.'['.$option['id'].'][custom_tagline]',
							'label'      	=> __( 'Custom Tagline', 'anva' ),
							'section'    	=> $section['id']
						) );

						// Logo Image
						$wp_customize->add_setting( $option_name.'['.$option['id'].'][image]', array(
							'default'    	=> esc_attr( $defaults['image'] ),
							'type'       	=> 'option',
							'capability' 	=> 'edit_theme_options',
							'transport'		=> $transport
						) );
						$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option['id'].'_image', array(
							'priority'		=> 4,
							'settings'		=> $option_name.'['.$option['id'].'][image]',
							'label'   		=> $option['name'].' '.__( 'Image', 'anva' ),
							'section' 		=> $section['id'],
						) ) );

					} else if ( $option['type'] == 'typography' ) {

						// TYPOGRAPHY

						// Setup defaults
						$defaults = array(
							'size' 		=> '',
							'style'		=> '',
							'face' 		=> '',
							'style' 	=> '',
							'color' 	=> '',
							'google' 	=> ''
						);

						if ( isset( $theme_settings[$option['id']] ) ) {
							$defaults = $theme_settings[$option['id']];
						}

						// Transport
						$transport = '';
						if ( isset( $option['transport'] ) ) {
							$transport = $option['transport'];
						}

						// Loop through included attributes
						foreach ( $option['atts'] as $attribute ) {

							// Register options
							$wp_customize->add_setting( $option_name.'['.$option['id'].']['.$attribute.']', array(
								'default'    	=> esc_attr( $defaults[$attribute] ),
								'type'       	=> 'option',
								'capability' 	=> 'edit_theme_options',
								'transport'		=> $transport
							) );

							switch ( $attribute ) {

								case 'size' :
									$size_options = array();
									for($i = 9; $i < 71; $i++) {
										$size = $i . 'px';
										$size_options[$size] = $size;
									}
									$wp_customize->add_control( $option['id'].'_'.$attribute, array(
										'priority'		=> $font_counter,
										'settings'		=> $option_name.'['.$option['id'].']['.$attribute.']',
										'label'   		=> $option['name'].' '.ucfirst($attribute),
										'section'    	=> $section['id'],
										'type'       	=> 'select',
										'choices'    	=> $size_options
									) );
									$font_counter++;
									break;

								case 'face' :
									$wp_customize->add_control( new WP_Customize_Anva_Font_Face( $wp_customize, $option['id'].'_'.$attribute, array(
										'priority'		=> $font_counter,
										'settings'		=> $option_name.'['.$option['id'].']['.$attribute.']',
										'label'   		=> $option['name'].' '.ucfirst($attribute),
										'section' 		=> $section['id'],
										'choices'    	=> anva_recognized_font_faces()
									) ) );
									$font_counter++;
									$wp_customize->add_setting( $option_name.'['.$option['id'].'][google]', array(
										'default'    	=> esc_attr( $defaults['google'] ),
										'type'       	=> 'option',
										'capability' 	=> 'edit_theme_options',
										'transport'		=> $transport
									) );
									$wp_customize->add_control( new WP_Customize_Anva_Google_Font( $wp_customize, $option['id'].'_'.$attribute.'_google', array(
										'priority'		=> $font_counter,
										'settings'		=> $option_name.'['.$option['id'].'][google]',
										'label'   		=> __( 'Google Font Name', 'anva' ),
										'section' 		=> $section['id']
									) ) );
									$font_counter++;
									break;

								case 'style' :
									$wp_customize->add_control( $option['id'].'_'.$attribute, array(
										'priority'		=> $font_counter,
										'settings'		=> $option_name.'['.$option['id'].']['.$attribute.']',
										'label'   		=> $option['name'].' '.ucfirst($attribute),
										'section'    	=> $section['id'],
										'type'       	=> 'select',
										'choices'    	=> anva_recognized_font_styles()
									) );
									$font_counter++;
									break;

								case 'color' :
									$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $option['id'].'_'.$attribute, array(
										'priority'		=> $font_counter,
										'settings'		=> $option_name.'['.$option['id'].']['.$attribute.']',
										'label'   		=> $option['name'].' '.ucfirst($attribute),
										'section' 		=> $section['id']
									) ) );
									$font_counter++;
									break;
							}

							// Divider line below each font
							$wp_customize->add_setting( $option_name.'['.$option['id'].'][divider]', array(
								'type'       	=> 'option',
								'capability' 	=> 'edit_theme_options',
								'transport'		=> $transport
							) );
							$wp_customize->add_control( new WP_Customize_Anva_Divider( $wp_customize, $option['id'].'_divider', array(
								'priority'		=> $font_counter,
								'settings'		=> $option_name.'['.$option['id'].'][divider]',
								'section'		=> $section['id']
							) ) );

							$font_counter++;

						}

					} else {

						// ALL OTHER OPTIONS

						// Default
						$default = '';
						if ( isset( $theme_settings[$option['id']] ) ) {
							$default = $theme_settings[$option['id']];
						}

						// Transport
						$transport = '';
						if ( isset( $option['transport'] ) ) {
							$transport = $option['transport'];
						}

						$priority = '';
						if ( isset( $option['priority'] ) ) {
							$priority = $option['priority'];
						}

						// Register option
						$wp_customize->add_setting( $option_name.'['.$option['id'].']', array(
							'default'    		=> esc_attr( $default ),
							'type'       		=> 'option',
							'capability' 		=> 'edit_theme_options',
							'transport'			=> $transport
						) );

						// Add controls
						switch ( $option['type'] ) {

							// Standard text option
							case 'text' :
								$wp_customize->add_control( $option['id'], array(
									'priority'	=> $priority,
									'settings'	=> $option_name.'['.$option['id'].']',
									'label'			=> $option['name'],
									'section'		=> $section['id']
								) );
								break;

							// Textarea
							case 'textarea' :
								$wp_customize->add_control( new WP_Customize_Anva_Textarea( $wp_customize, $option['id'], array(
									'priority'	=> $priority,
									'settings'	=> $option_name.'['.$option['id'].']',
									'label'   	=> $option['name'],
									'section' 	=> $section['id']
								) ) );
								break;

							// Select box
							case 'select' :
								$wp_customize->add_control( $option['id'], array(
									'priority'	=> $priority,
									'settings'	=> $option_name.'['.$option['id'].']',
									'label'			=> $option['name'],
									'section'		=> $section['id'],
									'type'			=> 'select',
									'choices'		=> $option['options']
								) );
								break;

							// Radio set
							case 'radio' :
								$wp_customize->add_control( $option['id'], array(
									'priority'	=> $priority,
									'settings'	=> $option_name.'['.$option['id'].']',
									'label'			=> $option['name'],
									'section'		=> $section['id'],
									'type'			=> 'radio',
									'choices'		=> $option['options']
								) );
								break;

							// Color
							case 'color' :
								$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $option['id'], array(
									'priority'	=> $priority,
									'settings'	=> $option_name.'['.$option['id'].']',
									'label'			=> $option['name'],
									'section'		=> $section['id']
								) ) );
								break;

							// Image
							case 'image' :
								$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option['id'], array(
									'priority'	=> $priority,
									'settings'	=> $option_name.'['.$option['id'].']',
									'label'   	=> $option['name'],
									'section' 	=> $section['id']
								) ) );
								break;
						}
					}
				}
			}
		}
	}

	// Remove irrelevant sections
	$remove_sections = apply_filters( 'anva_customizer_remove_sections', array( 'title_tagline' ) );
	if ( is_array( $remove_sections ) && $remove_sections ) {
		foreach ( $remove_sections as $section ) {
			$wp_customize->remove_section( $section );
		}
	}

	// Modify sections
	$modify_sections = apply_filters( 'anva_customizer_modify_sections', array() );
	if ( ! empty( $modify_sections ) ) {
		foreach ( $modify_sections as $section ) {
			// Currently only one section set to be modified. I'm doing this
			// loop to make it so you can stop items from being modified and
			// I can may add to this in the future.
			switch ( $section ) {
				case 'static_front_page' :

					// Modify section's title
					$wp_customize->add_section( 'static_front_page', array(
						'title'         => __( 'Homepage', 'anva' ),
						'priority'      => 120,
						'description'   => __( 'Your theme supports a static front page.', 'anva' ),
					) );

					// Add custom homepage option
					$wp_customize->add_setting( $option_name.'[homepage_content]', array(
						'default'    	=> '',
						'type'       	=> 'option',
						'capability' 	=> 'edit_theme_options'
					) );

					$wp_customize->add_control( 'homepage_content', array(
						'settings'		=> $option_name.'[homepage_content]',
						'label'			=> __( 'Homepage Content', 'anva' ),
						'section'		=> 'static_front_page',
						'type'			=> 'radio',
						'choices'		=> array(
							'posts'			=> __( 'WordPress Default', 'anva' ),
							'custom_layout' => __( 'Custom Layout', 'anva' )
						)
					) );

					// Add custom layout selection
					// Custom Layouts
					$custom_layouts = array();
					$custom_layout_posts = get_posts('post_type=tb_layout&numberposts=-1');

					if ( ! empty( $custom_layout_posts ) ) {
						foreach ( $custom_layout_posts as $layout ) {
							$custom_layouts[$layout->post_name] = $layout->post_title;
						}
					} else {
						$custom_layouts['null'] = __( 'You haven\'t created any custom layouts yet.', 'anva' );
					}

					$wp_customize->add_setting( $option_name.'[homepage_custom_layout]', array(
						'default'    	=> '',
						'type'       	=> 'option',
						'capability' 	=> 'edit_theme_options'
					) );

					$wp_customize->add_control( 'homepage_custom_layout', array(
						'settings'		=> $option_name.'[homepage_custom_layout]',
						'label'				=> __( 'Homepage Custom Layout', 'anva' ),
						'section'			=> 'static_front_page',
						'type'				=> 'select',
						'choices'			=> $custom_layouts
					) );
					break;
			}
		}
	}
}