<?php

/*
 * Contact Widget
 */
class Anva_Quick_Contact extends WP_Widget {

	/* Create Widget Function */
	function Anva_Quick_Contact() {

		$widget_ops = array(
			'classname' => 'widget_anva_quick_contact',
			'description' => __( 'Shows a contact form.', 'anva' )
		);

		parent::__construct( 'Anva_Quick_Contact', 'Anva Quick Contact', $widget_ops );
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html 	= '';
		$title 	= apply_filters('widget_title', $instance['title']);
 		$text 	= apply_filters( 'widget_text', $instance['text'], $instance );
 		$phone 	= $instance['phone'];
 		$email 	= $instance['email'];
 		$link 	= $instance['link'];
 		$skype 	= $instance['skype'];
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
		?>
		
		<ul class="widget-contact-info">
			<li class="contact-phone">
				<i class="fa fa-phone"></i><?php echo $phone; ?>
			</li>
			<li class="contact-email">
				<i class="fa fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
			</li>
			<li class="contact-link">
				<i class="fa fa-reply"></i> <a href="<?php echo $link; ?>"><?php echo anva_get_local( 'get_in_touch' ); ?></a>
			</li>
			<li class="contact-skype">
				<i class="fa fa-skype"></i> <?php echo $skype; ?>
			</li>
			<li class="contact-icons">
				<?php anva_social_media(); ?>
			</li>
		</ul>
		<?php

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 							= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['text'] 			= $new_instance['text'];
		$instance['phone'] 			= $new_instance['phone'];
		$instance['email'] 			= $new_instance['email'];
		$instance['link'] 			= $new_instance['link'];
		$instance['skype'] 			= $new_instance['skype'];
		$instance['autop'] 			= $new_instance['autop'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => __( 'Quick Contact', 'anva' ),
			'text' 	=> '',
			'phone'	=> '',
			'email'	=> '',
			'link' 	=> '',
			'skype' => '',
			'autop' => false
		));
		
		/* Inputs */
		$title 		= $instance['title'];
		$text 		= format_to_edit($instance['text']);
		$phone 		= $instance['phone'];
 		$email 		= $instance['email'];
 		$link 		= $instance['link'];
 		$skype 		= $instance['skype'];
		$autop 		= $instance['autop'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo anva_get_local( 'title' ) . ' :'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<!-- Text -->
		<p>
			<textarea class="widefat" rows="8" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>
		
		<!-- Auto P -->
		<p>			
			<input class="widefat" <?php checked( $autop, 'on'); ?> id="<?php echo $this->get_field_id('autop'); ?>" name="<?php echo $this->get_field_name('autop'); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('autop'); ?>"><?php echo anva_get_local( 'add_autop' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>"><?php echo anva_get_local( 'phone' ) . ' :'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($phone); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php echo anva_get_local( 'email' ) . ' :'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php echo anva_get_local( 'link' ) . ' :'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('skype'); ?>"><?php echo anva_get_local( 'skype' ) . ' :'; ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo esc_attr($skype); ?>" />
		</p>

		<?php
	}
}