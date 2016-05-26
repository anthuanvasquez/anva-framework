<?php
/**
 * The template file for comments.
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

if ( post_password_required() ) {
	return;
}

?>

<?php do_action( 'anva_comments_before' ); ?>

<div id="comments" class="clearfix">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf(
					_nx(
						'1 response &ldquo;%2$s&rdquo;',
						'%1$s responses &ldquo;%2$s&rdquo;',
						get_comments_number(), 
						'comments title', 'anva'
					),
					number_format_i18n(
						get_comments_number() ),
						'<span>' . get_the_title() . '</span>'
					);
			?>
		</h3>

		<?php do_action( 'anva_comment_pagination' ); ?>

		<ol class="commentlist clearfix">
			<?php wp_list_comments( 'type=comment&callback=anva_comment_list' ); ?>
		</ol><!-- .comment-list (end) -->

		<?php do_action( 'anva_comment_pagination' ); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php anva_get_local( 'no_comment' ); ?></p>
	<?php endif; ?>

	<?php
		$required_text = sprintf( __( 'Fields marked with %s are required.', 'anva' ), '<span class="required">*</span>' );
		$aria_req = 'required';
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'button butotn-3d no-margin',
			'title_reply'       => __( 'Leave a Reply', 'anva' ),
			'title_reply_to'    => __( 'Leave a Reply to %s', 'anva' ),
			'cancel_reply_link' => __( 'Cancel Reply', 'anva' ),
			'label_submit'      => __( 'Post Comment', 'anva' ),

			'must_log_in' => '<p class="must-log-in">' .
				sprintf(
					__( 'You must be %s to post a comment.', 'anva' ),
					sprintf(
						'<a href="%s">%s</a>',
						wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ),
						__( 'logged in', 'anva' )
					)
				) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
				sprintf(
					'%1$s <a href="%2$s">%3$s</a>. <a href="%4$s" title="%5$s">%6$s</a>',
					__( 'Logged in as', 'anva' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ),
					__( 'Log out of this account', 'anva' ),
					__( 'Log out?', 'anva' )
				) . '</p>',

			'fields' => apply_filters( 'comment_form_default_fields', array(

				'author' =>
					'<div class="col_one_third comment-form-author">
					<label for="author">' . __( 'Name', 'anva' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="author" name="author" type="text" class="sm-form-control" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' />' .
					'</div>',

				'email' =>
					'<div class="col_one_third comment-form-email">
					<label for="email">' . __( 'Email', 'anva' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="email" name="email" type="text" class="sm-form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
					'</div>',

				'url' =>
					'<div class="col_one_third col_last comment-form-url">
					<label for="url">' . __( 'Website', 'anva' ) . '</label>' .
					'<input id="url" name="url" type="text" class="sm-form-control" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" />' .
					'</div>' .
					'<div class="clear"></div>'

				)
			),

			'comment_notes_after' => '<p class="form-allowed-tags hidden">' .
				sprintf(
					__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'anva' ),
					' <code>' . allowed_tags() . '</code>'
				) . '</p>',

			'comment_field' =>  '
				<div class="col_full comment-form-comment">
				<label for="comment">' . __( 'Comment', 'anva' ) . '</label>
				<textarea id="comment" name="comment" class="sm-form-control" cols="45" rows="8" aria-required="true">' . '</textarea>
				</div>',

			'comment_notes_before' => '<p class="comment-notes">' .
				__( 'Your email address will not be published.', 'anva' ) . ' ' . ( $req ? $required_text : '' ) .
				'</p>',

		);

		comment_form( $args );
	?>

</div><!-- #comments (end) -->

<?php do_action( 'anva_comments_after' ); ?>
