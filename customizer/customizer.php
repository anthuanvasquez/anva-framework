<?php

// Customizer Extensions
include_once Anva::$framework_dir_path . 'customizer/custom-controls.php';

// Customizer Previews
include_once Anva::$framework_dir_path . 'customizer/preview.php';

// Customizer Utilities
include_once Anva::$framework_dir_path . 'customizer/utilities.php';

/**
 * Add option section for theme customizer added in WP 3.4.
 *
 * @since  1.0.0.
 * @param  string          $section_id
 * @param  string          $title
 * @param  array           $options
 * @param  integer|null    $priority
 * @param  string|boolean  $description
 * @return void
 */
function anva_add_customizer_section( $section_id, $title, $options, $priority = null, $description = '' ) {

	global $_anva_customizer_sections;

	if ( empty( $section_desc ) ) {
		$description = FALSE;
	}

	$_anva_customizer_sections[ $section_id ] = array(
		'id' 			=> $section_id,
		'title' 		=> $title,
		'options' 		=> $options,
		'priority'		=> $priority,
		'description'	=> $description,
	);

}

/**
 * @todo anva_add_customizer_panel()
 */

/**
 * Setup everything we need for WordPress customizer
 *
 * @since 1.0.0.
 * @return void
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
			$wp_customize->add_section( $section['id'], $section );

			$font_counter = 1;

			// Add Options
			if ( $section['options'] ) {

				foreach ( $section['options'] as $option ) {

					// Set section if one isn't set
					if ( ! isset( $option['section'] ) ) {
						$option['section'] = $section['id'];
					}

					// Set blank description if one isn't set
					if ( ! isset( $option['description'] ) ) {
						$option['description'] = '';
					}

					// Set blank active_callback if one isn't set
					if ( ! isset( $option['active_callback'] ) ) {
						$option['active_callback'] = '';
					}

					if ( isset( $option['type'] ) ) {

						// Apply a default sanitization if one isn't set
						if ( ! isset( $option['sanitize_callback'] ) ) {
							$option['sanitize_callback'] = anva_customizer_get_sanitization( $option['type'] );
						}

						// --------------------------------------------
						// Logo Option
						// --------------------------------------------

						if ( $option['type'] == 'logo' ) {

							// Setup defaults
							$defaults = array(
								'type' 						=> '',
								'custom' 					=> '',
								'custom_tagline' 	=> '',
								'image' 					=> ''
							);

							if ( isset( $theme_settings[ $option['id'] ] ) ) {
								foreach ( $defaults as $key => $value ) {
									if ( isset( $theme_settings[ $option['id'] ][ $key ] ) ) {
										$defaults[ $key ] = $theme_settings[ $option['id'] ][ $key ];
									}
								}
							}

							// Transport
							$transport = '';

							if ( isset( $option['transport'] ) ) {
								$transport = $option['transport'];
							}

							// Logo Type
							$wp_customize->add_setting(
								$option_name . '[' . $option['id'] . '][type]', array(
									'default'    	=> esc_attr( $defaults['type'] ),
									'type'       	=> 'option',
									'capability' 	=> 'edit_theme_options',
									'transport'		=> $transport,
									'sanitize_callback' => 'anva_customizer_sanitize_choices'
								)
							);

							$wp_customize->add_control(
								$option['id'] . '_type', array(
									'priority'				=> 1,
									'settings'				=> $option_name . '[' . $option['id'] . '][type]',
									'label'   				=> $option['label'] . ' ' . __( 'Type', 'anva' ),
									'section'    			=> $section['id'],
									'type'       			=> 'select',
									'choices'    			=> array(
										'title' 				=> __( 'Site Title', 'anva' ),
										'title_tagline'	=> __( 'Site Title + Tagline', 'anva' ),
										'custom' 				=> __( 'Custom Text', 'anva' ),
										'image' 				=> __( 'Image', 'anva' )
									)
								)
							);

							// Custom Title
							$wp_customize->add_setting(
								$option_name . '[' . $option['id'] . '][custom]', array(
									'default'    	=> esc_attr( $defaults['custom'] ),
									'type'       	=> 'option',
									'capability' 	=> 'edit_theme_options',
									'transport'		=> $transport,
									'sanitize_callback' => 'sanitize_text_field'

								)
							);

							$wp_customize->add_control(
								$option['id'] . '_custom', array(
									'priority'		=> 2,
									'settings'		=> $option_name . '[' . $option['id'] . '][custom]',
									'label'      	=> __( 'Custom Title', 'anva' ),
									'section'    	=> $section['id']
								)
							);

							// Custom Tagline
							$wp_customize->add_setting(
								$option_name . '[' . $option['id'] . '][custom_tagline]', array(
									'default'    	=> esc_attr( $defaults['custom_tagline'] ),
									'type'       	=> 'option',
									'capability' 	=> 'edit_theme_options',
									'transport'		=> $transport,
									'sanitize_callback' => 'sanitize_text_field'
								)
							);

							$wp_customize->add_control(
								$option['id'] . '_custom_tagline', array(
									'priority'		=> 3,
									'settings'		=> $option_name . '[' . $option['id'] . '][custom_tagline]',
									'label'      	=> __( 'Custom Tagline', 'anva' ),
									'section'    	=> $section['id']
								)
							);

							// Logo Image
							$wp_customize->add_setting(
								$option_name . '[' . $option['id'] . '][image]', array(
									'default'    	=> esc_attr( $defaults['image'] ),
									'type'       	=> 'option',
									'capability' 	=> 'edit_theme_options',
									'transport'		=> $transport,
									'sanitize_callback' => 'anva_sanitize_upload'
								)
							);

							$wp_customize->add_control(
								new WP_Customize_Image_Control(
									$wp_customize, $option['id'] . '_image', array(
										'priority'		=> 4,
										'settings'		=> $option_name . '[' . $option['id'] . '][image]',
										'label'   		=> $option['label'] . ' ' . __( 'Image', 'anva' ),
										'section' 		=> $section['id']
									)
								)
							);

						// --------------------------------------------
						// Typography Option
						// --------------------------------------------

						} else if ( $option['type'] == 'typography' ) {

							// Setup defaults
							$defaults = array(
								'size' 		=> '',
								'style'		=> '',
								'weight'    => '',
								'face' 		=> '',
								'color' 	=> '',
								'select' 	=> '',
								'google' 	=> ''
							);

							if ( isset( $theme_settings[ $option['id'] ] ) ) {
								$defaults = $theme_settings[ $option['id'] ];
							}

							// Transport
							$transport = '';

							if ( isset( $option['transport'] ) ) {
								$transport = $option['transport'];
							}

							if ( isset( $option['atts'] ) ) {

								// Loop through included attributes
								foreach ( $option['atts'] as $attribute ) {

									// Register options
									if ( 'select' != $attribute  ) {
										$wp_customize->add_setting(
											$option_name . '[' . $option['id'] . '][' . $attribute . ']', array(
												'default'    	=> esc_attr( $defaults[ $attribute ] ),
												'type'       	=> 'option',
												'capability' 	=> 'edit_theme_options',
												'transport'		=> $transport,
												'sanitize_callback' => 'sanitize_text_field'
											)
										);
									} else {
										$wp_customize->add_setting(
											$option_name . '[' . $option['id'] . ']', array(
												'default'    	=> esc_attr( $defaults[ $attribute ] ),
												'type'       	=> 'option',
												'capability' 	=> 'edit_theme_options',
												'transport'		=> $transport,
												'sanitize_callback' => 'anva_customizer_sanitize_choices'
											)
										);
									}

									switch ( $attribute ) {

										case 'size' :
											$size_options = array();
											foreach (anva_recognized_font_sizes() as $size) {
												$size_options[$size] = $size . 'px';
											}

											$wp_customize->add_control(
												$option['id'] . '_' . $attribute, array(
													'priority'		=> $font_counter,
													'settings'		=> $option_name . '[' . $option['id'] . '][' . $attribute . ']',
													'label'   		=> $option['label'] . ' ' . ucfirst( $attribute ),
													'section'    	=> $section['id'],
													'type'       	=> 'select',
													'choices'    	=> $size_options,
												)
											);

											$font_counter++;

											break;

										case 'face' :

											$wp_customize->add_control(
												new WP_Customize_Anva_Font_Face(
													$wp_customize, $option['id'] . '_' . $attribute, array(
														'priority'	=> $font_counter,
														'settings'	=> $option_name . '[' . $option['id'] . '][' . $attribute . ']',
														'label'   	=> $option['label'] .' ' . ucfirst( $attribute ),
														'section' 	=> $section['id'],
														'choices'   => anva_recognized_font_faces(),
													)
												)
											);

											$font_counter++;

											$wp_customize->add_setting(
												$option_name . '[' . $option['id'] . '][google]', array(
													'default'    	=> esc_attr( $defaults['google'] ),
													'type'       	=> 'option',
													'capability' 	=> 'edit_theme_options',
													'transport'		=> $transport,
													'sanitize_callback' => 'sanitize_text_field'
												)
											);

											$wp_customize->add_control(
												new WP_Customize_Anva_Google_Font(
													$wp_customize, $option['id'] . '_' . $attribute . '_google', array(
														'priority'	=> $font_counter,
														'settings'	=> $option_name . '[' . $option['id'] . '][google]',
														'label'   	=> __( 'Google Font Name', 'anva' ),
														'section' 	=> $section['id'],
													)
												)
											);

											$font_counter++;

											break;

										case 'weight' :

											$wp_customize->add_control(
												$option['id'] . '_' . $attribute, array(
													'priority'		=> $font_counter,
													'settings'		=> $option_name . '[' . $option['id'] . '][' . $attribute . ']',
													'label'   		=> $option['label'] . ' ' . ucfirst( $attribute ),
													'section'    	=> $section['id'],
													'type'       	=> 'select',
													'choices'    	=> anva_recognized_font_weights(),
												)
											);

											break;

										case 'style' :

											$wp_customize->add_control(
												$option['id'] . '_' . $attribute, array(
													'priority'		=> $font_counter,
													'settings'		=> $option_name . '[' . $option['id'] . '][' . $attribute . ']',
													'label'   		=> $option['label'] . ' ' . ucfirst( $attribute ),
													'section'    	=> $section['id'],
													'type'       	=> 'select',
													'choices'    	=> anva_recognized_font_styles(),
												)
											);

											$font_counter++;

											break;

										case 'color' :

											$wp_customize->add_control(
												new WP_Customize_Color_Control(
													$wp_customize, $option['id'] . '_' . $attribute, array(
														'priority'	=> $font_counter,
														'settings'	=> $option_name . '[' . $option['id'] . '][' . $attribute . ']',
														'label'   	=> $option['label'] . ' ' . ucfirst( $attribute ),
														'section' 	=> $section['id'],
													)
												)
											);

											$font_counter++;

											break;

										case 'select' :

											$wp_customize->add_control(
												$option['id'], array(
													'priority'		=> $font_counter,
													'settings'		=> $option_name . '[' . $option['id'] . ']',
													'label'   		=> $option['label'],
													'section'    	=> $section['id'],
													'type'       	=> 'range',
													'input_attrs' => array(
												        'min'   => 9,
												        'max'   => 72,
												        'step'  => 1,
												        'class' => 'test-class test',
												        'style' => 'color: #0a0',
												    ),
												)
											);

											$font_counter++;

											break;
									}

									if ( 'select' != $attribute ) {

										// Divider line below each font
										$wp_customize->add_setting(
											$option_name . '[' . $option['id'] . '][divider]', array(
												'type'       	=> 'option',
												'capability' 	=> 'edit_theme_options',
												'transport'		=> $transport,
												'sanitize_callback' => 'sanitize_text_field'
											)
										);

										$wp_customize->add_control(
											new WP_Customize_Anva_Divider(
												$wp_customize, $option['id'] . '_divider', array(
													'priority'	=> $font_counter,
													'settings'	=> $option_name . '[' . $option['id'] . '][divider]',
													'section'		=> $section['id'],
												)
											)
										);
									}

								}

							} else {

								$font_counter++;

								$wp_customize->add_setting(
									$option_name . '[' . $option['id'] . ']', array(
										'type'       	=> 'option',
										'capability' 	=> 'edit_theme_options',
										'transport'		=> $transport,
										'sanitize_callback' => 'anva_customizer_sanitize_choices'
									)
								);

								$wp_customize->add_control(
									$option['id'], array(
										'priority'		=> $font_counter,
										'settings'		=> $option_name . '[' . $option['id'] . ']',
										'label'   		=> $option['label'],
										'section'    	=> $section['id'],
										'type'       	=> 'select',
										'choices'    	=> anva_recognized_font_sizes(),
									)
								);

							}

						// --------------------------------------------
						// Other Options
						// --------------------------------------------

						} else {

							// Default
							$default = '';

							if ( isset( $theme_settings[ $option['id'] ] ) ) {
								$default = $theme_settings[ $option['id'] ];
							}

							if ( ! isset( $option['default'] ) ) {
								$option['default'] = esc_attr( $default );
							}

							if ( ! isset( $option['settings'] ) ) {
								$option['settings'] = $option_name . '[' . $option['id'] . ']';
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

							anva_customizer_add_setting( $option, $wp_customize );

							// Add controls based on control type
							switch ( $option['type'] ) {


								case 'text' :
								case 'url' :
								case 'select' :
								case 'radio' :
								case 'checkbox' :
								case 'range' :
								case 'dropdown-pages' :

									$wp_customize->add_control(
										$option['id'], $option
									);

									break;

								// Textarea
								case 'textarea' :

									if ( version_compare( $GLOBALS['wp_version'], '3.9.2', '<=' ) ) :

										$wp_customize->add_control(
											new WP_Customize_Anva_Textarea(
												$wp_customize, $option['id'], $option
											)
										);

									else :

										$wp_customize->add_control(
											'setting_id', array(
												$wp_customize->add_control(
													$option['id'], $option
												)
											)
										);

									endif;

									break;

								// Color
								case 'color' :

									$wp_customize->add_control(
										new WP_Customize_Color_Control(
											$wp_customize, $option['id'], $option
										)
									);

									break;

								// Image
								case 'image' :

									$wp_customize->add_control(
										new WP_Customize_Image_Control(
											$wp_customize,
											$option['id'], array(
												'label'             => $option['label'],
												'section'           => $option['section'],
												'sanitize_callback' => $option['sanitize_callback'],
												'priority'          => $option['priority'],
												'active_callback'   => $option['active_callback'],
												'description'      	=> $option['description']
											)
										)
									);

									break;

								case 'upload':

									$wp_customize->add_control(
										new WP_Customize_Upload_Control(
											$wp_customize,
											$option['id'], array(
												'label'             => $option['label'],
												'section'           => $option['section'],
												'sanitize_callback' => $option['sanitize_callback'],
												'priority'          => $option['priority'],
												'active_callback'   => $option['active_callback'],
												'description'      	=> $option['description']
											)
										)
									);

									break;
							}
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

					break;
			}
		}
	}

}
