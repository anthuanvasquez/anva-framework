<?php

/**
 * Archive titles
 * 
 * @since 1.0.0
 */
function anva_archive_title() {

	if ( is_category() ) :
		single_cat_title();

	elseif ( is_tag() ) :
		single_tag_title();

	elseif ( is_author() ) :
		printf( anva_get_local( 'author' ) . ' %s', '<span class="vcard">' . get_the_author() . '</span>' );

	elseif ( is_day() ) :
		printf( anva_get_local( 'day' ) . ' %s', '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		printf( anva_get_local( 'month' ) . ' %s', '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		printf( anva_get_local( 'year' ) . ' %s', '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		echo anva_get_local( 'asides' );

	elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
		echo anva_get_local( 'galleries' );

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		echo anva_get_local( 'images' );

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		echo anva_get_local( 'videos' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		echo anva_get_local( 'quotes' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		echo anva_get_local( 'links' );

	elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
		echo anva_get_local( 'status' );

	elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
		echo anva_get_local( 'audios' );

	elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
		echo anva_get_local( 'chats' );

	else :
		echo anva_get_local( 'archives' );
	endif;

}

/**
 * Posted on
 * 
 * @since 1.0.0
 */
function anva_posted_on() {
	
	// Get the time
	$time_string = '<time class="entry-date published" datetime="%1$s"><i class="fa fa-calendar"></i> %2$s</time>';
	
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="entry-date-updated updated" datetime="%3$s"><i class="fa fa-calendar"></i> %4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'jS F Y' ) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date( 'jS F Y' ) )
	);

	// Get comments number
	$num_comments = get_comments_number();

	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __( 'No Comments', 'anva' );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __( ' Comments', 'anva' );
		} else {
			$comments = __( '1 Comment', 'anva' );
		}
		$write_comments = '<a href="' . get_comments_link() . '"><span class="leave-reply">' . $comments . '</span></a>';
	} else {
		$write_comments =  __( 'Comments closed', 'anva' );
	}

	$sep = ' / ';

	printf(
		'<div class="entry-meta clearfix">
			<span class="posted-on">%1$s</span>
			<span class="sep">%5$s</span>
			<span class="byline"><i class="fa fa-user"></i> %2$s</span>
			<span class="sep">%5$s</span>
			<span class="category"><i class="fa fa-bars"></i> %3$s</span>
			<span class="sep">%5$s</span>
			<span class="comments-link"><i class="fa fa-comments"></i> %4$s</span>
		</div><!-- .entry-meta (end) -->',
		sprintf(
			'%1$s', $time_string
		),
		sprintf(
			'<span class="author vcard"><a class="url fn" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		),
		sprintf(
			'%1$s', get_the_category_list( ', ' )
		),
		sprintf(
			'%1$s', $write_comments
		),
		sprintf(
			'%1$s', $sep
		)
	);
}

/**
 * Display social media profiles
 * 
 * @since 1.0.0
 */
function anva_social_media( $buttons = array(), $style = null ) {

	$classes = array();

	// Set up buttons
	if ( ! $buttons ) {
		$buttons = anva_get_option( 'social_media' );
	}

	// If buttons haven't been sanitized return nothing
	if ( is_array( $buttons ) && isset( $buttons['includes'] ) ) {
		return null;
	}

	// Set up style
	if ( ! $style ) {
		$style = anva_get_option( 'social_media_style', 'light' );
		$classes[] = 'social-' . $style;
	}

	$classes = implode( ' ', $classes );

	// Social media sources
	$profiles = anva_get_social_media_profiles();

	// Start output
	$output = null;
	if ( is_array( $buttons ) && ! empty ( $buttons ) ) {

		$output .= '<div class="social-media">';
		$output .= '<div class="social-content">';
		$output .= '<ul class="social-icons">';

		foreach ( $buttons as $id => $url ) {

			// Link target
			$target = '_blank';
			
			// Link Title
			$title = '';
			if ( isset( $profiles[$id] ) ) {
				$title = $profiles[$id];
				if ( $id == 'email' ) {
					$id = 'envelope-o';
				}
			}

			$output .= sprintf( '<li><a href="%1$s" class="social-icon social-%3$s %5$s" target="%4$s"><i class="fa fa-%3$s"></i><span class="sr-only">%2$s</span></a></li>', $url, $title, $id, $target, $classes );
		}

		$output .= '</ul><!-- .social-icons (end) -->';
		$output .= '</div><!-- .social-content (end) -->';
		$output .= '</div><!-- .social-media (end) -->';
	}
	
	return apply_filters( 'anva_social_media_buttons', $output );

}

/**
 * Header search
 */
function anva_site_search() {
	if ( class_exists( 'Woocommerce' ) ) :
		anva_get_product_search_form();
	else :
		anva_get_search_form();
	endif;
}

