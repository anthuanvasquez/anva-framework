<?php

/**
 * Get all theme locals
 */
function of_get_string_locals() {
	
	$domain = OF_DOMAIN;
	$localize = array(
		'menu'										=> __( 'Menú', $domain ),
		'menu_primary' 						=> __( 'Menú Primario', $domain ),
		'menu_secondary' 					=> __( 'Menú Secundario', $domain ),
		'menu_message'						=> __( 'Por favor configura el menú en Administración _> Apariencia _> Menús', $domain ),
		'404_title'								=> __( 'Whoops! página no encontrada', $domain ),
		'404_description'					=> __( 'Disculpa, pero la página solicitada no se pudo encontrar. Prueba haciendo una búsqueda en el sitio o regresa a la página principal.', $domain ),
		'not_found'								=> __( 'No hay publicaciones', $domain ),
		'not_found_content'				=> __( 'No se encontraron publicaciones.', $domain ),
		'read_more'								=> __( 'Leer Más', $domain ),
		'prev'										=> __( '&larr; Anterior', $domain ),
		'next'										=> __( 'Siguiente &rarr;', $domain ),
		'comment_prev'						=> __( '&larr; Comentarios Anteriores', $domain ),
		'comment_next'						=> __( 'Comentarios Siguientes &rarr;', $domain ),
		'no_comment'							=> __( 'Comentarios cerrado.', $domain ),
		'search_for' 							=> __( 'Buscar para:', $domain ),
		'search_result'						=> __( 'Resultados de búsqueda para:', $domain ),
		'search'		 							=> __( 'Buscar', $domain ),
		'video'										=> __( 'Video', $domain),
		'page'										=> __( 'Página', $domain ),
		'page_options'						=> __( 'Opciones de Pagina', $domain),
		'page_title'							=> __( 'Título de Página:' ),
		'page_title_show'					=> __( 'Mostrar Titulo' ),
		'page_title_hide'					=> __( 'Ocultar Titulo' ),
		'sidebar_title'						=> __( 'Columna del Sidebar', $domain ),
		'sidebar_left'						=> __( 'Sidebar Left', $domain ),
		'sidebar_right'						=> __( 'Sidebar Right', $domain ),
		'sidebar_fullwidth'				=> __( 'Sidebar Full Width', $domain ),
		'sidebar_double'					=> __( 'Doble Sidebar', $domain ),
		'sidebar_double_left'			=> __( 'Doble Sidebar Left', $domain ),
		'sidebar_double_right'		=> __( 'Doble Sidebar Right', $domain ),
		'post_grid'								=> __( 'Post Grid:' ),
		'grid_2_columns'					=> __( '2 Columns', $domain ),
		'grid_3_columns'					=> __( '3 Columns', $domain ),
		'grid_4_columns'					=> __( '4 Columns', $domain ),
		'posted_on'								=> __( 'Publicado en', $domain ),
		'by'											=> __( 'Por', $domain ),
		'day' 										=> __( 'Día:', $domain ),
		'month' 									=> __( 'Mes:', $domain ),
		'year' 										=> __( 'Año:', $domain ),
		'author' 									=> __( 'Autor:', $domain ),
		'asides' 									=> __( 'Asides', $domain ),
		'galleries' 							=> __( 'Galerías', $domain),
		'images' 									=> __( 'Imágenes', $domain),
		'videos' 									=> __( 'Vídeos', $domain ),
		'quotes' 									=> __( 'Citas', $domain ),
		'links'										=> __( 'Enlaces', $domain ),
		'status'									=> __( 'Estados', $domain ),
		'audios'									=> __( 'Audios', $domain ),
		'chats'										=> __( 'Chats', $domain ),
		'archives'								=> __( 'Archivos', $domain ),
		'name' 										=> __( 'Nombre', $domain ),
		'name_place' 							=> __( 'Nombre Completo', $domain ),
		'name_required'						=> __( 'Por favor entre su nombre.', $domain ),
		'email' 									=> __( 'Email', $domain ),
		'email_place' 						=> __( 'Correo Electrónico', $domain ),
		'email_required'					=> __( 'Por favor entre un correo electrónico válido.', $domain),
		'email_error'							=> __( 'El correo electrónico debe tener un formato válido ej. nombre@email.com.', $domain ),
		'subject' 								=> __( 'Asunto', $domain ),
		'subject_required'				=> __( 'Por favor entre un asunto.', $domain ),
		'message' 								=> __( 'Mensaje', $domain ),
		'message_place' 					=> __( 'Mensaje', $domain ),
		'message_required'				=> __( 'Por favor entre un mensaje.', $domain ),
		'message_min'							=> __( 'Debe introducir un mínimo de 10 caracteres.', $domain ),
		'captcha_place'						=> __( 'Entre el resultado', $domain ),
		'captcha_required'				=> __( 'Por favor entre el resultado.', $domain ),
		'captcha_number'					=> __( 'La respuesta debe ser un numero entero.', $domain ),
		'captcha_equalto'					=> __( 'No es la repuesta correcta.', $domain ),
		'submit' 									=> __( 'Enviar Mensaje', $domain ),
		'submit_message'					=> __( 'Gracias, su email fue enviado con éxito.', $domain ),
		'submit_error'						=> __( '<strong>Lo sentimos</strong>, ha ocurrido un error, verfica que no haya campos en blanco.', $domain ),
		'footer_copyright'				=> __( 'Todos los Derechos Reservados.' , $domain ),
		'footer_text'							=> __( 'Diseño y Programación Web por:', $domain ),
		'get_in_touch'						=> __( 'Ponte en Contacto', $domain ),
		'main_sidebar_title'			=> __( 'Principal', $domain ),
		'main_sidebar_desc'				=> __( 'Area de widgets principal. Por defecto en el lado derecho.', $domain ),
		'home_sidebar_title'			=> __( 'Portada', $domain ),
		'home_sidebar_desc'				=> __( 'Area de widgets en la portada.', $domain ),
		'sidebar_left_title'			=> __( 'Left', $domain ),
		'sidebar_left_desc'				=> __( 'Area de widgets en el lado izquierdo.', $domain ),
		'sidebar_right_title'			=> __( 'Right', $domain ),
		'sidebar_right_desc'			=> __( 'Area de widgets en el lado derecho.', $domain ),
		'footer_sidebar_title'		=> __( 'Footer', $domain ),
		'footer_sidebar_desc'			=> __( 'Area de widgets en el footer.', $domain ),
		'shop_sidebar_title'			=> __( 'Tienda', $domain ),
		'shop_sidebar_desc'				=> __( 'Area de widgets para la tienda de los productos de woocommerce.', $domain ),
		'product_sidebar_title'		=> __( 'Productos', $domain ),
		'product_sidebar_desc'		=> __( 'Area de widgets para los productos individuales de woocommerce.', $domain ),
		'product_featured'				=> __( 'Productos Destacados', $domain ),
		'product_latest'					=> __( 'Productos Recientes', $domain ),
		'add_autop'								=> __( 'A&ntilde;adir p&aacute;rrafos autom&aacute;ticamente', $domain ),
		'featured_image'					=> __( 'Imagen Destacada', $domain ),
		'options'									=> __( 'Opciones', $domain ),
		'browsehappy'							=> __( 'Estas utilizando un navegador obsoleto. Actualiza tu navegador para <a href="%s">mejorar tu experiencia</a> en la web.' ),
		'skype'										=> __( 'Skype', $domain ),
		'title'										=> __( 'Título', $domain ),
		'date'										=> __( 'Fecha', $domain ),
		'order'										=> __( 'Orden', $domain ),
		'image'										=> __( 'Imagen', $domain ),
		'link'										=> __( 'Enlace', $domain ),
		'image_url'								=> __( 'URL de la Imagen', $domain ),
		'url'											=> __( 'URL', $domain ),
		'slide_id'								=> __( 'Slide ID', $domain ),
		'slide_area'							=> __( 'Selecciona el Area del Slide', $domain ),
		'slide_content'						=> __( 'Ocultar o Mostrar Contenido', $domain ),
		'slide_shortcode'					=> __( 'Por favor incluye un slug como parámetro por e.j. [slideshows slug="homepage"]', $domain ),
		'slide_message'						=> __( 'No se han configurado rotadores para los slideshows. Contacta con tu Desarrollador.', $domain ),
		'slide_title' 						=> __( 'Mostrar solo el título', $domain ),
		'slide_desc' 							=> __( 'Mostrar solo la descripción', $domain ),
		'slide_show' 							=> __( 'Mostrar título y descripción', $domain ),
		'slide_hide' 							=> __( 'Ocultar ambos', $domain ),
		'slide_meta'							=> __( 'Opciones de Slide', $domain )
	);

	return apply_filters( 'of_string_locals', $localize );

}

/**
 * Get separate local
 */
function of_get_local( $id ) {

	$text = null;
	$localize = of_get_string_locals();

	if ( isset( $localize[$id] ) ) {
		$text = $localize[$id];
	}

	return $text;
}

/**
 * Get all js locals
 */
function of_get_js_locals() {
	
	$localize = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'theme_url' => get_template_directory_uri(),
		'theme_images' => get_template_directory_uri() . '/assets/images'
	);

	return apply_filters( 'of_js_locals', $localize );
}