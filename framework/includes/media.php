<?php

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function anva_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'anva_content_width', 1200 );
}

/**
 * Get Image Sizes.
 *
 * @global $content_width
 *
 * @since  1.0.0
 */
function anva_get_image_sizes() {

    global $content_width;

    // Crop sizes
    $sizes = array(
        'anva_full' => array(
            'name'       => __( 'Anva Full Width', 'anva' ),
            'width'      => 2000,
            'height'     => 1333,
            'crop'       => true,
        ),
        'anva_xl' => array(
            'name'       => __( 'Anva Extra Large', 'anva' ),
            'width'      => $content_width,
            'height'     => 9999,
            'crop'       => false,
        ),
        'anva_lg' => array(
            'name'       => __( 'Anva Large', 'anva' ),
            'width'      => 1170,
            'height'     => 500,
            'crop'       => true,
        ),
        'anva_md' => array(
            'name'       => __( 'Anva Medium', 'anva' ),
            'width'      => 860,
            'height'     => 400,
            'crop'       => true,
        ),
        'anva_sm' => array(
            'name'       => __( 'Anva Small', 'anva' ),
            'width'      => 400,
            'height'     => 300,
            'crop'       => true,
        ),
        'anva_xs' => array(
            'name'       => __( 'Anva Extra Small', 'anva' ),
            'width'      => 170,
            'height'     => 128,
            'crop'       => true,
        ),
        'anva_grid_2' => array(
            'name'       => __( 'Anva Grid 2', 'anva' ),
            'width'      => 800,
            'height'     => 600,
            'crop'       => true,
        ),
        'anva_grid_3' => array(
            'name'       => __( 'Anva Grid 3', 'anva' ),
            'width'      => 600,
            'height'     => 450,
            'crop'       => true,
        ),
        'anva_post_grid'  => array(
            'name'       => __( 'Anva Post Grid', 'anva' ),
            'width'      => 520,
            'height'     => 280,
            'crop'       => true,
        ),
        'anva_masonry' => array(
            'name'       => __( 'Anva Masonry', 'anva' ),
            'width'      => 500,
            'height'     => 500,
            'crop'       => true,
        ),
        'anva_masonry_2' => array(
            'name'       => __( 'Anva Masonry Vertical', 'anva' ),
            'width'      => 500,
            'height'     => 700,
            'crop'       => true,
        ),
    );

    return apply_filters( 'anva_image_sizes', $sizes );
}

function anva_get_image_sizes_thumbnail() {

    $sizes = anva_get_image_sizes();
    $thumbnails = array();


    foreach ( $sizes as $thumbnail_id => $thumbnail) {
        $crop = ( $thumbnail['crop'] == true ? __( 'Hard Crop', 'anva' ) : __( 'Soft Crop', 'anva' )  );
        if ( 9999 === $thumbnail['height'] ) {
            $crop = __( 'No Height Crop', 'anva' );
        }
        $thumbnails[ $thumbnail_id ] = sprintf( '%1$s - (%2$s x %3$s, %4$s)', $thumbnail['name'], $thumbnail['width'], $thumbnail['height'], $crop );
    }

    return apply_filters( 'anva_image_sizes_select', $thumbnails );
}

/**
 * Get media queries.
 *
 * @since 1.0.0
 * @param array $localize
 * @param arra Array merge
 */
function anva_get_media_queries( $localize ) {
    $media_queries = array(
        'small'     => 320,
        'handheld'  => 480,
        'tablet'    => 768,
        'laptop'    => 992,
        'desktop'   => 1200
    );
    return array_merge( $localize, $media_queries );
}

/**
 * Add 100% width to <audio> tag of WP's built-in
 * audio player to make it responsive.
 *
 * @since 1.0.0
 * @param string $html
 */
function anva_audio_shortcode( $html ) {
    return str_replace( '<audio', '<audio width="100%"', $html );
}

