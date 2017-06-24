<?php
/**
 * Anva is a WordPress Theme Framework.
 *
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Anva class launches the framework. It's the organizational structure behind the
 * entire framework. This class should be loaded and initialized before anything else within
 * the theme is called to properly use the framework.
 *
 * @since  1.0.0
 */
class Anva {

	/**
	 * Framework's Name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var   string
	 */
	public static $name = 'Anva Framework';

	/**
	 * Framework's Version.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public static $version = '1.0.0';

	/**
	 * Framework version id.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public static $version_id = 'anva_framework_version';

	/**
	 * Theme version.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public static $theme_version = '';

	/**
	 * Theme version id.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public static $theme_version_id = '';

	/**
	 * The framework directory path.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public static $framework_dir_path = '';

	/**
	 * The framework directory uri.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public static $framework_dir_uri = '';

	/**
	 * Enable or disable framework debug mode.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    boolean
	 */
	public static $debug = false;

	/**
	 * Cloning is forbidden.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheating Huh?', 'anva' ), esc_html( self::$version ) );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheating Huh?', 'anva' ), esc_html( self::$version ) );
	}

	/**
	 * Constructor hook everything in.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Set framework paths.
		self::$framework_dir_path = trailingslashit( get_template_directory() . '/framework' );
		self::$framework_dir_uri  = trailingslashit( get_template_directory_uri() . '/framework' );

		// Setup framework constants.
		$this->set_constants();

		// Autolder classes.
		spl_autoload_register( array( $this, 'autoloader' ) );

		// Setup framework files.
		$this->set_files();

		// Setup framework hooks.
		$this->set_hooks();

		// Setup API hooks.
		$this->set_api();

	}

	/**
	 * Autoloads files when requested.
	 *
	 * @since 1.0.0
	 * @param string $class_name Name of the class being requested.
	 */
	function autoloader( $class_name ) {

		// If the class being requested does not start with our prefix.
		if ( 0 !== strpos( $class_name, 'Anva' ) ) {
			return;
		}

		$file_name = 'class-' . str_replace(
			array( 'Anva_', '_' ),
			array( '', '-' ),
			strtolower( $class_name )
		);

		// Compile our path from the current location.
		$file = self::$framework_dir_path . $file_name . '.php';

		// If a file is found then load it up!.
		if ( file_exists( $file ) ) {
			include_once( $file );
		}
	}