/**
 * Post navigation
 * 
 * @since 1.0.0
 */
function anva_post_nav() {
	
	$single_navigation = anva_get_option( 'single_navigation', 'show' );
	if ( 'show' != $single_navigation ) {
		return;
	}

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="post-navigation" role="navigation">
		<ul class="pager navigation-content clearfix">
			<?php
				previous_post_link( '<li class="previous">%link</li>', anva_get_local( 'prev' ) );
				next_post_link( '<li class="next">%link</li>', anva_get_local( 'next' ) );
			?>
		</ul>
	</nav><!-- .post-navigation (end) -->
	<div class="line"></div>
	<?php
}

/**
 * Mini posts list
 * 
 * @since 1.0.0
 */
function anva_mini_posts_list( $number = 3, $orderby = 'date', $order = 'date', $thumbnail = true ) {
	
	global $post;

	$output = '';

	$args = array(
		'posts_per_page' 	=> $number,
		'post_type' 			=> array( 'post' ),
		'orderby'					=> $orderby,
		'order'						=> $order
	);

	$query = anva_get_query_posts( $args );
	
	$output .= '<ul class="widget-posts-list">';

	while ( $query->have_posts() ) {
		$query->the_post();

		if ( $thumbnail ) {
			$output .= '<li class="sm-post small-post clearfix">';
			$output .= '<div class="entry-image">';
			$output .= '<a href="'. get_permalink() .'">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a>';
			$output .= '</div><!-- .entry-image (end) -->';
		} else {
			$output .= '<li class="sm-post small-post clearfix">';
		}

		$output .= '<div class="entry-c">';
		$output .= '<div class="entry-title">';
		$output .= '<h4><a href="'. get_permalink() .'">' . get_the_title() . '</a></h4>';
		$output .= '</div><!-- .entry-title (end) -->';
		$output .= '<div class="entry-meta">';
		$output .= '<span class="date">' . get_the_time( 'jS F Y' ) . '</span>';
		$output .= '</div><!-- .entry-meta (end) -->';
		$output .= '</div><!-- .entry-c (end) -->';
		$output .= '</li><!-- .mini-posts (end) -->';
	}

	wp_reset_postdata();

	$output .= '</ul>';

	echo $output;
	
}

/**
 * Blog post author
 * 
 * @since 1.0.0
 */
function anva_post_author() {
	
	$single_author = anva_get_option( 'single_author', 'hide' );
	if ( 'show' != $single_author ) {
		return;
	}

	global $post;
	$id 		= $post->post_author;
	$avatar = get_avatar( $id, '96' );
	$url 		= get_the_author_meta( 'user_url', $id );
	$name 	= get_the_author_meta( 'display_name', $id );
	$desc 	= get_the_author_meta( 'description', $id );
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php printf( 'Posted by <span><a href="%1$s">%2$s</a></span>', esc_url( $url ), esc_html( $name ) ); ?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="author-image">
				<?php echo $avatar ; ?>
			</div>
			<div class="author-description">
				<?php echo wpautop( esc_html( $desc ) ); ?>
			</div>
		</div>
	</div><!-- .panel (end) -->
	<div class="line"></div>
	<?php
}

function anva_post_tags() {
	$classes = 'entry-tags clearfix';
	if ( is_single() )
		$classes .= ' bottommargin';
	?>
	<span class="<?php echo esc_attr( $classes ); ?>">
		<?php the_tags( '<i class="fa fa-tags"></i> ', ' ' ); ?>
	</span><!-- .entry-tags (end) -->
	<?php
}

/**
 * Blog post share
 * 
 * @since 1.0.0
 */
function anva_post_share() {
	
	$single_share = anva_get_option( 'single_share', 'show' );
	if ( 'show' != $single_share ) {
		return;
	}

	if ( is_single() ) :
	?>
	<div class="social-share noborder clearfix">
		<span><?php _e( 'Share this Post:', 'anva' ); ?></span>
		<div>
			<a href="#" class="social-icon social-noborder social-facebook">
				<i class="fa fa-facebook"></i>
			</a>
			<a href="#" class="social-icon social-noborder social-twitter">
				<i class="fa fa-twitter"></i>
			</a>
			<a href="#" class="social-icon social-noborder social-pinterest">
				<i class="fa fa-pinterest"></i>
			</a>
			<a href="#" class="social-icon social-noborder social-google-plus">
				<i class="fa fa-google-plus"></i>
			</a>
			<a href="#" class="social-icon social-noborder social-rss">
				<i class="fa fa-rss"></i>
			</a>
			<a href="#" class="social-icon social-noborder social-envelope">
				<i class="fa fa-envelope"></i>
			</a>
		</div>
	</div><!-- .social-share (end) -->
	<?php
	endif;
}

