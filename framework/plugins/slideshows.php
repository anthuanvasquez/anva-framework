<?php

// SETUP ACTIONS
function of_slideshows_setup() {
	add_action( 'init', 'of_slideshows_setup_init' );
	add_action( 'admin_head', 'of_slideshows_admin_icon' );	
	add_action( 'add_meta_boxes', 'of_slideshows_create_slide_metaboxes' );
	add_action( 'save_post', 'of_slideshows_save_meta', 1, 2 );
	add_filter( 'manage_edit-slideshows_columns', 'of_slideshows_columns' );
	add_action( 'manage_slideshows_posts_custom_column', 'of_slideshows_add_columns' );
	add_shortcode( 'slideshows', 'of_slideshows_shortcode' );
}

function of_slideshows() {
	
	$args = array();
	$slider_speed = of_get_option( 'slider_speed', 5000 );
	$slider_control = of_get_option( 'slider_control' );
	$slider_direction = of_get_option( 'slider_direction' );
	$slider_play = of_get_option( 'slider_play' );

	// Main Slider
	$args['homepage'] = array(
		'size' 		=> 'thumb_featured',
		'options' => "
			animation: 'fade',
			animationSpeed: 1000,
			slideshowSpeed: '$slider_speed',
			controlNav: ('$slider_control' == 'show' ? true : false),
			directionNav: ('$slider_direction' == 'show' ? true : false),
			pausePlay: ('$slider_play' == 'show' ? true : false),
			pauseText: '',
			playText: '',
			prevText: '',
			nextText: '',
			video: true,
			start: function(slider) {
				slider.removeClass('loading');
			}
	");
	
	// Gallery Slider
	$args['gallery'] = array(
		'size' => 'thumbnail_blog_large'
	);

	// Attachments Slider	
	$args['attachments'] = array(
		'size' => 'thumbnail_blog_large'
	);
	
	return apply_filters( 'of_slideshows', $args );
}

// Create Post Type
function of_slideshows_setup_init() {

	$labels = array(
		'name' 									=> __( 'Slideshows', OF_DOMAIN ),
		'singular_name' 				=> __( 'Slide', OF_DOMAIN ),
		'all_items' 						=> __( 'Todos los Slides', OF_DOMAIN ),
		'add_new' 							=> __( 'A&ntilde;adir Nuevo Slide', OF_DOMAIN ),
		'add_new_item' 					=> __( 'A&ntilde;adir Nuevo Slide', OF_DOMAIN ),
		'edit_item' 						=> __( 'Editar Slide', OF_DOMAIN ),
		'new_item' 							=> __( 'Nuevo Slide', OF_DOMAIN ),
		'view_item' 						=> __( 'Ver Slide', OF_DOMAIN ),
		'search_items' 					=> __( 'Buscar Slides', OF_DOMAIN ),
		'not_found' 						=> __( 'Slide no Encontrado', OF_DOMAIN ),
		'not_found_in_trash' 		=> __( 'No se Encontraron Slides en la Papelera', OF_DOMAIN ),
		'parent_item_colon' 		=> '' );
	
	$args = array(
		'labels'               	=> $labels,
		'public'               	=> true,
		'publicly_queryable'   	=> true,
		'_builtin'             	=> false,
		'show_ui'              	=> true, 
		'query_var'            	=> true,
		'rewrite'              	=> apply_filters( 'of_slideshows_post_type_rewite', array( "slug" => "slideshows" )),
		'capability_type'      	=> 'post',
		'hierarchical'         	=> false,
		'menu_position'        	=> 26.6,
		'supports'             	=> array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies'           	=> array(),
		'has_archive'          	=> true,
		'show_in_nav_menus'    	=> false
	);

	register_post_type( 'slideshows', $args );
}


// Admin Icon
function of_slideshows_admin_icon() {
	echo '<style>#adminmenu #menu-posts-slideshows div.wp-menu-image:before { content: "\f233"; }</style>';	
}

// Show Slides
function of_slideshows_slides( $slug ) {
	
	$id = '_slider_id'; 				 // Default slider id
	$rotators = of_slideshows(); // Get slides area
	
	// Set values
	$image_size = isset( $rotators[ $slug ]['size']) ? $rotators[ $slug ]['size'] : 'large';
	$orderby = isset($rotators[ $slug ]['orderby']) ? $rotators[ $slug ]['orderby'] : "menu_order";
	$order = isset($rotators[ $slug ]['order']) ? $rotators[ $slug ]['order'] : "ASC";
	$limit = isset($rotators[ $slug ]['limit']) ? $rotators[ $slug ]['limit'] : "-1";

	// Default query args
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> $order,
		'orderby' 				=> $orderby,
		'meta_key' 				=> $id,
		'meta_value' 			=> $slug,
		'posts_per_page' 	=> $limit
	);
	
	// Attachments Query Args
	if ( $slug == "attachments" ) {
		$query_args['post_type'] = 'attachment';
		$query_args['post_parent'] = get_the_ID();
		$query_args['post_status'] = 'inherit';
		$query_args['post_mime_type'] = 'image';
		unset( $query_args['meta_value'] );
		unset( $query_args['meta_key'] );
	}
	
	// Output
	$html = "";
	
	query_posts( apply_filters( 'of_slideshows_query_args', $query_args) );

	if ( have_posts() ) {
		$html .= '<div id="slider_wrapper_' . $slug . '" class="slider-wrapper slider-wrapper-' . $slug . '">';
		$html .= '<div id="slider_inner_' . $slug . '" class="slider-inner slider-inner-' . $slug . '">';
		$html .= '<ul class="slides">';
		
		while ( have_posts() ) {

			the_post();
			
			$meta = of_get_post_custom();

			$url 	= $meta['_slider_link_url'][0];
			$data = $meta['_slider_data'][0];

			$a_tag_opening = '<a href="' . $url . '" title="' . the_title_attribute( array('echo' => false) ) . '" >';
						
			$html .= '<li>';
			$html .= '<div id="slide-' . get_the_ID() . '" class="slide slide-'. get_the_ID() .' slide-type-image">';
			
			if ( $slug == "attachments" ) {
				$html .= wp_get_attachment_image( get_the_ID(), $image_size );
			
			} else if ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag_opening;
				}

				$html .= get_the_post_thumbnail( get_the_ID(), $image_size , array( 'class' => 'slide-thumbnail' ) );

				if ( $url ) {
					$html .= '</a>';
				}
			}
			
			switch ( $data ) {
				case 'title':
					$html .= '<div class="slide-data">';
					$html .= '<h2 class="slide-title">';	

					if ( $url ) {
						$html .= $a_tag_opening;
					}

					$html .= get_the_title();

					if ( $url ) {
						$html .= '</a>';
					}

					$html .= '</h2>';
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="slide-data">';
					$html .= '<div class="slide-caption">';
					$html .= get_the_excerpt();
					$html .= '</div>';
					$html .= '</div>';
					break;

				case 'show':
					$html .= '<div class="slide-data">';
					$html .= '<h2 class="slide-title">';	

					if ( $url ) {
						$html .= $a_tag_opening;
					}

					$html .= get_the_title();

					if ( $url ) {
						$html .= '</a>';
					}

					$html .= '</h2>';
					$html .= '<div class="slide-caption">';
					$html .= get_the_excerpt();
					$html .= '</div>';
					$html .= '</div>';
					break;
			}
	
			$html .= '</div><!-- #slide-' . get_the_ID() . ' (end) -->';
			$html .= '</li>';
		}

		$html .= '</ul>';
		$html .= '</div><!-- #slider_inner_' . $slug . ' (end) -->';
		$html .= '</div><!-- #slider_wrapper_' . $slug . ' (end) -->';
		
		// Call Flexslider
		$html .= '<script>';
		$html .= 'jQuery(document).ready(function() {';
		$html .= "jQuery('#slider_inner_{$slug}').addClass('loading');";
		$html .= "jQuery('#slider_inner_{$slug}').flexslider({";
			
		if ( isset($rotators[ $slug ]['options']) && $rotators[ $slug ]['options'] != "" ) { 
			$html .= $rotators[ $slug ]['options'];
		} else {
			$html .="prevText: '', nextText: '',";
			$html .="start: function(slider){ slider.removeClass('loading'); }";
		}
		
		$html .= "});";
		$html .= "});";
		$html .= '</script>';		
	}
	
	wp_reset_query();
	
	return $html;
}

