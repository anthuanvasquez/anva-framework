jQuery( document ).ready( function( $ ) {

    'use strict';

    $( '.anva-field-link-mega-hide-headers' ).each(function() {
        var el   = $( this ),
            item = el.closest( '.menu-item' );
        if ( item.find( '.anva-field-link-mega input' ).is( ':checked' ) ) {
            el.find( 'label' ).css( 'display', 'block' );
        } else {
            el.find( 'label' ).css( 'display', 'none' );
        }
    });

    $( '.anva-field-link-mega-columns' ).each(function() {
        var el   = $( this ),
            item = el.closest( '.menu-item' );
        if ( item.find( '.anva-field-link-mega input' ).is( ':checked' ) ) {
            el.find( 'label' ).css( 'display', 'block' );
        } else {
            el.find( 'label' ).css( 'display', 'none' );
        }
    });

    $( '.anva-field-link-mega input' ).on( 'click', function() {
        var item = $( this ).closest( '.menu-item' );
        if ( item.find( '.anva-field-link-mega input' ).is( ':checked' ) ) {
            item.find( '.anva-field-link-mega-hide-headers label' ).css( 'display', 'block' );
            item.find( '.anva-field-link-mega-columns label' ).css( 'display', 'block' );
        } else {
            item.find( '.anva-field-link-mega-hide-headers label' ).css( 'display', 'none' );
            item.find( '.anva-field-link-mega-columns label' ).css( 'display', 'none' );
        }
    });

});