/**
 * Blog post related
 * 
 * @since 1.0.0
 */
function anva_post_related() {
	
	$single_related = anva_get_option( 'single_related', 'hide' );
	if ( 'show' != $single_related ) {
		return;
	}

	global $post;
	?>
	<h3><?php _e( 'Related Posts', 'anva' ); ?></h3>
	<div class="related-posts clearfix">
	<?php

	$limit = 4;
	$count = 1;
	$column = 2;
	$categories = get_the_category( $post->ID );

	$open_row = '<div class="grid_6 nomarginbottom">';
	$close_row = '</div><!-- .grid_6 (end) -->';

	if ( $categories ) :
		
		$ids = array();
	
		foreach ( $categories as $cat ) {
			$ids[] = $cat->term_id;
		}
		
		$query_args = array(
			'category__in' => $ids,
			'post__not_in' => array( $post->ID ),
			'posts_per_page' => $limit,
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand'
		);
	
		$query = anva_get_query_posts( $query_args );
	
		if ( $query->have_posts() ) : ?>
			
			<?php while ( $query->have_posts() ) :
				$query->the_post(); ?>

				<?php if ( 1 == $count ): echo $open_row; endif ?>
				
				<div class="md-post clearfix">
					<div class="entry-image">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'blog_md' ); ?>
						</a>
					</div><!-- .entry-image (end) -->
					<div class="entry-c">
						<div class="entry-title">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</div>
						<div class="entry-meta clearfix">
							<span><i class="fa fa-calendar"></i> <?php the_time( 'jS F Y' ); ?></span>
							<span class="sep">/</span>
							<span><a href="<?php the_permalink(); ?>/#comments"><i class="fa fa-comments"></i> <?php echo get_comments_number(); ?></a></span>
						</div>
						<div class="entry-content">
							<?php anva_excerpt( 90 ); ?>
						</div>
					</div><!-- .entry-c (end) -->
				</div><!-- .md-post (end) -->

				<?php if ( 0 == $count % $column ): echo $close_row; endif ?>
				<?php if ( $count % $column == 0 && $limit != $count ) : echo $open_row; endif; ?>

				<?php $count++; ?>

			<?php endwhile; ?>
			
			<?php if ( ( $count - 1 ) != $limit ) : echo $close_row; endif; ?>

		<?php endif;
	endif;
	wp_reset_postdata();
	?>
	</div><!-- .related-posts (end) -->
	<?php
}

/**
 * Blog post pagination
 * 
 * @since 1.0.0
 */
function anva_pagination( $query = '' ) {

	if ( empty( $query ) ) :
	?>
	<ul id="nav-posts" class="pager clearfix">
		<li class="previous"><?php previous_posts_link( anva_get_local( 'prev' ) ); ?></li>
		<li class="next"><?php next_posts_link( anva_get_local( 'next' ) ); ?></li>
	</ul>
	<?php
	else : ?>
	<ul id="nav-posts" class="pager clearfix">
		<li class="previous"><?php previous_posts_link( anva_get_local( 'prev'  ), $query->max_num_pages ); ?></li>
		<li class="next"><?php next_posts_link( anva_get_local( 'next'  ), $query->max_num_pages ); ?></li>
	</ul>
	<?php
	endif;
}

/**
 * Blog post pagination number
 * 
 * @since 1.0.0
 */
function anva_num_pagination( $pages = '', $range = 2 ) {
	
	$showitems = ( $range * 2) + 1;  
	
	global $paged;
	
	if ( empty( $paged ) ) $paged = 1;

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}
	
	if ( 1 != $pages ) {
		echo "<nav id='pagination'>";
		echo "<ul class='pagination clearfix'>";
			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
			
			if ( $paged > 1 && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( 1 != $pages &&( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) ) {
					echo ($paged == $i) ? "<li class='active'><a href='#'>".$i."<span class='sr-only'>(current)</span></a></li>" : "<li><a href='".get_pagenum_link( $i )."'>".$i."</a></li>";
				}
			}

			if ( $paged < $pages && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";  
			
			if ( $paged < $pages - 1 &&  $paged+$range - 1 < $pages && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link( $pages )."'>&raquo;</a></li>";
		echo "</ul>\n";
		echo "</nav>";
	}
}

/**
 * Blog comment pagination
 * 
 * @since 1.0.0.
 */
function anva_comment_pagination() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav id="comment-nav" class="pager comment-navigation" role="navigation">
		<div class="previous nav-previous"><?php previous_comments_link( anva_get_local( 'comment_prev' ) ); ?></div>
		<div class="next nav-next"><?php next_comments_link( anva_get_local( 'comment_next' ) ); ?></div>
	</nav><!-- #comment-nav-above (end) -->
	<?php
	endif;
}

