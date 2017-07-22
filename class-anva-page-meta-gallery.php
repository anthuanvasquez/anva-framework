<?php

if ( ! class_exists( 'Anva_Page_Meta_Gallery' ) ) :

/**
 * Anva Gallery.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        https://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Page_Meta_Gallery {
		/**
		 * ID for meta box and post field saved.
		 *
		 * @since 1.0.0
		 * @var   string
		 */
		public $id;

		/**
		 * Arguments to pass to add_meta_box().
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		private $args;

		/**
		 * Constructor Hook everything in.
		 *
		 * @since 1.0.0
		 * @param string $id
		 * @param array  $args
		 */
		public function __construct( $id, $args ) {
			$this->id = $id;

			$defaults = array(
			'page'     => array( 'post' ),	// Can contain post, page, link, or custom post type's slug
			'context'  => 'normal',		    // Normal, advanced, or side
			'priority' => 'high',// Priority
			);

			$this->args = wp_parse_args( $args, $defaults );

			// Hooks
			if ( is_admin() ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
				add_action( 'add_meta_boxes', array( $this, 'add' ) );
				add_action( 'save_post', array( $this, 'save' ) );
				add_action( 'wp_ajax_anva_gallery_get_thumbnail', array( $this, 'ajax_get_thumbnail' ) );
			}
			}

		/*
		 * Admin scripts
		 */
		public function scripts() {
			global $typenow;

			foreach ( $this->args['page'] as $page ) {

				// Add scripts only if page match with post type
				if ( $typenow == $page ) {

					wp_enqueue_script( 'media-upload' );
					wp_enqueue_script( 'anva_gallery',ANVA_FRAMEWORK_ADMIN_JS . 'admin-galleries.js', array(), Anva::get_version(), true );
					wp_localize_script( 'anva_gallery', 'AnvaGalleryLocal', anva_get_admin_locals( 'metabox_js' ) );
					wp_enqueue_style( 'anva_gallery', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-galleries.css', array(), Anva::get_version(), 'all' );

				}
			}
			}

		/*
		 * Adds the meta box container
		 */
		public function add() {
			// Filters
			$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );

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
			$gallery = get_post_meta( $post->ID, $this->id, true );

			wp_nonce_field( $this->id, $this->id . '_nonce' );
			?>

			<input type="hidden" id="anva_gallery_id" name="anva_gallery_id" value="<?php echo esc_attr( $this->id ); ?>" />
		<div id="anva-framework" class="anva-meta-box">
			<div class="anva-input-gallery">
				<div id="anva_gallery_container">
					<ul id="anva_gallery_thumbs" data-text="<?php _e( 'No images have been selected yet.', 'anva' ); ?>">
						<?php
							$gallery = ( is_string( $gallery ) ) ? @unserialize( $gallery ) : $gallery;
							if ( is_array( $gallery ) && count( $gallery ) > 0 ) {
							foreach ( $gallery as $attachment_id ) {
								$this->admin_thumb( $attachment_id );
								}
							}
						?>
						</ul>
					</div>
					<div class="anva-gallery-actions">
						<span id="anva-gallery-spinner" class="spinner"></span>
						<input type="button" id="anva_gallery_remove_all_buttons" class="button button-secondary" value="<?php echo __( 'Remove All Images', 'anva' ); ?>" />
						<input type="button" id="anva_gallery_upload_button" class="button button-primary" value="<?php echo __( 'Upload Image', 'anva' ); ?>" data-title="<?php echo __( 'Upload Image', 'anva' ); ?>" data-text="<?php _e( 'Select Image', 'anva' ); ?>" />
					</div>
				</div>
			</div>

			<?php
			}

		/*
		 * Save the meta when the post is saved
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
			$id         = $this->id;
			$images     = ( isset( $_POST['anva_gallery_thumb'] ) ) ? $_POST['anva_gallery_thumb'] : array();
			$images_ids = array();

			if ( count( $images ) > 0 ) {
				foreach ( $images as $key => $attachment_id ) {
					if ( is_numeric( $attachment_id ) ) {
						$images_ids[] = $attachment_id;
					}
				}
				update_post_meta( $post_id, $id, $images_ids );

				return $post_id;
			}

			delete_post_meta( $post_id, $id );
			}

		private function get_attachment( $attachment_id ) {
			$id    = array();
			$id[]  = $attachment_id;
			$image = wp_get_attachment_image_src( $attachment_id, 'medium', true );

			return array_merge( $id, $image );
			}

		/*
		 * Ajax get thumbnail
		 */
		public function ajax_get_thumbnail() {
			header( 'Cache-Control: no-cache, must-revalidate' );
			header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
			$this->admin_thumb( $_POST['imageid'] );
			die;
			}

		/**
		 * Get admin thumbnail
		 *
		 * @since 1.0.0
		 */
		private function admin_thumb( $attachment_id ) {
			$image = $this->get_attachment( $attachment_id );
			$class = 'landscape squre';

			if ( $image[2] > $image[3] ) {
				$class = 'landscape';
			}

			if ( $image[2] < $image[3] ) {
				$class = 'portrait';
			}
			?>
			<li class="attachment animated fadeIn" data-id="<?php echo esc_attr( $image[0] ); ?>">
			<a href="<?php echo esc_url( admin_url( 'post.php?post=' . $image[0] . '&action=edit' ) ); ?>" target="_blank">
				<div class="attachment-preview <?php echo esc_attr( $class ); ?>">
					<div class="thumbnail">
						<div class="centered">
							<img src="<?php echo esc_url( $image[1] ); ?>" width="<?php echo esc_attr( $image[2] ); ?>" height="<?php echo esc_attr( $image[3] ); ?>" />
						</div>
					</div>
				</div>
			</a>
			<a href="#" class="anva_gallery_remove">X</a>
			<input type="hidden" name="anva_gallery_thumb[]" value="<?php echo esc_attr( $image[0] ); ?>" />
		</li>
		<?php
		}
}
endif;
