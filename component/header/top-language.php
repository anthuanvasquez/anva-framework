<?php
/**
 * The default template used for top language list with
 * polylang support.
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

$top_lang = anva_get_option( 'top_lang_display', false );

if ( $top_lang && class_exists( 'Polylang' ) ) : ?>
	<!-- Top Lang -->
	<div id="top-lang">
		<a href="#" id="top-lang-trigger">
			<i class="icon-flag"></i>
		</a>
		<div class="top-lang-content">
			<ul class="top-lang-switch">
				<?php
					pll_the_languages(
						array(
							'show_flags' => 1,
							'show_names' => 1,
						)
					);
				?>
			</ul>
		</div>
	</div><!-- #top-lang end -->
<?php endif; ?>
