jQuery( document ).ready( function( $ ) {

    $('.anva-field-link-mega-hide-headers').each(function(){

        var $el = $(this),
            $item = $el.closest('.menu-item');

        if ( $item.find('.anva-field-link-mega input').is(':checked') ) {
            $el.find('label').show();
        } else {
            $el.find('label').hide();
        }

    });

    $('.anva-field-link-mega-columns').each(function(){

        var $el = $(this),
            $item = $el.closest('.menu-item');

        if ( $item.find('.anva-field-link-mega input').is(':checked') ) {
            $el.find('label').show();
        } else {
            $el.find('label').hide();
        }

    });

    $('.anva-field-link-mega input').on('click', function(){

        var $item = $(this).closest('.menu-item');

        if ( $item.find('.anva-field-link-mega input').is(':checked') ) {
            $item.find('.anva-field-link-mega-hide-headers label').show();
            $item.find('.anva-field-link-mega-columns label').show();
        } else {
            $item.find('.anva-field-link-mega-hide-headers label').hide();
            $item.find('.anva-field-link-mega-columns label').hide();
        }

    });

});
