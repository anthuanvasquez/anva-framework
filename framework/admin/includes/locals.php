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

		// Admin General JS Strings
		case 'js':
			$locals = array(
				'save_button'           => __( 'Saving...', 'anva' ),
				'save_button_title'     => __( 'Are you sure?', 'anva' ),
				'save_button_text'      => __( 'You will not be able to recover the options!', 'anva' ),
				'save_button_confirm'   => __( 'Yes, restore it!', 'anva' ),
				'save_button_cancel'    => __( 'Nooo, wait!', 'anva' ),
				'reset_title'           => __( 'Restore Defaults', 'anva' ),
				'import_empty_title'    => __( 'Import is Empty', 'anva' ),
				'import_empty_text'     => __( 'The import settings box is empty. Paste your exported settings before start to import the options.', 'anva' ),
				'import_button_title'   => __( 'Confirm the Import', 'anva' ),
				'import_button_text'    => __( 'All current theme settings will be overwritten!', 'anva' ),
				'import_button_confirm' => __( 'Yes, import it!', 'anva' ),
				'import_button_cancel'  => __( 'May be later!', 'anva' ),
				'delete'                => __( 'Delete', 'anva' ),
				'confirm'               => __( 'Yes', 'anva' ),
				'cancel'                => __( 'Cancel', 'anva' ),
				'sidebar_error_title'   => __( 'Sidebar input is empty!', 'anva' ),
				'sidebar_error_text'    => __( 'Enter the name for custom sidebar.', 'anva' ),
				'sidebar_button_title'  => __( 'Sure?', 'anva' ),
				'sidebar_button_text'   => __( 'You sure want delete this item?', 'anva' ),
				'contact_error_title'   => __( 'Contact input is empty!', 'anva' ),
				'contact_error_text'    => __( 'Enter the name for contact field.', 'anva' ),
				'contact_button_title'  => __( 'Sure?', 'anva' ),
				'contact_button_text'   => __( 'You sure want delete this field?', 'anva' ),
				'contact_exists_title'  => __( 'This Field Exists', 'anva' ),
				'contact_exists_text'   => __( 'You have already added', 'anva' ),
			);
			break;

		// Meta Box JS Strings
		case 'metabox_js':
			$locals = array(
				'ajaxurl'                => admin_url( 'admin-ajax.php' ),
				'builder_title'          => __( 'The title field is required.', 'anva' ),
				'builder_empty'          => __( 'Select an item to add it to the list.', 'anva' ),
				'builder_remove'         => __( 'Are you sure you want to remove this item?', 'anva' ),
				'builder_remove_all'     => __( 'Are you sure you want to remove all items?', 'anva' ),
				'builder_remove_empty'   => __( 'The list is empty.', 'anva' ),
				'builder_unsaved'        => __( 'Unsaved', 'anva' ),
				'builder_unsave'         => __( 'You have unsaved item in the list, save content before export.', 'anva' ),
				'builder_import'         => __( 'Choose the JSON file before import content.', 'anva' ),
				'builder_upload'         => __( 'Upload Image', 'anva' ),
				'builder_select_image'   => __( 'Select', 'anva' ),
				'builder_publish_items'  => __( 'Update Items', 'anva' ),
				'builder_publish_update' => __( 'Update', 'anva' ),
				'gallery_empty'          => __( 'The gallery is empty, add some image first.', 'anva' ),
				'gallery_confirm'        => __( 'Are you sure you want to remove all the images in the gallery?', 'anva' ),
				'gallery_selected'       => __( 'No images have been selected yet.', 'anva' ),
				'confirm'                => __( 'Yes', 'anva' ),
				'cancel'                 => __( 'Cancel', 'anva' ),
			);
			break;

		// Customizer JS Strings
		case 'customizer_js':
			$locals = array(
				'disclaimer' => __( 'Note: The customizer provides a simulated preview, and results may vary slightly when published and viewed on your live website.', 'anva' )
			);
			break;
	}

	return apply_filters( 'anva_admin_locals_' . $type, $locals );
}