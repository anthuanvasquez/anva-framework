<?php

/**
 * Add Custom Login Styles.
 *
 * @since   	1.0.0
 *
 * @author    Anthuan Vásquez <me@anthuanvasquez.net>
 * @copyright Copyright (c) 2015, Anthuan Vásquez
 *
 * @link      http://anthuanvasquez.net/
 */
class Anva_Login_Styles
{
	/**
	 * A single instance of this class.
	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance()
	{
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor Hook everything in.
	 */
	public function __construct()
	{

		// Add print styles in login head
		if ( ! has_action( 'login_enqueue_scripts', 'wp_print_styles' ) ) {
			add_action( 'login_enqueue_scripts', 'wp_print_styles', 11 );
		}

		add_action( 'login_enqueue_scripts', array($this, 'stylesheet') );
		add_filter( 'login_headerurl', array($this, 'logo_url') );
		add_action( 'login_footer', array($this, 'footer') );
	}

	/**
	 * Custom login stylesheet.
	 */
	public function stylesheet()
	{
		wp_enqueue_style( 'anva-login', get_template_directory_uri().'/assets/css/login.css', array(), ANVA_FRAMEWORK_VERSION, 'all' );
	}

	/**
	 * Change the logo url.
	 */
	public function logo_url()
	{
		return home_url( '/' );
	}

	/**
	 * Change the logo url title.
	 */
	public function logo_url_title()
	{
		return get_bloginfo( 'name' );
	}

	/**
	 * Add custom text in login footer page.
	 */
	public function footer()
	{
		$login_copyright = anva_get_option( 'login_copyright' );
		printf( '<div class="login-footer">%s</div>', $login_copyright );
	}
}

Anva_Login_Styles::instance();