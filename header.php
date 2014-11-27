<?php
/**
 * The Header for our theme.
 *
 * WARNING: It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @author		Anthuan Vasquez
 * @copyright	Copyright (c) Anthuan Vasquez
 * @link			http://anthuanvasquez.net
 * @package  	CodeTheme WordPress Framework
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	// Before layout
	of_layout_before();
?>
				
<div id="wrapper">
	<div id="container">

	<?php
		// Before header
		of_header_before();
	?>

	<div id="top">
		<header id="header" role="banner">
			<div class="header-inner">

				<div class="header-content">
					<div class="header-content-inner group">
						<?php
							/**
					 		 * Header elements.
					 		 */
							of_header_top();
							of_header_content();
							of_header_menu();
						?>
					</div><!-- .header-content-inner (end) -->
				</div><!-- .header-content (end) -->

			</div><!-- .header-inner (end) -->
		</header><!-- #header (end) -->
	</div><!-- #top (end) -->
	
	<?php
		// After header
		of_header_after();

		/*
		 * Display featured elements.
		 */
		of_featured_before();
		of_featured();
		of_featured_after();
	?>

	<?php
		// After main
		of_main_before();

		// Breadcrumbs
		of_breadcrumbs();
	?>