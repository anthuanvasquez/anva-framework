<?php
/**
 * The template file for header.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php do_action( 'anva_wp_head' ); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); anva_page_transition_data(); ?>>

<?php do_action( 'anva_before' ); ?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">

	<?php do_action( 'anva_top_before' ); ?>

	<?php do_action( 'anva_header_above' ); ?>

	<!-- HEADER (start) -->
	<header id="header" <?php anva_header_class(); ?>>
		<?php do_action( 'anva_header' ); ?>
	</header><!-- HEADER (end) -->

	<?php
		// Below Header
		do_action( 'anva_header_below' );

		// After Top
		do_action( 'anva_top_after' );

		// Featured
		do_action( 'anva_featured_before' );
		do_action( 'anva_featured' );
		do_action( 'anva_featured_after' );

		// Content Before
		do_action( 'anva_content_before' );
	?>

	<!-- CONTENT (start) -->
	<section id="content">
		<div class="content-wrap">
			<?php do_action( 'anva_above_layout' ); ?>
