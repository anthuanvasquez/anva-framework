<?php

if ( class_exists( 'Walker_Nav_Menu_Edit' ) ) :
/**
 * Extend WP's walker which sets up the HTML
 * to edit a nav menu.
 */
class Anva_Nav_Menu_Edit_Walker extends Walker_Nav_Menu_Edit {

		/**
		 * End the element output.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item.
		 * @param array  $args   Not used.
		 * @param int    $id     Not used.
		 */
		function end_el( &$output, $item, $depth = 0, $args = array() ) {

			// Get columns
			$columns = array();
			$columns[''] = __( 'Default Columns', 'anva' );
			foreach ( anva_get_grid_columns() as $key => $column ) {
				$columns[ $column['class'] ] = $column['name'];
			}

			// Options to add
			ob_start();

			/**
		 * Nav Menu Roles compat
		 */
			do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args );
			?>
			<p class="anva-field-link-mega description">
			<label for="edit-menu-item-mega-<?php echo $item->ID; ?>">
				<input type="checkbox" id="edit-menu-item-mega-<?php echo $item->ID; ?>" value="1" name="_anva_mega_menu[<?php echo $item->ID; ?>]"<?php checked( get_post_meta( $item->ID, '_anva_mega_menu', true ), '1' ); ?> />
				<?php esc_html_e( 'Enable mega menu', 'anva' ); ?>
			</label>
		</p>
		<p class="anva-field-link-mega-hide-headers description">
			<label for="edit-menu-item-mega-hide-headers-<?php echo $item->ID; ?>">
				<input type="checkbox" id="edit-menu-item-mega-hide-headers-<?php echo $item->ID; ?>" value="1" name="_anva_mega_menu_hide_headers[<?php echo $item->ID; ?>]"<?php checked( get_post_meta( $item->ID, '_anva_mega_menu_hide_headers', true ), '1' ); ?> />
				<?php esc_html_e( 'Hide mega menu column headers from 2nd level', 'anva' ); ?>
			</label>
		</p>
		<p class="anva-field-link-mega-columns description description-wide">
			<label for="edit-menu-item-mega-columns-<?php echo $item->ID; ?>">
				<?php esc_html_e( 'Use mega menu columns', 'anva' ); ?>
				<select id="edit-menu-item-mega-columns-<?php echo $item->ID; ?>" name="_anva_mega_menu_columns[<?php echo $item->ID; ?>]">
					<?php
					foreach ( $columns as $col_id => $col ) {
						echo '<option value="' . $col_id . '" ' . selected( get_post_meta( $item->ID, '_anva_mega_menu_columns', true ), $col_id, false ) . '">' . $col . '</option>';
						}
					?>
					</select>
				</label>
			</p>
			<p class="anva-field-link-bold description">
				<label for="edit-menu-item-bold-<?php echo $item->ID; ?>">
					<input type="checkbox" id="edit-menu-item-bold-<?php echo $item->ID; ?>" value="1" name="_anva_bold[<?php echo $item->ID; ?>]"<?php checked( get_post_meta( $item->ID, '_anva_bold', true ), '1' ); ?> />
					<?php esc_html_e( 'Bold menu item text (doesn\'t apply to mega menu headers)', 'anva' ); ?>
				</label>
			</p>
			<p class="anva-field-link-deactivate description">
				<label for="edit-menu-item-deactivate-<?php echo $item->ID; ?>">
					<input type="checkbox" id="edit-menu-item-deactivate-<?php echo $item->ID; ?>" value="1" name="_anva_deactivate_link[<?php echo $item->ID; ?>]"<?php checked( get_post_meta( $item->ID, '_anva_deactivate_link', true ), '1' ); ?> />
					<?php esc_html_e( 'Remove link functionality (sub levels only)', 'anva' ); ?>
				</label>
			</p>
			<p class="anva-field-link-placeholder description">
				<label for="edit-menu-item-placeholder-<?php echo $item->ID; ?>">
					<input type="checkbox" id="edit-menu-item-placeholder-<?php echo $item->ID; ?>" value="1" name="_anva_placeholder[<?php echo $item->ID; ?>]"<?php checked( get_post_meta( $item->ID, '_anva_placeholder', true ), '1' ); ?> />
					<?php esc_html_e( 'Display as transparent placeholder (sub levels only)', 'anva' ); ?>
				</label>
			</p>
			<?php
			$add = ob_get_clean();

			// The insertion point for the options we're adding.
			$search = '<p class="field-css-classes description description-thin">';

			// Get the portion within the overall output, which
			// represents the current item.
			$start = strpos( $output, '<li id="menu-item-' . $item->ID );
			$end = strpos( $output, '<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[' . $item->ID . ']" value="' . $item->ID . '" />' );
			$current = substr( $output, $start, $end -$start );

			// Now, substitute the portion of the overall output with
			// our modified version of that portion.
			$new = str_replace( $search, $add, $current );
			$output = str_replace( $current, $new, $output );

			}
}
endif;