/**
 * Register image sizes.
 *
 * @global $wp_version
 *
 * @since  1.0.0
 * @return void
 */
function anva_add_image_sizes() {

    // Compared wp version
    global $wp_version;

    // Get image sizes
    $sizes = anva_get_image_sizes();

    // Add image sizes
    foreach ( $sizes as $size => $atts ) {
        add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'] );
    }

}

/**
 * Show theme's image thumb sizes when inserting
 * an image in a post or page. This function gets
 * added as a filter to WP's image_size_names_choose.
 *
 * @since  1.0.0
 */
function anva_image_size_names_choose( $sizes ) {

    // Get image sizes for framework that were registered.
    $raw_sizes = anva_get_image_sizes();

    // Format sizes
    $image_sizes = array();

    foreach ( $raw_sizes as $id => $atts ) {
        $image_sizes[$id] = $atts['name'];
    }

    // Apply filter - Filter in filter... I know, I know.
    $image_sizes = apply_filters( 'anva_image_size_names_choose', $image_sizes );

    // Return merged with original WP sizes
    return array_merge( $sizes, $image_sizes );
}

/**
 * Featured image source.
 *
 * @since 1.0.0
 */
function anva_the_featured_image_src( $post_id, $thumbnail ) {
    echo anva_get_featured_image_src( $post_id, $thumbnail );
}

/**
 * Get featured image source.
 *
 * @since 1.0.0
 */
function anva_get_featured_image_src( $post_id, $thumbnail ) {
    $post_thumbnail_id = get_post_thumbnail_id( $post_id );
    if ( $post_thumbnail_id ) {
        $post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail );
        return $post_thumbnail[0];
    }
}


/**
 * Attachment image source.
 *
 * @since 1.0.0
 */
function anva_the_attachment_image_src( $attachment_id, $thumbnail ) {
    echo anva_get_attachment_image_src( $attachment_id, $thumbnail );
}

/**
 * Get attachment image source.
 *
 * @since 1.0.0
 */
function anva_get_attachment_image_src( $attachment_id, $thumbnail ) {
    if ( $attachment_id ) {
        $attachment_img = wp_get_attachment_image_src( $attachment_id, $thumbnail, true );
        return $attachment_img[0];
    }
    return false;
}


/**
 * Get featured image in posts.
 *
 * @since 1.0.0
 */
function anva_the_post_thumbnail( $thumb ) {

    if ( 'hide' != $thumb && ! has_post_thumbnail() ) {
        return;
    }

    // Get post ID
    $id = get_the_ID();

    // Default thumbnail size on single posts
    $thumbnail = 'anva_lg';

    ?>
    <div class="entry-image">
        <a href="<?php echo anva_get_featured_image_src( $id, $thumbnail ); ?>" data-lightbox="image" ><?php the_post_thumbnail( $thumbnail, array( 'title' => get_the_title() ) ); ?></a>
    </div><!-- .entry-image (end) -->
    <?php

}

/**
 * Get featured image in posts.
 *
 * @since 1.0.0
 */
function anva_the_small_thumbnail() {

    // Get post ID
    $id = get_the_ID();

    // Default thumbnail size on single posts
    $thumbnail = apply_filters( 'anva_small_thumbnail', 'anva_sm' );

    ?>
    <div class="entry-image">
        <a href="<?php anva_the_featured_image_src( $id, $thumbnail ); ?>" data-lightbox="image" ><?php the_post_thumbnail( $thumbnail, array( 'title' => get_the_title() ) ); ?></a>
    </div><!-- .entry-image (end) -->
    <?php

}

/**
 * Get featured image for post grid.
 *
 * @since 1.0.0
 * @param string $thumbnail
 */
function anva_the_post_grid_thumbnail( $thumbnail ) {

    if ( ! has_post_thumbnail() ) {
        return;
    }

    $thumbnail = apply_filters( 'anva_post_grid_thumbnail', $thumbnail );

    ?>
    <div class="entry-image">
        <a href="<?php the_permalink( get_queried_object_id() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( $thumbnail ); ?></a>
    </div><!-- .entry-image (end) -->
    <?php
}

