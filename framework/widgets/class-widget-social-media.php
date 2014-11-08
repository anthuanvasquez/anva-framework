<?php

/* Social Icons Widget */
class Custom_Social_Media extends WP_Widget {

	/* Create Widget Function */
	function Custom_Social_Media() {

		$widget_ops = array(
			'classname' => 'widget_social_media',
			'description' => __('Muestra los iconos de las redes mas populares y una descripcion.', OF_DOMAIN)
		);

		$this->WP_Widget('Custom_Social_Media', 'Custom Social Media', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html 	= '';
		$title 	= apply_filters('widget_title', $instance['title']);
 		$text 	= apply_filters( 'widget_text', $instance['text'], $instance );
		$autop 	= $instance['autop'] ? 'true' : 'false';
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
 
		/* Text */
		echo '<div class="textwidget">';
			if ( 'true' == $autop ) {				
				echo wpautop($text);
			} else {
				echo $text;
			}
		echo '</div>';
		
		/* Show Social Media Icons */
		of_social_icons();

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 							= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['text'] 			= $new_instance['text'];
		$instance['autop'] 			= $new_instance['autop'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'text' 	=> '',
			'autop' => false
		));
		
		/* Inputs */
		$title 				= $instance['title'];
		$text 				= format_to_edit($instance['text']);
		$autop 				= $instance['autop'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo of_get_local( 'title' ) . ' :'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<!-- Text -->
		<p>
			<textarea class="widefat" rows="8" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>
		
		<!-- Auto P -->
		<p>			
			<input class="widefat" <?php checked( $autop, 'on'); ?> id="<?php echo $this->get_field_id('autop'); ?>" name="<?php echo $this->get_field_name('autop'); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('autop'); ?>">A&ntilde;adir p&aacute;rrafos autom&aacute;ticamente</label>
		</p>

		<?php
	}
}