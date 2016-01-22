<?php
/*
Plugin Name: Options Framework Backup
Plugin URI:
Description: Backup your "Theme Options" to a downloadable text file.
Version: 1.0
Author: Kathy Darling
Author URI: http://kathyisawesome.com
Requires at least: 3.5.1
Tested up to: 3.5.1

Plugin version of the Options Framework Fork by Gilles Vauvarin

This code is a plugin version of the Options Framework Fork by Gilles Vauvarinfork
which itself borrows heavily from the WooThemes Framework admin-backup.php file.

Copyright: © 2012 Kathy Darling.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Don't load directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'OptionsFramework_Backup' ) ) :
class OptionsFramework_Backup {

	/**
	 * Admin page.
	 */
	private $admin_page;

	/**
	 * Current slug of the page.
	 */
	private $token = '';

	/**
	 * Default option name from DB.
	 */
	private $name = '';

	/**
	 * Constructor. Setup settings.
	 */
	function __construct() {

		// Get default option name
		$option_name = anva_get_option_name();

		// Setup properties
		$this->admin_page = '';
		$this->token = $option_name . '_backup';
		$this->name = $option_name;
	}

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	function init () {
		if ( is_admin() ) {
			// Register the admin screen.
			add_action( 'admin_menu', array( $this, 'register_admin_screen' ), 20 );
		}
	}

	/**
	 * Register the admin screen within WordPress.
	 *
	 * @since 1.0.0
	 */
	function register_admin_screen () {

		$menu = apply_filters( 'optionsframework_backup_menu', array(
			'page_title' 	=> __( 'Backup Options', 'anva' ),
			'menu_title' 	=> __( 'Backup Options', 'anva' ),
			'capability' 	=> 'manage_options',
			'slug' 				=> $this->token,
			'screen' 			=> array( $this, 'admin_screen' )
		));

		$this->admin_page = add_theme_page(
			$menu['page_title'],
			$menu['menu_title'],
			$menu['capability'],
			$menu['slug'],
			$menu['screen']
		);

		// Adds actions to hook in the required css and javascript
		add_action( "admin_print_styles-$this->admin_page", array( $this, 'optionsframework_load_adminstyles' ) );

		// Admin screen logic.
		add_action( 'load-' . $this->admin_page, array( $this, 'admin_screen_logic' ) );

		// Add contextual help.
		add_action( 'contextual_help', array( $this, 'admin_screen_help' ), 10, 3 );

		add_action( 'admin_notices', array( $this, 'admin_notices' ), 10 );

	}

	/**
	 * Load the CSS
	 *
	 * @since 1.0.0
	 */
	function optionsframework_load_adminstyles() {
		wp_enqueue_style( 'optionsframework', anva_get_core_uri() . '/assets/css/admin/options.css', array(), Options_Framework::VERSION );
	}

	/**
	 * admin_screen()
	 *
	 * @since 1.0.0
	 */
	function admin_screen () {
	?>
	<div id="optionsframework-wrap" class="wrap">
		<h2><?php _e( 'Import / Export' ); ?></h2>
		
		<div id="optionsframework-metabox" class="metabox-holder">
		<?php do_action( 'optionsframework_importer_before' ); ?>
		<div id="optionsframework">
			<div class="options-settings import-export-settings">
				
				<div class="column-1">
				<div id="import-notice" class="section-info">
					<p><?php printf( __( 'Please note that this backup manager backs up only your theme settings and not your content. To backup your content, please use the %sWordPress Export Tool%s.', 'anva' ), '<a href="' . esc_url( admin_url( 'export.php' ) ) . '">', '</a>' ); ?></p>
				</div><!-- #import-notice (end) -->

				<div class="postbox inner-group">
					<h3><?php _e( 'Import Settings', 'anva' ); ?></h3>
					<div class="section-description">
						 <?php _e( 'To get started, upload your backup file to import from below.', 'anva' ); ?>
					</div>
					<div class="section section-import">
						<h4 class="heading"><?php printf( __( 'Upload File: (Maximum Size: %s)' ), ini_get( 'post_max_size' ) ); ?></h4>
						<div class="option option-import">
							<div class="controls">
								<form enctype="multipart/form-data" method="post" action="<?php echo admin_url( 'admin.php?page=' . $this->token ); ?>">
									<?php wp_nonce_field( 'OptionsFramework-backup-import' ); ?>
									<input type="file" id="OptionsFramework-import-file" name="OptionsFramework-import-file" class="anva-input-file" />
									<input type="hidden" name="OptionsFramework-backup-import" value="1" />
									<input type="submit" class="button" value="<?php _e( 'Upload File and Import', 'anva' ); ?>" />
								</form>
							</div>
							<div class="explain">
								<?php _e( 'If you have settings in a backup file on your computer, the Import / Export system can import those into this site.', 'anva' ); ?>
							</div>
						</div><!-- .import (end) -->
					</div><!-- .section -->
				</div><!-- .iinner-group (end) -->
				
				<div class="postbox inner-group">
					<h3><?php _e( 'Export Settings', 'anva' ); ?></h3>
					<div class="section-description">
						<?php _e( 'When you click the button below, the Import / Export system will create a text file for you to save to your computer.', 'anva' ); ?>
					</div>
					<div class="section section-export">
						<h4 class="heading"><?php _e( 'Export File:', 'anva' ); ?></h4>
						<div class="option option-export">
							<div class="controls">
								<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=' . $this->token ) ); ?>">
									<?php wp_nonce_field( 'OptionsFramework-backup-export' ); ?>
									<input type="hidden" name="OptionsFramework-backup-export" value="1" />
									<input type="submit" class="button" value="<?php _e( 'Download Export File' , 'anva' ); ?>" />
								</form>
							</div>
							<div class="explain">
								<?php printf( __( 'This text file can be used to restore your settings here on "%s", or to easily setup another website with the same settings".', 'anva' ), get_bloginfo( 'name' ) ); ?>
							</div>
						</div><!-- .export (end) -->
					</div><!-- .section (end) -->
				</div><!-- .inner-group (end) -->
				<?php do_action( 'optionsframework_after_fields' ); ?>
				</div><!-- .column-1 (end) -->

				<div class="column-2">
					
				</div><!-- .column-2 (end) -->

				<div class="clear"></div>

			</div><!-- .import-export-settings (end) -->
		</div><!-- #optionsframework (end) -->
		<?php do_action( 'optionsframework_importer_after' ); ?>
		</div><!-- #optionsframework-metabox (nd) -->
	</div><!--/.wrap-->
	<?php
	}

	/**
	 * Add contextual help to the admin screen.
	 *
	 * @since 1.0.0
	 */
	function admin_screen_help ( $contextual_help, $screen_id, $screen ) {

		if ( $this->admin_page == $screen->id ) {

		$contextual_help =
			'<h3>' . sprintf( __( 'Welcome to the %s Backup Manager.', 'anva' ), ucfirst ( $this->name ) ) . '</h3>' .
			'<p>' . __( 'Here are a few notes on using this screen.', 'anva' ) . '</p>' .
			'<p>' . __( 'The backup manager allows you to backup or restore your "Theme Options" and other settings to or from a text file.', 'anva' ) . '</p>' .
			'<p>' . __( 'To create a backup, simply select the setting type you\'d like to backup (or "All Settings") and hit the "Download Export File" button.', 'anva' ) . '</p>' .
			'<p>' . __( 'To restore your settings from a backup, browse your computer for the file (under the "Import Settings" heading) and hit the "Upload File and Import" button. This will restore only the settings that have changed since the backup.', 'anva' ) . '</p>' .
			'<p><strong>' . sprintf( __( 'Please note that only valid backup files generated through the %s Backup Manager should be imported.', 'anva' ), ucfirst ( $this->name ) ) . '</strong></p>' .
			'<p><strong>' . __( 'Looking for assistance?', 'anva' ) . '</strong></p>' .
			'<p>' . sprintf( __( 'Please post your query on the %sThemeForest Support Item%s where we will do our best to assist you further.', 'anva' ), '<a href="' . esc_url( 'http://www.themeforest.com/user/oidoperfecto/portfolio' ) . '" target="_blank">', '</a>' ) . '</p>';
		}

		return $contextual_help;
	}

	/**
	 * Display admin notices when performing backup/restore.
	 *
	 * @since 1.0.0
	 */
	function admin_notices () {

		if ( ! isset( $_GET['page'] ) || ( $_GET['page'] != $this->token ) ) {
			return;
		}

		if ( isset( $_GET['error'] ) && $_GET['error'] == 'true' ) {
			echo '<div id="message" class="error"><p>' . __( 'There was a problem importing your settings. Please Try again.' ) . '</p></div>';

		} else if ( isset( $_GET['error-export'] ) && $_GET['error-export'] == 'true' ) {
			echo '<div id="message" class="error"><p>' . __( 'There was a problem exporting your settings. Please Try again.' ) . '</p></div>';

		} else if ( isset( $_GET['invalid'] ) && $_GET['invalid'] == 'true' ) {
			echo '<div id="message" class="error"><p>' . __( 'The import file you\'ve provided is invalid. Please try again.' ) . '</p></div>';

		} else if ( isset( $_GET['imported'] ) && $_GET['imported'] == 'true' ) {
			echo '<div id="message" class="updated"><p>' . sprintf( __( 'Settings successfully imported. | Return to %sTheme Options%s', 'options-framework-importer' ), '<a href="' . admin_url( 'admin.php?page=options-framework' ) . '">', '</a>' ) . '</p></div>';
		}
	}

	/**
	 * The processing code to generate the backup or restore from a previous backup.
	 *
	 * @since 1.0.0
	 */
	function admin_screen_logic () {
		if ( ! isset( $_POST['OptionsFramework-backup-export'] ) && isset( $_POST['OptionsFramework-backup-import'] ) && ( $_POST['OptionsFramework-backup-import'] == true ) ) {
			$this->import();
		}

		if ( ! isset( $_POST['OptionsFramework-backup-import'] ) && isset( $_POST['OptionsFramework-backup-export'] ) && ( $_POST['OptionsFramework-backup-export'] == true ) ) {
			$this->export();
		}
	}

	/**
	 * Import settings from a backup file.
	 *
	 * @since 1.0.0
	 */
	function import() {
		check_admin_referer( 'OptionsFramework-backup-import' ); // Security check.

		if ( ! isset( $_FILES['OptionsFramework-import-file'] ) ) { return; } // We can't import the settings without a settings file.

		// Extract file contents
		$upload = file_get_contents( $_FILES['OptionsFramework-import-file']['tmp_name'] );

		// Decode base64
		$data = base64_decode( $upload );

		// Decode the JSON from the uploaded file
		$datafile = json_decode( $data, true );

		// Check for errors
		if ( ! $datafile || $_FILES['OptionsFramework-import-file']['error'] ) {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&error=true' ) );
			exit;
		}

		// Make sure this is a valid backup file.
		if ( ! isset( $datafile['OptionsFramework-backup-validator'] ) ) {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&invalid=true' ) );
			exit;
		} else {
			// Now that we've checked it.
			// We don't need the field anymore.
			unset( $datafile['OptionsFramework-backup-validator'] );
		}

		// Get the theme name from database.
		$option_name = $this->name;

		// Update the settings in database
		if ( update_option( $option_name, $datafile ) ) {

			// Redirect, add success flag to the URI
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&imported=true' ) );
			exit;

		} else {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&error=true' ) );
			exit;
		}
	}

	/**
	 * Export settings to a backup file.
	 *
	 * @return void
	 */
	function export() {
		global $wpdb;
		
		check_admin_referer( 'OptionsFramework-backup-export' ); // Security check.

		// Get option name
		$option_name = $this->name;
		$database_options = get_option( $option_name );

		// Error trapping for the export.
		if ( $database_options == '' ) {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&error-export=true' ) );
			return;
		}

		if ( ! $database_options ) {
			return;
		}

		// Add our custom marker, to ensure only valid files are imported successfully.
		$database_options['OptionsFramework-backup-validator'] = date( 'Y-m-d h:i:s' );

		// Generate the export file to json.
		$json = json_encode( (array)$database_options );

		// Encode json file with base64 to protect the data
		$hash = base64_encode( $json );

		// Get the file
		$output = $hash;

		header( 'Content-Description: File Transfer' );
		header( 'Cache-Control: public, must-revalidate' );
		header( 'Pragma: hack' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Disposition: attachment; filename="' . $option_name . '-' . $this->token . '-' . date( 'Y-m-d-His' ) . '.json"' );
		header( 'Content-Length: ' . strlen( $output ) );
		echo $output;
		exit;

	}
}
endif;

/**
 * Create $anva_backup Object.
 *
 * @since 1.0.0
 * @uses OptionsFramework_Backup
 */
$anva_backup = new OptionsFramework_Backup();
$anva_backup->init();
