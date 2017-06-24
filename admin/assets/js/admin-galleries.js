jQuery( document ).ready( function( $ ) {

    'use strict';

    // WP Media Frame
    var frame;

    // Settings
    var s;

    // Anva Gallery Object
    var AnvaGallery = {

        // Default Settings
        settings: {
            thumbUl: $( '#anva_gallery_thumbs' ),
            thumbLi: $( '#anva_gallery_thumbs li' )
        },

        init: function() {

            // Set Settings.
            s = this.settings;

            // Initialize functions.
            AnvaGallery.sortableImage();
            AnvaGallery.uploadImage();
            AnvaGallery.removeThubmanil();
            AnvaGallery.removeAllThumbnail();
            AnvaGallery.emptyGallery();

        },

        sortableImage: function() {
            if ( s.thumbUl.length > 0 ) {
                s.thumbUl.sortable({
                    placeholder: 'anva-gallery-placeholder',
                    start: function( e, ui ) {
                        ui.placeholder.height( ui.item.height() - 2 );
                        ui.placeholder.width( ui.item.width() - 2 );
                    }
                });
            }
        },

        uploadImage: function() {
            $( '#anva_gallery_upload_button' ).on( 'click', function(e) {
                e.preventDefault();

                if ( frame ) {
                    frame.open();
                    return;
                }

                frame = wp.media.frames.frame = wp.media({
                    title: $(this).data('title' ),
                    button: {
                        text: $(this).data('text' )
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: true
                });

                frame.on( 'select', function() {
                    var images = frame.state().get('selection' ).toJSON(),
                        length = images.length;
                    for ( var i = 0; i < length; i++ ) {
                        AnvaGallery.getThumbnail( images[i].id );
                    }
                });

                frame.open();
            });
        },

        removeThubmanil: function() {
            s.thumbUl.on( 'click', '.anva_gallery_remove', function(e) {
                e.preventDefault();

                $(this).parent().fadeOut( 100, function() {
                    $(this).remove();
                });

                setTimeout(function() {
                    AnvaGallery.emptyGallery();
                }, 500);
            });
        },

        removeAllThumbnail: function() {
            $( '#anva_gallery_remove_all_buttons' ).on( 'click', function(e) {
                e.preventDefault();

                if ( $( '#anva_gallery_thumbs li' ).length === 0 ) {
                    alert( AnvaGalleryLocal.gallery_empty );
                    return;
                }

                if ( confirm( AnvaGalleryLocal.gallery_confirm ) ) {
                    s.thumbUl.empty();
                }

                AnvaGallery.emptyGallery();
            });
        },

        getThumbnail: function( id, cb ) {
            cb = cb || function() {};

            var data = {
                action: 'anva_gallery_get_thumbnail',
                imageid: id
            };

            $( '#anva-gallery-spinner' ).css('visibility', 'visible' );

            $.post( ajaxurl, data, function( response ) {
                s.thumbUl.append( response );
                cb();
            }).done( function() {
                $( '#anva-gallery-spinner' ).css('visibility', 'hidden' );
                AnvaGallery.emptyGallery();
            });
        },

        emptyGallery: function() {
            if ( $( '#anva_gallery_thumbs li' ).length === 0 ) {
                s.thumbUl.addClass('empty' );
            } else {
                s.thumbUl.removeClass('empty' );
            }
        }
    };

    AnvaGallery.init();

});
