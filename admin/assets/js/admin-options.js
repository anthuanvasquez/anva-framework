jQuery( document ).ready( function( $ ) {

    'use strict';

    // Anva Options Object
    var AnvaOptions = {

        init: function() {
            AnvaOptions.settingsChange();
            AnvaOptions.showSpinner();
            AnvaOptions.resetSubmit();
            AnvaOptions.importSubmit();
            AnvaOptions.extras();
            AnvaOptions.stickyActions();
        },

        settingsChange: function() {
            $( 'input, select, textarea' ).on( 'change', function() {
                $( '#anva-options-change' ).show( 400 );
            });
        },

        showSpinner: function() {
            $( '#anva-framework-submit .update-button' ).on( 'click', function() {
                $( this ).val( AnvaOptionsLocal.save_button );
                $( this ).next( '.spinner' ).addClass( 'is-active' );
            });
        },

        resetSubmit: function() {
            $( document ).on( 'click', '.reset-button', function( e ) {
                e.preventDefault();
                var form = $( this ).closest( 'form' );
                swal({
                    title: AnvaOptionsLocal.save_button_title,
                    text: AnvaOptionsLocal.save_button_text,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0085ba',
                    confirmButtonText: AnvaOptionsLocal.save_button_confirm,
                    cancelButtonText: AnvaOptionsLocal.save_button_cancel,
                    cancelButtonColor: '#f7f7f7',
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function( isConfirm ) {
                    if ( isConfirm ) {
                        form.append( '<input type="hidden" name="reset" value="true" />' );
                        form.submit();
                    }
                });
            });
        },

        importSubmit: function() {
            $( document ).on( 'click', '.import-button', function( e ) {
                e.preventDefault();
                var form = $( this ).closest( 'form' );

                if ( '' === $( '#section-import_settings textarea' ).val() ) {
                    swal({
                        title: AnvaOptionsLocal.import_empty_title,
                        text: AnvaOptionsLocal.import_empty_text,
                        type: 'info',
                        showConfirmButton: true,
                        confirmButtonColor: '#0085ba',
                    });
                    return false;
                }

                swal({
                    title: AnvaOptionsLocal.import_button_title,
                    text: AnvaOptionsLocal.import_button_text,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0085ba',
                    confirmButtonText: AnvaOptionsLocal.import_button_confirm,
                    cancelButtonText: AnvaOptionsLocal.import_button_cancel,
                    cancelButtonColor: '#f7f7f7',
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function( isConfirm ) {
                    if ( isConfirm ) {
                        form.append( '<input type="hidden" name="import" value="true" />' );
                        form.submit();
                    }
                });
            });
        },

        extras: function() {

            // CodeMirror Editor.
            var codeEditor = $( '.anva-code-editor-wrap' );
            codeEditor.each( function() {
                var codeEditorText = $( this ).find( '.anva-code-editor' ),
                    codeEditorMode = $( this ).data( 'editor' );
                codeEditorText.codemirror({
                    lineNumbers: true,
                    lineWrapping: true,
                    mode: codeEditorMode,
                    gutters: ['CodeMirror-lint-markers'],
                    lint: true,
                    autoRefresh: true,
                    theme: 'mdn-like',
                    styleActiveLine: true,
                    matchBrackets: true
                });
            });

            // Load transition.
            $( '.animsition' ).animsition({
                inClass: 'fade-in',
                outClass: 'fade-out',
                inDuration: 1500,
                outDuration: 800,
                linkElement: '.animsition-link',
                loading: true,
                loadingParentElement: 'body',
                loadingClass: 'animsition-loading',
                loadingInner: '',
                timeout: false,
                timeoutCountdown: 5000,
                onLoadEvent: true,
                browser: [ 'animation-duration', '-webkit-animation-duration'],
                overlay: false,
                overlayClass: 'animsition-overlay-slide',
                overlayParentElement: 'body',
                transition: function( url ) {
                    window.location.href = url;
                }
            });

            $( '.animsition' ).on( 'animsition.inEnd', function() {
                setTimeout( function() {
                    $( '.CodeMirror' ).each( function( index, el ) {
                        el.CodeMirror.refresh();
                    });
                }, 100 );
            });

            // Collapse sections.
            $( '.inner-group > h3' ).on( 'click', function( e ) {
                e.preventDefault();
                var collapse = $( this ),
                    postbox  = collapse.closest( '.postbox' );

                if ( postbox.hasClass( 'collapse-close' ) ) {
                    postbox.removeClass( 'collapse-close' );
                    if ( typeof( localStorage ) !== 'undefined' ) {
                        localStorage.removeItem( 'anva-section-' + postbox.attr( 'id' ) );
                    }
                    postbox.find( '.section-css' ).each(function() {
                        var editor = $( this ).find( '.CodeMirror' );
                        if ( editor ) {
                            edito.each( function( index, el ) {
                                el.CodeMirror.refresh();
                            });
                        }
                    });
                } else {
                    postbox.addClass( 'collapse-close' );
                    if ( typeof( localStorage ) !== 'undefined' ) {
                        localStorage.setItem( 'anva-section-' + postbox.attr( 'id' ), true );
                    }
                }

            });

            // Show content.
            $( '#anva-framework .postbox' ).each(function() {
                var postbox = $( this );
                if ( typeof( localStorage ) !== 'undefined' && localStorage.getItem( 'anva-section-' + postbox.attr( 'id' ) ) ) {
                    postbox.addClass( 'collapse-close' );
                }
            });

            // Hide admin notices
            var error = $( '#anva-framework-wrap .settings-error' );
            if ( error.length > 0 ) {
                setTimeout( function() {
                    error.fadeOut( 500 );
                }, 3000 );
            }

            if ( $( '.nav-tab-wrapper' ).length > 0 ) {
                AnvaOptions.tabs();
            }

        },

        tabs: function() {
            var group      = $( '.group' ),
                navtabs    = $( '.nav-tab-wrapper a' ),
                active_tab = '';

            // Hides all the .group sections to start
            group.hide();

            // Find if a selected tab is saved in localStorage
            if ( typeof( localStorage ) !== 'undefined' ) {
                active_tab = localStorage.getItem( 'active_tab' );
            }

            // If active tab is saved and exists, load it's .group
            if ( active_tab !== '' && $( active_tab ).length ) {
                $( active_tab ).fadeIn();
                $( active_tab + '-tab' ).addClass( 'nav-tab-active' );
            } else {
                $( '.group:first' ).fadeIn();
                $( '.nav-tab-wrapper a:first' ).addClass( 'nav-tab-active' );
            }

            // Bind tabs clicks
            navtabs.on( 'click', function( e ) {
                e.preventDefault();

                var $this = $( this ),
                    selected = $this.attr( 'href' );

                // Remove active class from all tabs
                navtabs.removeClass( 'nav-tab-active' );

                $this.addClass( 'nav-tab-active' ).blur();

                if ( typeof( localStorage ) !== 'undefined' ) {
                    localStorage.setItem( 'active_tab', $this.attr( 'href' ) );
                }

                // Editor height sometimes needs adjustment when unhidden
                $( '.wp-editor-wrap' ).each( function() {
                    var editor_iframe = $( this ).find( 'iframe' );
                    if ( editor_iframe.height() < 30 ) {
                        editor_iframe.css({ 'height': 'auto' });
                    }
                });

                group.hide();
                $( selected ).fadeIn();
            });
        },

        stickyActions: function() {
            var wrapper = $( '#anva-framework' ),
                column  = wrapper.find( '.options-settings > .columns-2' ),
                postbox = wrapper.find( '.postbox-wrapper' );

            if ( $( window ).scrollTop() > 115 ) {
                column.addClass( 'is-sticky' );
                postbox.addClass( 'is-sticky' );
            } else {
                column.removeClass( 'is-sticky' );
                postbox.removeClass( 'is-sticky' );
            }
        }
    };

    AnvaOptions.init();

    // Window scroll change
    $( window ).on( 'scroll', function() {
        AnvaOptions.stickyActions();
    });

});
