<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php of_post_thumbnails( of_get_option( 'posts_thumb' ) ); ?>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<div class="entry-meta">
			<?php
				$single_meta = of_get_option( 'single_meta' );
				if ( 'show' == $single_meta ) :
					of_posted_on();
				endif;
			?>
		</div>
	</header>

	<div class="entry-container group">
		<div class="entry-summary">
			<?php of_excerpt_limit(); ?>
			<a class="button" href="<?php the_permalink(); ?>">
				<?php echo of_get_local( 'read_more' ); ?>
			</a>
		</div>
	</div>
</article>