/**
 * Get colors scheme. The skin images don't exists in the framework
 * make sure you have a assets/images/skins folder in theme level.
 *
 * @since  1.0.0
 * @param  string $skin_path
 * @return array  $colors
 */
function anva_get_colors_scheme( $skin_path = '', $ext = 'png' ) {

    if ( empty( $skin_path ) ) {
        $skin_path = trailingslashit( ANVA_FRAMEWORK_URI . 'assets/images/skins' );
    }

    // Set the extension
    $ext = '.' . $ext;

    // Change the skin path with filters
    $skin_path = apply_filters( 'anva_colors_scheme_skin_path', $skin_path );

    $colors = array(
        'blue'          => array(
            'name'      => __( 'Blue', 'anva' ),
            'color'     => "#3498db",
            'image'     => esc_url( $skin_path . 'blue' . $ext ),
        ),
        'light_blue'    => array(
            'name'      => __( 'Light Blue', 'anva' ),
            'color'     => "#83d6ff",
            'image'     => esc_url( $skin_path . 'light_blue' . $ext ),
        ),
        'navy_blue'     => array(
            'name'      => __( 'Navy Blue', 'anva' ),
            'color'     => "#0f68b7",
            'image'     => esc_url( $skin_path . 'navy_blue' . $ext ),
        ),
        'teal'          => array(
            'name'      => __( 'Teal', 'anva' ),
            'color'     => "#16807a",
            'image'     => esc_url( $skin_path . 'teal' . $ext ),
        ),
        'green'         => array(
            'name'      => __( 'Green', 'anva' ),
            'color'     => "#019875",
            'image'     => esc_url( $skin_path . 'green' . $ext ),
        ),
        'turquoise'     => array(
            'name'      => __( 'Turquoise', 'anva' ),
            'color'     => "#5ae898",
            'image'     => esc_url( $skin_path . 'turquoise' . $ext ),
        ),
        'chelseagem'    => array(
            'name'      => __( 'Chelsea Gem', 'anva' ),
            'color'     => "#975732",
            'image'     => esc_url( $skin_path . 'chelseagem' . $ext ),
        ),
        'orange'        => array(
            'name'      => __( 'Orange', 'anva' ),
            'color'     => "#e67e22",
            'image'     => esc_url( $skin_path . 'orange' . $ext ),
        ),
        'sunglow'       => array(
            'name'      => __( 'Sunglow', 'anva' ),
            'color'     => "#ffd324",
            'image'     => esc_url( $skin_path . 'sunglow' . $ext ),
        ),
        'red'           => array(
            'name'      => __( 'Red', 'anva' ),
            'color'     => "#c0392b",
            'image'     => esc_url( $skin_path . 'red' . $ext ),
        ),
        'violet'        => array(
            'name'      => __( 'Violet', 'anva' ),
            'color'     => "#9b59b6",
            'image'     => esc_url( $skin_path . 'violet' . $ext ),
        ),
        'pink'          => array(
            'name'      => __( 'Pink', 'anva' ),
            'color'     => "#ea4c89",
            'image'     => esc_url( $skin_path . 'pink' . $ext ),
        ),
    );
    return apply_filters( 'anva_colors_scheme', $colors );
}

function anva_get_current_color() {
    $color = anva_get_option( 'base_color' );
    $schemes = anva_get_colors_scheme();
    if ( isset( $schemes[ $color ] ) ) {
        return $schemes[ $color ]['color'];
    }
}

/**
 * Add wrapper around embedded videos to allow for responsive videos.
 *
 * @since 1.0.0
 */
