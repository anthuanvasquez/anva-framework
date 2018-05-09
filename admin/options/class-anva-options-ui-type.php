<?php
/**
 * Definition of the Anva_Options_UI_Type class.
 *
 * @package AnvaFramework
 */

/**
 * Anva Options UI Type.
 */
class Anva_Options_UI_Type {

	/**
	 * A single instance of this class.
	 *
	 * @var object
	 */
	public static $instance = null;

	/**
	 * Option ID.
	 *
	 * @var array
	 */
	public $args = array();

	/**
	 * Returned html output.
	 *
	 * @var string
	 */
	public $output = '';

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct( $args ) {
		$this->args = $args;
	}

	public function toHtml() {
		return $this->output;
	}

	protected function get_id() {
		return $this->args['id'];
	}

	protected function get_name() {
		return $this->args['name'];
	}

	protected function get_value() {
		return $this->args['value'];
	}

}

class Anva_Options_UI_Text_Input extends Anva_Options_UI_Type {

	function __construct( $args ) {
    	parent::__construct( $args );
	}

	public function get_option() {

		$output = sprintf(
			'<input id="%s" class="anva-input anva-input-text" name="%s" type="text" value="%s" %s />',
			esc_attr( $this->args['id'] ),
			esc_attr( $this->args['name'] . '[' . $this->args['value'] . ']' ),
			esc_attr( $this->args['value'] ),
			$this->args['placeholder']
		);

		return $output;
	}

}