/**
 * Contact form
 */
function anva_contact_form() {
	
	global $email_sended_message;

	// Set random values to set random questions
	$a = rand(1, 9);
	$b = rand(1, 9);
	$s = $a + $b;
	$answer = $s;
	
	?>
	<div class="contact-form-container">
		
		<?php if ( ! empty( $email_sended_message ) ) : ?>
			<div id="email_message" class="alert alert-warning"><?php echo $email_sended_message; ?></div>
		<?php endif; ?>

		<form id="contactform" class="contact-form"  role="form" method="post" action="<?php the_permalink(); ?>#contactform">

			<div class="form-name form-group">
				<label for="cname" class="control-label"><?php echo anva_get_local( 'name' ); ?>:</label>
				<input id="name" type="text" placeholder="<?php echo anva_get_local( 'name_place' ); ?>" name="cname" class="form-control requiredField" value="<?php if ( isset( $_POST['cname'] ) ) echo esc_attr( $_POST['cname'] ); ?>">
			</div>
			
			<div class="form-email form-group">
				<label for="cemail" class="control-label"><?php echo anva_get_local( 'email' ); ?>:</label>
				<input id="email" type="email" placeholder="<?php _e('Correo Electr&oacute;nico', 'anva'); ?>" name="cemail" class="form-control requiredField" value="<?php if ( isset( $_POST['cemail'] ) ) echo esc_attr( $_POST['cemail'] );?>">
			</div>

			<div class="form-subject form-group">						
				<label for="csubject" class="control-label"><?php echo anva_get_local( 'subject' ); ?>:</label>
				<input id="subject" type="text" placeholder="<?php echo anva_get_local( 'subject' ); ?>" name="csubject" class="form-control requiredField" value="<?php if ( isset( $_POST['csubject'] ) ) echo esc_attr( $_POST['csubject'] ); ?>">
			</div>
			
			<div class="form-message form-group">
				<label for="cmessage" class="control-label"><?php echo anva_get_local( 'message' ); ?>:</label>
				<textarea id="message" name="cmessage" class="form-control" placeholder="<?php echo anva_get_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) echo esc_textarea( $_POST['cmessage'] ); ?></textarea>
			</div>
			
			<div class="form-captcha form-group">
				<label for="captcha" class="control-label"><?php echo $a . ' + '. $b . ' = ?'; ?>:</label>
				<input type="text" name="ccaptcha" placeholder="<?php echo anva_get_local( 'captcha_place' ); ?>" class="form-control requiredField" value="<?php if ( isset( $_POST['ccaptcha'] ) ) echo $_POST['ccaptcha'];?>">
				<input type="hidden" id="answer" name="canswer" value="<?php echo esc_attr( $answer ); ?>">
			</div>
			
			<div class="form-submit form-group">
				<input type="hidden" id="submitted" name="contact-submission" value="1">
				<input id="submit-contact-form" type="submit" class="button button-3d" value="<?php echo anva_get_local( 'submit' ); ?>">
			</div>
		</form>
	</div><!-- .contact-form-wrapper -->

	<script>
	jQuery(document).ready(function(){ 
		
		setTimeout(function(){
			jQuery("#email_message").fadeOut("slow");
		}, 3000);

		jQuery('#contactform input[type="text"]').attr('autocomplete', 'off');
		jQuery('#contactform').validate({
			rules: {
				cname: "required",
				csubject: "required",
				cemail: {
					required: true,
					email: true
				},
				cmessage: {
					required: true,
					minlength: 10
				},
				ccaptcha: {
					required: true,
					number: true,
					equalTo: "#answer"
				}
			},
			messages: {			
				cname: "<?php echo anva_get_local( 'name_required' ); ?>",
				csubject: "<?php echo anva_get_local( 'subject_required' ); ?>",
				cemail: {
					required: "<?php echo anva_get_local( 'email_required' ); ?>",
					email: "<?php echo anva_get_local( 'email_error' );  ?>"
				},
				cmessage: {
					required: "<?php echo anva_get_local( 'message_required' ); ?>",
					minlength: "<?php echo anva_get_local( 'message_min' ); ?>"
				},
				ccaptcha: {
					required: "<?php echo anva_get_local( 'captcha_required' ); ?>",
					number: "<?php echo anva_get_local( 'captcha_number' ); ?>",
					equalTo: "<?php echo anva_get_local( 'captcha_equalto' );  ?>"
				}
			}
		});
	});
	</script>
	<?php
}

