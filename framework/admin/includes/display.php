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

/**
 * Custom admin javascripts
 */
add_action( 'optionsframework_custom_scripts', 'of_admin_head_scripts' );
function of_admin_head_scripts() {

	$options_framework = new Options_Framework;
	$option_name = $options_framework->get_option_name();
	$settings = get_option( $option_name );
	$options = & Options_Framework::_optionsframework_options();

	$val = '';
	?>
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		<?php foreach ( $options as $value ) : ?>
			<?php
				if ( isset( $value['id'] ) ) {
					// Set the id
					$id = $value['id'];

					// Set default value to $val
					if ( isset( $value['std'] ) ) {
						$val = $value['std'];
					}
					// If the option is already saved, override $val
					if ( isset( $settings[($value['id'])] ) ) {
						$val = $settings[($value['id'])];
						// Striping slashes of non-array options
						if ( ! is_array($val) ) {
							$val = stripslashes( $val );
						}
					}
				}
			?>
			// Typography
			<?php if ( 'typography' == $value['type'] ) : ?>
				// Update font stacks preview
				var <?php echo $id; ?> = {
					face: jQuery('#<?php echo $id; ?>_face'),
					sample: jQuery('#<?php echo $id; ?>_sample_text'),
					google: jQuery('#<?php echo $id; ?>_google')
				};

				if ( <?php echo $id; ?>.face.val() == 'google' ) { <?php echo $id; ?>.google.removeClass('hidden'); }
				<?php echo $id; ?>.face.change(function() {
					<?php echo $id; ?>.sample.css('font-family', jQuery(this).val());
					if ( jQuery(this).val() == 'google' ) {
						<?php echo $id; ?>.google.removeClass('hidden');
					} else {
						<?php echo $id; ?>.google.addClass('hidden');
					}
				});
			<?php endif; ?>
			// Range Slider
			<?php if ( 'range' == $value['type'] ) : ?>
				var <?php echo $id; ?> = {
					input: jQuery("#<?php echo $id; ?>"),
					slider: jQuery("#<?php echo $id; ?>_range")
				}

				<?php
					// Remove all formats from the value
					$val = strtr( $val, ['px' => '', 'em' => '', '%' => '', 'rem' => ''] );
					// $val = str_replace( $value['options']['format'], '', $val );
					$plus = '+';
					$format = '';
					if ( isset( $value['options']['format'] ) ) {
						$format = $value['options']['format'];
					}
				?>

				// Update input range slider
				<?php echo $id; ?>.slider.slider({
					min: <?php echo esc_js( $value['options']['min'] ); ?>,
					max: <?php echo esc_js( $value['options']['max'] ); ?>,
					step: <?php echo esc_js( $value['options']['step'] ); ?>,
					value: <?php echo esc_js( $val ); ?>,
					slide: function(e, ui) {
						<?php echo $id; ?>.input.val( ui.value <?php echo esc_js( $plus ); ?> '<?php echo esc_js( $format ); ?>' );
					}
				});
				<?php echo $id; ?>.input.val( <?php echo $id; ?>.slider.slider( "value" ) <?php echo esc_js( $plus ); ?> '<?php echo esc_js( $format ); ?>' );
				<?php echo $id; ?>.slider.slider("pips");
				<?php echo $id; ?>.slider.slider("float", { pips: true });
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