// Admin metabox
function of_slideshows_create_slide_metaboxes() {
	add_meta_box(
		'of_slideshows_metabox_1',
		of_get_local( 'slide_meta' ),
		'of_slideshows_metabox_1',
		'slideshows',
		'normal',
		'default'
	);
}

function of_slideshows_metabox_1() {
	
	global $post;	
		
	$rotators 				= of_slideshows();
	$meta 						= of_get_post_custom();
	$slider_id		 		= isset($meta['_slider_id'][0]) ? $meta['_slider_id'][0] : '';
	$slider_link_url 	= isset($meta['_slider_link_url'][0]) ? $meta['_slider_link_url'][0] : '';
	$slider_data			=	isset($meta['_slider_data'][0]) ? $meta['_slider_data'][0] : '';
	?>
	
	<p><strong>URL:</strong></p>
	<p>
		<input type="text" style="width:99%;" name="slider_link_url" value="<?php echo esc_attr( $slider_link_url ); ?>" />
	</p>
	
	<p><strong><?php echo of_get_local( 'slide_area' ); ?>:</strong></p>
	<p>

		<?php if ( $rotators ) : ?>
			
		<select name="slider_id" style="width:99%;text-transform:capitalize;">
			<?php foreach ( $rotators as $rotator => $size ) : ?>
				<option value="<?php echo $rotator; ?>" <?php selected( $slider_id, $rotator, true ); ?>><?php echo $rotator ?></option>
			<?php endforeach; ?>
		</select>

		<?php else : ?>
			<div style="color:red;">
				<?php of_get_local( 'slide_message' ); ?>
			</div>
		<?php endif; ?>
	</p>

	<?php
		$select = array(
			'title' => of_get_local('slide_title'),
			'desc' 	=> of_get_local('slide_desc'),
			'show' 	=> of_get_local('slide_show'),
			'hide' 	=> of_get_local('slide_hide')
		);
	?>
	
	<p><strong><?php echo of_get_local( 'slide_content' ); ?>:</strong></p>
	<p><select name="slider_data" style="width:99%;">
		<?php
			foreach ( $select as $key => $value ) {
				echo '<option value="'.$key.'" '. selected( $slider_data, $key, true ) .'>'. $value .'</option>';
			}
		?>
	</select></p>
	
	<?php 
}