function anva_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o  = '<form class="form-inline password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
	$o .= '<span class="glyphicon glyphicon-lock"></span>';
	$o .= '<p class="lead">' . __( "To view this protected post, enter the password below:", 'anva' ) . '</p>';
	$o .= '<div class="form-group">';
	$o .= '<label for="' . $label . '">' . __( "Password", 'anva' ) . ' </label>';
	$o .= '<input class="form-control" name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" />';
	$o .= '</div>';
	$o .= '<input class="btn btn-default" type="submit" name="Submit" value="' . esc_attr__( "Submit", 'anva' ) . '" />';
	$o .= '</form>';
	return $o;
}

/**
 * Search form
 */
function anva_get_search_form() {
	?>
	<form role="search" method="get" id="searchform" class="form-inline search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="input-group">
			<input type="search" id="s" class="search-field form-control" placeholder="<?php echo anva_get_local( 'search' ); ?>" value="" name="s" title="<?php echo anva_get_local( 'search_for' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" id="searchsubmit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo anva_get_local( 'search_for' ); ?></span>
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>
	</form>
	<?php
}

/**
 * Woocommerce search product form
 */
function anva_get_product_search_form() {
	?>
	<form role="search" method="get" id="searchform" class="form-inline search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		<div class="input-group">
		<input type="text" id="s" name="s" class="search-field form-control" value="<?php echo get_search_query(); ?>"  placeholder="<?php _e( 'Search for products', 'woocommerce' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" id="searchsubmit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo esc_attr__( 'Search' ); ?></span>
					<i class="fa fa-search"></i>
				</button>
				<input type="hidden" name="post_type" value="product" />
			</span>
		</div>
	</form>
	<?php
}

/**
 * Get comment list
 * 
 * @since 1.0.0
 */
function anva_comment_list( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-wrapper">
			<div class="row">
	<?php endif; ?>
	
	<div class="comment-avatar col-xs-3 col-sm-2">
		<a href="<?php echo comment_author_url( $comment->comment_ID ); ?>">
			<?php
				if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, 64 );
				}
			?>
		</a>
	</div>

	<div class="comment-body col-xs-9 col-sm-10">
		<h4 class="comment-author vcard">
		<?php
			printf(
				'<cite class="fn">%s</cite> <span class="says sr-only">says:</span>',
				get_comment_author_link()
			);
		?>
		</h4>

		<div class="comment-meta">
			<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?>
				<?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
			</a>
		</div>

		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation well well-sm"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<?php endif; ?>
		
		<div class="comment-text">
			<?php comment_text(); ?>
		</div>
		
		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	
	</div>

	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	</div>
	<?php endif; ?>

<?php
}

/**
 * Replace reply link class in comment form
 * 
 * @since 1.0.0
 */
function anva_comment_reply_link_class( $class ){
	$class = str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-default btn-sm", $class );
	return $class;
}

/**
 * Display a breadcrumb menu after header
 * 
 * @since 1.0.0
 */
