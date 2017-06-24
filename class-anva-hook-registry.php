<?php

/**
 * Register hooks.
 */
class Anva_Hook_Registry {

	/**
	 * Registry.
	 *
	 * @var object
	 */
	private $registry;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->registery = array();
	}

	/**
	 * Add hooks.
	 */
	public function add_hook( $type, $name, $function, $priority = 10, $args = 1 ) {

		$type = strtolower( $type );

		if ( 'filter' != $type && 'action' != $type ) {
			return new WP_Error( '1', __( 'No proper hook type defined.', 'anva' ) );
		}

		if ( 'filter' === $type ) {
			$this->add_filter( $name, $function, $priority, $args );
		} else {
			$this->add_action( $name, $function, $priority, $args );
		}

		$hook_info = array(
			$type,
			$name,
			$function,
			$priority,
			$args,
		);

		$this->registry[] = $hook_info;
	}

	/**
	 * Add filter hook.
	 *
	 * @param [type] $name   [description]
	 * @param [type] $object [description]
	 * @param [type] $method [description]
	 */
	private function add_filter( $name, $function, $priority, $args ) {
		add_filter( $name, $function, $priority, $args );
	}

	/**
	 * Add action hook.
	 *
	 * @param [type] $name   [description]
	 * @param [type] $object [description]
	 * @param [type] $method [description]
	 */
	private function add_action( $name, $function, $priority, $args ) {
		add_action( $name, $function, $priority, $args );
	}
}
