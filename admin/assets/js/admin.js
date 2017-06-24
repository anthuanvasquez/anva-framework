jQuery( document ).ready( function( $ ) {

    'use strict';

    var AnvaSection = {

        init: function() {
            AnvaSection.colorPicker();
            AnvaSection.radioImages();
            AnvaSection.datePicker();
            AnvaSection.spinner();
            AnvaSection.logo();
            AnvaSection.typography();
            AnvaSection.socialMedia();
            AnvaSection.slideshows();
            AnvaSection.slideshowsGroup();
            AnvaSection.columns();
            AnvaSection.rangeSlider();
            AnvaSection.select();
            AnvaSection.select2();
            AnvaSection.showHide();
            AnvaSection.sidebars();
            AnvaSection.contactFields();
        },

        colorPicker: function() {
            if ( $().wpColorPicker() && $( '.anva-color' ).length > 0 ) {
                $( '.anva-color' ).wpColorPicker();
            }
        },

        radioImages: function() {
            $( '.anva-radio-img-box' ).on( 'click', function() {
                var el = $( this );
                el.closest( '.section-images' ).find( '.anva-radio-img-box' ).removeClass( 'anva-radio-img-selected' );
                el.addClass( 'anva-radio-img-selected' );
                el.find( '.anva-radio-img-radio' ).prop( 'checked', true );
            });
            $( '.anva-radio-img-img' ).show();
        },

        spinner: function() {
            if ( $( '.anva-spinner' ).length > 0 ) {
                $( '.anva-spinner' ).spinner();
            }
        },

        datePicker: function() {
            if ( $( '.anva-date-picker' ).length > 0 ) {
                $( '.anva-date-picker' ).datepicker({
                    showAnim: 'slideDown',
                    dateFormat: 'd MM, yy'
                });
            }
        },

        logo: function() {
            $( '.section-logo' ).each(function() {
                var el    = $( this ),
                    value = el.find( '.select-type select' ).val();
                el.find( '.logo-item' ).hide();
                el.find( '.' + value ).show();
            });

            $( '.section-logo .anva-select' ).on( 'change', function() {
                var el     = $( this ),
                    parent = el.closest( '.section-logo' ),
                    value  = el.val();
                parent.find( '.logo-item' ).hide();
                parent.find( '.' + value ).show();
            });
        },

        typography: function() {
            $( '.section-typography .anva-typography-face' ).each(function() {
                var el    = $(this),
                    value = el.val(),
                    text  = el.find( 'option[value="' + value + '"]' ).text();
                if ( value === 'google' ) {
                    el.closest( '.section-typography' ).find( '.google-font' ).fadeIn( 'fast' );
                    el.closest( '.section-typography' ).find( '.sample-text-font' ).hide();
                } else {
                    el.closest( '.section-typography' ).find( '.google-font' ).hide();
                    el.closest( '.section-typography' ).find( '.sample-text-font' ).show();
                    el.closest( '.section-typography' ).find( '.sample-text-font' ).css( 'font-family', text);
                }
            });

            $( '.section-typography .anva-typography-face' ).on( 'change', function() {
                var el    = $(this),
                    value = el.val(),
                    text  = el.find( 'option[value="' + value + '"]' ).text();
                if ( value === 'google' ) {
                    el.closest( '.section-typography' ).find( '.google-font' ).fadeIn( 'fast' );
                    el.closest( '.section-typography' ).find( '.sample-text-font' ).hide();
                } else {
                    el.closest( '.section-typography' ).find( '.google-font' ).hide();
                    el.closest( '.section-typography' ).find( '.sample-text-font' ).show();
                    el.closest( '.section-typography' ).find( '.sample-text-font' ).css( 'font-family', text);
                }
            });
        },

        socialMedia: function() {
            $( '.section-social_media' ).each(function() {
                var el = $(this);
                el.find( '.social_media-input' ).hide();
                el.find( '.checkbox' ).each(function() {
                    var checkbox = $(this);
                    if ( checkbox.is( ':checked' ) ) {
                        checkbox.closest( '.item' ).addClass( 'active' ).find( '.social_media-input' ).show();
                    } else {
                        checkbox.closest( '.item' ).removeClass( 'active' ).find( '.social_media-input' ).hide();
                    }
                });
            });

            $( '.section-social_media .checkbox' ).on( 'click', function() {
                var checkbox = $(this);
                if ( checkbox.is( ':checked' ) ) {
                    checkbox.closest( '.item' ).addClass( 'active' ).find( '.social_media-input' ).fadeIn( 'fast' );
                } else {
                    checkbox.closest( '.item' ).removeClass( 'active' ).find( '.social_media-input' ).hide();
                }
            });
        },

        slideshows: function() {
            $( '.group-slideshows' ).each(function() {
                var el    = $(this),
                    value = el.find( '#slider_id' ).val();
                el.find( '.slider-item' ).hide();
                el.find( '.' + value).show();
            });

            $( '.group-slideshows #slider_id' ).on( 'change', function() {
                var el     = $(this),
                    parent = el.closest( '.group-slideshows' ),
                    value  = el.val();
                parent.find( '.slider-item' ).hide();
                parent.find( '.' + value).show();
            });
        },

        slideshowsGroup: function() {
            $( '.section-slider_group_area' ).each(function() {
                var el = $(this);
                el.find( '.anva-slider-cat-input' ).hide();
                el.find( '.checkbox' ).each(function() {
                    var checkbox = $(this);
                    if ( checkbox.is( ':checked' ) ) {
                        checkbox.closest( '.anva-slider-cat-item' ).addClass( 'active' ).find( '.anva-slider-cat-input' ).show();
                    } else {
                        checkbox.closest( '.anva-slider-cat-item' ).removeClass( 'active' ).find( '.anva-slider-cat-input' ).hide();
                    }
                });
            });

            $( '.section-slider_group_area .checkbox' ).on( 'click', function() {
                var checkbox = $(this);
                if ( checkbox.is( ':checked' ) ) {
                    checkbox.closest( '.anva-slider-cat-item' ).addClass( 'active' ).find( '.anva-slider-cat-input' ).fadeIn( 'fast' );
                } else {
                    checkbox.closest( '.anva-slider-cat-item' ).removeClass( 'active' ).find( '.anva-slider-cat-input' ).hide();
                }
            });
        },

        columns: function() {
            $( '.section-columns' ).each(function(){
                var el  = $(this),
                    i   = 1,
                    num = el.find( '.column-num' ).val();
                el.find( '.column-width' ).hide();
                el.find( '.column-width-'+num).show();
            });

            $( '.section-columns .column-num' ).on( 'change', function(){
                var el     = $(this),
                    i      = 1,
                    num    = el.val(),
                    parent = el.closest( '.section-columns' );
                parent.find( '.column-width' ).hide();
                parent.find( '.column-width-'+num).fadeIn( 'fast' );
            });
        },

        rangeSlider: function() {
            if ( $().slider() ) {
                $( '.section-range, .section-typography .font-range' ).each(function() {
                    var el    = $(this),
                        range = el.find( '.anva-input-range' ),
                        value = range.val(),
                        id    = range.attr( 'id' ),
                        min   = range.data( 'min' ),
                        max   = range.data( 'max' ),
                        step  = range.data( 'step' ),
                        units = range.data( 'units' );
                    $( '#' + id + '_range' ).slider({
                        min: min,
                        max: max,
                        step: step,
                        value: value,
                        slide: function( e, ui ) {
                            $( '#' + id).val( ui.value );
                        }
                    });
                    $( '#' + id).val( $( '#' + id + '_range' ).slider( 'value' ) );
                    $( '#' + id + '_range' ).slider( 'pips');
                    $( '#' + id + '_range' ).slider( 'float', {
                        pips: true,
                        suffix: '' + units
                    });
                });
            }
        },

        select: function() {
            if ( $().selectric ) {
                $( '.select-wrapper .anva-select' ).selectric({
                    arrowButtonMarkup: '<b class="btn">&#x25be;</b>'
                });
            }
        },

        select2: function() {
            if ( $().select2 ) {
                $( '.select2-wrapper .anva-select2' ).select2();
            }
        },

        multiselect2: function() {
            if ( $().select2 ) {
                $( '.select2-wrapper .anva-multiselect2' ).select2();
            }
        },

        showHide: function() {

            // Select Show Hide
            $( '.section-select.show-hide .anva-select' ).each(function() {
                var el        = $(this),
                    value     = el.val(),
                    section   = el.closest( '.section' ),
                    trigger   = section.data( 'trigger' ),
                    receivers = section.data( 'receivers' ),
                    loop      = receivers.split( ' ' );
                if ( value === trigger ) {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).hide();
                    });
                }
            });

            $( '.section-select.show-hide .anva-select' ).on( 'change', function() {
                var el        = $(this),
                    value     = el.val(),
                    section   = el.closest( '.section' ),
                    trigger   = section.data( 'trigger' ),
                    receivers = section.data( 'receivers' ),
                    loop      = receivers.split( ' ' );
                if ( value === trigger ) {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).hide();
                    });
                }
            });

            // Checkbox Show Hide
            $( '.section-checkbox.show-hide .anva-checkbox' ).each( function() {
                var el        = $(this),
                    value     = el.val(),
                    section   = el.closest( '.section' ),
                    trigger   = section.data( 'trigger' ),
                    receivers = section.data( 'receivers' ),
                    loop      = receivers.split( ' ' );

                if ( el.is( ':checked' ) ) {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).hide();
                    });
                }
            });

            $( '.section-checkbox.show-hide .anva-checkbox' ).on( 'click', function() {
                var el        = $(this),
                    value     = el.val(),
                    section   = el.closest( '.section' ),
                    trigger   = section.data( 'trigger' ),
                    receivers = section.data( 'receivers' ),
                    loop      = receivers.split( ' ' );
                if ( el.is( ':checked' ) ) {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $( '#section-' + el).hide();
                    });
                }
            });
        },

        sidebars: function() {
            // Remove sidebar
            $( '.dynamic-sidebars ul' ).sortable();
            $( '.dynamic-sidebars ul' ).disableSelection();
            $(document).on( 'click', '.dynamic-sidebars .delete', function(e) {
                e.preventDefault();
                var ele = $(this).parent();
                swal({
                    title: AnvaSectionLocal.sidebar_button_title,
                    text: AnvaSectionLocal.sidebar_button_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0085ba",
                    confirmButtonText: AnvaSectionLocal.confirm,
                    cancelButtonText: AnvaSectionLocal.cancel,
                    cancelButtonColor: "##f7f7f7",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function( isConfirm ) {
                    if ( isConfirm ) {
                        ele.fadeOut();
                        setTimeout( function() {
                            ele.remove();
                            if ( $( '.dynamic-sidebars ul li' ).length === 0 ) {
                                $( '.dynamic-sidebars ul' ).addClass( 'empty' );
                            }
                        }, 500 );
                    }
                });
            });

            // Add new sidebar
            $( '#add-sidebar' ).on( 'click', function() {
                var $new         = $( '.sidebar' ).val(),
                    $sidebarName = $( '#dynamic_sidebar_name' ).val(),
                    $optionName  = $( '#option_name' ).val();
                if ( '' === $new.trim() ) {
                    swal( AnvaSectionLocal.sidebar_error_title, AnvaSectionLocal.sidebar_error_text );
                    return false;
                }
                if ( $new.length < 3 ) {
                    swal( 'Error', AnvaSectionLocal.sidebar_add_text );
                    return false;
                }
                $( '.dynamic-sidebars ul' ).removeClass( 'empty' );
                $( '.dynamic-sidebars ul' ).append( '<li>' + $new + ' <a href="#" class="delete">' + AnvaSectionLocal.delete + '</a> <input type="hidden" name="' + $optionName + '[' + $sidebarName + '][]' + '" value="' + $new + '" /></li>' );
                $( '.sidebar' ).val( '' );
            });
        },

        contactFields: function() {
            // Contact fields
            $( '.dynamic-contact-fields ul.contact-fields' ).sortable();
            $( '.dynamic-contact-fields ul.contact-fields' ).disableSelection();
            $(document).on( 'click', '.dynamic-contact-fields .delete', function(e) {
                e.preventDefault();
                var $ele = $(this).parent();
                swal({
                    title: AnvaSectionLocal.contact_button_title,
                    text: AnvaSectionLocal.contact_button_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0085ba",
                    confirmButtonText: AnvaSectionLocal.confirm,
                    cancelButtonText: AnvaSectionLocal.cancel,
                    cancelButtonColor: "##f7f7f7",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function( isConfirm ) {
                    if ( isConfirm ) {
                        $ele.fadeOut();
                        setTimeout( function() {
                            $ele.remove();
                            if ( $( '.dynamic-contact-fields ul li' ).length === 0 ) {
                                $( '.dynamic-contact-fields ul' ).addClass( 'empty' );
                            }
                        }, 500 );
                    }
                });
            });

            $(document).on( 'click', '#add-contact-field', function() {
                var $new = $( '#contact_fields option:selected' ).text();
                var $value = $( '#contact_fields option:selected' ).val();

                if ( '' === $new.trim() ) {
                    swal( AnvaSectionLocal.contact_error_title, AnvaSectionLocal.contact_error_text );
                    return false;
                }
                if ( $( '.dynamic-contact-fields ul.contact-fields' ).children( '#field-' + $value ).length > 0 ) {
                    swal( AnvaSectionLocal.contact_exists_title, AnvaSectionLocal.contact_exists_text + ' "' + $new + '".' );
                    return false;
                }
                $( '.dynamic-contact-fields ul' ).removeClass( 'empty' );
                var $contactFieldName = $( '#contact_field_name' ).val();
                var $optionName = $( '#option_name' ).val();
                $( '.dynamic-contact-fields ul' ).append( '<li id="field-' + $value + '">' + $new + ' <a href="#" class="delete">' + AnvaSectionLocal.delete + '</a> <input type="hidden" name="' + $optionName + '[' + $contactFieldName + '][]' + '" value="' + $value + '" /></li>' );
                $( '.sidebar' ).val( '' );
            });
        }
    };

    AnvaSection.init();

});