function anva_get_breadcrumbs() {
	
	global $post;

	$text['home']   		= anva_get_local( 'home' );
	$text['category'] 	= anva_get_local( 'category_archive' ) . ' "%s"';
	$text['search']  		= anva_get_local( 'search_results' ) . ' "%s"';
	$text['tag']   			= anva_get_local( 'tag_archive' ) . ' "%s"';
	$text['author']  		= anva_get_local( 'author_archive' ) . ' "%s"';
	$text['404']   			= anva_get_local( '404' );
	
	$show_current  			= 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home  			= 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link			= 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title   			= 1; // 1 - show the title for the links, 0 - don't show
	$delimiter   				= '<li class="separator"> / </li>'; // delimiter between crumbs
	$before     				= '<li class="current">'; // tag before the current crumb
	$after     					= '</li>'; // tag after the current crumb
	$home_link  				= home_url( '/' );
	$link_before 				= '<li typeof="v:Breadcrumb">';  
	$link_after  				= '</li>';  
	$link_attr  				= ' rel="v:url" property="v:title"';  
	$link     					= $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;  
	$parent_id  				= $parent_id_2 = $post->post_parent;  
	$frontpage_id 			= get_option( 'page_on_front' );  
	
	// Home or Front Page
	if ( is_home() || is_front_page() ) {
	
		if ( $show_on_home == 1 ) echo '<ol class="breadcrumb"><li><a href="' . $home_link . '">' . $text['home'] . '</a></li></ol>';  
	
	} else {
	
		echo '<ol class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
		
		if ( $show_home_link == 1 ) {
			
			echo '<li><a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a></li>';
			
			if ( $frontpage_id == 0 || $parent_id != $frontpage_id )
				echo $delimiter;
		} 
	
		// Category Navigation
		if ( is_category() ) {
			
			$this_cat = get_category( get_query_var( 'cat' ), false );

			if ( $this_cat->parent != 0 ) {  
				
				$cats = get_category_parents( $this_cat->parent, true, $delimiter );

				if ( $show_current == 0 ) {
					$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
				}
				
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				
				if ( $show_title == 0 ) {
					$cats = preg_replace('/ title="(.*?)"/', '', $cats);
				}
				
				echo $cats;
			}
			
			if ( $show_current == 1 )
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
		
		// Search Navigation
		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;  
		
		// Archive: Day
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;  
			echo $before . get_the_time('d') . $after;  
		
		// Archive: Month
		} elseif ( is_month() ) {  
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
			echo $before . get_the_time('F') . $after; 
		
		// Archive: Year
		} elseif ( is_year() ) {  
			echo $before . get_the_time('Y') . $after;  
		
		// Single Post
		} elseif ( is_single() && ! is_attachment() ) {  
			
			if ( get_post_type() != 'post' ) {
				
				$post_type = get_post_type_object(get_post_type());  
				
				$slug = $post_type->rewrite;  
				
				printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);  
				
				if ( $show_current == 1) {
					echo $delimiter . $before . get_the_title() . $after;  
				}
			
			} else {  
				$cat = get_the_category(); $cat = $cat[0];  
				$cats = get_category_parents($cat, TRUE, $delimiter);  
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);  
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
				echo $cats;  
				if ($show_current == 1) echo $before . get_the_title() . $after;  
			}  
	
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {  
			$post_type = get_post_type_object(get_post_type());  
			echo $before . $post_type->labels->singular_name . $after;  
		
		// Single Attachment
		} elseif ( is_attachment() ) {  
			$parent = get_post($parent_id);  
			$cat = get_the_category($parent->ID); $cat = $cat[0];  
			if ($cat) {  
				$cats = get_category_parents($cat, TRUE, $delimiter);  
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);  
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
				echo $cats;  
			}  
			printf($link, get_permalink($parent), $parent->post_title);  
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;  
		
		// Single Page
		} elseif ( is_page() && !$parent_id ) {  
			if ($show_current == 1) echo $before . get_the_title() . $after;  
	
		} elseif ( is_page() && $parent_id ) {  
			if ($parent_id != $frontpage_id) {  
				$breadcrumbs = array();  
				while ($parent_id) {  
					$page = get_page($parent_id);  
					if ($parent_id != $frontpage_id) {  
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
					}  
					$parent_id = $page->post_parent;  
				}  
				$breadcrumbs = array_reverse($breadcrumbs);  
				for ($i = 0; $i < count($breadcrumbs); $i++) {  
					echo $breadcrumbs[$i];  
					if ($i != count($breadcrumbs)-1) echo $delimiter;  
				}  
			}  
			if ($show_current == 1) {  
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;  
				echo $before . get_the_title() . $after;  
			}  
		
		// Tag Navigation
		} elseif ( is_tag() ) {  
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;  
		
		// Single Author Navigation
		} elseif ( is_author() ) {
			global $author;  
			$userdata = get_userdata($author);  
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;  
		
		// 404 Page
		} elseif ( is_404() ) {  
			echo $before . $text['404'] . $after;  
		
		// Single Page
		} elseif ( has_post_format() && ! is_singular() ) {  
			echo get_post_format_string( get_post_format() );  
		}  
		
		// Is Paged
		// if ( get_query_var('paged') ) {  
		// 	if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';  
		// 	echo __('Page') . ' ' . get_query_var('paged');  
		// 	if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';  
		// }
	
		echo '</ol><!-- .breadcrumb (end) -->';
	
	}
}


/**
 * Display gallery grid
 * 
 * @since 1.0.0
 */
function anva_gallery_grid( $post_id, $columns, $thumbnail ) {
	
	$classes 	 	= array();
	$gallery 	 	= anva_get_gallery_field();
	$gallery 	 	= anva_sort_gallery( $gallery );
	$animate 	 	= anva_get_option( 'gallery_animate' );
	$delay 	 		= anva_get_option( 'gallery_delay' );
	$highlight 	= anva_get_field( 'gallery_highlight' );
	$html 			= '';

	$classes[] = $columns;
	$classes = implode( ' ', $classes );
	
	$query_args = array(
		'post_type'   	 => 'attachment',
		'post_status' 	 => 'inherit',
		'post_mime_type' => 'image/jpeg',
		'posts_per_page' => -1,
		'post__in'			 => $gallery,
		'orderby'				 => 'post__in',
	);

	$query = anva_get_query_posts( $query_args );

	if ( $query->have_posts() ) {

		$html .= '<div class="gallery-container">';
		$html .= '<div class="masonry-thumbs ' . esc_attr( $classes ) . ' clearfix" data-lightbox="gallery" data-big="' . esc_attr( $highlight ) . '">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$title 			= get_the_title();
			$thumb_full = anva_get_attachment_image_src( get_the_ID(), 'full' );
			$thumb_size = anva_get_attachment_image_src( get_the_ID(), $thumbnail );
		
			$html .= '<a href="' . esc_url( $thumb_full ) . '" title="' . esc_attr( $title ) . '" data-animate="' . esc_attr( $animate ) . '" data-delay="' . esc_attr( $delay ) . '" data-lightbox="gallery-item">';
			$html .= '<img class="gallery-image" src="' . esc_attr( $thumb_size ) . '" alt="' . esc_attr( $title ) . '" />';
			$html .= '</a>';

		}

		wp_reset_postdata();

		$html .= '</div><!-- .masonry-thumbs (end) -->';
		$html .= '</div><!-- .gallery-container (end) -->';

	}

	return $html;
	
}

