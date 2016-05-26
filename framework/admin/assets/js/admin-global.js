jQuery( document ).ready( function( $ ) {

    "use strict";

    var ANVA_SECTIONS = {

        init: function() {
            ANVA_SECTIONS.colorPicker();
            ANVA_SECTIONS.radioImages();
            ANVA_SECTIONS.datePicker();
            ANVA_SECTIONS.spinner();
            ANVA_SECTIONS.logo();
            ANVA_SECTIONS.typography();
            ANVA_SECTIONS.socialMedia();
            ANVA_SECTIONS.columns();
            ANVA_SECTIONS.slider();
            ANVA_SECTIONS.rangeSlider();
            ANVA_SECTIONS.select();
            ANVA_SECTIONS.showHide();
            ANVA_SECTIONS.sidebars();
            ANVA_SECTIONS.contactFields();
        },

        colorPicker: function() {
            if ( $('.anva-color').length > 0 ) {
                $('.anva-color').wpColorPicker();
            }
        },

        radioImages: function() {
            $('.anva-radio-img-box').click( function() {
                $(this).closest('.section-images').find('.anva-radio-img-box').removeClass('anva-radio-img-selected');
                $(this).addClass('anva-radio-img-selected');
                $(this).find('.anva-radio-img-radio').prop('checked', true);
            });
            $('.anva-radio-img-img').show();
        },

        spinner: function() {
            if ( $('.anva-spinner').length > 0 ) {
                $('.anva-spinner').spinner();
            }
        },

        datePicker: function() {
            if ( $('.anva-date-picker').length > 0 ) {
                $('.anva-date-picker').datepicker({
                    showAnim: 'slideDown',
                    dateFormat: 'd MM, yy'
                });
            }
        },

        logo: function() {
            $('.section-logo').each(function(){
                var el = $(this), value = el.find('.select-type select').val();
                el.find('.logo-item').hide();
                el.find('.' + value).show();
            });

            $('.section-logo .anva-select select').on( 'change', function() {
                var el = $(this), parent = el.closest('.section-logo'), value = el.val();
                parent.find('.logo-item').hide();
                parent.find('.' + value).show();
            });
        },

        typography: function() {
            $('.section-typography .anva-typography-face').each(function() {
                var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
                if ( value === 'google' ) {
                    el.closest('.section-typography').find('.google-font').fadeIn('fast');
                    el.closest('.section-typography').find('.sample-text-font').hide();
                } else {
                    el.closest('.section-typography').find('.google-font').hide();
                    el.closest('.section-typography').find('.sample-text-font').show();
                    el.closest('.section-typography').find('.sample-text-font').css('font-family', text);
                }
            });

            $('.section-typography .anva-typography-face').on( 'change', function() {
                var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
                if ( value === 'google' ) {
                    el.closest('.section-typography').find('.google-font').fadeIn('fast');
                    el.closest('.section-typography').find('.sample-text-font').hide();
                } else {
                    el.closest('.section-typography').find('.google-font').hide();
                    el.closest('.section-typography').find('.sample-text-font').show();
                    el.closest('.section-typography').find('.sample-text-font').css('font-family', text);
                }
            });
        },

        socialMedia: function() {
            $('.section-social_media').each(function() {
                var el = $(this);
                el.find('.social_media-input').hide();
                el.find('.checkbox').each(function() {
                    var checkbox = $(this);
                    if ( checkbox.is(':checked') ) {
                        checkbox.closest('.item').addClass('active').find('.social_media-input').show();
                    } else {
                        checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
                    }
                });
            });

            $('.section-social_media .checkbox').on('click', function() {
                var checkbox = $(this);
                if ( checkbox.is(':checked') ) {
                    checkbox.closest('.item').addClass('active').find('.social_media-input').fadeIn('fast');
                } else {
                    checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
                }
            });
        },

        columns: function() {
            $('.section-columns').each(function(){
                var el = $(this), i = 1, num = el.find('.column-num').val();
                el.find('.column-width').hide();
                el.find('.column-width-'+num).show();
            });

            $('.section-columns .column-num').on('change', function(){
                var el = $(this), i = 1, num = el.val(), parent = el.closest('.section-columns');
                parent.find('.column-width').hide();
                parent.find('.column-width-'+num).fadeIn('fast');
            });
        },

        slider: function() {
            $('.group-slideshows').each(function() {
                var el = $(this), value = el.find('#slider_id').val();
                el.find('.slider-item').hide();
                el.find('.' + value).show();
            });

            $('.group-slideshows #slider_id').on( 'change', function() {
                var el = $(this), parent = el.closest('.group-slideshows'), value = el.val();
                parent.find('.slider-item').hide();
                parent.find('.' + value).show();
            });
        },

        rangeSlider: function() {

            $('.section-range, .section-typography .font-range').each(function() {
                var el = $(this),
                value = el.find('.anva-input-range').val(),
                id = el.find('.anva-input-range').attr('id'),
                min = el.find('.anva-input-range').data('min'),
                max = el.find('.anva-input-range').data('max'),
                step = el.find('.anva-input-range').data('step'),
                units = el.find('.anva-input-range').data('units');
                $('#' + id + '_range').slider({
                    min: min,
                    max: max,
                    step: step,
                    value: value,
                    slide: function( e, ui ) {
                        $('#' + id).val( ui.value );
                    }
                });
                $('#' + id).val( $('#' + id + '_range').slider( "value" ) );
                $('#' + id + '_range').slider("pips");
                $('#' + id + '_range').slider("float", { pips: true, suffix: "" + units });
            });
        },

        select: function() {
            // Fancy Select
            $('.anva-select-label').each(function(){
                var el = $(this),
                    value = el.find('select').val(),
                    text = el.find('option[value="' + value + '"]').text();
                el.find('span').text(text);
            });

            $('.anva-select-label select').live('change', function(){
                var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
                el.closest('.anva-select-label').find('span').text(text);
            });
        },

        showHide: function() {

            // Select Show Hide
            $('.section-select.show-hide select').each(function(){
                var el        = $(this),
                    value     = el.val(),
                    trigger   = el.closest('.section').data('trigger'),
                    receivers = el.closest('.section').data('receivers'),
                    loop      = receivers.split(' ');
                if ( value === trigger ) {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).hide();
                    });
                }
            });

            $('.section-select.show-hide select').on( 'change', function() {
                var el        = $(this),
                    value     = el.val(),
                    trigger   = el.closest('.section').data('trigger'),
                    receivers = el.closest('.section').data('receivers'),
                    loop      = receivers.split(' ');
                if ( value === trigger ) {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).hide();
                    });
                }
            });

            // Checkbox Show Hide
            $('.section-checkbox.show-hide input.anva-checkbox').each( function() {
                var el        = $(this),
                    value     = el.val(),
                    trigger   = el.closest('.section').data('trigger'),
                    receivers = el.closest('.section').data('receivers'),
                    loop      = receivers.split(' ');
                if ( el.is(':checked') ) {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).hide();
                    });
                }
            });

            $('.section-checkbox.show-hide input.anva-checkbox').on( 'click', function() {
                var el        = $(this),
                    value     = el.val(),
                    trigger   = el.closest('.section').data('trigger'),
                    receivers = el.closest('.section').data('receivers'),
                    loop      = receivers.split(' ');
                if ( el.is(':checked') ) {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).show();
                    });
                } else {
                    $.each( loop, function(index, el) {
                        $('#section-' + el).hide();
                    });
                }
            });
        },

        sidebars: function() {
            // Remove sidebar
            $('.dynamic-sidebars ul').sortable();
            $('.dynamic-sidebars ul').disableSelection();
            $(document).on( 'click', '.dynamic-sidebars .delete', function(e) {
                e.preventDefault();
                var $ele = $(this).parent();
                swal({
                    title: anvaJs.sidebar_button_title,
                    text: anvaJs.sidebar_button_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0085ba",
                    confirmButtonText: anvaJs.confirm,
                    cancelButtonText: anvaJs.cancel,
                    cancelButtonColor: "##f7f7f7",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function( isConfirm ) {

                    if ( isConfirm ) {
                        $ele.fadeOut();
                        setTimeout( function() {
                            $ele.remove();
                            if ( $('.dynamic-sidebars ul li').length === 0 ) {
                                $('.dynamic-sidebars ul').addClass('empty');
                            }
                        }, 500 );
                    }

                });
            });

            // Add new sidebar
            $('#add-sidebar').click( function() {
                var $new = $('.sidebar').val();
                if ( '' === $new.trim() ) {
                    swal( anvaJs.sidebar_error_title, anvaJs.sidebar_error_text );
                    return false;
                }
                if ( $new.length < 3 ) {
                    swal( 'Error', 'The name must have more than 3 characters.' );
                    return false;
                }
                $('.dynamic-sidebars ul').removeClass('empty');
                var $sidebarName = $('#dynamic_sidebar_name').val();
                var $optionName = $('#option_name').val();
                $('.dynamic-sidebars ul').append( '<li>' + $new + ' <a href="#" class="delete">' + anvaJs.delete + '</a> <input type="hidden" name="' + $optionName + '[' + $sidebarName + '][]' + '" value="' + $new + '" /></li>' );
                $('.sidebar').val('');
            });
        },

        contactFields: function() {
            // Contact fields
            $('.dynamic-contact-fields ul.contact-fields').sortable();
            $('.dynamic-contact-fields ul.contact-fields').disableSelection();
            $(document).on( 'click', '.dynamic-contact-fields .delete', function(e) {
                e.preventDefault();
                var $ele = $(this).parent();
                swal({
                    title: anvaJs.contact_button_title,
                    text: anvaJs.contact_button_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0085ba",
                    confirmButtonText: anvaJs.confirm,
                    cancelButtonText: anvaJs.cancel,
                    cancelButtonColor: "##f7f7f7",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function( isConfirm ) {
                    if ( isConfirm ) {
                        $ele.fadeOut();
                        setTimeout( function() {
                            $ele.remove();
                            if ( $('.dynamic-contact-fields ul li').length === 0 ) {
                                $('.dynamic-contact-fields ul').addClass('empty');
                            }
                        }, 500 );
                    }
                });
            });

            $(document).on( 'click', '#add-contact-field', function() {
                var $new = $('#contact_fields option:selected').text();
                var $value = $('#contact_fields option:selected').val();

                if ( '' === $new.trim() ) {
                    swal( anvaJs.contact_error_title, anvaJs.contact_error_text );
                    return false;
                }
                if ( $('.dynamic-contact-fields ul.contact-fields').children('#field-' + $value ).length > 0 ) {
                    swal( anvaJs.contact_exists_title, anvaJs.contact_exists_text + ' "' + $new + '".' );
                    return false;
                }
                $('.dynamic-contact-fields ul').removeClass('empty');
                var $contactFieldName = $('#contact_field_name').val();
                var $optionName = $('#option_name').val();
                $('.dynamic-contact-fields ul').append( '<li id="field-' + $value + '">' + $new + ' <a href="#" class="delete">' + anvaJs.delete + '</a> <input type="hidden" name="' + $optionName + '[' + $contactFieldName + '][]' + '" value="' + $value + '" /></li>' );
                $('.sidebar').val('');
            });
        }
    };

    ANVA_SECTIONS.init();

});
