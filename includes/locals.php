<?php
/**
 * Localizations functions.
 *
 * @package    AnvaFramework
 * @subpackage Includes
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

/**
 * Get all theme locals (not admin).
 *
 * @since  1.0.0
 * @return array $localize
 */
function anva_get_text_locals() {

	$localize = array(
		'blog'                 => esc_html__( 'Blog', 'anva' ),
		'asc'                  => esc_html__( 'ASC', 'anva' ),
		'desc'                 => esc_html__( 'DESC', 'anva' ),
		'posts_number'         => esc_html__( 'Posts Number', 'anva' ),
		'order_by'             => esc_html__( 'Order by', 'anva' ),
		'rand'                 => esc_html__( 'Random', 'anva' ),
		'show_thumbnails'      => esc_html__( 'Show Thumbnails', 'anva' ),
		'menu'                 => esc_html__( 'Menu', 'anva' ),
		'menu_primary'         => esc_html__( 'Primary Menu', 'anva' ),
		'menu_top_bar'         => esc_html__( 'Top Bar Links', 'anva' ),
		'menu_side_panel'      => esc_html__( 'Side Panel Menu', 'anva' ),
		'menu_split_1'         => esc_html__( 'Split Menu Left', 'anva' ),
		'menu_split_2'         => esc_html__( 'Split Menu Right', 'anva' ),
		'menu_footer'          => esc_html__( 'Footer Copyright Links', 'anva' ),
		'menu_message'         => esc_html__( 'Setup a custom menu at Appearance > Menus in your admin panel, and apply it to the "Primary Menu" location.', 'anva' ),
		'404_title'            => esc_html__( 'Whoops! page not found', 'anva' ),
		'404_sub_title'        => esc_html__( 'Ooopps.! The Page you were looking for, couldn\'t be found.', 'anva' ),
		'404_description'      => esc_html__( 'Try doing a search on the site or return to the home page.', 'anva' ),
		'not_found'            => esc_html__( 'No posts found', 'anva' ),
		'not_found_content'    => esc_html__( 'No posts found.', 'anva' ),
		'read_more'            => esc_html__( 'Read more', 'anva' ),
		'read_more_about'      => esc_html__( 'about an interesting article to read', 'anva' ),
		'prev'                 => esc_html__( 'Previous', 'anva' ),
		'next'                 => esc_html__( 'Next', 'anva' ),
		'comment_prev'         => esc_html__( 'Previous Comments', 'anva' ),
		'comment_next'         => esc_html__( 'Next Comments', 'anva' ),
		'no_comment'           => esc_html__( 'Comments close.', 'anva' ),
		'search_for'           => esc_html__( 'Search for', 'anva' ),
		'search_result'        => esc_html__( 'Search Results for', 'anva' ),
		'search'               => esc_html__( 'Search', 'anva' ),
		'video'                => esc_html__( 'Video', 'anva' ),
		'page'                 => esc_html__( 'Page', 'anva' ),
		'pages'                => esc_html__( 'Pages', 'anva' ),
		'edit_post'            => esc_html__( 'Edit Post', 'anva' ),
		'page_options'         => esc_html__( 'Page Options', 'anva' ),
		'page_title'           => esc_html__( 'Page Title', 'anva' ),
		'page_title_show'      => esc_html__( 'Show Title', 'anva' ),
		'page_title_hide'      => esc_html__( 'Hide Title', 'anva' ),
		'sidebar_title'        => esc_html__( 'Sidebar Column', 'anva' ),
		'sidebar_left'         => esc_html__( 'Sidebar Left', 'anva' ),
		'sidebar_right'        => esc_html__( 'Sidebar Right', 'anva' ),
		'sidebar_fullwidth'    => esc_html__( 'Sidebar Full Width', 'anva' ),
		'sidebar_double'       => esc_html__( 'Double Sidebar', 'anva' ),
		'sidebar_double_left'  => esc_html__( 'Double Sidebar Left', 'anva' ),
		'sidebar_double_right' => esc_html__( 'Double Sidebar Right', 'anva' ),
		'post_grid'            => esc_html__( 'Post Grid', 'anva' ),
		'grid_2_columns'       => esc_html__( '2 Columns', 'anva' ),
		'grid_3_columns'       => esc_html__( '3 Columns', 'anva' ),
		'grid_4_columns'       => esc_html__( '4 Columns', 'anva' ),
		'posted_on'            => esc_html__( 'Posted on', 'anva' ),
		'by'                   => esc_html__( 'by', 'anva' ),
		'category'             => esc_html__( 'Category', 'anva' ),
		'tag'                  => esc_html__( 'Tag', 'anva' ),
		'year'                 => esc_html__( 'Year', 'anva' ),
		'month'                => esc_html__( 'Month', 'anva' ),
		'day'                  => esc_html__( 'Day', 'anva' ),
		'author'               => esc_html__( 'Author', 'anva' ),
		'asides'               => esc_html__( 'Asides', 'anva' ),
		'galleries'            => esc_html__( 'Galleries', 'anva' ),
		'images'               => esc_html__( 'Images', 'anva' ),
		'videos'               => esc_html__( 'Videos', 'anva' ),
		'quotes'               => esc_html__( 'Quotes', 'anva' ),
		'links'                => esc_html__( 'Links', 'anva' ),
		'status'               => esc_html__( 'Estatus', 'anva' ),
		'audios'               => esc_html__( 'Audios', 'anva' ),
		'chats'                => esc_html__( 'Chats', 'anva' ),
		'archives'             => esc_html__( 'Archives', 'anva' ),
		'name'                 => esc_html__( 'Name', 'anva' ),
		'name_place'           => esc_html__( 'Complete Name', 'anva' ),
		'name_required'        => esc_html__( 'Please enter your name.', 'anva' ),
		'email'                => esc_html__( 'E-Mail', 'anva' ),
		'email_place'          => esc_html__( 'E-Mail', 'anva' ),
		'email_required'       => esc_html__( 'Please enter a valid Email.', 'anva' ),
		'email_error'          => esc_html__( 'The E-Mail must have a valid format ex. name@email.com.', 'anva' ),
		'subject'              => esc_html__( 'Subject', 'anva' ),
		'subject_required'     => esc_html__( 'Please enter a subject.', 'anva' ),
		'message'              => esc_html__( 'Message', 'anva' ),
		'message_place'        => esc_html__( 'Message', 'anva' ),
		'message_required'     => esc_html__( 'Please enter your message.', 'anva' ),
		'message_min'          => esc_html__( 'Must enter minimun char lenth 10.', 'anva' ),
		'mobile'               => esc_html__( 'Mobile', 'anva' ),
		'company_name'         => esc_html__( 'Company Name', 'anva' ),
		'captcha_place'        => esc_html__( 'Enter the result', 'anva' ),
		'captcha_required'     => esc_html__( 'Enter the captcha result.', 'anva' ),
		'captcha_number'       => esc_html__( 'The answer must a integer number.', 'anva' ),
		'captcha_equalto'      => esc_html__( 'Incorrect answer.', 'anva' ),
		'submit'               => esc_html__( 'Submit Message', 'anva' ),
		'submit_message'       => esc_html__( 'Thanks, your E-Mail send succefully.', 'anva' ),
		'submit_error'         => esc_html__( 'Sorry, verify the required fields.', 'anva' ),
		'footer_copyright'     => esc_html__( 'All Rights Reserved' , 'anva' ),
		'footer_text'          => esc_html__( 'Design by', 'anva' ),
		'get_in_touch'         => esc_html__( 'Get in Touch', 'anva' ),
		'home'                 => esc_html__( 'Home', 'anva' ),
		'add_autop'            => esc_html__( 'Add automatic Paragraph', 'anva' ),
		'featured_image'       => esc_html__( 'Featured Image', 'anva' ),
		'options'              => esc_html__( 'Options', 'anva' ),
		'skype'                => esc_html__( 'Skype', 'anva' ),
		'phone'                => esc_html__( 'Phone', 'anva' ),
		'title'                => esc_html__( 'Title', 'anva' ),
		'date'                 => esc_html__( 'Date', 'anva' ),
		'order'                => esc_html__( 'Order', 'anva' ),
		'image'                => esc_html__( 'Image', 'anva' ),
		'link'                 => esc_html__( 'Link', 'anva' ),
		'image_url'            => esc_html__( 'Image URL', 'anva' ),
		'url'                  => esc_html__( 'URL', 'anva' ),
		'slide_id'             => esc_html__( 'Slide ID', 'anva' ),
		'slide_area'           => esc_html__( 'Select the Slide area', 'anva' ),
		'slide_content'        => esc_html__( 'Hide or Show content', 'anva' ),
		'slide_title'          => esc_html__( 'Show title only', 'anva' ),
		'slide_desc'           => esc_html__( 'Show description only', 'anva' ),
		'slide_show'           => esc_html__( 'Show title and description', 'anva' ),
		'slide_hide'           => esc_html__( 'Hide Both', 'anva' ),
		'slide_meta'           => esc_html__( 'Slide Options', 'anva' ),
	);

	return apply_filters( 'anva_text_locals', $localize );

}

/**
 * Separate local.
 *
 * @since 1.0.0.
 * @param string $id The ID for local string.
 */
function anva_local( $id ) {
	echo esc_html( anva_get_local( $id ) );
}

/**
 * Get separate local.
 *
 * @since  1.0.0
 * @param  string $id The local ID.
 * @return string $text The given local ID.
 */
function anva_get_local( $id ) {

	$text     = null;
	$localize = anva_get_text_locals();

	if ( isset( $localize[ $id ] ) ) {
		$text = $localize[ $id ];
	}

	// Sanitize the output.
	return esc_html( $text );
}

/**
 * Get all js locals (not admin).
 *
 * @since  1.0.0
 * @return array $localize Locals used for javascripts.
 */
function anva_get_js_locals() {

	$localize = array(
		'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		'themeUrl'    => trailingslashit( get_template_directory_uri() ),
		'themeImages' => trailingslashit( get_template_directory_uri() . '/assets/images' ),
	);

	return apply_filters( 'anva_js_locals', $localize );
}
