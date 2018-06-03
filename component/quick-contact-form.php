<?php
/**
 * The default template used for quick contact form in sidebar.
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
?>
<div class="quick-contact-form-result"></div>

<form
	id="quick-contact-form"
	name="quick-contact-form"
	action="#"
	method="post"
	class="quick-contact-form nobottommargin">

	<div class="form-process"></div>

	<input
		type="text"
		class="required sm-form-control input-block-level"
		id="quick-contact-form-name"
		name="quick-contact-form-name"
		value=""
		placeholder="<?php _e( 'Full Name', 'anva' ); ?>" />

	<input
		type="text"
		class="required sm-form-control email input-block-level"
		id="quick-contact-form-email"
		name="quick-contact-form-email"
		value=""
		placeholder="<?php _e( 'Email Address', 'anva' ); ?>" />

	<textarea
		class="required sm-form-control input-block-level short-textarea"
		id="quick-contact-form-message"
		name="quick-contact-form-message"
		rows="4"
		cols="30"
		placeholder="<?php _e( 'Message', 'anva' ); ?>"></textarea>

	<input
		type="text"
		class="hidden"
		id="quick-contact-form-botcheck"
		name="quick-contact-form-botcheck"
		value="" />

	<button
		type="submit"
		id="quick-contact-form-submit"
		name="quick-contact-form-submit"
		class="button button-small button-3d nomargin"
		value="submit">
		<?php _e( 'Send Email', 'anva' ); ?>
	</button>
</form>
