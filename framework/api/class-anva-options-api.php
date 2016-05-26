<?php

if ( ! class_exists( 'Anva_Options_API' ) ) :

/**
 * Anva Core Options API.
 *
 * This class establishes all of the framework's theme options,
 * allow these options to be modified from theme side.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Options_API
{
	/**
	 * A single instance of this class.
 	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Raw options.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array
	 */
	private $raw_options = array();

	/**
	 * Formatted options.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array
	 */
	private $formatted_options = array();

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance()
	{
		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor Hook everything in.
	 */
	private function __construct()
	{
		if ( is_admin() ) {
			
			// Setup options
			$this->set_raw_options();

			// Format options
			add_action( 'after_setup_theme', array( $this, 'set_formatted_options' ), 1000 );
		}
	}

	/**
	 * Setup raw options array for the start of the API process.
	 */
	public function set_raw_options()
	{
		/* ---------------------------------------------------------------- */
		/* Helpers
		/* ---------------------------------------------------------------- */
		
		// Fill layouts array
		$layouts = array();
		if ( is_admin() ) {
			foreach ( anva_get_sidebar_layouts() as $key => $value ) {
				$layouts[ $key ] = $value['icon'];
			}
		}

		// Pull all the categories into an array
		$categories = array();
		if ( is_admin() ) {
			foreach ( get_categories() as $category ) {
				$categories[ $category->cat_ID ] = $category->cat_name;
			}
		}

		// Pull all the pages into an array
		$pages = array();
		if ( is_admin() ) {
			$pages[''] = __( 'Select a page', 'anva' ) . ':';
			foreach ( get_pages( 'sort_column=post_parent,menu_order' ) as $page ) {
				$pages[ $page->ID ] = $page->post_title;
			}
		}

		/* ---------------------------------------------------------------- */
		/* Defaults
		/* ---------------------------------------------------------------- */

		// Template defaults
		$template_defaults = array(
			'blog' 				=> __( 'Classic Blog', 'anva' ),
			'search' 			=> __( 'Classic Search', 'anva' ),
			'2col' 				=> __( '2 Columns', 'anva'),
			'3col' 				=> __( '3 Columns', 'anva' )
		);

		// Social media buttons defautls
		$social_media_defaults = apply_filters( 'anva_social_icons_defaults', array(
			'dribbble'		=> 'https://dribbble.com/oidoperfecto',
			'gplus' 		=> 'https://plus.google.com/+AnthuanVasquez',
			'twitter' 		=> 'https://twitter.com/oidoperfecto', // Follow Me! :)
			'rss'			=> get_feed_link()
		) );

		// Logo defaults
		$logo_defaults = apply_filters( 'anva_logo_defaults', array(
			'type'            => 'image',
			'custom'          => '',
			'image'           => ANVA_FRAMEWORK_IMG . 'logo.png',
			'image_2x'        => ANVA_FRAMEWORK_IMG . 'logo@2x.png',
			'image_alternate' => ANVA_FRAMEWORK_IMG . 'logo-alternate.png'
		) );

		// Author default credtis
		$author = '<a href="' . esc_url( 'http://anthuanvasquez.net' ) . '" target="_blank">Anthuan Vasquez</a>';

		// If using image radio buttons, define a directory path
		$image_path = get_template_directory_uri() . '/assets/images/';

		/* ---------------------------------------------------------------- */
		/* Tab #1: Layout
		/* ---------------------------------------------------------------- */

		$layout_options = array(
			'main' => array(
				'name' 	=> __( 'Main', 'anva' ),
				'class' => 'group-main',
				'options' => array(
					'breadcrumbs' => array(
						'name' => __('Breadcrumbs', 'anva'),
						'desc' => __('Select whether youd like breadcrumbs to show throughout the site or not.', 'anva'),
						'id' => 'breadcrumbs',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show breadcrumbs', 'anva'),
							'hide' => __('Hide breadcrumbs', 'anva')
						)
					),
					'social_icons_profiles' => array(
						"name" => __('Social Media Profiles', 'anva'),  
						"desc" => sprintf( __( 'Enter the full URL you\'d like the button to link to in the corresponding text field that appears. Example: %s. <strong>Note:</strong> If youre using the RSS button, your default RSS feed URL is: <strong>%s</strong>.', 'anva' ), esc_url( 'http://twitter.com/oidoperfecto' ), get_feed_link()  ),  
						"id" => "social_icons_profiles",
						"type" => "social_media",
						"std" => $social_media_defaults
					),
				)
			),
			'header' => array(
				'name' 	=> __( 'Header', 'anva' ),
				'class' => 'group-header',
				'options' => array(
					'custom_logo' => array(
						'name' => __( 'Logo', 'anva' ),
						'desc' => __( 'Configure the primary branding logo for the header of your site.<br /><br />Use the "Upload" button to either upload an image or select an image from your media library. When inserting an image with the "Upload" button, the URL and width will be inserted for you automatically. You can also type in the URL to an image in the text field along with a manually-entered width.<br /><br />If you\'re inputting a "HiDPI-optimized" image, it needs to be twice as large as you intend it to be displayed. Feel free to leave the HiDPI image field blank if you\'d like it to simply not have any effect.', 'anva' ),
						'id' => 'custom_logo',
						'std' => $logo_defaults,
						'type' => 'logo'
					),
					'favicon' => array(
						'name' => __('Favicon', 'anva'),
						'desc' => __('Configure your won favicon. Recommended size is 16x16px.', 'anva'),
						'id' => 'favicon',
						'std' => '',
						'class' => 'input-upload',
						'type' => 'upload'
					),
					'apple_touch_icon_display' => array(
						'name' => NULL,
						'desc' => __( 'Use the apple tuch icon.', 'anva'),
						'id' => 'apple_touch_icon_display',
						'std' => '',
						'type' => 'checkbox',
						'trigger' => '1',
						'receivers' => 'apple_touch_icon apple_touch_icon_76 apple_touch_icon_120 apple_touch_icon_152',
					),
					'apple_touch_icon' => array(
						'name' => __('Appe Touch Icon (iPhone)', 'anva'),
						'desc' => __('Configure the apple touch icon for iphones (non retina display). Recommended size is 57x57px.', 'anva'),
						'id' => 'apple_touch_icon',
						'std' => '',
						'class' => 'input-upload',
						'type' => 'upload'
					),
					'apple_touch_icon_76' => array(
						'name' => __('Appe Touch Icon (iPad)', 'anva'),
						'desc' => __('Configure the apple touch icon for ipads (non retina display). Recommended size is 76x76px.', 'anva'),
						'id' => 'apple_touch_icon_76',
						'std' => '',
						'class' => 'input-upload',
						'type' => 'upload'
					),
					'apple_touch_icon_120' => array(
						'name' => __('Appe Touch Icon (iPhone Retina)', 'anva'),
						'desc' => __('Configure the apple touch icon for iphones (retina display). Recommended size is 120x120px.', 'anva'),
						'id' => 'apple_touch_icon_120',
						'std' => '',
						'class' => 'input-upload',
						'type' => 'upload'
					),
					'apple_touch_icon_152' => array(
						'name' => __('Appe Touch Icon (iPad Retina)', 'anva'),
						'desc' => __('Configure the apple touch icon for ipads (retina display). Recommended size is 152x152px.', 'anva'),
						'id' => 'apple_touch_icon_152',
						'std' => '',
						'class' => 'input-upload',
						'type' => 'upload'
					)
				)
			),
			'siderbar' => array(
				'name' => __( 'Sidebar Layout', 'anva' ),
				'class' => 'group-sidebar',
				'options' => array(
					'sidebar_layout' => array(
						'name' => __( 'Default Sidebar Layout', 'anva'),
						'desc' => __( 'Choose the default sidebar layout for the main content area of your site. </br>Note: This will be the default sidebar layout throughout your site, but you can be override this setting for any specific page.', 'anva'),
						'id' => 'sidebar_layout',
						'std' => 'right',
						'type' => 'images',
						'options' => $layouts
					),
					'sidebar_message' => array(
						'name' => NULL,
						'desc' => __( 'Show message when the sidebars don\'t have any widgets.', 'anva'),
						'id' => 'sidebar_message',
						'std' => '0',
						'type' => 'checkbox',
					),
					'dynamic_sidebar' => array(
						'name' => __( 'Custom Sidebars', 'anva' ),
						'desc' => __( 'Add a custom sidebars.', 'anva' ),
						'id' => 'dynamic_sidebar',
						'std' => array(),
						'type' => 'sidebar'
					),
				),
			),
			'footer' => array(
				'name' => __( 'Footer', 'anva' ),
				'class' => 'group-header',
				'options' => array(
					'footer_setup' => array(
						'name'		=> __( 'Setup Columns', 'anva' ),
						'desc'		=> __( 'Choose the number of columns along with the corresponding width configurations.', 'anva' ),
						'id' 		=> 'footer_setup',
						'type'		=> 'columns'
					),
					'footer_copyright' => array(
						'name' => __( 'Copyright Text', 'anva' ),
						'desc' => __( 'Enter the copyright text you\'d like to show in the footer of your site. You can use basic HTML. <br /><br /><em>%year%</em> show current year. <br /><em>%site_title%</em> show your site title.', 'anva' ),
						'id' => "footer_copyright",
						'std' => 'Copyright %year% %site_title%. ' . sprintf( __( 'Powered by %s. Designed by %s.', 'anva' ), '<a href="' . esc_url( 'http://wordpress.org' ) . '" title="WordPress" target="_blank">WordPress</a>', $author ),
						'type' => 'textarea'
					),
				)
			),
		);

		/* ---------------------------------------------------------------- */
		/* Tab #2: Content
		/* ---------------------------------------------------------------- */

		$content_options = array(
			'single' => array(
				'name' => __( 'Posts - Single', 'anva' ),
				'desc' => __( 'These settings will only apply to vewing single posts.', 'anva' ),
				'class' => 'group-single-posts',
				'options' => array(
					'single_meta' => array(
						'name' => __('Meta Information', 'anva'),
						'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the post.', 'anva'),
						'id' => 'single_meta',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show meta informaton', 'anva'),
							'hide' => __('Hide meta informaton', 'anva'),
						)
					),
					'single_thumb' => array(
						'name' => __('Featured Images', 'anva'),
						'desc' => __('Select how you want your featured images to show at the top of the posts.', 'anva'),
						'id' => 'single_thumb',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __( 'Show featured images', 'anva'),
							'hide' => __( 'Hide featured images', 'anva'),
						)
					),
					'single_comments' => array(
						'name' => __('Comments', 'anva'),
						'desc' => __('Select if you\'d like to completely hide comments or not below the post.', 'anva'),
						'id' => 'single_comments',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show comments', 'anva'),
							'hide' => __('Hide comments', 'anva'),
						)
					),
					'single_share' => array(
						'name' => __('Share Icons', 'anva'),
						'desc' => __('Select to display socials sharing in single posts.', 'anva'),
						'id' => 'single_share',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show share icons', 'anva'),
							'hide' => __('Hide share icons', 'anva')
						)
					),
					'single_author' => array(
						'name' => __('About Author', 'anva'),
						'desc' => __('Select to display about the author in single posts.', 'anva'),
						'id' => 'single_author',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show about author', 'anva'),
							'hide' => __('Hide about author', 'anva')
						)
					),
					'single_related' => array(
						'name' => __('Related Posts', 'anva'),
						'desc' => __('Select to display related posts in single posts.', 'anva'),
						'id' => 'single_related',
						'std' => 'cat',
						'type' => 'select',
						'options' => array(
							'tag'  => __('Show related posts by tag', 'anva'),
							'cat'  => __('Show related posts by category', 'anva'),
							'hide' => __('Hide related posts', 'anva'),
						)
					),
					'single_navigation' => array(
						'name' => __('Navigation Posts', 'anva'),
						'desc' => __('Select to display next and previous posts in single posts.', 'anva'),
						'id' => 'single_navigation',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show navigation posts', 'anva'),
							'hide' => __('Hide navigation posts', 'anva'),
						)
					),
					'single_post_reading_bar' => array(
						'name' => __( 'Show Post Reading Bar', 'anva'),
						'desc' => __( 'Select to display the post reading bar indicator in single posts.', 'anva'),
						'id' => 'single_post_reading_bar',
						'std' => '',
						'type' => 'select',
						'options' => array(
							'show' => __( 'Show the post reading bar', 'anva' ),
							'hide' => __( 'Hide the post reading bar', 'anva' ),
						)
					),
				)
			),
			'primary' => array(
				'name' 	=> __( 'Posts - Blog', 'anva' ),
				'desc' 	=> __( 'These settings apply to your primary posts page', 'anva' ),
				'class' => 'group-primary-posts',
				'options' => array(
					'primary_meta' => array(
						'name' => __('Meta information', 'anva'),
						'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the primary posts.', 'anva'),
						'id' => 'primary_meta',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show meta information', 'anva'),
							'hide' => __('Hide meta information', 'anva'),
						)
					),
					'primary_thumb' => array(
						'name' => __('Featured Images', 'anva'),
						'desc' => __('Choose how you want your featured images to show in primary posts.', 'anva'),
						'id' => 'primary_thumb',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show featured images', 'anva'),
							'hide' => __('Hide featured images', 'anva'),
						)
					),
					'primary_content' => array(
						'name' => __('Excerpt or Content', 'anva'),
						'desc' => __('Choose whether you want to show full content or post excerpts only.', 'anva'),
						'id' => 'primary_content',
						'std' => 'excerpt',
						'type' => 'select',
						'options' => array(
							'content' => __('Show full content', 'anva'),
							'excerpt' => __('Show excerpt', 'anva'),
						)
					),
					'exclude_categories' => array(
						'name' => __('Exclude Categories', 'anva'),
						'desc' => __('Select any categories you\'d like to be excluded from your blog.', 'anva'),
						'id' => 'exclude_categories',
						'std' => array(),
						'type' => 'multicheck',
						'options' => $categories
					),
				)
			),
			'archives' => array(
				'name' => __( 'Archives', 'anva' ),
				'desc' => __( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', 'anva' ),
				'class' => 'group-archives',
				'options' => array(
					'archive_title' => array(
						'name' => __('Show titles', 'anva'),
						'desc' => __('Choose whether or not you want the title to show on tag archives, category archives, date archives, author archives and search result pages.', 'anva'),
						'id' => 'archive_title',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show the title', 'anva'),
							'hide' => __('Hide title', 'anva'),
						)
					),
					'archive_page' => array(
						'name' => __('Page Layout', 'anva'),
						'desc' => __('Select default layout for archive page.', 'anva'),
						'id' => 'archive_page',
						'std' => 'blog',
						'type' => 'select',
						'options' => $template_defaults
					),
				)
			),
			'contactform' => array(
				'name' => __( 'Contact Form', 'anva' ),
				'desc' => __( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', 'anva' ),
				'class' => 'group-contactform',
				'options' => array(
					'contact_email' => array(
						'name' => __('Your Email Address', 'anva'),
						'desc' => __('Enter which email address will be sent from the contact form.', 'anva'),
						'id' => 'contact_email',
						'std' => '',
						'type' => 'text',
					),
					'contact_fields' => array(
						'name' => __('Contact Form Fields', 'anva'),
						'desc' => __('Select and sort fields for your contact page. Use fields you want to show on your contact form.', 'anva'),
						'id' => 'contact_fields',
						'std' => array(
							'name',
							'email',
							'subject',
							'message',
						),
						'type' => 'contact_fields',
					),
					'contact_captcha' => array(
						'name' => __('Captcha', 'anva'),
						'desc' => __('Enable this option to display captcha image to prevent possible spam in contact page.', 'anva'),
						'id' => 'contact_captcha',
						'std' => 'no',
						'type' => 'select',
						'options' => array(
							'no' => __( 'No, disable', 'anva' ),
							'yes' => __( 'Enable the captcha', 'anva' ),
						),
					),
					'contact_map_html' => array(
						'name' => __('Office or Company Name', 'anva'),
						'desc' => __('Enter your office name, brand or address. It displays as popup inside the map.', 'anva'),
						'id' => 'contact_map_html',
						'std' => '',
						'type' => 'text',
					),
					'contact_map_type' => array(
						'name' => __('Map Type', 'anva'),
						'desc' => __('Enter the map coordinates. Latitude and Longitude address.', 'anva'),
						'id' => 'contact_map_type',
						'std' => 'ROADMAP',
						'options' => array(
							'HYBRID' => __( 'Hybrid', 'anva' ),
							'TERRAIN' => __( 'Terrain', 'anva' ),
							'SATELLITE' => __( 'Satellite', 'anva' ),
							'ROADMAP' => __( 'Roadmap', 'anva' ),
						),
						'type' => 'select',
					),
					'contact_map_address' => array(
						'name' => __('Map Coordinates', 'anva'),
						'desc' => __('Enter the map coordinates. Latitude and Longitude address.', 'anva'),
						'id' => 'contact_map_address',
						'std' => '',
						'type' => 'double_text',
					),
					'contact_map_zoom' => array(
						'name' => __('Map Zoom', 'anva'),
						'desc' => __('Select zoom level for the contact map..', 'anva'),
						'id' => 'contact_map_zoom',
						'std' => '10',
						'type' => 'range',
						'options' => array(
							'min' => 1,
							'max' => 19,
							'step' => 1,
						)
					),
				)
			),
		);

		/* ---------------------------------------------------------------- */
		/* Finalize and extend
		/* ---------------------------------------------------------------- */

		$this->raw_options = array(
			'layout' 	   => array(
				'name'     => __( 'Layout', 'anva' ),
				'sections' => $layout_options,
				'icon'     => 'screenoptions',
			),
			'content' 	   => array(
				'name'     => __( 'Content', 'anva' ),
				'sections' => $content_options,
				'icon'     => 'format-status',
			),
		);

		// The following filter probably won't be used often,
		// but if there's something that can't be accomplished
		// through the client mutator API methods, then this
		// provides a way to modify these raw options.
		$this->raw_options = apply_filters( 'anva_core_options', $this->raw_options );

	}

	/**
	 * Format raw options after client has had a chance to
	 * modifty options.
	 *
	 * This works because our set_formatted_options()
	 * mutator is hooked in to the WP loading process at
	 * after_setup_theme.
	 */
	public function set_formatted_options() {

		$this->formatted_options = array();

		// Tab Level
		foreach ( $this->raw_options as $tab_id => $tab ) {

			$icon = $tab['icon'];

			// Insert Tab Heading
			$this->formatted_options[] = array(
				'id' 	=> $tab_id,
				'icon'	=> $icon,
				'name' 	=> $tab['name'],
				'type' 	=> 'heading'
			);

			// Section Level
			if ( $tab['sections'] ) {
				foreach ( $tab['sections'] as $section_id => $section ) {

					$desc = '';
					$class = '';

					// Start section
					if ( isset( $section['desc'] ) ) {
						$desc = $section['desc'];
					}

					if ( isset( $section['class'] ) ) {
						$class= $section['class'];
					}

					$this->formatted_options[] = array(
						'id'	 => $section_id,
						'name' => $section['name'],
						'desc' => $desc,
						'class'=> $class,
						'type' => 'group_start'
					);

					// Options Level
					if ( $section['options'] ) {
						foreach ( $section['options'] as $option_id => $option ) {
							$this->formatted_options[] = $option;
						}
					}

					// End section
					$this->formatted_options[] = array(
						'type' => 'group_end'
					);
				}
			}
		}

		// Apply filters
		$this->formatted_options = apply_filters( 'anva_formatted_options', $this->formatted_options );

	}

	/**
	 * Add options panel tab
	 */
	public function add_tab( $tab_id, $tab_name, $top = false, $icon = '' ) {

		// Can't create a tab that already exists. 
		// Must use remove_tab() first to modify.
		if ( isset( $this->raw_options[$tab_id] ) ) {
			return;
		}

		if ( $top ) {

			// Add tab to the top of array
			$new_options = array();
			$new_options[$tab_id] = array(
				'name'     => $tab_name,
				'sections' => array(),
				'icon'     => $icon,
			);
			$this->raw_options = array_merge( $new_options, $this->raw_options );

		} else {

			// Add tab to the end of global array
			$this->raw_options[$tab_id] = array(
				'name'     => $tab_name,
				'sections' => array(),
				'icon'     => $icon,
			);

		}
	}

	/**
	 * Remove options panel tab
	 */
	public function remove_tab( $tab_id ) {
		unset( $this->raw_options[$tab_id] );
	}

	/**
	 * Add section to an options panel tab
	 */
	public function add_section( $tab_id, $section_id, $section_name, $section_desc = '', $options = array(), $top = false ) {

		// Make sure tab exists
		if ( ! isset( $this->raw_options[$tab_id] ) )
			return;

		$class = 'group-' . $section_id;

		// Format options array
		$new_options = array();
		if ( $options ) {
			foreach ( $options as $option ) {
				if ( isset( $option['id'] ) ) {
					$new_options[$option['id']] = $option;
				}
			}
		}

		// Does the options section already exist?
		if ( isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			$this->raw_options[$tab_id]['sections'][$section_id]['options'] = array_merge( $this->raw_options[$tab_id]['sections'][$section_id]['options'], $new_options );
			return;
		}

		// Add new section to top or bottom
		if ( $top ) {

			$previous_sections = $this->raw_options[$tab_id]['sections'];

			$this->raw_options[$tab_id]['sections'] = array(
				$section_id => array(
					'name' 		=> $section_name,
					'class'		=> $class,
					'desc' 		=> $section_desc,
					'options' => $new_options
				)
			);

			$this->raw_options[$tab_id]['sections'] = array_merge( $this->raw_options[$tab_id]['sections'], $previous_sections );

		} else {

			$this->raw_options[$tab_id]['sections'][$section_id] = array(
				'name'		=> $section_name,
				'class'		=> $class,
				'desc'		=> $section_desc,
				'options'	=> $new_options
			);

		}

	}

	/**
	 * Remove section from an options panel tab
	 */
	public function remove_section( $tab_id, $section_id ) {
		unset( $this->raw_options[$tab_id]['sections'][$section_id] );
	}

	/**
	 * Add option
	 */
	public function add_option( $tab_id, $section_id, $option_id, $option ) {

		

		if ( ! isset( $this->raw_options[$tab_id] ) ) {
			return;
		}

		if ( ! isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			return;
		}

		$this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] = $option;

	}

	/**
	 * Remove option
	 */
	public function remove_option( $tab_id, $section_id, $option_id ) {

		if ( ! isset( $this->raw_options[$tab_id] ) || ! isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			return;
		}

		if ( isset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] ) ) {

			// If option has element's ID as key, we can find and
			// remove it easier.
			unset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] );

		} else {

			// If this is an option added by a child theme or plugin,
			// and it doesn't have the element's ID as the key, we'll
			// need to loop through to find it in order to remove it.
			foreach ( $this->raw_options[$tab_id]['sections'][$section_id]['options'] as $key => $value ) {
				if ( $value['id'] == $option_id ) {
					unset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$key] );
				}
			}

		}
	}

	/**
	 * Edit option
	 */
	public function edit_option( $tab_id, $section_id, $option_id, $att, $value ) {

		if ( ! isset( $this->raw_options[$tab_id] ) ) {
			return;
		}

		if ( ! isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			return;
		}

		if ( ! isset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] ) ) {
			return;
		}

		$this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id][$att] = $value;
	}

	/**
	 * Get core options
	 */
	public function get_raw_options() {
		return $this->raw_options;
	}

	/**
	 * Get formatted options
	 */
	public function get_formatted_options() {
		return $this->formatted_options;
	}

}
endif;