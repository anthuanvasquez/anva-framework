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
		jQuery('#body_font_face').change(function() {

				jQuery('#body_font_sample_text').css('font-family', jQuery(this).val());

				if ( jQuery(this).val() == 'google' ) {
	  			jQuery('#body_font_google').show();
	  		} else {
	  			jQuery('#body_font_google').hide();
	  		}
		});
	});
	</script>
<?php
}