/**
 * Display slider
 *
 * @since 1.0.0
 */
function anva_sliders( $slider ) {

	// Kill it if there's no slider
	if ( ! $slider ) {
		printf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'No slider selected.', 'anva' ) );
		return;
	}

	if ( anva_is_slider( $slider ) ) {

		// Get sliders data
		$sliders = anva_get_sliders();

		// Get Slider ID
		$slider_id = $slider;

		// Gather settings
		$settings = $sliders[$slider_id]['options'];

		// Display slider based on its slider type
		do_action( 'anva_slider_' . $slider_id, $slider, $settings );

	} elseif ( 'revslider' == $slider ) {
		anva_revolution_slider_default();
	
	} elseif ( 'layerslider' == $slider ) {
		/**
		 * anva_layer_slider_default()
		 * @todo create function to support Layer Slider
		 */
	} else {
		printf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'No slider found.', 'anva' ) );
		return;
	}

}

/**
 * Get Revolution Slider ID
 *
 * @since 1.0.0
 */
function anva_revolution_slider_default() {
	
	if ( ! class_exists( 'RevSliderFront' ) ) {
		printf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'Revolution Slider not found, make sure the plugin is installed and activated.', 'anva' ) );
		return;
	}

	$revslider_id = anva_get_option( 'revslider_id' );

	if ( ! empty( $revslider_id ) ) {
		putRevSlider( $revslider_id );
	}
}

/**
 * Standard slider type
 *
 * @since 1.0.0
 */
function anva_slider_standard_default( $slider, $settings ) {

	// Global Options
	$pause = anva_get_option( 'standard_pause' );
	$arrows = anva_get_option( 'standard_arrows' );
	$animation = anva_get_option( 'standard_fx' );
	$speed = anva_get_option( 'standard_speed' );
	$thumbs = anva_get_option( 'standard_thumbs' );
	$grid = anva_get_option( 'standard_grid' );
	$thumbnail = 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html = '';
	
	if ( $query->have_posts() ) {
		
		$html .= '<div class="fslider flex-thumb-grid ' . esc_attr( $grid ) . '" data-animation="' . esc_attr( $animation ) . '" data-thumbs="' . esc_attr( $thumbs ) . '" data-arrows="' . esc_attr( $arrows ) . '" data-speed="' . esc_attr( $speed ) . '" data-pause="'. esc_attr( $pause ) . '">';
		$html .= '<div class="flexslider">';
		$html .= '<ul class="slider-wrap slides">';
		
		while ( $query->have_posts() ) {

			$query->the_post();
			
			$id 		 = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_field( 'description' );
			$url 		 = anva_get_field( 'url' );
			$content = anva_get_field( 'content' );
			$image   = anva_get_featured_image( $id, 'anva_sm' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';
			
			$html .= '<div class="slide slide-'. esc_attr( $id ) . '" data-thumb="'. esc_attr( $image ) .'">';
			
			if ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $thumbnail , array( 'class' => 'slide-image' ) );

				// Close anchor
				if ( $url ) {
					$html .= '</a>';
				}
			}
			
			switch ( $content ) {
				case 'title':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $title );
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $desc );
					$html .= '</div>';
					break;

				case 'both':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $title );
					$html .= '<span>' . esc_html( $desc ) . '</span>';
					$html .= '</div>';
					break;
			}
			
			$html .= '</div>';
		}

		wp_reset_postdata();

		$html .= '</ul><!-- .slider-wrap (end) -->';
		$html .= '</div><!-- .flexslider (end) -->';
		$html .= '</div><!-- .fslider (end) -->';
	}

	echo $html;
}

/**
 * OWL slider type
 *
 * @since 1.0.0
 */
function anva_slider_owl_default( $slider, $settings ) {

	$thumbnail = 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html = '';
	
	if ( $query->have_posts() ) {
		
		$html .= '<div id="oc-slider" class="owl-carousel">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$id 		 = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_field( 'description' );
			$url 		 = anva_get_field( 'url' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';

			if ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $thumbnail , array( 'class' => 'slide-image' ) );

				if ( $url ) {
					$html .= '</a>';
				}
			}
		
		}

		wp_reset_postdata();

		$html .= '</div><!-- #oc-slider (end) -->';
		
	}
	
	echo $html;

}

