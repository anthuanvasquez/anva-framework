<?php

/*
 * Display for action of_header_content().
 */
function of_header_logo_default() {
	?>
	<div id="brand" class="brand">
		<a id="logo" class="logo" href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>">
			<?php
				printf(
					'<img src="%1$s" alt="%2$s" /><span class="sr-only">%2$s</span>',
					esc_url( of_get_option( 'logo' ) ),
					get_bloginfo( 'name' )
				);
			?>
		</a><!-- #logo (end) -->
	</div><!-- brand (end) -->
	<?php
}

/**
 * Display social media buttons in the header addon.
 *
 * @return void 
 */
function of_social_media_top() {
	echo of_social_media();
}

function of_featured_default() {
	if ( is_front_page() ) :
	?>
	<div id="featured">
		<div class="featured-inner">
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
		
		<a href="#" id="mobile-toggle" class="mobile-toggle toggle-button">
			<i class="fa fa-bars"></i>
			<span class="sr-only"><?php echo of_get_local( 'menu' ); ?></span>
		</a>
		
		<nav id="navigation" class="main-navigation group" role="navigation">
			<?php
				wp_nav_menu( array( 
					'theme_location'  => 'primary',
					'container'       => 'div',
					'container_class' => 'navigation-inner',
					'container_id'    => '',
					'menu_class'      => 'navigation-menu sf-menu group', // include superfish menu
					'menu_id'         => 'primary',
					'echo'            => true,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
				);
			?>
		</nav><!-- #navigation (end) -->

	<?php
		else :
			echo '<p>' . of_get_local( 'menu_message' ) . '</p>';
		endif;
}

function of_footer_copyright_default() {
	$footer_copyright = of_get_option( 'footer_copyright' );
	echo $footer_copyright;
}

function of_breadcrumbs_default() {
	$single_breadcrumb = of_get_option( 'single_breadcrumb' );
	if ( 1 == $single_breadcrumb ) {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			?>
			<div id="breadcrumbs">
				<div class="breadcrumbs-inner">
					<div class="breadcrumbs-content">
						<?php yoast_breadcrumb( '<p>', '</p>' ); ?>
					</div><!-- .breadcrumbs-content (end) -->
				</div><!-- .breadcrumbs-inner (end) -->
			</div><!-- #breadcrumbs (end) -->
			<?php
		}
	}
}

function of_main_before_default() {
	?>
	<div id="main">
		<div class="main-inner">
			<div class="main-content">
	<?php
}

function of_main_after_default() {
	?>
			</div><!-- .main-content -->
		</div><!-- .main-inner (end) -->
	</div><!-- #main (end) -->
	<?php
}
