<?php
/**
 * The default template used for contact form.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

global $_email_sended_message;

// Set random values to set random questions.
$value_1        = rand( 1, 9 );
$value_2        = rand( 1, 9 );
$random_values  = $value_1 + $value_2;
$answer         = $random_values;
$contact_fields = anva_get_option( 'contact_fields', array( 'name', 'email', 'message' ) );
$captcha        = anva_get_option( 'contact_captcha' );
?>
<div class="contact-form-container">

	<?php if ( ! empty( $_email_sended_message ) ) : ?>
		<div id="email_message" class="alert alert-warning">
			<?php echo esc_html( $_email_sended_message ); ?>
		</div>
	<?php endif; ?>

	<?php wp_nonce_field( 'contact_form', 'contact_form_nonce' ); ?>

	<div id="contactmap"></div>

	<form id="contactform" class="contact-form"  role="form" method="post" action="<?php the_permalink(); ?>#contactform">

		<?php
			if ( ! empty( $contact_fields ) ) :
			foreach ( $contact_fields as $field ) :
				switch ( $field ) :

					case 'name':
						?>
						<div class="form-name form-group">
							<label for="cname" class="control-label">
								<?php anva_local( 'name' ); ?>:
							</label>
							<input id="name" type="text" placeholder="<?php anva_local( 'name_place' ); ?>" name="cname" class="form-control requiredField" value="<?php if ( isset( $_POST['cname'] ) ) { echo esc_attr( $_POST['cname'] );} ?>">
							</div>
							<?php
							break;

					case 'email':
						?>
						<div class="form-email form-group">
							<label for="cemail" class="control-label">
								<?php anva_local( 'email' ); ?>:
							</label>
							<input id="email" type="email" placeholder="<?php anva_local( 'email_place' ); ?>" name="cemail" class="form-control requiredField" value="<?php if ( isset( $_POST['cemail'] ) ) { echo esc_attr( $_POST['cemail'] );}?>">
							</div>
							<?php
							break;

					case 'subject':
						?>
						<div class="form-subject form-group">
							<label for="csubject" class="control-label">
								<?php anva_local( 'subject' ); ?>:
							</label>
							<input id="subject" type="text" placeholder="<?php anva_local( 'subject' ); ?>" name="csubject" class="form-control requiredField" value="<?php if ( isset( $_POST['csubject'] ) ) { echo esc_attr( $_POST['csubject'] );} ?>">
							</div>
							<?php
							break;

					case 'message':
						?>
						<div class="form-message form-group">
							<label for="cmessage" class="control-label">
								<?php anva_local( 'message' ); ?>:
							</label>
							<textarea id="message" name="cmessage" class="form-control" placeholder="<?php anva_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) { echo esc_textarea( $_POST['cmessage'] );} ?></textarea>
							</div>
							<?php
							break;

					case 'phone':
						?>
						<div class="form-phone form-group">
							<label for="cphone" class="control-label">
								<?php anva_local( 'phone' ); ?>:
							</label>
							<input id="phone" type="tel" placeholder="<?php anva_local( 'phone' ); ?>" name="cphone" class="form-control requiredField" value="<?php anva_local( 'phone_place' ); ?>"><?php if ( isset( $_POST['cphone'] ) ) { echo esc_html( $_POST['cphone'] );} ?>">
							</div>
							<?php
							break;

					case 'mobile':
						?>
						<div class="form-mobile form-group">
							<label for="cmobile" class="control-label">
								<?php anva_local( 'mobile' ); ?>:
							</label>
							<input id="mobile" type="tel" placeholder="<?php anva_local( 'mobile_place' ); ?>" name="cmobile" class="form-control requiredField" value="<?php if ( isset( $_POST['cmobile'] ) ) { echo esc_html( $_POST['cmobile'] );} ?>">
							</div>
							<?php
							break;

					case 'company_name':
						?>
						<div class="form-company_name form-group">
							<label for="ccompany_name" class="control-label">
								<?php anva_local( 'company_name' ); ?>:
							</label>
							<input id="company_name" type="text" placeholder="<?php anva_local( 'company_name_place' ); ?>" name="ccompany_name" class="form-control requiredField" value="<?php if ( isset( $_POST['ccompany_name'] ) ) { echo esc_html( $_POST['ccompany_name'] );} ?>">
							</div>
							<?php
							break;

					case 'country':
						?>
						<div class="form-country form-group">
							<label for="ccountry" class="control-label">
								<?php anva_local( 'country' ); ?>:
							</label>
							<input id="ccountry" type="text" placeholder="<?php anva_local( 'country' ); ?>" name="ccountry" class="form-control requiredField" value="<?php anva_local( 'country_place' ); ?>"><?php if ( isset( $_POST['ccountry'] ) ) { echo esc_html( $_POST['ccountry'] );} ?>">
							</div>
							<?php
							break;

					endswitch;
				endforeach;
			else :
				printf( '<div class="alert alert-info">' . __( 'The contact fields are not defined, verified on the %s.', 'anva' ) . '</div>', sprintf( '<a href="' . esc_url( admin_url( '/themes.php?page=' . anva_get_option_name() ) ) . '">%s</>', __( 'theme options', 'anva' ) ) );
			endif;
		?>

		<?php if ( 'yes' == $captcha ) : ?>
			<div class="form-captcha form-group">
				<label for="captcha" class="control-label">
					<?php echo $value_1 . ' + ' . $value_2 . ' = ?'; ?>:
				</label>
				<input type="text" name="ccaptcha" placeholder="<?php anva_local( 'captcha_place' ); ?>" class="form-control requiredField" value="<?php if ( isset( $_POST['ccaptcha'] ) ) { echo $_POST['ccaptcha'];} ?>">
				<input type="hidden" id="answer" name="canswer" value="<?php echo esc_attr( $answer ); ?>">
			</div>
		<?php endif; ?>

		<div class="form-submit form-group">
			<input type="hidden" id="submitted" name="contact-submission" value="1">
			<input id="submit-contact-form" type="submit" class="button button-3d" value="<?php anva_local( 'submit' ); ?>">
		</div>
	</form>
</div><!-- .contact-form-wrapper -->

<?php
	$latitude            = 0;
	$longitude           = 0;
	$zoom                = anva_get_option( 'contact_map_zoom', 10 );
	$html                = anva_get_option( 'contact_map_html' );
	$contact_map_type    = anva_get_option( 'contact_map_type', 'ROADMAP' );
	$contact_map_address = anva_get_option( 'contact_map_address' );

	if ( isset( $contact_map_address[0] ) && ! empty( $contact_map_address[0] ) ) {
	$latitude = $contact_map_address[0];
	}

	if ( isset( $contact_map_address[1] ) && ! empty( $contact_map_address[1] ) ) {
	$longitude = $contact_map_address[1];
	}
?>
<script type="text/javascript">
	jQuery(document).ready( function($) {
		var options = {
			controls: {
				panControl: true,
				zoomControl: false,
				mapTypeControl: false,
				scaleControl: false,
				streetViewControl: false,
				overviewMapControl: true
			},
			scrollwheel: false,
			maptype: '<?php echo esc_js( $contact_map_type ); ?>',
			markers: [{
				latitude: <?php echo esc_js( $latitude ); ?>,
				longitude: <?php echo esc_js( $longitude ); ?>,
				html: "<?php echo esc_js( $html ); ?>",
				popup: true
			}],
			zoom: <?php echo esc_js( $zoom ); ?>
		}
		if ( $('#contactmap').length > 0 ) {
			// $('#contactmap').gMap( options );
		}
	});
</script>

<script type="text/javascript">
jQuery(document).ready( function($) {
	setTimeout( function() {
		$("#email_message").fadeOut("slow");
	}, 3000);
	$('#contactform input[type="text"]').attr('autocomplete', 'off');
	$('#contactform').validate({
		rules: {
			cname: "required",
			cmobile: "required",
			cphone: "required",
			ccompany_name: "required",
			ccountry: "required",
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
			cname: "<?php anva_local( 'name_required' ); ?>",
			csubject: "<?php anva_local( 'subject_required' ); ?>",
			cemail: {
				required: "<?php anva_local( 'email_required' ); ?>",
				email: "<?php anva_local( 'email_error' );  ?>"
			},
			cmessage: {
				required: "<?php anva_local( 'message_required' ); ?>",
				minlength: "<?php anva_local( 'message_min' ); ?>"
			},
			ccaptcha: {
				required: "<?php anva_local( 'captcha_required' ); ?>",
				number: "<?php anva_local( 'captcha_number' ); ?>",
				equalTo: "<?php anva_local( 'captcha_equalto' );  ?>"
			}
		}
	});
});
</script>
