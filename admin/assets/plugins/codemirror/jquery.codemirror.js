( function( $ ) {
    $.fn.codemirror = function( options ) {
        var result = this;
        var settings = $.extend({
            'mode': 'css',
            'lineNumbers': false
        }, options );

        this.each( function() {
            result = CodeMirror.fromTextArea( this, settings );
        });

        return result;
    };
})( jQuery );
