<?php

/**
 * Customizer control extensions
 *
 * @since 1.0.0
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Add control for textarea
	 *
	 * @since 1.0.0
	 */
	class WP_Customize_Anva_Textarea extends WP_Customize_Control {

		public $type = 'textarea';
		
		public $statuses;

		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __( 'Default', 'anva' ) );
			parent::__construct( $manager, $id, $args );
		}

		public function to_json() {
			parent::to_json();
			$this->json['statuses'] = $this->statuses;
		}

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
			</label>
			<?php
		}

	}

	/**
	 * Add control to select font face
	 *
	 * @since 1.0.0
	 */
	class WP_Customize_Anva_Font_Face extends WP_Customize_Control {

		public $type = 'font_face';
		
		public $statuses;

		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __( 'Default', 'anva' ) );
			parent::__construct( $manager, $id, $args );
		}

		public function enqueue() {
			wp_enqueue_script( 'anva_customizer' );
			wp_enqueue_style( 'anva_customizer' );
		}

		public function to_json() {
			parent::to_json();
			$this->json['statuses'] = $this->statuses;
		}

		public function render_content() {
			if ( empty( $this->choices ) ) {
				return;
			}
			?>
			<label class="anva-font-face">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?>>
					<?php
					foreach ( $this->choices as $value => $label ) {
						printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $this->value(), $value, false ), $label );
					}
					?>
				</select>
			</label>
			<?php
		}

	}

	/**
	 * Add control to input Google font name
	 *
	 * @since 1.0.0
	 */
	class WP_Customize_Anva_Google_Font extends WP_Customize_Control {

		public $type = 'google_font';
		
		public $statuses;

		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __('Default', 'anva' ) );
			parent::__construct( $manager, $id, $args );
		}

		public function enqueue() {
			wp_enqueue_script( 'anva_customizer' );
			wp_enqueue_style( 'anva_customizer' );
		}

		public function to_json() {
			parent::to_json();
			$this->json['statuses'] = $this->statuses;
		}

		public function render_content() {
			?>
			<label class="anva-google-font">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
				<p><?php _e( 'Example', 'anva' ); ?>: <?php _e( 'Open Sans', 'anva' ); ?></p>
				<p><a href="<?php echo esc_url( 'http://www.google.com/webfonts' ); ?>" target="_blank"><?php _e( 'Browse Google Webfonts', 'anva' ); ?></a></p>
			</label>
			<?php
		}

	}

	/**
	 * Add control for divider
	 *
	 * @since 1.0.0
	 */
	class WP_Customize_Anva_Divider extends WP_Customize_Control {

		public $type = 'divider';
		
		public $statuses;

		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __('Default', 'anva' ) );
			parent::__construct( $manager, $id, $args );
		}

		public function render_content() {
			?>
			<div class="anva-divider"></div>
			<?php
		}

	}

}