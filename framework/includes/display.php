<?php

function of_ie_browser_message() {
	$string = of_get_local( 'browsehappy' );
	$url = esc_url( 'http://browsehappy.com/' );
	?>
	<!--[if lt IE 9]><p class="browsehappy"><?php echo sprintf( $string, $url ); ?></p><![endif]-->
	<?php
}


/*
 * Default display for action of_header_logo().
 */
function of_header_logo_default() {
	?>
	<a id="logo" class="logo" href="<?php echo home_url(); ?>">
		<?php
			$string = '<img src="%s" alt="%s" />';
			$logo = of_get_option( 'logo', 'logo' );
			$name = get_bloginfo( 'name' );
			echo sprintf( $string, $logo, $name );
		?>
		<span class="screen-reader-text"><?php echo $name; ?></span>
	</a>
	<?php
}

/**
 * Display social media buttons in the header addon.
 *
 * @return void 
 */
function of_social_icons() {
	echo of_social_media();
}

function of_featured_default() {
	if ( is_front_page() ) :
	?>
	<div id="featured">
		<div class="featured-inner inner">
			<?php
				if ( function_exists( 'of_slideshows_slides' ) ) {
					echo of_slideshows_slides( 'homepage' );
				}
			?>
		</div><!-- .featured-inner (end) -->
	</div><!-- #featured (end) -->
	<?php
	endif;
}

function of_menu_default() {
	if ( has_nav_menu( 'primary' ) ) :
	?>

	<div class="mobile-navigation">
		<a href="#" id="mobile-navigation" class="toggle-button">
			<i class="fa fa-bars"></i>
			<span class="screen-reader-text"><?php echo of_get_local( 'menu' ); ?></span>
		</a>
	</div><!-- .mobile-navigation (end) -->

	<nav id="main-navigation" class="main-navigation horizontal-navigation group" role="navigation">
		<?php
			wp_nav_menu( array( 
				'theme_location'  => 'primary',
				'container'       => 'div',
				'container_class' => 'navigation-inner inner',
				'container_id'    => '',
				'menu_class'      => 'navigation-menu sf-menu group', // include superfish menu
				'menu_id'         => 'primary',
				'echo'            => true,
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
			);
		?>
	</nav><!-- #main-navigation (end) -->
	
	<?php
		else :
			echo '<p>' . of_get_local( 'menu_message' ) . '</p>';
		endif;
}

function of_apple_touch_icon() {
	?>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/assets/images/favicon.png'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon.png'; ?>" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon-72x72.png'; ?>" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon-114x114.png'; ?>" />
	<?php
}

function of_custom_css() {
	$custom_css = of_get_option( 'custom_css' );
	echo '<style type="text/css">'.$custom_css.'</style>';
}

function of_footer_text_default() {
	echo '<p>';
	$string = '<strong>%s</strong> &copy; %d %s %s %s <a id="gotop" href="#"><i class="fa fa-chevron-up"></i> <span class="screen-reader-text">Go Top</span></a>';
	$name = get_bloginfo( 'name' );
	$date = date( 'Y' );
	$copyright = of_get_local( 'footer_copyright' );
	$text = of_get_local( 'footer_text' );
	$author = '<a href="'. esc_url( 'http://3mentes.com/') .'">3mentes.</a>';
	echo sprintf( $string, $name, $date, $copyright, $text, $author );
	echo '</p>';
}

function of_layout_before_default() {
	?>
	<div id="wrapper">
	<?php
}

function of_layout_after_default() {
	?>
	</div><!-- #wrapper (end) -->
	<?php
}

function of_breadcrumbs() {
	$single_breadcrumb = of_get_option( 'single_breadcrumb' );
	if ( 1 == $single_breadcrumb ) {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			?>
			<div id="breadcrumbs">
				<div class="breadcrumbs-inner inner">
					<?php yoast_breadcrumb( '<p>', '</p>' ); ?>
				</div>
			</div><!-- #breadcrumbs (end) -->
			<?php
		}
	}
}

function of_content_before_default() {
	?>
	<div id="content">
		<div class="content-inner inner">
	<?php
}

function of_content_after_default() {
	?>
			</div><!-- .content-inner (end) -->
	</div><!-- #content (end) -->
	<?php
}

function of_sidebar_layout_before_default() {
	$sidebar = of_get_post_meta('_sidebar_column');
	if ( 'left' == $sidebar || 'double' == $sidebar ) {
		get_sidebar( 'left' );
	} elseif ( 'double_left' == $sidebar ) {
		get_sidebar( 'left' );
		get_sidebar( 'right' );
	}
}

function of_sidebar_layout_after_default() {
	$sidebar = of_get_post_meta('_sidebar_column');
	if ( 'right' == $sidebar || 'double' == $sidebar ) {
		get_sidebar( 'right' );
	} elseif ( 'double_right' == $sidebar ) {
		get_sidebar( 'left' );
		get_sidebar( 'right' );
	}
}

function of_navigation() {	
	$nav = of_get_option( 'navigation' );
	switch( $nav ) :
	case 'off_canvas_navigation': ?>
	<script type="text/javascript">
	jQuery(document).ready( function() {
		// Off Canvas Navigation
		var offCanvas = jQuery('#off-canvas-button'),
			offCanvasNav = jQuery('#off-canvas'),
			pageCanvas = jQuery('#container'),
			bodyCanvas = jQuery('body');

		bodyCanvas.addClass('js-ready');

		offCanvas.click( function(e) {
			e.preventDefault();
			offCanvasNav.toggleClass('is-active');
			pageCanvas.toggleClass('is-active');
		});

		// Hide Off Canvas Nav on Windows Resize
		jQuery(window).resize( function() {
			var off_canvas_nav_display = jQuery('#off-canvas').css('display');
			if( off_canvas_nav_display === 'block' ) {
				jQuery('#off-canvas').removeClass('is-active');
				jQuery('#container').removeClass('is-active');
			}
		});
	});
	</script>
	<?php break;
	case 'toggle_navigation': ?>
	<script type="text/javascript">
	jQuery(document).ready( function() {
		// ---------------------------------------------------------
		// Show main navigation with slidetoggle effect
		// ---------------------------------------------------------
		jQuery('#mobile-navigation').click( function(e) {
			e.preventDefault();
			jQuery('#main-navigation').slideToggle();
		});

		// ---------------------------------------------------------
		// Show main navigation if is hide
		// ---------------------------------------------------------
		jQuery(window).resize( function() {
			var nav_display = jQuery('#main-navigation').css('display');
			if( nav_display === 'none' ) {
				jQuery('#main-navigation').css('display', 'block');
			}
		});
	});
	</script>
	<?php break;
	endswitch;
}

function of_debug_queries() {
	// if ( current_user_can( 'administrator' ) ) {
	// echo '<div class="browsehappy">Page generated in '.timer_stop(1).' seconds with '.get_num_queries().' database queries.</div>';
	// }
}