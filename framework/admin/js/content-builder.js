/**
 * Custom scripts needed for the colorpicker, image button selectors,
 * and navigation tabs.
 */

jQuery(document).ready(function($) {

	jQuery("#content_builder_add_button").click( function(){
		
		var select 	= jQuery('#content_options');
		var id 			= select.find("option:selected").val();
		var title 	= select.find("option:selected").attr('title');

		jQuery('#content_builder_sort').append(' \
			<li id="' + id + '" class="ui-state-default"> \
			<div class="icon"><span class="ui-icon ui-icon-arrow-4-diag"></span></div> \
			<div class="title">' + title + '</div> \
			<a class="remove" href="#">X</a> \
			<div class="clear"></div> \
			</li>'
		);
			
	});

	jQuery("#content_builder_sort" ).sortable({
		placeholder: "ui-state-highlight",
		create: function(event, ui) { 
			myCheckRel = jQuery(this).attr('data-sort');
		
			var order = jQuery(this).sortable('toArray');
			jQuery('#' + myCheckRel).val(order);
		},
		update: function(event, ui) {
			myCheckRel = jQuery(this).attr('rel');
			var order = jQuery(this).sortable('toArray');
				jQuery('#' + myCheckRel).val(order);
		}
	});
	jQuery("#content_builder_sort").disableSelection();

});