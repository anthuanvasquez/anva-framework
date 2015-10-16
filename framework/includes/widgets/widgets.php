<?php

include_once ( anva_get_core_directory() . '/includes/widgets/class-anva-posts-list.php' );
include_once ( anva_get_core_directory() . '/includes/widgets/class-anva-social-media-buttons.php' );
include_once ( anva_get_core_directory() . '/includes/widgets/class-anva-quick-contact.php' );

/**
 * Register widgets
 * 
 * @since 1.0.0
 */
function anva_register_widgets() {

	$widgets = anva_get_widgets();

	// Register Framework Widgets
	foreach ( $widgets as $key => $widget ) {
		// Validate if widget class exists
		//if ( isset( $widget['class'] ) && class_exists( $widget['class'] ) ) {
			register_widget( $widget['class'] );
		//}
	}

}

/**
 * Get widgets
 * 
 * @since 1.0.0
 */
function anva_get_widgets() {

	$widgets = array(
		'posts_list' =>array(
			'class' => 'Anva_Posts_List',
			'name' => 'Anva Posts List'
		),
		'social_media_buttons' =>array(
			'class' => 'Anva_Social_Media_Buttons',
			'name' => 'Anva Social Media Buttons'
		),
		'quick_contact' =>array(
			'class' => 'Anva_Quick_Contact',
			'name' => 'Anva Quick Contact'
		)
	);
	
	return apply_filters( 'anva_widgets', $widgets );
}