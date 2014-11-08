<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
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
		<?php of_post_thumbnails( of_get_option( 'single_thumb' ) ); ?>
		<?php the_content(); ?>
	</div>
</article>