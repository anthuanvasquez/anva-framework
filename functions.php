<?php
/*-----------------------------------------------------------------------------------*/
/* Run Anva WordPress Framework
/* Below is the file needed to load the parent theme and theme framework.
/*-----------------------------------------------------------------------------------*/

// Get the template directory and make sure it has a trailing slash
$anva_base_dir = trailingslashit( get_template_directory() );

// Load Anva framework
require_once( $anva_base_dir . 'framework/anva.php' 					);

// Launch Anva framework
new Anva();

// Load theme functions
require_once( $anva_base_dir . 'includes/theme-functions.php' );