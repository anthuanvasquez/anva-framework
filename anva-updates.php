<?php

/**
 * Setup auto updates.
 *
 * @since 1.0.0
 */
function anva_envato_updates() {

	// Return early if not in the admin.
	if ( ! is_admin() ) {
		return;
	}

	global $_envato_updates;

	// Include update classes.
	if ( ! class_exists( 'Envato_Protected_API' ) ) {
		include_once( ANVA_FRAMEWORK_ADMIN . 'updates/class-envato-protected-api.php' );
	}

	if ( ! class_exists( 'Anva_Envato_Updates' ) ) {
		include_once( ANVA_FRAMEWORK_ADMIN . 'updates/class-anva-envato-updates.php' );
	}

	// Admin page.
	if ( is_admin() && current_user_can( anva_admin_module_cap( 'updates' ) ) ) {

		// Options to display on page.
		$update_options = array(
			'envato_info' => array(
				'name'			=> __( 'Configuration', 'anva' ),
				'id' 			=> 'envato_info',
				'type' 			=> 'info',
				'desc'			=> __( 'Although there is a backup option below, we recommend that you still always backup your theme files before running any automatic updates. Additionally, it\'s a good idea to never update any plugin or theme on a live website without first testing its compatibility with your specific WordPress site.', 'anva' ),
				'class'         => 'danger',
			),
			'username' 			=> array(
				'name'			=> __( 'Envato Username', 'anva' ),
				'id'			=> 'username',
				'desc'			=> __( 'Enter the username that you have purchased the theme with through ThemeForest.', 'anva' ),
				'type' 			=> 'text',
			),
			'api' 				=> array(
				'name'			=> __( 'Envato API Key', 'anva' ),
				'id'			=> 'api',
				'desc'			=> sprintf( __( 'Enter an %s key associated with your Envato username.', 'anva' ), sprintf( '<a href="' . esc_url( 'http://extras.envato.com/api/' ) . '" target="_blank">%s</a>', __( 'Envato API', 'anva' ) ) ),
				'type' 			=> 'password',
			),
			'backup' 			=> array(
				'name'			=> __( 'Backups', 'anva' ),
				'id'			=> 'backup',
				'desc'			=> __( 'Select if you\'d like a backup made of the previous theme version on your server before updating to the new version.', 'anva' ),
				'std'			=> 'yes',
				'type' 			=> 'select',
				'options'		=> array(
					'yes' 		=> __( 'Yes, make theme backups when updating', 'anva' ),
					'no' 		=> __( 'No, don\'t make theme backups', 'anva' ),
				),
			),
		);

		$update_options = apply_filters( 'anva_envato_options', $update_options );

		anva_add_option_section( 'advanced', 'updates', __( 'Envato Updates', 'anva' ), null, $update_options, false );

	}// End if().

	// Setup arguments for Anva_Envato_Updates class based on user-configured options.
	$settings = array(
		'username' => anva_get_option( 'username' ),
		'api'      => anva_get_option( 'api' ),
		'backup'   => anva_get_option( 'backup' ),
	);

	$username = '';
	$api_key  = '';
	$backup   = '';

	if ( isset( $settings['username'] ) ) {
		$username = $settings['username'];
	}

	if ( isset( $settings['api'] ) ) {
		$api_key = $settings['api'];
	}

	if ( isset( $settings['backup'] ) ) {
		$backup = $settings['backup'];
	}

	$args = array(
		'envato_username' => $username,
		'envato_api_key'  => $api_key,
		'backup'          => $backup,
	);

	$args = apply_filters( 'anva_envato_update_args', $args );

	// Run Envato Updates.
	$_envato_updates = new Anva_Envato_Updates( $args );

}