// SAVE THE EXTRA GOODS FROM THE SLIDE
function of_slideshows_save_meta( $post_id, $post ) {
	
	if ( isset( $_POST['slider_link_url'] ) ) {
		update_post_meta( $post_id, '_slider_link_url', strip_tags( $_POST['slider_link_url'] ) );
	}
	
	if ( isset( $_POST['slider_id'] ) ) {
		update_post_meta( $post_id, '_slider_id', strip_tags( $_POST['slider_id'] ) );
	}

	if ( isset( $_POST['slider_data'] ) ) {
		update_post_meta( $post_id, '_slider_data', strip_tags( $_POST['slider_data'] ) );
	}

}

// ADMIN COLUMNS
function of_slideshows_columns( $columns ) {
	$columns = array(
		'cb'       => '<input type="checkbox" />',
		'image'    => of_get_local( 'image' ),
		'title'    => of_get_local( 'title' ),
		'ID'       => of_get_local( 'slide_id' ),
		'order'    => of_get_local( 'order' ),
		'link'     => of_get_local( 'link' ),
		'date'     => of_get_local( 'date' )
	);
	return $columns;
}

function of_slideshows_add_columns( $column ) {
	
	global $post;
	
	$edit_link 		= get_edit_post_link( $post->ID );
	$meta 				= of_get_post_custom();
	$slider_link 	= $meta['_slider_link_url'][0];
	$slider_id 		= $meta['_slider_id'][0];

	if ( $column == 'image' )
		echo '<a href="' . $edit_link . '" title="' . $post->post_title . '">' . get_the_post_thumbnail( $post->ID, array( 90, 90 ), array( 'alt' => $post->post_title  )  ) . '</a>';
	
	if ( $column == 'order' )
		echo '<a href="' . $edit_link . '">' . $post->menu_order . '</a>';
	
	if ( $column == 'ID' )
		echo $slider_id;
	
	if ( $column == 'link' )
		echo '<a href="' . $slider_link . '" target="_blank" >' . $slider_link . '</a>';		
}

// SHORTCODE
function of_slideshows_shortcode($atts, $content = null) {
	
	$slug = isset( $atts['slug'] ) ? $atts['slug'] : "attachments";
	$string = of_get_local( 'slide_shortcode' );
	
	if ( ! $slug ) {
		return apply_filters( 'of_slideshows_empty_shortcode', $string );
	}

	return of_slideshows( $slug );
}