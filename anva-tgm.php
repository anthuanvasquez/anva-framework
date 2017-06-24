<?php
/**
 * Register required plugins.
 *
 * @package AnvaFramework
 */

/**
 * Required and recommended plugins.
 *
 * @since 1.0.0
 */
function anva_plugins() {

	// Return early if not in the admin.
	if ( ! is_admin() ) {
		return;
	}

	if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
		include_once ANVA_FRAMEWORK_ADMIN . 'plugins/class-tgm-plugin-activation.php';
		add_action( 'tgmpa_register', 'anva_register_required_plugins' );
	}

}

/**
 * Register the required and recommended plugins for this theme.
 *
 * @since 1.0.0
 */
function anva_register_required_plugins() {

	// Get option name.
	$name = anva_get_option_name() . '_plugins';

	// Required Plugins.
	$plugins = array(
		array(
			'name'               => 'Anva Post Types',
			'slug'               => 'anva-post-types',
			'source'             => ANVA_FRAMEWORK_ADMIN . '/plugins/packages/anva-post-types.zip',
			'required'           => true,
			'version'            => '1.0.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'               => 'Anva Shortcodes Pack',
			'slug'               => 'anva-shortcodes-pack',
			'source'             => ANVA_FRAMEWORK_ADMIN . '/plugins/packages/anva-shortcodes-pack.zip',
			'required'           => true,
			'version'            => '1.0.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'               => 'Anva Widgets Pack',
			'slug'               => 'anva-widgets-pack',
			'source'             => ANVA_FRAMEWORK_ADMIN . '/plugins/packages/anva-widgets-pack.zip',
			'required'           => false,
			'version'            => '1.0.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
	);

	// Plugins Config.
	$config = array(
		'id'             => $name,    // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path'   => '',       // Default absolute path to bundled plugins.
		'menu'           => $name,    // Menu slug.
		'has_notices'    => true,     // Show admin notices or not.
		'dismissable'    => true,     // If false, a user cannot dismiss the nag message.
		'dismiss_msg'    => '',       // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'   => false,    // Automatically activate plugins after installation or not.
		'message'        => '',       // Message to output right before the plugins table.
		'strings'        => array(
			'page_title' => __( 'Install Recommended Plugins', 'anva' ),
			'menu_title' => __( 'Theme Plugins', 'anva' ),
		),
	);

	$plugins = apply_filters( 'anva_tgm_plugins', $plugins );
	$config  = apply_filters( 'anva_tgm_config', $config );

	tgmpa( $plugins, $config );
}
