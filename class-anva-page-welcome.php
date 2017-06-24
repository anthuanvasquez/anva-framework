<?php
/**
 * Welcome Screen
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */
class Anva_Page_Welcome {

	/**
	 * A single instance of this class.
	 *
	 * @var   Object
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Welcome screen default id.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $id = 'anva';

	/**
	 * Transient id.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $transient = '_anva_welcome_screen_activation_redirect';

	/**
	 * Theme version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $version;

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->version = Anva::get_version();

		if ( isset( $_GET['activated'] ) && true == $_GET['activated'] ) {
			set_transient( $this->transient, true, 30 );
		}

		add_action( 'admin_init', array( $this, 'screen_do_activation_redirect' ) );
		add_action( 'admin_menu', array( $this, 'screen_pages' ) );
		add_action( 'admin_head', array( $this, 'screen_remove_menus' ) );
	}

	public function screen_do_activation_redirect() {
		// Bail if no activation redirect.
		if ( ! get_transient( $this->transient ) ) {
			return;
		}

		// Delete the redirect transient.
		delete_transient( $this->transient );

		// Bail if activating from network, or bulk.
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// Redirect to bbPress about page.
		wp_safe_redirect(
			add_query_arg(
				array( 'page' => $this->id ),
				admin_url( 'index.php' )
			)
		);

	}

	public function screen_pages() {
		add_dashboard_page(
			__( 'Welcome To Anva', 'anva' ),
			__( 'Welcome To Anva', 'anva' ),
			'read',
			$this->id,
			array( $this, 'welcome_screen_display' )
		);
	}

	public function welcome_screen_display() {
		?>
		<div class="wrap about-wrap">
			<h1><?php esc_html_e( 'Welcome to Anva!', 'anva' ); ?></h1>

			<div class="about-text">
				<p><?php esc_html_e( 'Anva is now installed and ready to use!. Get ready to build something beautiful. Import Demos and install the plugins. Read below for additional information. We hope you enjoy it! The Anva Team!', 'anva' ); ?></p>
			</div>

			<div class="anva-logo">
				<span class="anva-version">
					<?php printf( __( 'Version %s', 'anva' ), $this->version ); ?>
				</span>
			</div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab" href="#theme-demos" >
					<?php esc_html_e( 'Install Demos', 'anva' ); ?>
				</a>
				<a class="nav-tab" href="#theme-support">
					<?php esc_html_e( 'Support', 'anva' ); ?>
				</a>
				<a class="nav-tab" href="#theme-plugins">
					<?php esc_html_e( 'Plugins', 'anva' ); ?>
				</a>
			</h2>

			<div id="theme-demos" class="feature-section theme-demos">
				Theme demos
			</div>

			<div id="theme-support" class="feature-section theme-support">
				Theme support
			</div>

			<div id="theme-plugins" class="feature-section theme-browser theme-plugins">
				<div class="theme">
					<div class="theme-wrapper">
						<div class="theme-screenshot">
							<img src="<?php echo ANVA_FRAMEWORK_ADMIN_IMG . 'fusion_core.png'; ?>" alt="Anva Post Types" />
							<div class="plugin-info">
								<span class="plugin-version"></span>
								<a class="plugin-link" href="#" target="_blank">
									Anva Post Types
								</a>
							</div>
						</div>
						<h3 class="theme-name">Anva Post Types</h3>
						<div class="theme-actions">
							<a href="#" class="button button-primary">Activate</a>
						</div>
						<div class="plugin-required">Required</div>
					</div>
				</div>
			</div>

			<div class="anva-thanks">
				<p class="description">
					<?php esc_html_e( 'Thank you for choosing Anva. We are honored and are fully dedicated to making your experience perfect', 'anva' ); ?>
				</p>
			</div>
		</div>
		<?php
	}

	public function screen_remove_menus() {
		remove_submenu_page( 'index.php', $this->id );
	}
}
