;( function( wp, $ ) {

    // Bail if the customizer isn't initialized
    if ( ! wp || ! wp.customize ) {
        return;
    }

    var templateUrl   = AnvaCustomizerPreview.templateUrl,
        optionName    = AnvaCustomizerPreview.optionName,
        Logo          = AnvaCustomizerPreview.logo,
        fontStacks    = AnvaCustomizerPreview.fontStacks,
        googleFonts   = AnvaCustomizerPreview.googleFonts;

    // ---------------------------------------------------------
    // Background
    // ---------------------------------------------------------

    /* Body BG Color */
    wp.customize( optionName + '[background_color]', function( value ) {
        value.bind( function( color ) {
            $( 'body' ).css( 'background-color', color );
        });
    });

    /* Body BG Image */
    wp.customize( optionName + '[background_image]', function( value ) {
        value.bind( function( image ) {
            $( '.preview_background_image' ).remove();

            if ( '' !== image ) {
                $( 'head' ).append( '<style class="preview_background_image">body { background-image: url("' + image + '"); background-position: center center; background-repeat: no-repeat; background-attachment: fixed; }</style>' );
            }
        });
    });

    /* Body BG Pattern */
    wp.customize( optionName + '[background_pattern]', function( value ) {
        value.bind( function( pattern ) {
            $( '.preview_background_pattern' ).remove();

            if ( '' !== pattern ) {
                var image = templateUrl + '/assets/images/patterns/' + pattern + '.png';
                $( 'head' ).append( '<style class="preview_background_pattern">body { background-image: url("' + image + '"); background-repeat: repeat; }</style>' );
            }
        });
    });

    // ---------------------------------------------------------
    // Header
    // ---------------------------------------------------------

    /* Logo - Type */
    wp.customize( optionName + '[custom_logo][type]', function( value ) {
        value.bind( function( value ) {
            // Set global marker. This allows us to
            // know the currently selected logo type
            // from any other option.
            Logo.type = value;

            // Remove classes specific to type so we
            // can add tehm again depending on new type.
            $( '#logo' ).removeAttr( 'class' );

            // Display markup depending on type of logo selected.
            if ( value == 'title' ) {
                $( '#logo' ).addClass( 'logo-text' );
                $( '#logo' ).html( '<h1 class="text-logo"><a href="' + Logo.site_url + '" title="' + Logo.title + '">' + Logo.title + '</a></h1>' );
            } else if ( value == 'title_tagline' ) {
                $( '#logo' ).addClass( 'logo-tagline' );
                $( '#logo' ).addClass( 'logo-has-tagline' );
                $( '#logo' ).html( '<h1 class="text-logo"><a href="' + Logo.site_url + '" title="' + Logo.title + '">' + Logo.title + '</a></h1><span class="logo-tagline">' + Logo.tagline + '</span>' );
            } else if ( value == 'custom' ) {
                var html = '<h1 class="text-logo"><a href="' + Logo.site_url + '" title="' + Logo.custom+'">' + Logo.custom + '</a></h1>';
                if ( Logo.custom_tagline ) {
                    $( '#logo' ).addClass( 'logo-has-tagline' );
                    html = html+'<span class="logo-tagline">'+Logo.custom_tagline+'</span>';
                }
                $( '#logo' ).addClass( 'logo-text' );
                $( '#logo' ).html(html);
            } else if ( value == 'image' ) {
                var html;
                if ( Logo.image ) {
                    html = '<a href="' + Logo.site_url + '" title="' + Logo.title + '"><img src="' + Logo.image + '" alt="' + Logo.title + '" /></a>';
                } else {
                    html = '<strong>Oops! You still need to upload an image.</strong>';
                }
                $( '#logo' ).addClass( 'logo-image logo-has-image' );
                $( '#logo' ).html( html );
            }
        });
    });

    /* Logo - Custom Title */
    wp.customize( optionName + '[custom_logo][custom]', function( value ) {
        value.bind(function( value ) {
            // Set global marker
            Logo.custom = value;

            // Only do if anything if the proper logo
            // type is currently selected.
            if ( Logo.type === 'custom' ) {
                $( '#logo h1 a' ).text( value );
            }
        });
    });

    /* Logo - Custom Tagline */
    wp.customize(optionName + '[custom_logo][custom_tagline]',function( value ) {
        value.bind(function(value) {
            // Set global marker
            Logo.custom_tagline = value;

            // Remove previous tagline if needed.
            $( '#logo' ).removeAttr( 'class' );
            $( '#logo .logo-tagline' ).remove();

            // Only do if anything if the proper logo
            // type is currently selected.
            if ( Logo.type === 'custom' ) {
                if ( value ) {
                    $( '#logo' ).addClass( 'logo-has-tagline' );
                    $( '#logo' ).append( '<span class="logo-tagline">' + value + '</span>' );
                }
            }
        });
    });

    /* Logo - Image */
    wp.customize( optionName + '[custom_logo][image]', function( value ) {
        value.bind( function( value ) {
            // Set global marker
            Logo.image = value;

            // Only do if anything if the proper logo
            // type is currently selected.
            if ( Logo.type === 'image' ) {
                var html;
                if ( value ) {
                    html = '<a href="' + Logo.site_url + '" title="' + Logo.title + '"><img src="' + Logo.image + '" alt="' + Logo.title + '" /></a>';
                } else {
                    html = '<strong>Oops! You still need to upload an image.</strong>';
                }
                $( '#logo' ).removeAttr( 'class' );
                $( '#logo' ).addClass( 'logo-image logo-has-image' );
                $( '#logo' ).html( html );
            }
        });
    });

    /* Social Media Style */
    wp.customize( optionName + '[social_media_style]', function( value ) {
        value.bind( function( style ) {
            $( '#top-bar .social-icons a' ).removeClass( 'social-light social-dark social-colored' );
            $( '#top-bar .social-icons a' ).addClass( 'social-' + style );
        });
    });

    // ---------------------------------------------------------
    // Main Styles
    // ---------------------------------------------------------

    /* Layout Style */
    wp.customize( optionName + '[layout_style]', function( value ) {
        value.bind( function( value ) {
            $( 'body' ).removeClass( 'boxed stretched' );
            $( 'body' ).addClass( value );
        });
    });

    /* Base Color Scheme */
    wp.customize( optionName + '[base_color]', function( value ) {
        value.bind( function( color ) {
            $( 'body' ).removeClass( 'base-color-black base-color-blue base-color-brown base-color-dark_purple base-color-dark base-color-green base-color-light_blue base-color-light base-color-navy base-color-orange base-color-pink base-color-purple base-color-red base-color-slate base-color-teal' );
            $( 'body' ).addClass( 'base-color-' + color );
        });
    });

    /* Footer Color Scheme */
    wp.customize( optionName + '[footer_color]', function( value ) {
        value.bind( function( color ) {
            $( '#footer' ).removeClass( 'dark' );
            $( '#footer' ).addClass( color );
        });
    });

    // ---------------------------------------------------------
    // Body Typography
    // ---------------------------------------------------------

    /* Body Typography - Size */
    wp.customize( optionName + '[body_font][size]', function( value ) {
        value.bind( function( size ) {

            if ( size === '' ) {
                size = 14;
            }

            size = size + 'px';

            $( '.preview_body_font_size' ).remove();
            $( 'head' ).append( '<style class="preview_body_font_size">body{ font-size: ' + size + '; }</style>' );
        });
    });

    /* Body Typography - Style */
    wp.customize( optionName + '[body_font][style]', function( value ) {
        value.bind( function( style ) {
            $( '.preview_body_font_style' ).remove();

            var body_font_style;

            if ( style === 'normal' ) {
                body_font_style = 'font-style: normal; text-transform: none';
            } else if ( style === 'italic' ) {
                body_font_style = 'font-style: italic; text-transform: none';
            } else if ( style === 'uppercase' ) {
                body_font_style = 'font-style: normal; text-transform: uppercase';
            } else if ( style === 'uppercase-italic' ) {
                body_font_style = 'font-style: italic; text-transform: uppercase';
            }

            $( 'head' ).append( '<style class="preview_body_font_style">body{' + body_font_style + '}</style>' );
        });
    });

    /* Body Typography - Weight */
    wp.customize( optionName + '[body_font][weight]', function( value ) {
        value.bind( function( weight ) {
            $( '.preview_body_font_weight' ).remove();

            var body_font_weight;
            body_font_weight = weight;

            if ( weight === '' ) {
                body_font_weight = 400;
            }

            $( 'head' ).append( '<style class="preview_body_font_weight">body{font-weight:' + body_font_weight + '}</style>' );
        });
    });

    /* Body Typography - Face */
    wp.customize( optionName + '[body_font][face]', function( value ) {
        value.bind( function( face ) {
            var header_font_face = $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family' );

            if ( face === 'google' ) {
                googleFonts.bodyToggle = true;
                var google_font = googleFonts.bodyName.split(":");
                google_font = google_font[0];
                $( 'body' ).css( 'font-family', google_font);
                $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', header_font_face);
            } else {
                googleFonts.bodyToggle = false;
                $( 'body' ).css( 'font-family', fontStacks[face]);
                $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', header_font_face);
            }
        });
    });

    /* Body Typography - Google */
    wp.customize( optionName + '[body_font][google]', function( value ) {
        value.bind( function( google_font ) {
            // Only proceed if user has actually selected for
            // a google font to show in previous option.
            if ( googleFonts.bodyToggle ) {
                // Set global google font for reference in
                // other options.
                googleFonts.bodyName = google_font;

                // Determine current header font so we don't
                // override it with our new body font.
                var header_font_face = $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family' );

                // Remove previous google font to avoid clutter.
                $( '.preview_google_body_font' ).remove();

                // Format font name for inclusion
                var include_google_font = google_font.replace(/ /g,'+' );

                // Include font
                setTimeout( function() {
                    $( 'head' ).append( '<link href="https://fonts.googleapis.com/css?family=' + include_google_font + '" rel="stylesheet" type="text/css" class="preview_google_body_font" />' );
                }, 1000 );

                // Format for CSS
                google_font = google_font.split(":");
                google_font = google_font[0];

                // Apply font in CSS
                $( 'body' ).css( 'font-family', google_font);
                $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', header_font_face); // Maintain header font when body font switches
            }
        });
    });

    // ---------------------------------------------------------
    // Header Typography
    // ---------------------------------------------------------

    /* Header Typography - Style */
    wp.customize( optionName + '[heading_font][style]', function( value ) {
        value.bind( function(style) {
            var headings = $( 'h1, h2, h3, h4, h5, h6' );
            if ( style === 'normal' ) {
                headings.css( 'font-weight', 'normal' );
                headings.css( 'font-style', 'normal' );
                headings.css( 'text-transform', 'none' );
            } else if ( style === 'italic' ) {
                headings.css( 'font-weight', 'bold' );
                headings.css( 'font-style', 'normal' );
                headings.css( 'text-transform', 'none' );
            } else if ( style === 'uppercase' ) {
                headings.css( 'font-weight', 'normal' );
                headings.css( 'font-style', 'italic' );
                headings.css( 'text-transform', 'uppercase' );
            } else if ( style === 'uppercase-italic' ) {
                headings.css( 'font-weight', 'bold' );
                headings.css( 'font-style', 'italic' );
                headings.css( 'text-transform', 'uppercase' );
            }
        });
    });

    /* Header Typography - Face */
    wp.customize( optionName + '[heading_font][face]', function( value ) {
        value.bind( function( face ) {
            if ( face === 'google' ) {
                googleFonts.headingToggle = true;
                var google_font = googleFonts.headingName.split(":");
                google_font = google_font[0];
                $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', google_font);
            } else {
                googleFonts.headingToggle = false;
                $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', fontStacks[face]);
            }
        });
    });

    /* Header Typography - Google */
    wp.customize( optionName + '[heading_font][google]', function( value ) {
        value.bind( function( google_font ) {
            // Only proceed if user has actually selected for
            // a google font to show in previous option.
            if ( googleFonts.headingToggle ) {
                // Set global google font for reference in
                // other options.
                googleFonts.headingName = google_font;

                // Remove previous google font to avoid clutter.
                $( '.preview_google_header_font' ).remove();

                // Format font name for inclusion
                var include_google_font = google_font.replace(/ /g,'+' );

                // Include font
                setTimeout( function() {
                    $( 'head' ).append( '<link href="https://fonts.googleapis.com/css?family=' + include_google_font + '" rel="stylesheet" type="text/css" class="preview_google_header_font" />' );
                }, 1000 );

                // Format for CSS
                google_font = google_font.split( ':' );
                google_font = google_font[0];

                // Apply font in CSS
                $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', google_font);
            }
        });
    });

    // ---------------------------------------------------------
    // Menu Typography
    // ---------------------------------------------------------

    /* Menu Typography - Size */
    wp.customize( optionName + '[menu_font][size]', function( value ) {
        value.bind( function( size ) {
            // We're doing this odd-ball way so jQuery
            // doesn't apply body font to other elements.
            $( '.preview_menu_font_size' ).remove();
            $( 'head' ).append( '<style class="preview_menu_font_size">#primary-menu > div > ul { font-size: ' + size + '; }</style>' );
        });
    });

    /* Menu Typography - Style */
    wp.customize( optionName + '[menu_font][style]', function( value ) {
        value.bind( function( style ) {

            // We're doing this odd-ball way so jQuery
            // doesn't apply body font to other elements.
            $( '.preview_menu_font_style' ).remove();

            // Possible choices: normal, bold, italic, bold-italic
            var menu_font_style;

            if ( style === 'normal' ) {
                menu_font_style = 'font-weight: normal; font-style: normal;';
            } else if ( style === 'bold' ) {
                menu_font_style = 'font-weight: bold; font-style: normal;';
            } else if ( style === 'italic' ) {
                menu_font_style = 'font-weight: normal; font-style: italic;';
            } else if ( style === 'bold-italic' ) {
                menu_font_style = 'font-weight: bold; font-style: italic;';
            }

            $( 'head' ).append( '<style class="preview_menu_font_style">#primary-menu > div > ul {' + menu_font_style + '}</style>' );
        });
    });

    /* Menu Typography - Face */
    wp.customize( optionName + '[menu_font][face]', function( value ) {
        value.bind( function( face ) {

            if ( face === 'google' ) {
                googleFonts.menuToggle = true;
                var google_font = googleFonts.menuName.split( ':' );
                google_font = google_font[0];
                $( '#primary-menu > div > ul' ).css( 'font-family', google_font);
            } else {
                googleFonts.menuToggle = false;
                $( '#primary-menu > div > ul' ).css( 'font-family', fontStacks[face]);
            }
        });
    });

    /* Menu Typography - Google */
    wp.customize( optionName + '[menu_font][google]', function( value ) {
        value.bind( function( google_font ) {
            // Only proceed if user has actually selected for
            // a google font to show in previous option.
            if ( googleFonts.menuToggle ) {
                // Set global google font for reference in
                // other options.
                googleFonts.menuName = google_font;

                // Remove previous google font to avoid clutter.
                $( '.preview_google_body_font' ).remove();

                // Format font name for inclusion
                var include_google_font = google_font.replace(/ /g,'+' );

                // Include font
                setTimeout( function() {
                    $( 'head' ).append( '<link href="https://fonts.googleapis.com/css?family=' + include_google_font + '" rel="stylesheet" type="text/css" class="preview_google_body_font" />' );
                }, 1000 );

                // Format for CSS
                google_font = google_font.split( ':' );
                google_font = google_font[0];

                // Apply font in CSS
                $( '#primary-menu > div > ul' ).css( 'font-family', google_font);
            }
        });
    });

    /* H1 Font */
    wp.customize( optionName + '[heading_h1]', function( value ) {
        value.bind( function( size ) {
            $( 'h1, .h1, .page-title h1, .entry-title h1' ).css( 'font-size', size + 'px' );
        });
    });

    /* H2 Font */
    wp.customize( optionName + '[heading_h2]', function( value ) {
        value.bind( function( size ) {
            $( 'h2, .h2, .entry-title h2' ).css( 'font-size', size + 'px' );
        });
    });

    /* H3 Font */
    wp.customize( optionName + '[heading_h3]', function( value ) {
        value.bind( function( size ) {
            $( 'h3, .h3' ).css( 'font-size', size + 'px' );
        });
    });

    /* H4 Font */
    wp.customize( optionName + '[heading_h4]', function( value ) {
        value.bind(function( size ) {
            $( 'h4, .h4' ).css( 'font-size', size + 'px' );
        });
    });

    /* H5 Font */
    wp.customize( optionName + '[heading_h5]', function( value ) {
        value.bind(function( size ) {
            $( 'h5, .h5' ).css( 'font-size', size + 'px' );
        });
    });

    /* H6 Font */
    wp.customize( optionName + '[heading_h6]', function( value ) {
        value.bind( function( size ) {
            $( 'h6, .h6' ).css( 'font-size', size + 'px' );
        });
    });

    // ---------------------------------------------------------
    // Custom CSS
    // ---------------------------------------------------------

    wp.customize( optionName + '[custom_css]', function( value ) {
        value.bind( function( css ) {
            $( '.preview_custom_css' ).remove();
            $( 'head' ).append( '<style class="preview_custom_css">' + css + '</style>' );
        });
    });

} )( window.wp, jQuery );
