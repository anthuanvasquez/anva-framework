<?php
/**
 * Return user read text strings. This function allows
 * to have all of the framework's common localized text
 * strings in once place. Also, the following filters can
 * be used to add/remove strings.
 *
 * @since 1.0.0
 */

 function anva_get_admin_locals( $type ) {
	
	$locals = array();
	
	switch ( $type ) {

		// Admin General JS strings
		case 'js':
			$locals = array(
				'reset_title'		=> __( 'Restore Defaults', 'anva' )
			);
			break;

		// Meta Box JS Strings
		case 'metabox_js':
			$locals = array(
				'ajaxurl' 							=> admin_url( 'admin-ajax.php' ),
				'builder_title'					=> __( 'The title field is required.', 'anva' ),
				'builder_empty' 				=> __( 'Select an item to add it to the list.', 'anva' ),
				'builder_remove' 				=> __( 'Are you sure you want to remove this item?', 'anva' ),
				'builder_remove_all' 		=> __( 'Are you sure you want to remove all items?', 'anva' ),
				'builder_remove_empty' 	=> __( 'The list is empty.', 'anva' ),
				'builder_unsaved'				=> __( 'Unsaved', 'anva' ),
				'builder_unsave'				=> __( 'You have unsaved item in the list, save content before export.', 'anva' ),
				'builder_import'				=> __( 'Choose the JSON file before import content.', 'anva' ),
				'builder_upload'				=> __( 'Upload Image', 'anva' ),
				'builder_select_image'	=> __( 'Select', 'anva' ),
				'gallery_empty'					=> __( 'The gallery is empty, add some image first.', 'anva' ),
				'gallery_confirm'				=> __( 'Are you sure you want to remove all the images in the gallery?', 'anva' ),
				'gallery_selected'			=> __( 'No images have been selected yet.', 'anva' ),
			);
			break;

		// Customizer JS strings
		case 'customizer_js':
			$locals = array(
				'disclaimer'						=> __( 'Note: The customizer provides a simulated preview, and results may vary slightly when published and viewed on your live website.', 'anva' )
			);
			break;
	}

	return apply_filters( 'anva_admin_locals_' . $type, $locals );
}