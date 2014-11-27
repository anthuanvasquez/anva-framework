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
		<div class="clearfix"></div>
		<?php the_tags( of_get_local('tags') . ': ', ', ' ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . of_get_local('pages') . ': ', 'after' => '</div>' ) ); ?>
		<?php edit_post_link( of_get_local( 'edit_post' ), '<span class="edit-link">', '</span>' ); ?>
		
		<?php
			// About author
			if ( 'hide' != of_get_option( 'single_author' ) ) :
				get_template_part( 'templates/content', 'about_author' );
			endif;

			// Navigation
			if ( 'hide' != of_get_option( 'single_nav' ) ) :
				of_post_navigation();
			endif;

			// Related Posts
			if ( 'hide' != of_get_option( 'single_related' ) ) :
				of_related_posts();
			endif;
		?>
	</div>
</article>