	/**
	 * Defines the constant paths for use within the
	 * core framework, parent theme, and child theme.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function set_constants() {
		define( 'ANVA_FRAMEWORK_VERSION', self::get_version() );
		define( 'ANVA_FRAMEWORK_DEBUG', self::get_debug() );
		define( 'ANVA_FRAMEWORK_CSS', trailingslashit( self::$framework_dir_uri . 'assets/css' ) );
		define( 'ANVA_FRAMEWORK_JS', trailingslashit( self::$framework_dir_uri . 'assets/js' ) );
		define( 'ANVA_FRAMEWORK_IMG', trailingslashit( self::$framework_dir_uri . 'assets/images' ) );
		define( 'ANVA_FRAMEWORK_ADMIN', trailingslashit( self::$framework_dir_path . 'admin' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_URI', trailingslashit( self::$framework_dir_uri . 'admin' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_CSS', trailingslashit( self::$framework_dir_uri . 'admin/assets/css' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_JS', trailingslashit( self::$framework_dir_uri . 'admin/assets/js' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_IMG', trailingslashit( self::$framework_dir_uri . 'admin/assets/images' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_PLUGINS', trailingslashit( self::$framework_dir_uri . 'admin/assets/plugins' ) );
	}

	/**
	 * Include core framerwork files.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function set_files() {

		// Admin files.
		include_once( self::$framework_dir_path . 'admin/options-ui-types.php' );
		include_once( self::$framework_dir_path . 'admin/options-ui-sanitization.php' );
		include_once( self::$framework_dir_path . 'admin/includes/general.php' );
		include_once( self::$framework_dir_path . 'admin/includes/helpers.php' );
		include_once( self::$framework_dir_path . 'admin/includes/display.php' );
		include_once( self::$framework_dir_path . 'admin/includes/meta.php' );
		include_once( self::$framework_dir_path . 'admin/includes/locals.php' );

		// Helpers functions.
		include_once( self::$framework_dir_path . 'anva-tgm.php' );
		include_once( self::$framework_dir_path . 'anva-updates.php' );
		include_once( self::$framework_dir_path . 'anva-helpers.php' );

		// General functions.
		include_once( self::$framework_dir_path . 'includes/general.php' );
		include_once( self::$framework_dir_path . 'includes/display.php' );
		include_once( self::$framework_dir_path . 'includes/post-formats.php' );
		include_once( self::$framework_dir_path . 'includes/media.php' );
		include_once( self::$framework_dir_path . 'includes/content.php' );
		include_once( self::$framework_dir_path . 'includes/parts.php' );
		include_once( self::$framework_dir_path . 'includes/attributes.php' );
		include_once( self::$framework_dir_path . 'includes/elements.php' );
		include_once( self::$framework_dir_path . 'includes/helpers.php' );
		include_once( self::$framework_dir_path . 'includes/locals.php' );

		// Customizer API.
		include_once( self::$framework_dir_path . 'customizer/customizer.php' );
	}

	/**
	 * Initialize framework hooks.
	 *
	 * @since 1.0.0
	 */
	public function set_hooks() {

		/**
		 * General Hooks.
		 */
		add_action( 'anva_init_api', 'anva_init_api_helpers' );
		add_filter( 'image_size_names_choose', 'anva_image_size_names_choose' );
		add_action( 'after_setup_theme', 'anva_load_theme_texdomain' );
		add_action( 'after_setup_theme', 'anva_add_image_sizes' );
		add_action( 'after_setup_theme', 'anva_add_theme_support' );
		add_action( 'after_setup_theme', 'anva_require_theme_supports', 12 );
		add_action( 'after_setup_theme', 'anva_register_footer_sidebar_locations' );
		add_action( 'init', 'anva_register_menus' );
		add_action( 'wp_before_admin_bar_render', 'anva_admin_menu_bar', 100 );

		/**
		 * Customizer.
		 */
		add_action( 'wp_loaded', 'anva_customizer_preview' );
		add_action( 'customize_register', 'anva_customizer_init' );
		add_action( 'customize_register', 'anva_customizer_register_blog' );
		add_action( 'customize_controls_print_styles', 'anva_customizer_styles' );
		add_action( 'customize_controls_enqueue_scripts', 'anva_customizer_scripts' );
		add_action( 'customize_preview_init', 'anva_customize_preview_enqueue_scripts' );

		/**
		 * Admin Hooks.
		 */
		if ( is_admin() ) {
			add_action( 'after_setup_theme', 'anva_plugins' );
			add_action( 'after_setup_theme', 'anva_envato_updates' );
			add_action( 'after_setup_theme', 'anva_admin_menu_init', 1001 );
			add_action( 'init', 'anva_admin_init', 1 );
			add_action( 'admin_init', 'anva_add_meta_boxes_default' );
			add_action( 'admin_init', 'anva_add_sanitization' );
			add_action( 'admin_init', array( $this, 'update_version' ) );
			add_action( 'admin_enqueue_scripts', 'anva_admin_assets', 20 );
			add_action( 'admin_notices', 'anva_admin_theme_activate' );

			/**
			 * Page options hooks.
			 */
			add_action( 'anva_page_options_top', 'anva_admin_check_settings' );
			add_action( 'anva_page_options_before', 'anva_add_settings_flash' );
			add_action( 'anva_page_options_after_fields', 'anva_admin_footer_credits' );
			add_action( 'anva_page_options_after_fields', 'anva_admin_footer_links' );
			add_action( 'anva_page_options_actions', 'anva_admin_settings_last_save' );
			add_action( 'anva_page_options_actions', 'anva_admin_settings_changed' );
		}

		/**
		 * Front-End Hooks.
		 */
		if ( ! is_admin() ) {

			/**
			 * AJAX hooks.
			 */
			add_action( 'wp_ajax_anva_blog_posts_filter', 'anva_blog_posts_filter' );
			add_action( 'wp_ajax_anva_ajax_search', 'anva_ajax_search' );
			add_action( 'wp_ajax_nopriv_anva_blog_posts_filter', 'anva_blog_posts_filter' );
			add_action( 'wp_ajax_nopriv_anva_ajax_search', 'anva_ajax_search' );

			/**
			 * WordPress Default Hooks.
			 */
			add_filter( 'body_class', 'anva_body_class' );
			add_filter( 'body_class', 'anva_browser_class' );
			add_filter( 'post_class', 'anva_post_class' );
			add_filter( 'oembed_result', 'anva_oembed', 10, 3 );
			add_filter( 'embed_oembed_html', 'anva_oembed', 10, 3 );
			add_filter( 'wp_audio_shortcode', 'anva_audio_shortcode' );

			/**
			 * Content.
			 */
			add_filter( 'anva_the_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
			add_filter( 'anva_the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
			add_filter( 'anva_the_content', 'anva_footer_copyright_helpers' );
			add_filter( 'anva_the_content', 'anva_do_icon' );
			add_filter( 'anva_the_content', 'wptexturize' );
			add_filter( 'anva_the_content', 'wpautop' );
			add_filter( 'anva_the_content', 'shortcode_unautop' );
			add_filter( 'anva_the_content', 'do_shortcode' );
			add_filter( 'the_content_more_link', 'anva_read_more_link', 10, 2 );
			add_filter( 'the_password_form', 'anva_password_form' );
			add_filter( 'widget_text', 'anva_footer_copyright_helpers' );
			add_filter( 'widget_text', 'anva_do_icon' );
			add_filter( 'anva_js_locals', 'anva_get_media_queries' );
			add_filter( 'wp_page_menu_args', 'anva_page_menu_args' );
			add_filter( 'wp_link_pages_args', 'anva_link_pages_args' );
			add_filter( 'wp_link_pages_link', 'anva_link_pages_link', 10, 2 );
			add_filter( 'walker_nav_menu_start_el', 'anva_nav_menu_start_el', 10, 4 );
			add_filter( 'nav_menu_css_class', 'anva_nav_menu_css_class', 10, 4 );
			add_filter( 'nav_menu_item_id', 'anva_nav_menu_item_id', 10, 4 );
			add_filter( 'wp_head', 'anva_wp_title_compat', 5 );
			add_action( 'after_setup_theme', 'anva_content_width', 0 );
			add_action( 'after_setup_theme', 'anva_add_attributes' );
			add_action( 'after_setup_theme', 'anva_add_elements' );
			add_action( 'init', 'anva_contact_send_email' );
			add_action( 'wp', 'anva_setup_author' );
			add_action( 'wp_head', 'anva_head_apple_touch_icon' );
			add_action( 'wp_head', 'anva_head_viewport', 1 );

			/**
			 * Post formats.
			 */
			add_filter( 'the_content', 'anva_content_format_gallery', 7 );
			add_filter( 'the_content', 'anva_content_format_audio', 7 );
			add_filter( 'the_content', 'anva_content_format_video', 7 );
			add_filter( 'the_content', 'anva_content_format_quote', 7 );
			add_filter( 'the_content', 'anva_content_format_link', 7 );

			/**
			 * Header.
			 */
			add_action( 'anva_before', 'anva_side_panel_default' );
			add_action( 'anva_header_above', 'anva_breaking_news_default' );
			add_action( 'anva_header_above', 'anva_top_bar_default' );
			add_action( 'anva_header_above', 'anva_sidebar_above_header' );
			add_action( 'anva_header', 'anva_header_default' );
			add_action( 'anva_header_logo', 'anva_header_logo_default' );
			add_action( 'anva_header_extras', 'anva_header_extras_default' );
			add_action( 'anva_header_primary_menu', 'anva_header_primary_menu_default' );
			add_action( 'anva_header_primary_menu_addon', 'anva_header_primary_menu_addon_default' );

			/**
			 * Featured content.
			 */
			add_action( 'anva_featured_before', 'anva_featured_before_default' );
			add_action( 'anva_featured', 'anva_featured_default' );
			add_action( 'anva_featured_after', 'anva_featured_after_default' );

			/**
			 * Main content
			 */
			add_action( 'anva_post_meta', 'anva_post_meta_default' );
			add_action( 'anva_post_content', 'anva_post_content_default' );
			add_action( 'anva_post_comments', 'anva_post_comments_default' );
			add_action( 'anva_comment_pagination_before', 'anva_comment_pagination' );
			add_action( 'anva_comment_pagination_after', 'anva_comment_pagination' );
			add_action( 'anva_post_footer', 'anva_post_terms_default' );
			add_action( 'anva_post_footer', 'anva_post_share_default' );
			add_action( 'anva_post_single_below', 'anva_post_nav_default' );
			add_action( 'anva_post_single_below', 'anva_post_author_default' );
			add_action( 'anva_post_single_below', 'anva_post_related_default' );
			add_action( 'anva_post_single_below', 'anva_post_more_stories_default' );
			add_action( 'anva_content_before', 'anva_breadcrumbs_outside_default' );
			add_action( 'anva_content_before', 'anva_page_title_default' );
			add_action( 'anva_above_layout', 'anva_sidebar_above_content' );
			add_action( 'anva_above_layout', 'anva_above_layout_default' );
			add_action( 'anva_post_type_navigation', 'anva_post_type_navigation_default' );
			add_action( 'anva_breadcrumbs', 'anva_breadcrumbs_default' );
			add_action( 'anva_content_builder', 'anva_display_elements' );
			add_action( 'anva_contact_form', 'anva_contact_form_default' );
			add_action( 'anva_content_after', 'anva_post_reading_bar', 20 );

			/**
			 * Sidebars.
			 */
			add_action( 'anva_sidebar_before', 'anva_sidebar_before_default' );
			add_action( 'anva_sidebar_after', 'anva_sidebar_after_default' );
			add_action( 'anva_sidebars', 'anva_sidebars_default' );
			add_action( 'anva_below_layout', 'anva_below_layout_default' );
			add_action( 'anva_below_layout', 'anva_sidebar_below_content' );

			/**
			 * Footer.
			 */
			add_action( 'anva_footer_content', 'anva_footer_content_default' );
			add_action( 'anva_footer_copyrights', 'anva_footer_copyrights_default' );
			add_action( 'anva_footer_below', 'anva_sidebar_below_footer' );
			add_action( 'anva_after', 'anva_debug' );

			/**
			 * Sliders.
			 */
			add_action( 'anva_slider_standard', 'anva_slider_standard_default', 9, 2 );
			add_action( 'anva_slider_owl', 'anva_slider_owl_default', 9, 2 );
			add_action( 'anva_slider_nivo', 'anva_slider_nivo_default', 9, 2 );
			add_action( 'anva_slider_bootstrap', 'anva_slider_bootstrap_default', 9, 2 );
			add_action( 'anva_slider_swiper', 'anva_slider_swiper_default', 9, 2 );
			add_action( 'anva_slider_camera', 'anva_slider_camera_default', 9, 2 );

		} // End if().
	}

	/**
	 * Initialize API helpers.
	 *
	 * @since 1.0.0
	 */
	public function set_api() {
		/**
		 * Before api initialization not hooked
		 * by default.
		 */
		do_action( 'anva_init_api_before' );

		/**
		 * Hooked.
		 *
		 * @see anva_init_api_helpers
		 */
		do_action( 'anva_init_api' );
	}


	/**
	 * Get framework name.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function get_name() {
		return self::$name;
	}

	/**
	 * Get framework version.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function get_version() {
		return self::$version;
	}

	/**
	 * Update framework and theme versions.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public static function update_version() {

		// Get option name.
		$option_id = anva_get_option_name();

		// Normalize versions to 3 parts.
		self::$theme_version = anva_normalize_version( anva_get_theme( 'version' ) );
		self::$version = anva_normalize_version( self::$version );

		// Set theme version id to saved to DB.
		self::$theme_version_id = $option_id . '_version';

		// Get versions.
		$framework_db_version = anva_normalize_version( get_option( self::$version_id, false ) );
		$theme_db_version = anva_normalize_version( get_option( self::$theme_version_id, false ) );

		// Update framework version if need it.
		if ( version_compare( self::$version, $framework_db_version, '>' ) ) {
			update_option( self::$version_id, self::$version );
		}

		// Update theme version if need it.
		if ( version_compare( self::$theme_version, $theme_db_version, '>' ) ) {
			update_option( self::$theme_version_id, self::$theme_version );
		}
	}

	/**
	 * Get debug.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public static function get_debug() {
		// Check if EP_DEBUG is defined and set to true.
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			return true;
		}

		if ( self::$debug ) {
			return true;
		}

		return false;
	}
}