function anva_oembed( $html, $url ) {

    // If this is a tweet, keep on movin' fella.
    if ( strpos( $url, 'twitter.com' ) !== false ) {
        return $html;
    }

    // If this is a link to external WP post
    // (introduced in WP 4.4), abort.
    if ( strpos( $html, 'wp-embedded-content' ) !== false ) {
        return $html;
    }

    // Check if wrapper has been applied.
    if ( strpos( $html, 'video-wrapper' ) !== false ) {
        return $html;
    }

    // Apply YouTube wmode fix
    if ( strpos($url, 'youtube') !== false || strpos($url, 'youtu.be') !== false ) {
        if ( strpos($html, 'wmode=transparent') === false ) {
            $html = str_replace('feature=oembed', 'feature=oembed&wmode=transparent', $html);
        }
    }

    return sprintf('<div class="video-wrapper"><div class="video-inner">%s</div></div>', $html);
}

/**
 * Get animations.
 *
 * @since  1.0.0
 * @return array $animations
 */
function anva_get_animations() {
    $animations = array(
        'bounce',
        'flash',
        'pulse',
        'rubberBand',
        'shake',
        'swing',
        'tada',
        'wobble',
        'bounceIn',
        'bounceInDown',
        'bounceInLeft',
        'bounceInRight',
        'bounceInUp',
        'bounceOut',
        'bounceOutDown',
        'bounceOutLeft',
        'bounceOutRight',
        'bounceOutUp',
        'fadeIn',
        'fadeInDown',
        'fadeInDownBig',
        'fadeInLeft',
        'fadeInLeftBig',
        'fadeInRight',
        'fadeInRightBig',
        'fadeInUp',
        'fadeInUpBig',
        'fadeOut',
        'fadeOutDown',
        'fadeOutDownBig',
        'fadeOutLeft',
        'fadeOutLeftBig',
        'fadeOutRight',
        'fadeOutRightBig',
        'fadeOutUp',
        'fadeOutUpBig',
        'flip',
        'flipInX',
        'flipInY',
        'flipOutX',
        'flipOutY',
        'lightSpeedIn',
        'lightSpeedOut',
        'rotateIn',
        'rotateInDownLeft',
        'rotateInDownRight',
        'rotateInUpLeft',
        'rotateInUpRight',
        'rotateOut',
        'rotateOutDownLeft',
        'rotateOutDownRight',
        'rotateOutUpLeft',
        'rotateOutUpRight',
        'hinge',
        'rollIn',
        'rollOut',
        'zoomIn',
        'zoomInDown',
        'zoomInLeft',
        'zoomInRight',
        'zoomInUp',
        'zoomOut',
        'zoomOutDown',
        'zoomOutLeft',
        'zoomOutRight',
        'zoomOutUp',
    );
    return apply_filters( 'anva_animations', $animations );
}

/**
 * Gallery slider from post content.
 *
 * @since 1.0.0
 * @param string $gallery
 * @param string $type
 * @param string $size
 */
function anva_gallery_slider_content( $gallery = '', $type = 'standard', $size = 'anva_md' ) {
    echo anva_get_gallery_slider_content( $gallery, $type, $size );
}

/**
 * Get gallery slider from post content.
 *
 * @since  1.0.0
 * @param  string $gallery
 * @param  string $type
 * @param  string $size
 * @return string $output
 */
