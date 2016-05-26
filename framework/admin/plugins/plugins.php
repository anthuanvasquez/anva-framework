<?php

/**
 * Plugins.
 *
 * @since 1.0.0
 */
function anva_plugins() {

	if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
		include_once ANVA_FRAMEWORK_ADMIN . 'plugins/class-tgm-plugin-activation.php';
	}

	add_action( 'tgmpa_register', 'anva_register_required_plugins' );
}

/**
 * Register the required plugins for this theme.
 *
 * @since 1.0.0
 */
function anva_register_required_plugins() {

	// Required Plugins
	$plugins = array(
		array(
			'name'               => 'TGM Example Plugin', // The plugin name.
			'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'         => 'TGM New Media Plugin', // The plugin name.
			'slug'         => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
			'source'       => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
			'external_url' => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
		),
		array(
			'name'      => 'Adminbar Link Comments to Pending',
			'slug'      => 'adminbar-link-comments-to-pending',
			'source'    => 'https://github.com/jrfnl/WP-adminbar-comments-to-pending/archive/master.zip',
		),
		array(
			'name'      => 'BuddyPress',
			'slug'      => 'buddypress',
			'required'  => false,
		),
		array(
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
		),

	);

	$name = anva_get_option_name() . '_plugins';

	// Plugins Config
	$config = array(
		'id'             => 'anva',                  // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path'   => '',                      // Default absolute path to bundled plugins.
		'menu'           => $name, 		   			// Menu slug.
		'has_notices'    => true,                    // Show admin notices or not.
		'dismissable'    => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'    => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'   => false,                   // Automatically activate plugins after installation or not.
		'message'        => '',                      // Message to output right before the plugins table.
		'strings'        => array(
			'page_title' => __( 'Install Recommended Plugins', 'anva' ),
			'menu_title' => __( 'Theme Plugins', 'anva' ),
		),
	);

	$plugins = apply_filters( 'anva_tgm_plugins', $plugins );
	$config  = apply_filters( 'anva_tgm_config', $config );

	tgmpa( $plugins, $config );
}
