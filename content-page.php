<?php
	$hide_title = of_get_post_meta('_hide_title');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'hide' != $hide_title ) : ?>
			<h1 class="entry-title" ><?php the_title(); ?></h1>
		<?php endif; ?>
		<div class="entry-meta">
			<?php
				$single_meta = of_get_option( 'single_meta' );
				if ( 'show' == $single_meta ) :
					of_posted_on();
				endif;
			?>
		</div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<footer>
		<?php the_tags( '', ', ', '' ); ?>
		<?php wp_link_pages(); ?>
	</footer>

</article>