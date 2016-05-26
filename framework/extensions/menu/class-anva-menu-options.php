<?php
/**
 * Add options to Appearance > Menus
 *
 * @author      Jason Bobich
 * @copyright   Copyright (c) Jason Bobich
 * @link        http://jasonbobich.com
 * @link        http://themeblvd.com
 * @package     Theme Blvd WordPress Framework
 */
class Anva_Menu_Options {

    /*--------------------------------------------*/
    /* Properties, private
    /*--------------------------------------------*/

    /**
     * A single instance of this class.
     *
     * @since 2.3.0
     */
    private static $instance = null;

    /*--------------------------------------------*/
    /* Constructor
    /*--------------------------------------------*/

    /**
     * Creates or returns an instance of this class.
     *
     * @since 2.3.0
     *
     * @return Anva_Menu_Options A single instance of this class.
     */
    public static function get_instance() {

        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor. Hook everything in.
     *
     * @since 2.3.0
     */
    public function __construct() {

        add_action( 'admin_enqueue_scripts', array($this, 'assets') );
        add_filter( 'wp_edit_nav_menu_walker', array($this, 'walker') );
        add_action( 'wp_update_nav_menu_item', array($this, 'save'), 10, 3 );

    }

    /*--------------------------------------------*/
    /* Methods
    /*--------------------------------------------*/

    /**
     * Menus Admin page scripts and styles
     *
     * @since 2.5.0
     */
    public function assets( $hook ) {
        if ( $hook == 'nav-menus.php' ) {
            wp_enqueue_style( 'anva_menus', esc_url( ANVA_FRAMEWORK_ADMIN_CSS . 'menu.css' ), null, ANVA_FRAMEWORK_VERSION );
            wp_enqueue_script( 'anva_menus', esc_url( ANVA_FRAMEWORK_ADMIN_JS . 'menu.js' ), array('jquery'), ANVA_FRAMEWORK_VERSION );
        }
    }

    /**
     * Include an extended version of WP's Walker_Nav_Menu_Edit
     * and apply it.
     *
     * @since 2.5.0
     */
    public function walker() {
        include_once( 'class-anva-nav-menu-edit.php' );
        return 'Anva_Nav_Menu_Edit';
    }

    /**
     * Save the options we've added to the menu builder.
     *
     * @since 2.5.0
     */
    public function save( $menu_id, $item_id, $args ) {

        global $_POST;

        if ( empty( $_POST['_anva_mega_menu'][$item_id] ) ) {
            update_post_meta( $item_id, '_anva_mega_menu', '0' );
        } else {
            update_post_meta( $item_id, '_anva_mega_menu', '1' );
        }

        if ( empty( $_POST['_anva_mega_menu_hide_headers'][$item_id] ) ) {
            update_post_meta( $item_id, '_anva_mega_menu_hide_headers', '0' );
        } else {
            update_post_meta( $item_id, '_anva_mega_menu_hide_headers', '1' );
        }

        if ( empty( $_POST['_anva_mega_menu_columns'][$item_id] ) ) {
            update_post_meta( $item_id, '_anva_mega_menu_columns', '' );
        } else {
            update_post_meta( $item_id, '_anva_mega_menu_columns', $_POST['_anva_mega_menu_columns'][$item_id] );
        }

        if ( empty( $_POST['_anva_bold'][$item_id] ) ) {
            update_post_meta( $item_id, '_anva_bold', '0' );
        } else {
            update_post_meta( $item_id, '_anva_bold', '1' );
        }

        if ( empty( $_POST['_anva_deactivate_link'][$item_id] ) ) {
            update_post_meta( $item_id, '_anva_deactivate_link', '0' );
        } else {
            update_post_meta( $item_id, '_anva_deactivate_link', '1' );
        }

        if ( empty( $_POST['_anva_placeholder'][$item_id] ) ) {
            update_post_meta( $item_id, '_anva_placeholder', '0' );
        } else {
            update_post_meta( $item_id, '_anva_placeholder', '1' );
        }

    }
}