<?php

/**
 * Display the theme credits.
 */
function of_admin_footer_after() {
	?>
	<div id="optionsframework-credit">
		<span class="alignleft">Theme <?php echo THEME_VERSION; ?></span>
		<span class="alignright">Develop by Anthuan Vasquez.</span>
		<div class="clear"></div>
	</div>
	<?php
}

add_action( 'optionsframework_custom_scripts', 'of_admin_head_scripts' );
function of_admin_head_scripts() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {

		<?php $options = & Options_Framework::_optionsframework_options(); ?>
		<?php foreach ( $options as $value ) : ?>
			<?php if ( 'typography' == $value['type'] ) : ?>

				if ( jQuery('#<?php echo $value["id"]; ?>_face').val() == 'google' ) { jQuery(this).show(); }
				jQuery('#<?php echo $value["id"]; ?>_face').change(function() {
					jQuery('#<?php echo $value["id"]; ?>_sample_text').css('font-family', jQuery(this).val());
					if ( jQuery(this).val() == 'google' ) {
						jQuery('#<?php echo $value["id"]; ?>_google').show();
					} else {
						jQuery('#<?php echo $value["id"]; ?>_google').hide();
					}
				});

			<?php endif; ?>
		<?php endforeach; ?>

		setTimeout( function() {
			jQuery('#optionsframework-wrap .settings-error').fadeOut(500);
		}, 2000);

		jQuery('#logo_retina_check').click(function() {
			jQuery('#section-logo_retina').fadeToggle(400);
		});

		if (jQuery('#logo_retina_check:checked').val() !== undefined) {
			jQuery('#section-logo_retina').show();
		}

	});
	</script>
<?php
}
