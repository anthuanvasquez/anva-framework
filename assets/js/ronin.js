jQuery.noConflict();
jQuery(document).ready( function() {

	var windows_width = jQuery(window).width();

	// ---------------------------------------------------------
	// Superfish Menu
	// ---------------------------------------------------------
	jQuery('ul.navigation-menu').superfish({
			delay:       200,
			animation:   { height: 'show' },
			animationOut: { height: 'hide' },
			speed:       'fast',
			autoArrows:  false
		});
	
});