<?php

if ( ! class_exists( 'Anva_Options_Import_Export' ) ) :

/**
 * Create the options page panel.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Options_Page
{
	/**
	 * A single instance of this class.
 	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = NULL;

	/**
	 * Page hook for the options screen.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $options_screen = NULL;

	/**
	 * If sanitization has run yet or not when saving
	 * options.
	 *
	 * @since 1.0.0
	 * @var   bool
	 */
	private $sanitized = false;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Hook in the scripts and styles.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct()
	{
		if ( is_admin() && current_user_can( anva_admin_module_cap( 'options' ) ) ) {

			// Gets options to load
			$options = anva_get_options();

			// Checks if options are available
			if ( $options ) {

				// Add the options page and menu item
				add_action( 'admin_menu', array( $this, 'add_custom_options_page' ) );

				// Add the required scripts and styles
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), 10 );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );

				// Settings need to be registered after admin_init
				add_action( 'admin_init', array( $this, 'settings_init' ) );

				// Adds options menu to the admin bar
				add_action( 'wp_before_admin_bar_render', array( $this, 'admin_bar' ) );

			}
		}
	}

	/**
	 * Registers the settings.
	 *
	 * @global $pagenow
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function settings_init()
	{
		global $pagenow;

		// Get the option name
		$name = anva_get_option_name();

		// Registers the settings fields and callback
		register_setting( 'anva_options_page_settings', $name, array( $this, 'validate_options' ) );
	}

	/**
	 * Define menu options.
	 *
	 * @since  1.0.0
	 * @return $menu
	 */
	public static function menu_settings()
	{
		// Get option name
		$name = anva_get_option_name();

		// Set default menu settings
		$menu = array(
			'mode' 			=> 'submenu',
			'page_title' 	=> __( 'Theme Options', 'anva' ),
			'menu_title' 	=> __( 'Theme Options', 'anva' ),
			'capability' 	=> anva_admin_module_cap( 'options' ), // Role: Administrator
			'menu_slug'  	=> $name,
			'parent_slug' 	=> 'themes.php',
			'icon_url' 		=> 'dashicons-admin-generic',
			'position' 		=> '61'
		);

		return apply_filters( 'anva_options_page_menu', $menu );
	}

	/**
	 * Add a subpage to the appearance menu.
	 *
	 * @since 1.0.0
	 */
	public function add_custom_options_page()
	{
		$menu = $this->menu_settings();

		$this->options_screen = add_theme_page(
			$menu['page_title'],
			$menu['menu_title'],
			$menu['capability'],
			$menu['menu_slug'],
			array( $this, 'options_page' )
		);
	}

	/**
	 * Loads the required stylesheets.
	 *
	 * @since  1.0.0
	 * @param  object $hook
	 * @return void
	 */
	public function enqueue_admin_styles( $hook )
	{
		if ( $this->options_screen != $hook )
			return;

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'codemirror', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/codemirror.css', array(), '5.13.2' );
		wp_enqueue_style( 'codemirror_theme', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/theme/mdn-like.css', array(), '5.13.2' );
		wp_enqueue_style( 'animsition', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'animsition.min.css', array(), '4.0.1' );
		wp_enqueue_style( 'jquery_ui_custom', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-custom.min.css', array(), '1.11.4' );
		wp_enqueue_style( 'jquery_slider_pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.css', array(),  '1.11.3' );
		wp_enqueue_style( 'anva_options', ANVA_FRAMEWORK_ADMIN_CSS . 'options-page.min.css', array(), ANVA_FRAMEWORK_VERSION );

	}

	/**
	 * Loads the required javascript.
	 *
	 * @since  1.0.0
	 * @param  object $hook
	 * @return void
	 */
	public function enqueue_admin_scripts( $hook )
	{
		if ( $this->options_screen != $hook )
			return;

		// Enqueue custom option panel JS
		wp_enqueue_script( 'codemirror', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/codemirror.js', array( 'jquery' ), '5.13.2', true );
		wp_enqueue_script( 'codemirror_mode_css', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/mode/css/css.js', array( 'codemirror' ), '5.13.2', true );
		wp_enqueue_script( 'codemirror_mode_js', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/mode/javascript/javascript.js', array( 'codemirror' ), '5.13.2', true );
		wp_enqueue_script( 'jquery-animsition', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'animsition.min.js', array( 'jquery' ), '4.0.1', true );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-slider-pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.js', array( 'jquery' ), '1.7.2', true );
		wp_enqueue_script( 'anva_options', ANVA_FRAMEWORK_ADMIN_JS . 'options-page.min.js', array( 'jquery', 'wp-color-picker' ), ANVA_FRAMEWORK_VERSION, true );
		wp_localize_script( 'anva_options', 'anvaJs', anva_get_admin_locals( 'js' ) );

		// Inline scripts from anva-options-interface.php
		add_action( 'admin_head', array( $this, 'admin_head' ) );
	}

	/**
	 * Hook to add custom scripts.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function admin_head()
	{
		do_action( 'anva_options_page_custom_scripts' );
	}

	/**
	 * Builds out the options panel.
	 *
	 * If we were using the Settings API as it was intended we would use
	 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
	 * we'll call our own custom fields. See class-anva-options-interface.php
	 * for specifics on how each individual field is generated.
	 *
	 * Nonces are provided using the settings_fields().
	 *
	 * @since  1.0.0
	 * @return void
	 */
	 public function options_page()
	 {
	 ?>
		<div id="anva-framework-wrap" class="wrap">

			<?php
				$menu = $this->menu_settings();
				$options = anva_get_options();

			 	printf( '<h2>%1$s <span>%3$s<em>%2$s</em></span></h2>', esc_html( $menu['page_title'] ), anva_get_theme( 'version' ), __( 'Version', 'anva' ) );
			 ?>

			<?php do_action( 'anva_options_page_top' ); ?>

			<?php settings_errors( 'anva-options-page-errors', false, false ); ?>

			<h2 class="nav-tab-wrapper">
				<?php echo anva_get_options_tabs( $options ); ?>
			</h2>

			<?php do_action( 'anva_options_page_before' ); ?>

			<div id="anva-framework-metabox" class="metabox-holder">
				<div id="anva-framework" class="anva-framework animsition">
					<form class="anva-framework-settings options-settings" action="options.php" method="post">
						<div class="columns-1">
							<input type="hidden" id="option_name" value="<?php echo anva_get_option_name(); ?>" >
							<?php
								settings_fields( 'anva_options_page_settings' );

								// Settings
								$option_name = anva_get_option_name();
								$settings = get_option( $option_name );

								// Fields
								anva_get_options_fields( $option_name, $settings, $options );
							?>
							<?php do_action( 'anva_options_page_after_fields' ); ?>
						</div><!-- .columns-1 (end) -->
						<div class="columns-2">
							<div class="postbox-wrapper">
								<?php do_action( 'anva_options_page_side_before' ); ?>
								<div id="anva-framework-submit" class="postbox">
									<h3><span><?php esc_html_e( 'Actions', 'anva' );?></span></h3>
									<div class="inside">
										<?php anva_admin_settings_log(); ?>
										<div class="actions">
											<input type="submit" class="button button-primary update-button" name="update" value="<?php esc_attr_e( 'Save Options', 'anva' ); ?>" />
											<span class="spinner"></span>
											<input type="submit" class="button button-secondary reset-button" value="<?php esc_attr_e( 'Restore Defaults', 'anva' ); ?>" />
											<div class="clear"></div>
										</div>
									</div>
								</div>
								<?php do_action( 'anva_options_page_side_after' ); ?>
							</div>
						</div><!-- .columns-2 (end) -->
						<div class="clear"></div>
					</form>
				</div>
			</div><!-- #anva-framework-metabox (end) -->
			<?php do_action( 'anva_options_page_after' ); ?>
		</div><!-- #anva-framework-wrap (end) -->
	<?php
	}

	/**
	 * Validate Options.
	 *
	 * This runs after the submit/reset button has been clicked and
	 * validates the inputs.
	 *
	 * @uses   $_POST['reset'] to restore default options
	 *
	 * @since  1.0.0
	 * @param  array $input
	 * @return array $clean
	 */
	public function validate_options( $input )
	{
		// Need it to create log for the changed settings
		$option_name = anva_get_option_name();

		/*
		 * Restore Defaults
		 *
		 * In the event that the user clicked the "Restore Defaults"
		 * button, the options defined in the theme's options.php
		 * file will be added to the option for the active theme.
		 *
		 */
		if ( isset( $_POST['reset'] ) ) {

			// Delete option log
			delete_option( $option_name . '_log' );

			// Add notice
			$this->save_options_notice( 'restore_defaults', __( 'Default options restored.', 'anva' ) );

			return $this->get_default_values();
		}

		/*
		 * Update Settings
		 *
		 * This used to check for $_POST['update'], but has been updated
		 * to be compatible with the theme customizer introduced in WordPress 3.4
		 */

		$clean = array();

		$options = anva_get_options();

		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[ $id ] ) ) {
				$input[ $id ] = false;
			}

			// Set switch to false if it wasn't sent in the $_POST
			if ( 'switch' == $option['type'] && ! isset( $input[ $id ] ) ) {
				$input[ $id ] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[ $id ] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[ $id ][ $key ] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'anva_sanitize_' . $option['type'] ) ) {
				$clean[ $id ] = apply_filters( 'anva_sanitize_' . $option['type'], $input[ $id ], $option );
			}
		}

		// Add update message for page re-fresh
		// Avoid duplicates
		if ( ! $this->sanitized ) {
			$this->save_options_notice( 'save_options', __( 'Options saved.', 'anva' ) );
		}

		// We know sanitization has happenned at
		// least once at this point
		// so set to true.
		$this->sanitized = true;

		// Hook to run after validation
		do_action( 'anva_options_page_after_validate', $clean );

		// Create or update the last changed settings
		update_option( $option_name . '_log', current_time( 'mysql' ) );

		return $clean;
	}

	/**
	 * Display message when options have been saved.
	 *
	 * @since  1.0.0
	 */
	public function save_options_notice( $id, $desc )
	{
		add_settings_error( 'anva-options-page-errors', $id, $desc, 'updated fade' );
	}

	/**
	 * Get the default values for all the theme options
	 *
	 * Get an array of all default values as set in
	 * options.php. The 'id','std' and 'type' keys need
	 * to be defined in the configuration array. In the
	 * event that these keys are not present the option
	 * will not be included in this function's output.
	 *
	 * @since  1.0.0
	 * @return array $output
	 *
	 */
	public function get_default_values()
	{
		$output = array();
		$config = anva_get_options();

		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
			if ( has_filter( 'anva_sanitize_' . $option['type'] ) ) {
				$output[$option['id']] = apply_filters( 'anva_sanitize_' . $option['type'], $option['std'], $option );
			}
		}

		return $output;
	}

	/**
	 * Add options menu item to admin bar.
	 *
	 * @global $wp_admin_bar
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_bar()
	{
		$menu = $this->menu_settings();

		global $wp_admin_bar;

		if ( 'menu' == $menu['mode'] ) {
			$href = admin_url( 'admin.php?page=' . $menu['menu_slug'] );
		} else {
			$href = admin_url( 'themes.php?page=' . $menu['menu_slug'] );
		}

		$args = array(
			'parent' => 'appearance',
			'id' => 'anva_theme_options',
			'title' => $menu['menu_title'],
			'href' => $href
		);

		$wp_admin_bar->add_menu( apply_filters( 'anva_options_page_admin_bar', $args ) );
	}

}

endif;
