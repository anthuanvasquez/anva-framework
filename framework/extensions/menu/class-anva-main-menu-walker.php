<?php

/**
 * Create new walker for WP's wp_nav_menu function.
 * Takes into account mega menus and icons.
 *
 * @since 2.5.0
 */
class Anva_Main_Menu_Walker extends Walker_Nav_Menu {

    private $doing_mega = false;
    private $mega_col = '';
    private $count = 0;
    private $show_headers = false;
    private $current_header = NULL;

    /**
     * Start level
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {

        if ( $this->doing_mega ) {
            if ( $depth == 0 ) {
                $output .= "<div class=\"mega-menu-content style-2 clearfix\">\n";
            } else if ( $depth == 1 ) {
                $output .= "<div class=\"mega-menu-column $this->mega_col\">\n";
            } else {
                return; // Additional sub levels not allowed past 1 for mega menus
            }
        }

        if ( ! $this->doing_mega ) {
            $output .= '<ul class="sub-menu">';
        } else if ( $depth != 0 ) {
            $output .= '<ul class="sub-menu mega-sub-menu level-1">';
        }

        if ( $this->doing_mega && $depth == 1 ) {

            // Putting the 2nd level menu item as the first,
            // prominent item in the 3rd level.
            if ( $this->current_header ) {

                if ( get_post_meta($this->current_header->ID, '_anva_deactivate_link', true) || get_post_meta($this->current_header->ID, '_anva_placeholder', true) ) {

                    $class = 'menu-item-has-children';

                    if ( get_post_meta($this->current_header->ID, '_anva_placeholder', true) ) {
                        $class .= ' placeholder';
                    }

                    $output .= sprintf( '<li class="%s"><span class="mega-menu-heading">%s</span></li>', $class, apply_filters( 'the_title', $this->current_header->title, $this->current_header->ID ) );

                } else {

                    $args->before = '<span class="mega-menu-heading">';
                    $args->after = '</span>';

                    parent::start_el( $output, $this->current_header, 2, $args );
                    parent::end_el( $output, $this->current_header, 2, $args );

                    $args->before = $args->after = '';

                }

                $output = trim( $output );
                $output = substr_replace( $output, "<ul class=\"sub-menu mega-sub-menu level-2\">\n", -5 ); // Replace last </li> with opening <ul>
            }
        }

    }

    /**
     * End level
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {

        if ( $this->doing_mega ) {
            if ( $depth == 0 ) {
                $output .= "</div><!-- .mega-menu-content (end) -->\n";
            } else if ( $depth == 1 ) {

                if ( $this->show_headers ) {
                    $output .= "</ul><!-- .mega-sub-menu.level-2 (end) -->\n";
                    $output .= "</li><!-- .menu-item-has-children (end) -->\n";
                }

                $output .= "</ul><!-- .mega-sub-menu.level-1 (end) -->\n";
                $output .= "</div><!-- .mega-menu-column (end) -->\n";
                $this->count++;

            } else {
                return; // Additional sub levels not allowed past 1 for mega menus
            }
        } else {
            $output .= '</ul>';
        }

    }

    /**
     * Start nav element
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        // Activate mega menu, if enabled
        if ( $depth == 0 ) {

            $this->doing_mega = false;
            $this->show_headers = false;
            $this->current_header = null;
            $this->count = 0;

            if ( $args->theme_location == apply_filters('anva_primary_menu_location', 'primary') && get_post_meta($item->ID, '_anva_mega_menu', true) ) {

                $this->doing_mega = true;
                $this->mega_col = get_post_meta( $item->ID, '_anva_mega_menu_columns', true );

                if ( ! get_post_meta($item->ID, '_anva_mega_menu_hide_headers', true) ) {
                    $this->show_headers = true;
                }
            }
        }

        // If level 2 header of mega menu, skip and store it to
        // be displayed as a title for level 3.
        if ( $this->doing_mega && $depth == 1 ) {
            if ( $this->show_headers ) {
                $this->current_header = $item;
            }
            return;
        }

        // Add sub indicator icons, if necessary
        if ( in_array('menu-item-has-children', $item->classes) && ( $depth == 0 || ! $this->doing_mega ) ) {

            $direction = 'down';

            if ( $depth > 0 ) {
                if ( is_rtl() ) {
                    $direction = 'left';
                } else {
                    $direction = 'right';
                }
            }

            //$args->link_after = apply_filters('anva_menu_sub_indicator', sprintf( '<i class="sf-sub-indicator fa fa-caret-%s"></i>', $direction ), $direction );

        }

        // Deactivate link, if enabled
        if ( $depth > 0 && ( get_post_meta($item->ID, '_anva_deactivate_link', true) || get_post_meta($item->ID, '_anva_placeholder', true) ) ) {

            $class = 'menu-item menu-item-'.$item->ID;

            if ( get_post_meta($item->ID, '_anva_placeholder', true) ) {
                $class .= ' placeholder';
            }

            if ( get_post_meta($item->ID, '_anva_bold', true) ) {
                $class .= ' bold';
            }

            $output .= sprintf('<li id="menu-item-%s" class="%s"><span class="menu-btn">%s</span></li>', $item->ID, $class, apply_filters( 'the_title', $item->title, $item->ID ) );
            return;
        }

        // Add bold class
        if ( get_post_meta($item->ID, '_anva_bold', true) ) {
            $item->classes[] = 'bold';
        };

        parent::start_el( $output, $item, $depth, $args, $id );

        $args->link_after = '';

    }

    /**
     * End nav element
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ) {

        // Add "has-mega-menu" class to list item holding mega menu
        if ( $this->doing_mega && $depth == 0 ) {
            $output = str_replace( sprintf('<li id="menu-item-%s" class="', $item->ID), sprintf('<li id="menu-item-%s" class="mega-menu mega-col-%s ', $item->ID, $this->count), $output);
        }

        if ( $this->doing_mega && $depth == 1 ) {
            $output = str_replace( sprintf('<li id="menu-item-%s" class="', $item->ID), sprintf('<li id="menu-item-%s" class="mega-menu-title ', $item->ID), $output);
        }

        if ( ! $this->doing_mega || $depth != 1 ) {
            $output .= "</li>\n";
        }
    }

}