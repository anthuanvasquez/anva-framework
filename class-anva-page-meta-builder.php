<?php

if ( ! class_exists( 'Anva_Page_Meta_Builder' ) ) :

/**
 * Anva Content Builder.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Page_Meta_Builder {

		/**
		 * ID for meta box and post field.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $id;

		/**
		 * Arguments for add_meta_box().
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    array
		 */
		private $args = array();

		/**
		 * Options array for page builder elements.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    array
		 */
		private $options = array();

		/**
		 * Settings from database.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    array
		 */
		private $settings = array();

		/**
		 * Constructor hook in meta box to start the process.
		 *
		 * @since 1.0.0
		 */
		public function __construct( $id, $args, $options ) {
			if ( is_admin() && current_user_can( anva_admin_module_cap( 'builder' ) ) ) {

				global $post;

				$this->id = $id;
				$this->options = $options;

				$defaults = array(
				'page'     => array( 'page' ),	// Can contain post, page, link, or custom post type's slug
				'context'  => 'normal',			// Normal, advanced, or side
				'priority' => 'high',// Priority
				);

				$this->args = wp_parse_args( $args, $defaults );

				// Hooks
				add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
				add_action( 'admin_head', array( $this, 'head' ) );
				add_action( 'admin_notices', array( $this, 'admin_notices' ), 10 );
				add_action( 'add_meta_boxes', array( $this, 'add' ) );
				add_action( 'save_post', array( $this, 'save' ) );
				add_action( 'wp_ajax_anva_builder_get_fields', array( $this, 'ajax_get_fields' ) );
				add_action( 'wp_ajax_nopriv_anva_builder_get_fields', array( $this, 'ajax_get_fields' ) );
			}
			}

		/**
		 * Enqueue scripts.
		 *
		 * @global $post
		 *
		 * @since  1.0.0
		 * @param  object $hook
		 */
		public function scripts( $hook ) {

			global $typenow;

			foreach ( $this->args['page'] as $page ) {

				// Add scripts only if page match with post type
				if ( $typenow == $page ) {

					$wp_editor = array(
					'url' => get_home_url(),
					'includes_url'	=> includes_url(),
					);

					// Color Picker
					wp_enqueue_style( 'wp-color-picker' );

					// jQuery UI
					wp_enqueue_script( 'jquery-ui-draggable' );
					wp_enqueue_script( 'jquery-ui-droppable' );
					wp_enqueue_script( 'jquery-ui-sortable' );
					wp_enqueue_script( 'jquery-ui-resizable' );
					wp_enqueue_script( 'jquery-ui-selectable' );
					wp_enqueue_script( 'jquery-ui-slider' );

					// Media
					wp_enqueue_media();

					wp_enqueue_style( 'jquery_ui_custom', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-custom.min.css', array(), '1.11.4' );
					wp_enqueue_style( 'jquery_ui_slider_pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.css', array(),  '1.11.3' );
					wp_enqueue_script( 'jquery-ui-slider-pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.js', array( 'jquery' ), '1.7.2', true );

					wp_enqueue_style( 'tooltipster', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'tooltipster/tooltipster.min.css', array(), '3.3.0' );
					wp_enqueue_script( 'tooltipster', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'tooltipster/tooltipster.min.js', array( 'jquery' ), '3.3.0', false );
					wp_enqueue_script( 'js-wp-editor', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'js-wp-editor.min.js', array( 'jquery' ), '1.1', false );
					wp_localize_script( 'js-wp-editor', 'ap_vars', $wp_editor );

					wp_enqueue_style( 'anva_builder', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-builder.css', array( 'tooltipster' ), Anva::get_version(), 'all' );
					wp_enqueue_script( 'anva_builder', ANVA_FRAMEWORK_ADMIN_JS . 'admin-builder.js', array( 'jquery' ), Anva::get_version(), false );
					wp_localize_script( 'anva_builder', 'AnvaBuilderLocal', anva_get_admin_locals( 'metabox_js' ) );

				}
			}// End foreach().
			}

		/**
		 * Get elements data from database.
		 *
		 * @global $post, $typenow
		 *
		 * @since  1.0.0
		 */
		public function head() {

			$order  = array();
			$output = '';
			$screen = get_current_screen();

			if ( 'page' !== $screen->id ) {
				return;
			}

			global $post, $typenow;

			foreach ( $this->args['page'] as $page ) {

				// Add scripts only if page match with post type
				if ( $typenow === $page ) {

					$settings = get_post_meta( $post->ID, $this->id, true );

					if ( empty( $settings ) ) {
						return;
					}

					$order = $settings['order'];
					$items = explode( ',', $order );

					$output .= "<script type='text/javascript'>\n";
					$output .= "jQuery(document).ready(function($) {\n";
					$output .= "/* <![CDATA[ */\n";

					foreach ( $items as $item_id => $item ) {
						if ( ! empty( $item ) ) {
							$data = $settings[ $item ]['data'];
							$output .= sprintf(
							'$( "#%1$s" ).data( "anva_builder_settings", "%2$s" );',
							esc_js( $item ),
							addslashes( $data )
							);
						}
					}

					$output .= "/* ]]> */\n";
					$output .= "});\n";
					$output .= '</script>';

					echo $output;
				}
			}// End foreach().
			}

		/**
		 * Call WP's add_meta_box() for each post type
		 *
		 * @since 1.0.0
		 */
		public function add() {
			// Filters
			$this->args = apply_filters( 'anva_builder_args_' . $this->id, $this->args );

			foreach ( $this->args['page'] as $page ) {
				add_meta_box(
				$this->id,
				$this->args['title'],
				array( $this, 'display' ),
				$page,
				$this->args['context'],
				$this->args['priority']
				);
			}
			}

		/**
		 * Renders the content of the meta box
		 *
		 * @since 1.0.0
		 */
		public function display( $post ) {
			$enable		= '';
			$shortcodes = $this->options;
			$settings 	= get_post_meta( $post->ID, $this->id, true );
			$items 		= array();

			if ( isset( $settings['enable'] ) ) {
				$enable = $settings['enable'];
			}

			if ( isset( $settings['order'] ) ) {
				$order = $settings['order'];
			}

			if ( isset( $order ) ) {
				$items = explode( ',', $order );
			}

			$empty = '';
			if ( ! isset( $items[0] ) || empty( $items[0] ) ) {
				$empty = 'empty';
			}

			// Add an nonce field so we can check for it later.
			wp_nonce_field( $this->id, $this->id . '_nonce' );
			?>
			<input type="hidden" id="anva_post_id" name="anva_post_id" value="<?php echo esc_attr( $post->ID ); ?>" />
		<input type="hidden" id="anva_builder_id" name="anva_builder_id" value="<?php echo esc_attr( $this->id ); ?>" />
		<input type="hidden" id="anva_shortcode" name="anva_shortcode" value="" />
		<input type="hidden" id="anva_shortcode_title" name="anva_shortcode_title" value="" />
		<input type="hidden" id="anva_shortcode_image" name="anva_shortcode_image" value="" />
		<input type="hidden" id="anva_shortcode_order" name="<?php echo esc_attr( $this->id . '[order]' ); ?>" value="" />
		<input type="hidden" id="anva_current_item" name="anva_current_item" value="" />

		<div id="anva-framework" class="anva-framework">
			<div class="anva-builder-wrap">
				<div class="anva-builder-elements-wrap">
					<ul class="builder-elements">
						<?php foreach ( $this->options as $element_id => $element ) : ?>
							<?php if ( isset( $element['icon'] ) && ! empty( $element['icon'] ) ) : ?>
								<li class="builder-item">
									<?php
										printf(
											'<div class="tooltip element-shortcode" data-element="%1$s" data-title="%2$s" title="%4$s"><img class="icon-thumbnail" src="%3$s" alt="%2$s" /><span class="icon-title">%2$s</span></div>',
											esc_attr( $element_id ),
											esc_attr( $element['name'] ),
											esc_url( $element['icon'] ),
											esc_attr( $element['desc'] )
										);
									?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>
					</div><!-- .anva-builder-elements-wrap (end) -->

					<div class="anva-builder-actions-wrap">
						<div class="anva-builder-action">
							<div class="anva-backup-container">
								<a href="#" class="anva-tooltip-info">
									<span class="dashicons dashicons-info"></span>
								</a>
								<div class="anva-tooltip-info-html hidden">
									<h3><?php esc_html_e( 'Quick Info', 'anva' ); ?></h3>
									<p><?php esc_html_e( 'Select below the item you want to display and click "+ Add Item", it will add inline form for selected element once you finish customizing click "Apply" button. You can Drag & Drop each items to re order them.', 'anva' ); ?></p>
								</div>
								<a href="#" class="button button-toggle">
									<?php esc_html_e( 'Template', 'anva' ); ?>
								</a>
								<div class="anva-backup-inner">
									<span class="anva-arrow"></span>
									<div class="anva-export-wrap">
									<input type="hidden" id="anva-export" name="anva_export" />
									<input type="submit" class="button button-primary button-export" value="<?php esc_html_e( 'Export', 'anva' ); ?>" />
									</div>
									<div class="anva-import-wrap">
									<input type="hidden" id="anva-import" name="anva_import" />
									<input type="submit" class="button button-secondary button-import" value="<?php esc_html_e( 'Import', 'anva' ); ?>" />
									<input type="file" id="anva-import-file" name="anva_import_file" />
									</div>
								</div>
							</div>

							<a hef="#" id="add-builder-row" class="button">
								<?php esc_html_e( 'Add Row', 'anva' ); ?>
							</a>
							<a id="remove-all-items" class="button button-secondary button-remove-all">
								<?php esc_html_e( 'Remove All Items', 'anva' ); ?>
							</a>
							<a id="add-builder-item" class="button button-primary button-add-item">
								<?php esc_html_e( 'Add New Item', 'anva' ); ?>
							</a>
						</div>
					</div><!-- .anva-builder-actions-wrap (end) -->

					<ul id="builder-sortable-items" class="builder-sortable-items sortable-items <?php echo $empty; ?>" data-text="<?php esc_html_e( 'Drag items here or Click on Add New Item', 'anva' ); ?>">
						<?php
						if ( isset( $items[0] ) && ! empty( $items[0] ) ) :

							foreach ( $items as $item_id => $item )	:

								$data = $settings[ $item ]['data'];
								$obj  = json_decode( $data );

								if ( isset( $item[0] ) && isset( $shortcodes[ $obj->shortcode ] ) ) :

									$shortcode_type = $shortcodes[ $obj->shortcode ]['name'];
									$shortocde_icon = $shortcodes[ $obj->shortcode ]['icon'];
									$shortcode = $obj->shortcode;
									$obj_title_name = '';

									if ( $obj->shortcode != 'divider' ) {
										$obj_title_name = $obj->shortcode . '_title';

										if ( property_exists( $obj, $obj_title_name ) ) {
											$obj_title_name = $obj->$obj_title_name;

										} else {
											$obj_title_name = '';
										}
} else {
										$obj_title_name = '<span class="shortcode-type">' . esc_html__( 'Divider', 'anva' ) . '</span>';
										$shortcode_type = '';
									}
									?>
									<li id="<?php echo esc_attr( $item ); ?>" class="item item-<?php echo esc_attr( $item ); ?> <?php echo esc_attr( $shortcode ); ?>" data-size="col_full">
										<div class="actions">
											<a title="<?php esc_html_e( 'Add Column', 'anva' ); ?>" href="#" class="button-col-up"></a>
											<a title="<?php esc_html_e( 'Remove Column', 'anva' ); ?>" href="#" class="button-col-down"></a>
											<a title="<?php esc_html_e( 'Move Item Up', 'anva' ); ?>" href="#" class="button-move-up"></a>
											<a title="<?php esc_html_e( 'Move Item Down', 'anva' ); ?>" href="#" class="button-move-down"></a>
											<a title="<?php esc_html_e( 'Edit Item', 'anva' ); ?>" href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=anva_builder_get_fields&shortcode=' . $shortcode . '&rel=' . $item ) ); ?>" class="button-edit" data-id="<?php echo esc_attr( $item ); ?>"></a>
											<a title="<?php esc_html_e( 'Remove Item', 'anva' )?>" href="#" class="button-remove"></a>
										</div>
										<div class="thumbnail">
											<img src="<?php echo esc_url( $shortocde_icon ); ?>" alt="<?php echo esc_attr( $shortcode_type ); ?>" />
										</div>
										<div class="title">
											<span class="shortcode-type"><?php echo $shortcode_type; ?></span>
											<span class="shortcode-title"><?php echo urldecode( $obj_title_name ); ?></span>
										</div>
										<span class="spinner spinner-<?php echo esc_attr( $item ); ?>"></span>
										<div class="clear"></div>
									</li>
									<?php
								endif;
							endforeach;
							endif;
						?>
					</ul><!-- .sortable-items (end) -->

					<div class="anva-builder-footer">
						<div class="message">
						<?php
							printf(
								'%s %s <span class="alignright">%s %s</span>',
								__( 'Anva Content Builder powered by Anva Framework', 'anva' ),
								Anva::get_version(),
								__( 'Develop by', 'anva' ),
								sprintf( '<a href="' . esc_url( 'http://anthuanvasquez.net/' ) . '">%s</a>', esc_html__( 'Anthuan Vasquez', 'anva' ) )
							);
						?>
						</div>
					</div><!-- .anva-builder-footer (end) -->
				</div><!-- .anva-builder-wrap (end) -->
			</div><!-- .anva-meta-box (end) -->
		<?php
		}

		/**
		 * Save meta data sent from meta box
		 *
		 * @since 1.0.0
		 * @param integer The post ID
		 */
		public function save( $post_id ) {
			/*
			 * We need to verify this came from the our screen and with proper authorization,
			 * because save_post can be triggered at other times.
			 */

			// Check if our nonce is set.
			if ( ! isset( $_POST[ $this->id . '_nonce' ] ) ) {
			return $post_id;
			}

			$nonce = $_POST[ $this->id . '_nonce' ];

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $nonce, $this->id ) ) {
			return $post_id;
			}

			// If this is an autosave, our form has not been submitted,
			// so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
			}

			// Check the user's permissions.
			if ( 'page' == $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
				}
} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
							}
			}

			/*
			 * OK, its safe!
			 */

			$this->backup_content();

			$data = array();

			if ( isset( $_POST[ $this->id ] ) && ! empty( $_POST[ $this->id ] ) ) {
				foreach ( $_POST[ $this->id ] as $id => $value ) {
					$data[ $id ] = $value;
				}
				update_post_meta( $post_id, $this->id, $data );

				return $post_id;
			}

			delete_post_meta( $post_id, $this->id );

			}

		/**
		 * Admin notices
		 *
		 * @since 1.0.0
		 */
		public function admin_notices() {

			global $typenow;

			if ( ! isset( $_GET['page'] ) || ( $_GET['page'] != $typenow ) ) {
				return;
			}

			if ( isset( $_GET['imported'] ) && $_GET['imported'] == 'true' ) {
				printf( '<div id="message" class="updated"><p>%s</p></div>', esc_html__( 'Content has successfully imported.', 'anva' ) );

			} elseif ( isset( $_GET['error-import'] ) && $_GET['error-import'] == 'true' ) {
				echo '<div id="message" class="error"><p>' . esc_html__( 'There was a problem importing your content. Please Try again.', 'anva' ) . '</p></div>';
			}
			}

		/**
		 * Export or Import builder content
		 *
		 * @since 1.0.0
		 */
		public function backup_content() {
			if ( isset( $_POST['anva_import'] ) && ( $_POST['anva_import'] == '1' ) ) {
				$this->import();
			}

			if ( isset( $_POST['anva_export'] ) && ( $_POST['anva_export'] == '1' ) ) {
				$this->export();
			}
			}

		/**
		 * Import builder content
		 *
		 * @since 1.0.0
		 */
		public function import() {

			global $post;

			if ( ! isset( $_FILES['anva_import_file'] ) || $_FILES['anva_import_file']['error'] > 0 ) {
				wp_redirect( admin_url( 'post.php?post=' . $post->ID . '&action=edit&error-builder=true' ) );
				return;
			}

			// Check if zip file
			$import_filename 	= $_FILES['anva_import_file']['name'];
			$import_type 		= $_FILES['anva_import_file']['type'];
			$is_zip 			= false;
			$new_filename 		= basename( $import_filename, '_.zip' );
			$accepted_types 	= array(
			'application/zip',
			'application/x-zip-compressed',
			'multipart/x-zip',
			'application/s-compressed',
			);

			foreach ( $accepted_types as $mime_type ) {
				if ( $mime_type == $import_type ) {
					$is_zip = true;
					break;
				}
			}

			// ZIP file
			if ( $is_zip ) {

				$option_name = anva_get_option_name();

				WP_Filesystem();
				$upload_dir = wp_upload_dir();
				$cache_dir 	= '';

				if ( isset( $upload_dir['basedir'] ) ) {
					$cache_dir = $upload_dir['basedir'] . '/' . $option_name;
				}

				move_uploaded_file( $_FILES['anva_import_file']['tmp_name'], $cache_dir . '/' . $import_filename );
				// $unzipfile = unzip_file( $cache_dir . '/' . $import_filename, $cache_dir );
				$zip = new ZipArchive();
				$x 	 = $zip->open( $cache_dir . '/' . $import_filename );

				for ( $i = 0; $i < $zip->numFiles; $i++ ) {
					$new_filename = $zip->getNameIndex( $i );
					break;
				}

				if ( $x === true ) {
					$zip->extractTo( $cache_dir );
					$zip->close();
				}

				$import_options = file_get_contents( $cache_dir . '/' . $new_filename );

				unlink( $cache_dir . '/' . $import_filename );
				unlink( $cache_dir . '/' . $new_filename );

			} else {
				$import_options = file_get_contents( $_FILES['anva_import_file']['tmp_name'] );
			}// End if().

			$import_options = json_decode( $import_options, true );

			update_post_meta( $post->ID, $this->id, $import_options );

			wp_redirect( admin_url( 'post.php?post=' . $post->ID . '&action=edit&imported=true' ) );

			exit;

			}

		/**
		 * Export builder content
		 *
		 * @since 1.0.0
		 */
		public function export() {

			global $post;

			$page_slug   = get_the_title( $post->ID );
			$page_slug   = sanitize_title( $page_slug );
			$option_name = anva_get_option_name();
			$filename    = strtolower( $option_name ) . '_page_builder_' . $page_slug . '_' . date( 'Y-m-d_hia' );

			// Get current content
			$export_options = get_post_meta( $post->ID, $this->id, true );

			// Convert to JSON
			$output = json_encode( $export_options );

			header( 'Content-Description: File Transfer' );
			header( 'Cache-Control: public, must-revalidate' );
			header( 'Pragma: hack' );
			header( 'Content-Type: application/json' );
			header( 'Content-Disposition: attachment; filename="' . $filename . '.json"' );
			header( 'Content-Length: ' . strlen( $output ) );
			echo $output;
			exit;

			}

		/**
		 * Get ajax fields
		 *
		 * @since 1.0.0
		 */
		function ajax_get_fields() {
			if ( isset( $_GET['shortcode'] ) && ! empty( $_GET['shortcode'] ) ) :

				$shortcodes = $this->options;

				if ( isset( $shortcodes[ $_GET['shortcode'] ] ) ) :
					$id            = $_GET['rel'];
					$shortcode     = $_GET['shortcode'];
					$shortcode_arr = $shortcodes[ $shortcode ];
					?>

					<div id="item-inline-<?php echo esc_attr( $id ); ?>" data-shortcode="<?php echo esc_attr( $shortcode ); ?>" class="item-inline item-inline-<?php echo esc_attr( $id ); ?>">

					<div class="section section-header">
						<h2><?php echo $shortcode_arr['name']; ?></h2>
						<button type="button" id="save-<?php echo esc_attr( $id ); ?>" class="button button-primary">
							<?php esc_html_e( 'Update', 'anva' ); ?>
						</button>
						<button type="button" id="cancel-<?php echo esc_attr( $id ); ?>" class="button button-secondary">
							<?php esc_html_e( 'Cancel', 'anva' ); ?>
						</button>
					</div>

					<?php if ( isset( $shortcode_arr['name'] ) && $shortcode_arr['name'] != 'Divider' ) :
							$title = $shortcode . '_title';
							$value = $shortcode_arr['name']; ?>

						<div class="section section-title">
							<h4><?php esc_html_e( 'Name', 'anva' ); ?></h4>
							<div class="option">
								<div class="controls">
									<input type="text" id="<?php echo $title; ?>" name="<?php echo $title; ?>" data-attr="title" value="<?php echo $value; ?>" class="anva-input" />
								</div>
								<div class="explain">
									<?php esc_html_e( 'Enter the name of the element.', 'anva' ); ?>
								</div>
							</div>
						</div>

					<?php else : ?>
						<input type="hidden" id="<?php echo $title; ?>" name="<?php echo $title; ?>" data-attr="title" value="<?php echo $value; ?>" class="anva-input" />
					<?php endif; ?>

						<?php anva_the_options_fields( 'anva_builder', '', $shortcode_arr['attr'], $shortcode ); ?>

						<?php if ( isset( $shortcode_arr['content'] ) && $shortcode_arr['content'] ) :
						$editor_id = $shortcode . '_content'; ?>

						<div class="section section-content">
							<h4><?php esc_html_e( 'Content', 'anva' ); ?></h4>
							<div class="explain">
								<?php printf( '%s <strong>%s</strong>.', esc_html__( 'Enter the text or HTML content to display in this item', 'anva' ), $shortcode_arr['name'] ); ?>
							</div>
							<div class="controls">
								<textarea id="<?php echo esc_attr( $editor_id ); ?>" name="<?php echo esc_attr( $editor_id ); ?>" rows="10" class="anva-input anva-textarea anva-wp-editor"></textarea>
							</div>
						</div>

					<?php endif; ?>

					</div><!-- .item-inline (end) -->

					<script type="text/javascript">
					/* <![CDATA[ */
					jQuery(document).ready( function($) {

						'use strict';

						var $currentItemData = $('#<?php echo esc_js( $id ); ?>').data( 'anva_builder_settings' ),
							$currentItemOBJ  = $.parseJSON( $currentItemData );

						console.log($currentItemData);

						$.each( $currentItemOBJ, function( index, value ) {
							if ( typeof $( '#' + index ) != 'undefined' ) {
								$( '#' + index ).val( decodeURI( value ) );

								console.log(index);
								console.log(value);

								if ( $( '#' + index ).hasClass('anva-file') ) {
									var $remove = $('#' + index + '_button').data('remove');
									$('#' + index + '_button').text( $remove );
									$('#' + index + '_image').append('<img src="' + value + '" /><a href="#" class="anva-remove-image">X</a>').slideDown('fast');
								}
							}
						});

						// Cancel Changes
						$("#cancel-<?php echo esc_js( $id ); ?>").on( 'click', function(e) {
							e.preventDefault();
							var itemInner = $('#item-inner-<?php echo esc_js( $id ); ?>');
							var parentEle = $('#<?php echo esc_js( $id ); ?>');

							if ( parentEle.hasClass('has-inline-content') ) {
								parentEle.removeClass('has-inline-content');
							}

							if ( itemInner.length > 0 ) {
								itemInner.slideToggle();
								setTimeout( function() {
									itemInner.remove();
								}, 500);
							}
						});

						// Apply Changes
						$("#save-<?php echo esc_js( $id ); ?>").on( 'click', function(e) {
							e.preventDefault();

							// Validate title
							var $title = $(this).closest('.item-inline').find('.section-title input');

							if ( $title.val() == '' ) {
								alert( anvaBuilderJs.builder_title );
								return false;
							}

							// WP Editor
							tinyMCE.triggerSave();

							// Get current item ID
							var $currentItem = $('#anva_current_item').val();

							// Get current item shortcode
							var $currentShortcode = $('#item-inline-<?php echo esc_js( $id ); ?>').attr('data-shortcode');

							// Create Object
							var itemData = {};

							itemData.id = $currentItem;
							itemData.shortcode = $currentShortcode;

							$('#item-inline-<?php echo esc_js( $id ); ?> :input.anva-input').each( function() {

								console.log($(this).attr('id'));

								if ( typeof $(this).attr('id') !== 'undefined' ) {
									itemData[$(this).attr('id')] = encodeURI( $(this).val() );

									if ( $(this).attr('data-attr') == 'title' ) {
										$('#' + $currentItem).find('.title .shortcode-title').html( decodeURI( $(this).val() ) );

										if ( $('#' + $currentItem).find('.unsave').length == 0 ) {
											$('<span class="unsave">' + anvaBuilderJs.builder_unsaved + '</span>').appendTo( $('#' + $currentItem).find('.title .shortcode-type') );
											$('#' + $currentItem).addClass('item-unsaved');
										}
									}
								}
							});

							// Create the JSON string
							var currentItemDataJSON = JSON.stringify( itemData ),
								$itemInner = $('#item-inner-<?php echo esc_js( $id ); ?>'),
								$parentEle = $('#<?php echo esc_js( $id ); ?>');

							// Save Data
							$('#' + $currentItem).data( 'anva_builder_settings', currentItemDataJSON );

							if ( $parentEle.hasClass('has-inline-content') ) {
								$parentEle.removeClass('has-inline-content');
							}

							if ( $itemInner.length > 0 ) {
								$itemInner.slideToggle();
								setTimeout( function() {
									$itemInner.remove();
								}, 500);
							}
						});
					});
					/* ]]> */
					</script>
				<?php endif; ?>
			<?php endif; ?>
			<?php die();
			}
}
endif;
