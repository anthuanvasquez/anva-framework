function validate( val ) {
	var pageGrid = jQuery("#post_grid");
	var pageSidebar = jQuery("#sidebar_column");
	if ( 'template-post_grid.php' == val ) {
		pageGrid.show();
	} else {
		pageGrid.hide();
	}
	if ( 'default' == val ) {
		pageSidebar.show();
	} else {
		pageSidebar.hide();
	}
}

jQuery.noConflict();
jQuery(document).ready(function($) {
	var pageTemplate = jQuery("#page_template");
	
	// Initial
	validate( pageTemplate.val() )

	// On Change
	pageTemplate.on( "change", function(e) {		
		validate( jQuery(this).val() )
	});

});