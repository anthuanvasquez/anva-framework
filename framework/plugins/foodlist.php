<?php

add_action( 'after_setup_theme', 'of_foodlist_setup' );

function of_foodlist_setup() {
	add_filter( 'foodlist_menu_template', 'of_menu_template', 10, 2 );
	add_filter( 'foodlist_menu_section_template', 'of_menu_section_template', 10, 2 );
	add_filter( 'foodlist_menu_item_template', 'of_menu_item_template', 10, 2 );
}

function of_menu_template( $tpl ) {
	$tpl = '
		<div class="fl-menu" id="fl-menu-[menu_id]">
			<div class="clear"></div>
			<ul>
				[menu_sections]
				<li>
					[menu_section]
				</li>
				[/menu_sections]
			</ul>
		</div>
	';
	return $tpl;
}

function of_menu_section_template( $tpl ) {
	$tpl = '
		<div class="fl-menu-section" id="fl-menu-section-[menu_section_id]-[menu_section_instance]">
			<h2>[menu_section_title] <a href="#menu-toc" title="Ir Arriba"><i class="fa fa-long-arrow-up"></i></a></h2>
			<div class="clear"></div>
			<ul class="group">
				[menu_items]
				<li>
					[menu_item]
				</li>
				[/menu_items]
			</ul>
		</div>
	';
	return $tpl;
}

function of_menu_item_template( $tpl ) {	
	$tpl = '
		<div class="fl-menu-item" id="fl-menu-item-[menu_item_id]-[menu_item_instance]">
			<div class="fl-excerpt">
				[menu_item_thumbnail]
				<h3>[menu_item_title]</h3>
				[menu_item_excerpt]
			</div>
			<div class="fl-menu-item-meta">
				<span class="fl-currency-sign">[currency_sign]</span>
				<span class="fl-menu-item-price">[menu_item_price]</span>
			</div>
			<div class="clear"></div>
		</div>
	';
	return $tpl;
}