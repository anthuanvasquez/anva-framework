<?php
/**
 * The template for displaying the header.
 *
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-loader="3">

<?php anva_before(); ?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">

<!-- CONTAINER (start) -->
<div id="container">
	
	<?php anva_top_before(); ?>

	<!-- TOP (start) -->
	<header id="top">

		<?php anva_header_above(); ?>

		<div id="header">
			<div class="header-content">	
				<div class="container clearfix">
					<?php anva_header_logo(); ?>
					<?php anva_header_extras(); ?>
				</div><!-- .header-content (end) -->
			</div><!-- .container (end) -->
			
			<?php anva_header_primary_menu(); ?>

		</div><!-- #header (end) -->

		<?php anva_header_below(); ?>

	</header><!-- TOP (end) -->

	<?php
		// After Top
		anva_top_after();

		// Featured
		anva_featured_before();
		anva_featured();
		anva_featured_after();
	?>
	
	<?php anva_content_before(); ?>

	<!-- CONTENT (start) -->
	<section id="content">
		<div class="main-content">
			<div class="container clearfix">
				<?php anva_breadcrumbs(); ?>
				<?php anva_above_layout(); ?>