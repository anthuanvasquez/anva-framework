<?php
/**
 * The default template used for 404's.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<div class="entry-wrap">
	<article id="page-404" class="page page-404">

        <div class="col_half nobottommargin">
            <div class="error404 center">404</div>
        </div>

        <div class="col_half nobottommargin col_last">
            <div class="heading-block nobottomborder">
                <h4><?php anva_local( '404_sub_title' ); ?></h4>
                <span><?php anva_local( '404_description' ); ?></span>
            </div>
            <form action="<?php echo home_url( '/' ); ?>" method="get" role="form" class="nobottommargin">
                <div class="input-group input-group-lg">
                    <input type="text" name="s" class="form-control" placeholder="Search for Pages...">
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">Search</button>
                    </span>
                </div>
            </form>
        </div>
	</article><!-- #page-404 (end) -->
</div><!-- .entry-wrap (end) -->