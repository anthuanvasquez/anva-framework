<div class="entry-about-author">
	<div class="entry-about-author-inner">
		<div class="entry-about-author-content">
			<div class="row grid-columns">
				<div class="author-gravatar col-sm-2">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), 180 ); ?>
				</div>
				<div class="author-description col-sm-10">
					<h3><?php echo get_the_author(); ?></h3>
					<div class="author-info clearfix">
						<?php wpautop( the_author_meta( 'description' ) ); ?>
					</div>
					<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php
							echo sprintf(
								of_get_local('posts_by_author') . ' %s %s',
								get_the_author(),
								'<span class="meta-nav">&rarr;</span>'
							);
						?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>