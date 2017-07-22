<?php
/**
 * Definition of the Anva_Options class.
 *
 * @package AnvaFramework
 */

if ( ! class_exists( 'Anva_Options' ) ) :

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
	 * @package     AnvaFramework
	 */
	class Anva_Options {

		/**
		 * A single instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Original Option name.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var string
		 */
		private $original_option_name = 'anva';

		/**
		 * Option name.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var string
		 */
		private $option_name = '';

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
		 * Default options values.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $defaults = array();

		/**
		 * Set transient for default options values.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $default_transient = '';

		/**
		 * Set transient for formatted options.
		 * s
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $formatted_transient = '';

		/**
		 * Enable or disable the cache for options.
		 *
		 * @since 1.0.0
		 * @var boolean
		 */
		private $cache = true;

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @since 1.0.0
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Constructor hook everything in.
		 */
		private function __construct() {

			// Set option name.
			$this->set_option_name();

			// Set raw options.
			$this->set_raw_options();

			// Set transient to cache formatted options.
			if ( empty( $this->formatted_transient ) ) {
				$this->formatted_transient = $this->option_name . '_formatted_options';
			}

			// Set transient to cache default values.
			if ( empty( $this->default_transient ) ) {
				$this->default_transient = $this->option_name . '_default_values';
			}

			// If DEBUG is active disable cache.
			if ( Anva::get_debug() ) {
				$this->cache = false;
			}

			// Hook options after setup theme happen.
			add_action( 'after_setup_theme', array( $this, 'set_formatted_options' ), 1000 );
			add_action( 'after_setup_theme', array( $this, 'set_default_values' ), 1001 );

		}

		/**
		 * Setup raw options array for framework.
		 */
		public function set_raw_options() {

			// Pull all the layouts into array.
			$layouts = anva_pull_layouts();

			// Pull all the categories into an array.
			$categories = anva_pull_categories();

			// Pull all the pages into an array.
			$pages = anva_pull_pages();

			// Social media buttons defautls.
			$social_media_defaults = apply_filters( 'anva_social_icons_defaults', array(
				'dribbble' => 'https://dribbble.com/oidoperfecto',
				'gplus'    => 'https://plus.google.com/+AnthuanVasquez',
				'twitter'  => 'https://twitter.com/oidoperfecto', // Follow Me! :).
				'rss'      => get_feed_link(),
			) );

			// Logo defaults.
			$logo_defaults = apply_filters( 'anva_logo_defaults', array(
				'type'       => 'image',
				'custom'     => '',
				'image'      => get_template_directory_uri() . '/assets/images/logo.png',
				'image_2x'   => get_template_directory_uri() . '/assets/images/logo@2x.png',
				'image_mini' => get_template_directory_uri() . '/assets/images/logo-mini.png',
			) );

			// Contact Fielfs Defaults.
			$contact_fields_defaults = apply_filters( 'anva_contact_fields_defaults', array(
				'name',
				'email',
				'subject',
				'message',
			) );

			// Author credtis.
			$author = '<a href="' . esc_url( 'http://anthuanvasquez.net' ) . '" target="_blank">Anthuan Vasquez</a>';

			// WordPress credits.
			$wordpress = '<a href="' . esc_url( 'http://wordpress.org' ) . '" title="WordPress" target="_blank">WordPress</a>';

			// If using image radio buttons, define a directory path.
			$image_path = get_template_directory_uri() . '/assets/images/';

			/**
			 * Tab #1: Layout
			 */

			$layout_options = array(
				'general' => array(
					'name' 	=> esc_html__( 'General', 'anva' ),
					'class' => 'group-general',
					'options' => array(
						'breadcrumbs' => array(
							'name' => esc_html__( 'Breadcrumbs', 'anva' ),
							'desc' => esc_html__( 'Select whether youd like breadcrumbs to show throughout the site or not.', 'anva' ),
							'id' => 'breadcrumbs',
							'std' => 'inside',
							'type' => 'select',
							'options' => array(
								'inside'  => esc_attr__( 'Show breadcrumbs inside page titles', 'anva' ),
								'outside' => esc_attr__( 'Show breadcrumbs outside page titles', 'anva' ),
								'hide'    => esc_attr__( 'Hide breadcrumbs', 'anva' ),
							),
						),
						'social_icons_profiles' => array(
							'name' => esc_html__( 'Social Media Profiles', 'anva' ),
							'desc' => sprintf(
								esc_html__( 'Enter the full URL you\'d like the button to link to in the corresponding text field that appears. Ex. %1$s. %2$s.', 'anva' ),
								esc_url( 'http://twitter.com/oidoperfecto' ),
								sprintf(
									'<strong>%s:</strong> %s: <strong>%s</strong>',
									esc_html__( 'Note', 'anva' ),
									esc_html__( 'If you are using the RSS button, your default RSS feed URL is', 'anva' ),
									get_feed_link()
								)
							),
							'id' => 'social_icons_profiles',
							'type' => 'social_media',
							'std' => $social_media_defaults,
						),
					),
				),
				'header' => array(
					'name' 	=> esc_html__( 'Header', 'anva' ),
					'class' => 'group-header',
					'options' => array(
						'custom_logo' => array(
							'name' => esc_html__( 'Logo', 'anva' ),
							'desc' => esc_html__( 'Configure the primary branding logo for the header of your site. Use the "Upload" button to either upload an image or select an image from your media library. When inserting an image with the "Upload" button, the URL and width will be inserted for you automatically. You can also type in the URL to an image in the text field along with a manually-entered width. If you\'re inputting a "HiDPI-optimized" image, it needs to be twice as large as you intend it to be displayed. Feel free to leave the HiDPI image field blank if you\'d like it to simply not have any effect.', 'anva' ),
							'id' => 'custom_logo',
							'std' => $logo_defaults,
							'type' => 'logo',
						),
						'favicon' => array(
							'name'  => esc_html__( 'Favicon', 'anva' ),
							'desc'  => esc_html__( 'Configure your won favicon. Recommended size is 16x16px.', 'anva' ),
							'id'    => 'favicon',
							'std'   => '',
							'class' => 'input-upload',
							'type'  => 'upload',
						),
						'apple_touch_icon_display' => array(
							'name'      => null,
							'desc'      => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Touch Icons', 'anva' ), esc_html__( 'Use the apple tuch icon.', 'anva' ) ),
							'id'        => 'apple_touch_icon_display',
							'std'       => '',
							'type'      => 'checkbox',
							'trigger'   => '1',
							'receivers' => 'apple_touch_icon apple_touch_icon_76 apple_touch_icon_120 apple_touch_icon_152',
						),
						'apple_touch_icon' => array(
							'name' => esc_html__( 'Appe Touch Icon (iPhone)', 'anva' ),
							'desc' => esc_html__( 'Configure the apple touch icon for iphones (non retina display). Recommended size is 57x57px.', 'anva' ),
							'id' => 'apple_touch_icon',
							'std' => '',
							'class' => 'input-upload',
							'type' => 'upload',
						),
						'apple_touch_icon_76' => array(
							'name' => esc_html__( 'Appe Touch Icon (iPad)', 'anva' ),
							'desc' => esc_html__( 'Configure the apple touch icon for ipads (non retina display). Recommended size is 76x76px.', 'anva' ),
							'id' => 'apple_touch_icon_76',
							'std' => '',
							'class' => 'input-upload',
							'type' => 'upload',
						),
						'apple_touch_icon_120' => array(
							'name' => esc_html__( 'Appe Touch Icon (iPhone Retina)', 'anva' ),
							'desc' => esc_html__( 'Configure the apple touch icon for iphones (retina display). Recommended size is 120x120px.', 'anva' ),
							'id' => 'apple_touch_icon_120',
							'std' => '',
							'class' => 'input-upload',
							'type' => 'upload',
						),
						'apple_touch_icon_152' => array(
							'name' => esc_html__( 'Appe Touch Icon (iPad Retina)', 'anva' ),
							'desc' => esc_html__( 'Configure the apple touch icon for ipads (retina display). Recommended size is 152x152px.', 'anva' ),
							'id' => 'apple_touch_icon_152',
							'std' => '',
							'class' => 'input-upload',
							'type' => 'upload',
						),
					),
				),
				'siderbar' => array(
					'name' => esc_html__( 'Sidebar Layout', 'anva' ),
					'class' => 'group-sidebar',
					'options' => array(
						'sidebar_layout' => array(
							'name' => esc_html__( 'Default Sidebar Layout', 'anva' ),
							'desc' => esc_html__( 'Choose the default sidebar layout for the main content area of your site. </br>Note: This will be the default sidebar layout throughout your site, but you can be override this setting for any specific page.', 'anva' ),
							'id' => 'sidebar_layout',
							'std' => 'right',
							'type' => 'images',
							'options' => $layouts,
						),
						'sidebar_message' => array(
							'name' => null,
							'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Sidebars Message', 'anva' ), esc_html__( 'Show message when the sidebars don\'t have any widgets.', 'anva' ) ),
							'id' => 'sidebar_message',
							'std' => '0',
							'type' => 'checkbox',
						),
						'dynamic_sidebar' => array(
							'name' => esc_html__( 'Custom Sidebars', 'anva' ),
							'desc' => esc_html__( 'Add a custom sidebars, will be register with others sidebars in widgets section.', 'anva' ),
							'id' => 'dynamic_sidebar',
							'std' => array(),
							'type' => 'sidebar',
						),
					),
				),
				'footer' => array(
					'name' => esc_html__( 'Footer', 'anva' ),
					'class' => 'group-header',
					'options' => array(
						'footer_setup' => array(
							'name'		=> esc_html__( 'Setup Columns', 'anva' ),
							'desc'		=> esc_html__( 'Choose the number of columns along with the corresponding width configurations.', 'anva' ),
							'id' 		=> 'footer_setup',
							'type'		=> 'columns',
						),
						'footer_copyright' => array(
							'name' => esc_html__( 'Copyright Text', 'anva' ),
							'desc' => esc_html__( 'Enter the copyright text you\'d like to show in the footer of your site. You can use basic HTML. %year% show current year. %site_title% show your site title.', 'anva' ),
							'id' => 'footer_copyright',
							'std' => 'Copyright %year% %site_title%. ' . sprintf( esc_html__( 'Powered by %1$s. Designed by %2$s.', 'anva' ), $wordpress, $author ),
							'type' => 'textarea',
						),
					),
				),
			);

			/**
			 * Tab #2: Content
			 */

			$content_options = array(
				'single' => array(
					'name' => esc_html__( 'Posts - Single', 'anva' ),
					'desc' => esc_html__( 'These settings will only apply to vewing single posts.', 'anva' ),
					'class' => 'group-single-posts',
					'options' => array(
						'single_meta' => array(
							'name' => esc_html__( 'Meta Information', 'anva' ),
							'desc' => esc_html__( 'Select if you\'d like the meta information (date posted, author, etc) to show at the top of the post.', 'anva' ),
							'id' => 'single_meta',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show meta informaton', 'anva' ),
								'hide' => esc_attr__( 'Hide meta informaton', 'anva' ),
							),
						),
						'single_thumb' => array(
							'name' => esc_html__( 'Featured Images', 'anva' ),
							'desc' => esc_html__( 'Select how you want your featured images to show at the top of the posts.', 'anva' ),
							'id' => 'single_thumb',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show'  => esc_attr__( 'Show standard featured images', 'anva' ),
								'small' => esc_attr__( 'Show small featured images', 'anva' ),
								'hide'  => esc_attr__( 'Hide featured images', 'anva' ),
							),
							'trigger'   => 'small',
							'receivers' => 'single_thumb_align',
						),
						'single_thumb_align' => array(
							'name' => esc_html__( 'Align Small Thumbnails', 'anva' ),
							'desc' => esc_html__( 'Select how you want to align your featured images.', 'anva' ),
							'id'   => 'single_thumb_align',
							'std'  => 'left',
							'type' => 'select',
							'options' => array(
								'left'   => esc_attr__( 'Align small thumbnails to the left', 'anva' ),
								'right'  => esc_attr__( 'Align small thumbnails to the right', 'anva' ),
								'center' => esc_attr__( 'Align small thumbnails to center', 'anva' ),
							),
						),
						'single_thumb_lightbox' => array(
							'name' => null,
							'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Lightbox', 'anva' ), esc_html__( 'Link featured image to a lightbox', 'anva' ) ),
							'id'   => 'single_thumb_lightbox',
							'std'  => '1',
							'type' => 'checkbox',
						),
						'comments' => array(
							'name' => esc_html__( 'Comments', 'anva' ),
							'desc' => esc_html__( 'Select if you\'d like to completely hide comments or not below the posts, pages, portfolio or galleries.', 'anva' ),
							'id'   => 'comments',
							'std'  => array(
								'single' => '1',
							),
							'type' => 'multicheck',
							'options' => anva_get_default_comment_areas(),
						),
						'single_share' => array(
							'name' => esc_html__( 'Share Icons', 'anva' ),
							'desc' => esc_html__( 'Select to display socials sharing in single posts.', 'anva' ),
							'id' => 'single_share',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show share icons', 'anva' ),
								'hide' => esc_attr__( 'Hide share icons', 'anva' ),
							),
						),
						'single_author' => array(
							'name' => esc_html__( 'About Author', 'anva' ),
							'desc' => esc_html__( 'Select to display about the author in single posts.', 'anva' ),
							'id' => 'single_author',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show about author', 'anva' ),
								'hide' => esc_attr__( 'Hide about author', 'anva' ),
							),
						),
						'single_related' => array(
							'name' => esc_html__( 'Related Posts', 'anva' ),
							'desc' => esc_html__( 'Select to display related posts in single posts.', 'anva' ),
							'id' => 'single_related',
							'std' => 'cat',
							'type' => 'select',
							'options' => array(
								'tag'  => esc_attr__( 'Show related posts by tag', 'anva' ),
								'cat'  => esc_attr__( 'Show related posts by category', 'anva' ),
								'hide' => esc_attr__( 'Hide related posts', 'anva' ),
							),
						),
						'single_navigation' => array(
							'name' => esc_html__( 'Navigation Posts', 'anva' ),
							'desc' => esc_html__( 'Select to display next and previous posts in single posts.', 'anva' ),
							'id' => 'single_navigation',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show navigation posts', 'anva' ),
								'hide' => esc_attr__( 'Hide navigation posts', 'anva' ),
							),
						),
						'single_post_reading_bar' => array(
							'name' => esc_html__( 'Show Post Reading Bar', 'anva' ),
							'desc' => esc_html__( 'Select to display the post reading bar indicator in single posts.', 'anva' ),
							'id' => 'single_post_reading_bar',
							'std' => '',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show the post reading bar', 'anva' ),
								'hide' => esc_attr__( 'Hide the post reading bar', 'anva' ),
							),
							'trigger' => 'show',
							'receivers' => 'single_post_reading_bar_position',
						),
						'single_post_reading_bar_position' => array(
							'name' => esc_html__( 'Reading Bar Position', 'anva' ),
							'desc' => esc_html__( 'Select the position of the post reading bar in single posts.', 'anva' ),
							'id' => 'single_post_reading_bar_position',
							'std' => 'bottom',
							'type' => 'select',
							'options' => array(
								'top'    => esc_attr__( 'Show at the top', 'anva' ),
								'bottom' => esc_attr__( 'Show at the bottom', 'anva' ),
							),
						),
						'single_more_story' => array(
							'name' => esc_html__( 'Show More Stories', 'anva' ),
							'desc' => esc_html__( 'Select to display the more stories.', 'anva' ),
							'id' => 'single_more_story',
							'std' => 'hide',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show the more story box', 'anva' ),
								'hide' => esc_attr__( 'Hide the more story box', 'anva' ),
							),
						),
					),
				),
				'primary' => array(
					'name' 	=> esc_html__( 'Posts - Blog', 'anva' ),
					'desc' 	=> esc_html__( 'These settings apply to your primary posts page', 'anva' ),
					'class' => 'group-primary-posts',
					'options' => array(
						'primary_meta' => array(
							'name' => esc_html__( 'Meta information', 'anva' ),
							'desc' => esc_html__( 'Select if you\'d like the meta information (date posted, author, etc) to show at the top of the primary posts.', 'anva' ),
							'id' => 'primary_meta',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show meta information', 'anva' ),
								'hide' => esc_attr__( 'Hide meta information', 'anva' ),
							),
						),
						'primary_thumb' => array(
							'name' => esc_html__( 'Featured Images', 'anva' ),
							'desc' => esc_html__( 'Choose how you want your featured images to show in primary posts.', 'anva' ),
							'id' => 'primary_thumb',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show featured images', 'anva' ),
								'hide' => esc_attr__( 'Hide featured images', 'anva' ),
							),
						),
						'primary_content' => array(
							'name' => esc_html__( 'Excerpt or Content', 'anva' ),
							'desc' => esc_html__( 'Choose whether you want to show full content or post excerpts only.', 'anva' ),
							'id' => 'primary_content',
							'std' => 'excerpt',
							'type' => 'select',
							'options' => array(
								'content' => esc_html__( 'Show full content', 'anva' ),
								'excerpt' => esc_html__( 'Show excerpt', 'anva' ),
							),
						),
						'exclude_categories' => array(
							'name' => esc_html__( 'Exclude Categories', 'anva' ),
							'desc' => esc_html__( 'Select any categories you\'d like to be excluded from your blog.', 'anva' ),
							'id' => 'exclude_categories',
							'std' => array(),
							'type' => 'multicheck',
							'options' => $categories,
						),
					),
				),
				'archives' => array(
					'name' => esc_html__( 'Archives Pages', 'anva' ),
					'desc' => esc_html__( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', 'anva' ),
					'class' => 'group-archives',
					'options' => array(
						'archive_title' => array(
							'name' => esc_html__( 'Show titles', 'anva' ),
							'desc' => esc_html__( 'Choose whether or not you want the title to show on tag archives, category archives, date archives, author archives and search result pages.', 'anva' ),
							'id' => 'archive_title',
							'std' => 'show',
							'type' => 'select',
							'options' => array(
								'show' => esc_attr__( 'Show the title', 'anva' ),
								'hide' => esc_attr__( 'Hide title', 'anva' ),
							),
						),
					),
				),
				'contactform' => array(
					'name' => esc_html__( 'Contact Form', 'anva' ),
					'desc' => esc_html__( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', 'anva' ),
					'class' => 'group-contactform',
					'options' => array(
						'contact_email' => array(
							'name' => esc_html__( 'Your Email Address', 'anva' ),
							'desc' => esc_html__( 'Enter which email address will be sent from the contact form.', 'anva' ),
							'id' => 'contact_email',
							'std' => '',
							'type' => 'email',
						),
						'contact_fields' => array(
							'name' => esc_html__( 'Contact Form Fields', 'anva' ),
							'desc' => esc_html__( 'Select and sort fields for your contact page. Use fields you want to show on your contact form.', 'anva' ),
							'id' => 'contact_fields',
							'std' => $contact_fields_defaults,
							'type' => 'contact_fields',
						),
						'contact_captcha' => array(
							'name' => esc_html__( 'Captcha', 'anva' ),
							'desc' => esc_html__( 'Enable this option to display captcha image to prevent possible spam in contact page.', 'anva' ),
							'id' => 'contact_captcha',
							'std' => 'no',
							'type' => 'select',
							'options' => array(
								'no'  => esc_attr__( 'No, disable', 'anva' ),
								'yes' => esc_attr__( 'Enable the captcha', 'anva' ),
							),
						),
						'contact_map_html' => array(
							'name' => esc_html__( 'Office or Company Name', 'anva' ),
							'desc' => esc_html__( 'Enter your office name, brand or address. It displays as popup inside the map.', 'anva' ),
							'id' => 'contact_map_html',
							'std' => '',
							'type' => 'text',
						),
						'contact_map_type' => array(
							'name' => esc_html__( 'Map Type', 'anva' ),
							'desc' => esc_html__( 'Enter the map coordinates. Latitude and Longitude address.', 'anva' ),
							'id' => 'contact_map_type',
							'std' => 'ROADMAP',
							'type' => 'select',
							'options' => array(
								'HYBRID'    => esc_attr__( 'Hybrid', 'anva' ),
								'TERRAIN'   => esc_attr__( 'Terrain', 'anva' ),
								'SATELLITE' => esc_attr__( 'Satellite', 'anva' ),
								'ROADMAP'   => esc_attr__( 'Roadmap', 'anva' ),
							),
						),
						'contact_map_address' => array(
							'name' => esc_html__( 'Map Coordinates', 'anva' ),
							'desc' => esc_html__( 'Enter the map coordinates. Latitude and Longitude address.', 'anva' ),
							'id' => 'contact_map_address',
							'std' => '',
							'type' => 'double_text',
						),
						'contact_map_zoom' => array(
							'name' => esc_html__( 'Map Zoom', 'anva' ),
							'desc' => esc_html__( 'Select zoom level for the contact map..', 'anva' ),
							'id' => 'contact_map_zoom',
							'std' => '10',
							'type' => 'range',
							'options' => array(
								'min'  => 1,
								'max'  => 19,
								'step' => 1,
							),
						),
					),
				),
			);

			/* Finalize and extend */

			$this->raw_options = array(
				'layout' 	   => array(
					'name'     => esc_html__( 'Layout', 'anva' ),
					'sections' => $layout_options,
					'icon'     => 'screenoptions',
				),
				'content' 	   => array(
					'name'     => esc_html__( 'Content', 'anva' ),
					'sections' => $content_options,
					'icon'     => 'format-status',
				),
			);

			// The following filter probably won't be used often,
			// but if there's something that can't be accomplished
			// through the client mutator API methods, then this
			// provides a way to modify these raw options.
			$this->raw_options = apply_filters( 'anva_raw_options', $this->raw_options );

		}

		/**
		 * Format raw options after client has had a chance to
		 * modifty options.
		 *
		 * This works because set_formatted_options()
		 * mutator is hooked in to the WP loading process at
		 * after_setup_theme.
		 */
		public function set_formatted_options() {

			// Get formatted options cache.
			$cache = get_transient( $this->formatted_transient );

			// If cache is stored return.
			if ( $cache && $this->cache ) {
				return;
			}

			$this->formatted_options = array();

			// Tab Level.
			foreach ( $this->raw_options as $tab_id => $tab ) {

				$icon = $tab['icon'];

				// Insert Tab Heading.
				$this->formatted_options[] = array(
					'id' 	=> $tab_id,
					'icon'	=> $icon,
					'name' 	=> $tab['name'],
					'type' 	=> 'heading',
				);

				// Section Level.
				if ( $tab['sections'] ) {
					foreach ( $tab['sections'] as $section_id => $section ) {

						$desc  = '';
						$class = '';

						if ( isset( $section['desc'] ) ) {
							$desc = $section['desc'];
						}

						if ( isset( $section['class'] ) ) {
							$class = $section['class'];
						}

						$this->formatted_options[] = array(
							'id'    => $section_id,
							'name'  => $section['name'],
							'desc'  => $desc,
							'class' => $class,
							'type'  => 'group_start',
						);

						// Options Level.
						if ( $section['options'] ) {
							foreach ( $section['options'] as $option_id => $option ) {
								$this->formatted_options[] = $option;
							}
						}

						// End section.
						$this->formatted_options[] = array(
							'type' => 'group_end',
						);
					}
				}
			}// End foreach().

			// Apply filters.
			$this->formatted_options = apply_filters( 'anva_formatted_options', $this->formatted_options );

			// Store formatted options as transient.
			if ( $this->cache ) {
				set_transient( $this->formatted_transient, $this->formatted_options, 60 * 60 );
			}
		}

		/**
		 * Set default values from formatted options.
		 *
		 * @return array Default options values.
		 */
		public function set_default_values() {

			// Get default values cache.
			$cache = get_transient( $this->default_transient );

			if ( $cache && $this->cache ) {
				return;
			}

			foreach ( $this->get_formatted_options() as $option ) {
				if ( ! isset( $option['id'] ) ) {
					continue;
				}

				if ( ! isset( $option['std'] ) ) {
					continue;
				}

				if ( ! isset( $option['type'] ) ) {
					continue;
				}

				// Before save default options we need sanitize them.
				$this->defaults[ $option['id'] ] = apply_filters( 'anva_sanitize_' . $option['type'], $option['std'], $option );
			}

			// Apply filters.
			$this->defaults = apply_filters( 'anva_default_values', $this->defaults );

			// Store default values as transient.
			if ( $this->cache ) {
				set_transient( $this->default_transient, $this->defaults, 60 * 60 );
			}
		}

		/**
		 * Set the theme option name.
		 *
		 * @since 1.0.0
		 */
		public function set_option_name() {
			if ( empty( $this->option_name ) ) {
				$this->option_name = get_option( 'stylesheet', $this->original_option_name );
				$this->option_name = preg_replace( '/\W/', '_', strtolower( $this->option_name ) );
			}

			// Apply filters.
			$this->option_name = apply_filters( 'anva_option_name', $this->option_name );
		}

		/**
		 * Add options panel tab.
		 */
		public function add_tab( $tab_id, $tab_name, $top = false, $icon = '' ) {

			// Can't create a tab that already exists.
			// Must use remove_tab() first to modify.
			if ( isset( $this->raw_options[ $tab_id ] ) ) {
				return;
			}

			if ( $top ) {

				// Add tab to the top of array.
				$new_options = array();
				$new_options[ $tab_id ] = array(
					'name'     => $tab_name,
					'sections' => array(),
					'icon'     => $icon,
				);

				$this->raw_options = array_merge( $new_options, $this->raw_options );

			} else {

				// Add tab to the end of global array.
				$this->raw_options[ $tab_id ] = array(
					'name'     => $tab_name,
					'sections' => array(),
					'icon'     => $icon,
				);

			}
		}

		/**
		 * Remove options panel tab.
		 *
		 * @param string $tab_id Tab ID to be removed.
		 */
		public function remove_tab( $tab_id ) {
			unset( $this->raw_options[ $tab_id ] );
		}

		/**
		 * Add section to an options panel tab.
		 *
		 * @param string  $tab_id       Tab ID.
		 * @param string  $section_id   Section ID.
		 * @param string  $section_name Name of the section.
		 * @param string  $section_desc Description of the section.
		 * @param array   $options      Options array to be added to the section.
		 * @param boolean $top          Move section to the top.
		 */
		public function add_section( $tab_id, $section_id, $section_name, $section_desc = '', $options = array(), $top = false ) {

			// Make sure tab exists.
			if ( ! isset( $this->raw_options[ $tab_id ] ) ) {
				return;
			}

			$class = 'group-' . $section_id;

			// Format options array.
			$new_options = array();
			if ( $options ) {
				foreach ( $options as $option ) {
					if ( isset( $option['id'] ) ) {
						$new_options[ $option['id'] ] = $option;
					}
				}
			}

			// Does the options section already exist?.
			if ( isset( $this->raw_options[ $tab_id ]['sections'][ $section_id ] ) ) {
				$this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'] = array_merge( $this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'], $new_options );
				return;
			}

			// Add new section to top or bottom.
			if ( $top ) {

				$previous_sections = $this->raw_options[ $tab_id ]['sections'];

				$this->raw_options[ $tab_id ]['sections'] = array(
					$section_id => array(
						'name' 		=> $section_name,
						'class'		=> $class,
						'desc' 		=> $section_desc,
						'options'   => $new_options,
					),
				);

				$this->raw_options[ $tab_id ]['sections'] = array_merge( $this->raw_options[ $tab_id ]['sections'], $previous_sections );

			} else {

				$this->raw_options[ $tab_id ]['sections'][ $section_id ] = array(
					'name'		=> $section_name,
					'class'		=> $class,
					'desc'		=> $section_desc,
					'options'	=> $new_options,
				);

			}
		}

		/**
		 * Remove section from an options panel tab.
		 */
		public function remove_section( $tab_id, $section_id ) {
			unset( $this->raw_options[ $tab_id ]['sections'][ $section_id ] );
		}

		/**
		 * Add option.
		 */
		public function add_option( $tab_id, $section_id, $option_id, $option ) {

			if ( ! isset( $this->raw_options[ $tab_id ] ) ) {
				return;
			}

			if ( ! isset( $this->raw_options[ $tab_id ]['sections'][ $section_id ] ) ) {
				return;
			}

			$this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'][ $option_id ] = $option;

		}

		/**
		 * Remove option.
		 */
		public function remove_option( $tab_id, $section_id, $option_id ) {

			if ( ! isset( $this->raw_options[ $tab_id ] ) || ! isset( $this->raw_options[ $tab_id ]['sections'][ $section_id ] ) ) {
				return;
			}

			if ( isset( $this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'][ $option_id ] ) ) {

				// If option has element's ID as key, we can find and
				// remove it easier.
				unset( $this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'][ $option_id ] );

			} else {

				// If this is an option added by a child theme or plugin,
				// and it doesn't have the element's ID as the key, we'll
				// need to loop through to find it in order to remove it.
				foreach ( $this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'] as $key => $value ) {
					if ( $value['id'] == $option_id ) {
						unset( $this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'][ $key ] );
					}
				}
			}
		}

		/**
		 * Edit option.
		 *
		 * @param  string               $tab_id Tab ID.
		 * @param  string               $section_id Section ID.
		 * @param  string               $option_id Option ID.
		 * @param  string               $att Attribute.
		 * @param  string|array|boolean $value Option valie.
		 * @return void
		 */
		public function edit_option( $tab_id, $section_id, $option_id, $att, $value ) {

			if ( ! isset( $this->raw_options[ $tab_id ] ) ) {
				return;
			}

			if ( ! isset( $this->raw_options[ $tab_id ]['sections'][ $section_id ] ) ) {
				return;
			}

			if ( ! isset( $this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'][ $option_id ] ) ) {
				return;
			}

			$this->raw_options[ $tab_id ]['sections'][ $section_id ]['options'][ $option_id ][ $att ] = $value;
		}

		/**
		 * Get raw options.
		 *
		 * @return array Raw options without format.
		 */
		public function get_raw_options() {
			return $this->raw_options;
		}

		/**
		 * Get formatted options.
		 *
		 * @return array Formatted options.
		 */
		public function get_formatted_options() {
			$cache = get_transient( $this->formatted_transient );
			if ( $cache && $this->cache ) {
				return $cache;
			}
			return $this->formatted_options;
		}

		/**
		 * Get default values.
		 *
		 * @since  1.0.0
		 * @return array Default options values
		 */
		public function get_default_values() {
			$cache = get_transient( $this->default_transient );
			if ( $cache && $this->cache ) {
				return $cache;
			}
			return $this->defaults;
		}


		/**
		 * Get especific option value.
		 *
		 * @param  string               $id Default options ID.
		 * @param  string|array|boolean $default Default options value.
		 * @return string|array|boolean $default Default options value.
		 */
		public function get_option( $id, $default = false ) {
			// Get settings from database.
			$options = $this->get_all();

			// Return specific option.
			if ( isset( $options[ $id ] ) ) {
				return $options[ $id ];
			}

			// Return specific default option.
			if ( ! $default ) {
				return $this->get_default( $id );
			}

			// Return default option.
			return $default;
		}

		/**
		 * Get specific default option value.
		 *
		 * @param  string
		 * @return string|boolean|array
		 */
		public function get_default( $id ) {
			$defaults = $this->get_default_values();
			if ( isset( $defaults[ $id ] ) ) {
				return $defaults[ $id ];
			}

			return false;
		}

		/**
		 * Get option name.
		 *
		 * @since  1.0.0
		 * @return string Option name.
		 */
		public function get_option_name() {
			return $this->option_name;
		}

		/**
		 * Get all saved options.
		 *
		 * @return array
		 */
		public function get_all() {
			return get_option( $this->option_name, array() );
		}
	}

endif;
