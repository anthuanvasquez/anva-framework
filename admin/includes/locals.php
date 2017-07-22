<?php
/**
 * Return user read text strings. This function allows
 * to have all of the framework's common localized text
 * strings in once place. Also, the following filters can
 * be used to add/remove strings.
 *
 * @since  1.0.0
 * @param  string $type   Localize type.
 * @return array  $locals Localize array strings.
 */
 function anva_get_admin_locals( $type ) {

	$locals = array();

	switch ( $type ) {

		// Admin General.
		case 'js':
			$locals = array(
				'save_button'           => esc_html__( 'Saving...', 'anva' ),
				'save_button_title'     => esc_html__( 'Are you sure?', 'anva' ),
				'save_button_text'      => esc_html__( 'You will not be able to recover the options!', 'anva' ),
				'save_button_confirm'   => esc_html__( 'Yes, restore it!', 'anva' ),
				'save_button_cancel'    => esc_html__( 'Nooo, wait!', 'anva' ),
				'reset_title'           => esc_html__( 'Restore Defaults', 'anva' ),
				'import_empty_title'    => esc_html__( 'Import is Empty', 'anva' ),
				'import_empty_text'     => esc_html__( 'The import settings box is empty. Paste your exported settings before start to import the options.', 'anva' ),
				'import_button_title'   => esc_html__( 'Confirm the Import', 'anva' ),
				'import_button_text'    => esc_html__( 'All current theme settings will be overwritten!', 'anva' ),
				'import_button_confirm' => esc_html__( 'Yes, import it!', 'anva' ),
				'import_button_cancel'  => esc_html__( 'May be later!', 'anva' ),
				'delete'                => esc_html__( 'Delete', 'anva' ),
				'confirm'               => esc_html__( 'Yes', 'anva' ),
				'cancel'                => esc_html__( 'Cancel', 'anva' ),
				'sidebar_error_title'   => esc_html__( 'Sidebar input is empty!', 'anva' ),
				'sidebar_error_text'    => esc_html__( 'Enter the name for custom sidebar.', 'anva' ),
				'sidebar_button_title'  => esc_html__( 'Sure?', 'anva' ),
				'sidebar_button_text'   => esc_html__( 'You sure want delete this item?', 'anva' ),
				'sidebar_add_title'     => esc_html__( 'The name must have more than 3 characters.', 'anva' ),
				'contact_error_title'   => esc_html__( 'Contact input is empty!', 'anva' ),
				'contact_error_text'    => esc_html__( 'Enter the name for contact field.', 'anva' ),
				'contact_button_title'  => esc_html__( 'Sure?', 'anva' ),
				'contact_button_text'   => esc_html__( 'You sure want delete this field?', 'anva' ),
				'contact_exists_title'  => esc_html__( 'This Field Exists', 'anva' ),
				'contact_exists_text'   => esc_html__( 'You have already added', 'anva' ),
			);
			break;

		// Meta Box.
		case 'metabox_js':
			$locals = array(
				'ajaxurl'                => admin_url( 'admin-ajax.php' ),
				'builder_title'          => esc_html__( 'The title field is required.', 'anva' ),
				'builder_empty'          => esc_html__( 'Select an item to add it to the list.', 'anva' ),
				'builder_remove'         => esc_html__( 'Are you sure you want to remove this item?', 'anva' ),
				'builder_remove_all'     => esc_html__( 'Are you sure you want to remove all items?', 'anva' ),
				'builder_remove_empty'   => esc_html__( 'The list is empty.', 'anva' ),
				'builder_unsaved'        => esc_html__( 'Unsaved', 'anva' ),
				'builder_unsave'         => esc_html__( 'You have unsaved item in the list, save content before export.', 'anva' ),
				'builder_import'         => esc_html__( 'Choose the JSON file before import content.', 'anva' ),
				'builder_upload'         => esc_html__( 'Upload Image', 'anva' ),
				'builder_select_image'   => esc_html__( 'Select', 'anva' ),
				'builder_publish_items'  => esc_html__( 'Update Items', 'anva' ),
				'builder_publish_update' => esc_html__( 'Update', 'anva' ),
				'gallery_empty'          => esc_html__( 'The gallery is empty, add some image first.', 'anva' ),
				'gallery_confirm'        => esc_html__( 'Are you sure you want to remove all the images in the gallery?', 'anva' ),
				'gallery_selected'       => esc_html__( 'No images have been selected yet.', 'anva' ),
				'confirm'                => esc_html__( 'Yes', 'anva' ),
				'cancel'                 => esc_html__( 'Cancel', 'anva' ),
			);
			break;

		// Customizer.
		case 'customizer_js':
			$locals = array(
				'disclaimer'             => esc_html__( 'Note: The customizer provides a simulated preview, and results may vary slightly when published and viewed on your live website.', 'anva' ),
			);
			break;
	}// End switch().

	return apply_filters( 'anva_admin_locals_' . $type, $locals );
}