/**
 * Nivo slider type
 *
 * @since 1.0.0
 */
function anva_slider_nivo_default( $slider, $settings ) {
	
	$thumbnail = 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html = '';
	$caption = '';
	
	if ( $query->have_posts() ) {

		$count = 0;
		$html .= '<div class="nivoSlider">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_id = get_the_ID();
			$title 	 = get_the_title();
			
			$count++;

			if ( has_post_thumbnail() ) {
				$html .= get_the_post_thumbnail( $post_id, $thumbnail , array( 'class' => 'slide-image', 'title' => '#nivocaption' . $count ) );
			}

			$caption .= '<div id="nivocaption' . $count . '" class="nivo-html-caption">' . $title .' </div>';
			
		}

		wp_reset_postdata();
	
		$html .= '</div><!-- .nivoSlider (end) -->';
		$html .= $caption;

	}

	echo $html;
}

/**
 * Boostrap carousel slider type
 *
 * @since 1.0.0
 */
function anva_slider_bootstrap_default( $slider, $settings ) {

	$thumbnail = 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html = '';
	$count = 0;
	$li = '';
	$class = '';

	$post_count = count( $query->posts );
	for ( $i = 0; $i < $post_count; $i++ ) {
		if ( 0 == $i ) {
			$class = 'class="' . esc_attr( $class ) . '"';
		}
		$li .= '<li data-target="#bootstrap-carousel" data-slide-to="' . esc_attr( $i ) . '" ' . $class . '></li>';
	}

	// Reset class
	$class = '';
	
	if ( $query->have_posts() ) {

		$html .= '<div id="bootstrap-carousel" class="boostrap-carousel carousel slide" data-ride="carousel">';
		
		$html .= '<ol class="carousel-indicators">';
		$html .= $li;
		$html .= '</ol><!-- .carousel-indicators (end) -->';

		$html .= '<div class="carousel-inner" role="listbox">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_id = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_field( 'description' );

			if ( 0 == $count ) {
				$class = 'active';
			}

			$html .= '<div class="item ' . esc_attr( $class ) . '">';
			
			if ( has_post_thumbnail() ) {
				$html .= get_the_post_thumbnail( $post_id, $thumbnail );
			}

			// $html .= '<div class="carousel-caption">';
			// $html .= '<h3>' . $title . '</h3>';
			
			// if ( ! empty( $desc ) ) {
			// 	$html .= '<p>' . $desc . '</p>';
			// }

			// $html .= '</div>';
			$html .= '</div>';

			// Reset class
			$class = '';
			
			$count++;

		}

		wp_reset_postdata();

		$html .= '</div><!-- .carousel-inner (end) -->';

		$html .= '<a class="left carousel-control" href="#bootstrap-carousel" role="button" data-slide="prev">';
		$html .= '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
		$html .= '<span class="sr-only">Previous</span>';
		$html .= '</a>';
		$html .= '<a class="right carousel-control" href="#bootstrap-carousel" role="button" data-slide="next">';
		$html .= '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
		$html .= '<span class="sr-only">Next</span>';
		$html .= '</a>';
		
		$html .= '</div><!-- .boostrap-carousel (end) -->';

	}

	echo $html;

}

function anva_slider_swiper_default() {
	?>
	
	<div class="swiper-container swiper-parent">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')"></div>
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')"></div>
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')">
				<div class="slide-container clearfix">
					<div class="slider-caption slider-caption-center">
						<h2 data-caption-animate="fadeInUp">Welcome to Canvas</h2>
						<p data-caption-animate="fadeInUp" data-caption-delay="200">Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on our Canvas.</p>
					</div>
				</div>
			</div>
		</div>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
		
		<!-- If we need navigation buttons -->
		<div id="slider-arrow-left"><i class="fa fa-angle-left"></i></div>
		<div id="slider-arrow-right"><i class="fa fa-angle-right"></i></div>
		
	</div>
	<?php
}

function anva_slider_camera_default() {
	?>
	 <div class="camera_wrap" id="camera_wrap_1">
			<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
					<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
							<div class="container">Powerful Layout with Responsive functionality that can be adapted to any screen size.</div>
					</div>
			</div>
			<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
					<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
							<div class="container">Looks beautiful &amp; ultra-sharp on Retina Screen Displays.</div>
					</div>
			</div>
			<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
					<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
							<div class="container">Included 20+ custom designed Slider Pages with Premium Sliders like Layer, Revolution, Swiper &amp; others.</div>
					</div>
			</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#camera_wrap_1').camera();
	});
	</script>
	<?php
}