function anva_get_gallery_slider_content( $gallery = '', $type = 'standard', $size = 'anva_md' ) {

    $post_id = get_the_ID();
    $type    = apply_filters( 'anva_gallery_slider_type', $type, $post_id );
    $size    = apply_filters( 'anva_gallery_slider_size', $size, $post_id );

    // Did user pass in a gallery shortcode?
    if ( $gallery ) {
        $content = $gallery;
    } else {
        $content = get_the_content();
    }

    // Get gallery slider type
    $gallery_slider_type = anva_get_post_meta( '_anva_gallery_slider_type' );

    if ( ! empty( $gallery_slider_type ) ) {
        $type = $gallery_slider_type;
    }


    // Did user insert a gallery like [gallery ids="1,2,3,4"]
    // via $gallery param or anywhere in post?
    $pattern     = get_shortcode_regex();
    $attachments = array();

    if ( preg_match( "/$pattern/s", $content, $match ) && 'gallery' == $match[2] ) {

        $atts = shortcode_parse_atts( $match[3] );


        if ( ! empty( $atts['ids'] ) ) {
            $ids = explode( ',', $atts['ids'] );
            $query = array(
                'post_type'      => 'attachment',
                'posts_per_page' => -1,
                'post__in'       => $ids
            );
            $attachments = get_posts( $query );
        }
    }

    // If no gallery present, pull from attachments of posts
    // (old school way before WP 3.5, less common)
    if ( ! $attachments ) {
        $args = array(
            'post_parent'    => $post_id,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'posts_per_page' => -1,
            'post_mime_type' => 'image'
        );
        $attachments = get_children( $args );
    }

    //var_dump($attachments);

    // Slider needs 2 or more attachments.
    if ( count( $attachments ) <= 1 ) {
        if ( is_user_logged_in() ) {
            return sprintf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'Oops! Couldn\'t find a gallery with one or more image attachments. Make sure to insert a gallery into the body of the post or attach some images to the post.', 'anva' ) );
        }
        return;
    }

    // CSS Classes
    $classes   = array();
    $classes[] = "{$type}-slider-wrapper";
    $class     = apply_filters( 'anva_gallery_slider_class', $classes );
    $class     = implode( ' ', $class );

    // Default Slider Wrap
    $slider_wrap  = "<div id=\"gallery-slider-{$post_id}\" class=\"{$class} gallery-slider\">\n";
    $slider_wrap .= "%s\n";
    $slider_wrap .= "</div><!-- .gallery-slider (end) -->";

    // Start Output
    $output = '';

    if ( $type == 'nivo' ) {

        /*--------------------------------------------*/
        /* Nivo Slider
        /*--------------------------------------------*/

        $slider  = "<div class=\"nivoSlider\">";
        $slider .= "%s\n";
        $slider .= "</div><!-- .nivoSlider (end) -->";

        // Each slides
        $slide = '';

        foreach ( $attachments as $attachment ) {
            $image = wp_get_attachment_image_src( $attachment->ID, $size );
            $slide .= sprintf( "<img src=\"%s\" alt=\"%s\" />\n", $image[0], $attachment->post_title );
        }

        $output .= sprintf( $slider_wrap, sprintf( $slider, $slide ) );

    } elseif ( $type == 'standard' ) {

        /*--------------------------------------------*/
        /* Standard Slider
        /*--------------------------------------------*/

        $slider  = "<div class=\"fslider\" data-arrows=\"false\" data-lightbox=\"gallery\">";
        $slider .= "<div class=\"flexslider\">";
        $slider .= "<div class=\"slider-wrap\">";
        $slider .= "%s\n";
        $slider .= "</div><!-- .slider-wrap (end) -->";
        $slider .= "</div><!-- .flexslider (end) -->";
        $slider .= "</div><!-- .fslider (end) -->";

        // Each slides
        $slide = '';

        foreach ( $attachments as $attachment ) {
            $image = wp_get_attachment_image_src( $attachment->ID, $size );
            $slide .= "<div class=\"slide\">";
            $slide .= sprintf(
                "<a href=\"%s\" data-lightbox=\"gallery-item\">%s</a>\n",
                anva_get_attachment_image_src( $attachment->ID, 'full' ), // Get original image resolution
                sprintf(
                    "<img src=\"%s\" alt=\"%s\" />\n",
                    $image[0],
                    $attachment->post_title
                )
            );
            $slide .= "</div>";
        }

        $output .= sprintf( $slider_wrap, sprintf( $slider, $slide ) );

    }

    return apply_filters( 'anva_gallery_slider_content', $output, $post_id, $type, $attachments );
}

