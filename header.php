<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<?php
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) )
		header( 'X-UA-Compatible: IE=edge,chrome=1' );
	?>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php of_layout_before(); ?>
				
<div id="container">
	
	<header id="header">
		<div class="header-inner inner">
			
			<div class="header-top group">				
				<div id="brand" class="brand">
					<?php of_header_logo(); ?>
				</div>

				<div id="addon" class="addon">
					<?php of_header_addon(); ?>
				</div>
			</div><!-- .header-top (end) -->
			
			<div class="header-bottom">
				<?php of_menu(); ?>
			</div><!-- .header-bottom (end) -->

		</div><!-- .header-inner (end) -->
	</header><!-- #header (end) -->
	
	<?php of_featured(); ?>

	<?php of_content_before(); ?>