/**
 * Gallery masonry from post content.
 *
 * @since 1.0.0
 * @param string $gallery
 * @param string $size
 */
function anva_gallery_masonry_content( $gallery = '', $size = 'anva_sm', $cols = '6' ) {
    echo anva_get_gallery_masonry_content( $gallery, $size, $cols );
}

/**
 * Get gallery masonry from post content.
 *
 * @since  1.0.0
 * @param  string $gallery
 * @param  string $size
 * @return string $output
 */
function anva_get_gallery_masonry_content( $gallery = '', $size = 'anva_sm', $cols = '6' ) {

    $post_id = get_the_ID();
    $size    = apply_filters( 'anva_gallery_masonry_size', $size, $post_id );

    // Get gallery hightlight
    $gallery_highlight   = anva_get_post_meta( '_anva_gallery_highlight' );
    $gallery_columns = anva_get_post_meta( '_anva_gallery_columns' );

    if ( ! empty( $gallery_highlight ) ) {
        $gallery_highlight = "data-big=\"{$gallery_highlight}\"";
    }

    if ( ! empty( $gallery_columns ) ) {
        $cols = $gallery_columns;
    }

    // Did user pass in a gallery shortcode?
    if ( $gallery ) {
        $content = $gallery;
    } else {
        $content = get_the_content();
    }

    // Did user insert a gallery like [gallery ids="1,2,3,4"]
    // via $gallery param or anywhere in post?
    $pattern     = get_shortcode_regex();
    $attachments = array();

    if ( preg_match( "/$pattern/s", $content, $match ) && 'gallery' == $match[2] ) {

        $atts = shortcode_parse_atts( $match[3] );

        if ( ! empty( $atts['ids'] ) ) {
            $ids = explode( ',', $atts['ids'] );
            $query = array(
                'post_type'      => 'attachment',
                'posts_per_page' => -1,
                'post__in'       => $ids
            );
            $attachments = get_posts( $query );
        }
    }

    // If no gallery present, pull from attachments of posts
    // (old school way before WP 3.5, less common)
    if ( ! $attachments ) {
        $args = array(
            'post_parent'       => $post_id,
            'post_status'       => 'inherit',
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image'
        );
        $attachments = get_children( $args );
    }

    // Slider needs 2 or more attachments.
    if ( count( $attachments ) <= 1 ) {
        if ( is_user_logged_in() ) {
            return sprintf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'Oops! Couldn\'t find a gallery with one or more image attachments. Make sure to insert a gallery into the body of the post or attach some images to the post.', 'anva' ) );
        } else {
            return;
        }
    }

    // CSS Classes
    $classes   = array();
    $classes[] = 'portfolio-single-image';
    $classes[] = 'col-' . $cols;
    $class     = apply_filters( 'anva_gallery_masonry_class', $classes );
    $class     = implode( ' ', $class );

    // Default Slider Wrap
    $slider_wrap  = "<div id=\"gallery-slider-{$post_id}\" class=\"masonry-thumbs {$class} gallery-slider\" data-lightbox=\"gallery\" {$gallery_highlight}\>\n";
    $slider_wrap .= "%s\n";
    $slider_wrap .= "</div><!-- .gallery-slider (end) -->";

    // Start Output
    $output = '';

    // Each slides
    $slide = '';

    foreach ( $attachments as $attachment ) {
        $image = wp_get_attachment_image_src( $attachment->ID, $size );
        $slide .= sprintf(
            "<a href=\"%s\" data-lightbox=\"gallery-item\">%s</a>\n",
            anva_get_attachment_image_src( $attachment->ID, 'full' ), // Get original image resolution
            sprintf(
                "<img class=\"image_fade\" src=\"%s\" alt=\"%s\" />\n",
                $image[0],
                $attachment->post_title
            )
        );
    }

    $output .= sprintf( $slider_wrap, $slide );

    return apply_filters( 'anva_gallery_masonry_content', $output, $post_id, $attachments );
}
