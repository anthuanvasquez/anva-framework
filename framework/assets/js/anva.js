if ( typeof jQuery === 'undefined' ) {
	throw new Error( 'JavaScript requires $' );
}

var ANVA = ANVA || {};

(function($) {

	"use strict";

	// Initial
	ANVA.initialize = {

		init: function() {

			ANVA.initialize.responsiveLogo();
			ANVA.initialize.responsiveClasses();
			ANVA.initialize.lightbox();
			ANVA.initialize.primaryMenu();
			ANVA.initialize.menuTrigger();
			ANVA.initialize.removeEmptyEl('div.fl-thumbnail');
			ANVA.initialize.removeEmptyEl('p');
			ANVA.initialize.goToTop();
			ANVA.initialize.paginationButtons();
			ANVA.initialize.pageTransition();
			
		},

		responsiveLogo: function() {

		},

		responsiveClasses: function() {

			function handlerClass(className) {
				return {
					match : function() {
						$body.addClass(className);
					},
					unmatch : function() {
						$body.removeClass(className);
					}
				};
			}

			enquire.register("screen and (max-width: 10000px) and (min-width: " + ANVAJS.desktop + "px)", handlerClass('device-lg'));
			enquire.register("screen and (max-width: 1199px) and (min-width: " + ANVAJS.laptop + "px)", handlerClass('device-md'));
			enquire.register("screen and (max-width: 991px) and (min-width: " + ANVAJS.tablet + "px)", handlerClass('device-sm'));	
			enquire.register("screen and (max-width: 767px) and (min-width: " + ANVAJS.handheld + "px)", handlerClass('device-sx'));
			enquire.register("screen and (max-width: 479px) and (min-width: 0px)", handlerClass('device-xxs'));

		},

		lightbox: function() {
			var $lightboxImageEl 	= $('[data-lightbox="image"]'),
				$lightboxGalleryEl 	= $('[data-lightbox="gallery"]'),
				$lightboxIframeEl 	= $('[data-lightbox="iframe"]');

			// Image
			if ( $lightboxImageEl.length > 0 ) {
				$lightboxImageEl.magnificPopup({
					type: 'image',
					closeOnContentClick: true,
					closeBtnInside: false,
					fixedContentPos: true,
					mainClass: 'mfp-no-margins mfp-fade', // class to remove default margin from left and right side
					image: {
						verticalFit: true
					}
				});
			}

			// Gallery
			if ( $lightboxGalleryEl.length > 0 ) {
				$lightboxGalleryEl.each(function() {
					var element = $(this);

					element.magnificPopup({
						delegate: 'a[data-lightbox="gallery-item"]',
						type: 'image',
						closeOnContentClick: true,
						closeBtnInside: false,
						fixedContentPos: true,
						mainClass: 'mfp-no-margins mfp-fade', // class to remove default margin from left and right side
						image: {
							verticalFit: true
						},
						gallery: {
							enabled: true,
							navigateByImgClick: true,
							preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						tLoading: 'Loading image #%curr%...',
						image: {
							tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
							titleSrc: function(item) {
								return '<div class="gallery-caption"><h4>' + item.el.attr('title') + '</h4>' + '<p>' + item.el.attr('data-desc') + '</p></div>';
							}
						}
					});
				});
			}
			// Frame
			if ( $lightboxIframeEl.length > 0 ) {
				$lightboxIframeEl.magnificPopup({
					disableOn: 600,
					type: 'iframe',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			}
		},

		topScrollOffset: function() {
			var topOffsetScroll = 0;

			if ( ( $body.hasClass('device-lg') || $body.hasClass('device-md') ) && !ANVA.isMobile.any() ) {
				if ( $header.hasClass('sticky-header') ) {
					if ( $pagemenu.hasClass('dots-menu') ) { topOffsetScroll = 100; } else { topOffsetScroll = 144; }
				} else {
					if ( $pagemenu.hasClass('dots-menu') ) { topOffsetScroll = 140; } else { topOffsetScroll = 184; }
				}

				if ( !$pagemenu.length ) {
					if ( $header.hasClass('sticky-header') ) { topOffsetScroll = 100; } else { topOffsetScroll = 140; }
				}
			} else {
				topOffsetScroll = 40;
			}

			return topOffsetScroll;
		},

		defineColumns: function( element ){
			var column = 4;

			if( element.hasClass('portfolio-full') ) {
				if( element.hasClass('portfolio-3') ) column = 3;
				else if( element.hasClass('portfolio-5') ) column = 5;
				else if( element.hasClass('portfolio-6') ) column = 6;
				else column = 4;

				if( $body.hasClass('device-sm') && ( column == 4 || column == 5 || column == 6 ) ) {
					column = 3;
				} else if( $body.hasClass('device-xs') && ( column == 3 || column == 4 || column == 5 || column == 6 ) ) {
					column = 2;
				} else if( $body.hasClass('device-xxs') ) {
					column = 1;
				}
			} else if( element.hasClass('masonry-thumbs') ) {

				var lgCol = element.attr('data-lg-col'),
					mdCol = element.attr('data-md-col'),
					smCol = element.attr('data-sm-col'),
					xsCol = element.attr('data-xs-col'),
					xxsCol = element.attr('data-xxs-col');

				if( element.hasClass('col-2') ) column = 2;
				else if( element.hasClass('col-3') ) column = 3;
				else if( element.hasClass('col-5') ) column = 5;
				else if( element.hasClass('col-6') ) column = 6;
				else column = 4;

				if( $body.hasClass('device-lg') ) {
					if( lgCol ) { column = Number(lgCol); }
				} else if( $body.hasClass('device-md') ) {
					if( mdCol ) { column = Number(mdCol); }
				} else if( $body.hasClass('device-sm') ) {
					if( smCol ) { column = Number(smCol); }
				} else if( $body.hasClass('device-xs') ) {
					if( xsCol ) { column = Number(xsCol); }
				} else if( $body.hasClass('device-xxs') ) {
					if( xxsCol ) { column = Number(xxsCol); }
				}

			}

			return column;
		},

		setFullColumnWidth: function( element ){

			if( element.hasClass('portfolio-full') ) {
				var columns = ANVA.initialize.defineColumns( element );
				var containerWidth = element.width();
				if( containerWidth == ( Math.floor(containerWidth/columns) * columns ) ) { containerWidth = containerWidth - 1; }
				var postWidth = Math.floor(containerWidth/columns);
				if( $body.hasClass('device-xxs') ) { var deviceSmallest = 1; } else { var deviceSmallest = 0; }
				element.find(".portfolio-item").each(function(index){
					if( deviceSmallest == 0 && $(this).hasClass('wide') ) { var elementSize = ( postWidth*2 ); } else { var elementSize = postWidth; }
					$(this).css({"width":elementSize+"px"});
				});
			} else if( element.hasClass('masonry-thumbs') ) {
				var columns = ANVA.initialize.defineColumns( element ),
					containerWidth = element.innerWidth(),
					windowWidth = $window.width();
				if( containerWidth == windowWidth ){
					containerWidth = windowWidth*1.004;
					element.css({ 'width': containerWidth+'px' });
				}
				var postWidth = (containerWidth/columns);

				postWidth = Math.floor(postWidth);

				if( ( postWidth * columns ) >= containerWidth ) { element.css({ 'margin-right': '-1px' }); }

				element.children('a').css({"width":postWidth+"px"});

				var firstElementWidth = element.find('a:eq(0)').outerWidth();

				element.isotope({
					masonry: {
						columnWidth: firstElementWidth
					}
				});

				var bigImageNumbers = element.attr('data-big');
				if( bigImageNumbers ) {
					bigImageNumbers = bigImageNumbers.split(",");
					var bigImageNumber = '',
						bigi = '';
					for( bigi = 0; bigi < bigImageNumbers.length; bigi++ ){
						bigImageNumber = Number(bigImageNumbers[bigi]) - 1;
						element.find('a:eq('+bigImageNumber+')').css({ width: firstElementWidth*2 + 'px' });
					}
					var t = setTimeout( function(){
						element.isotope('layout');
					}, 1000 );
				}
			}

		},

		goToTop: function() {
			$goTop.click(function(e) {
				e.preventDefault();
				$root.animate({ scrollTop: 0 }, 400 );
			});
		},

		goToTopScroll: function()	{
			$window.scroll(function() {
				if ( $body.hasClass('device-lg') || $body.hasClass('device-md') || $body.hasClass('device-sm') ) {
					if ( $(this).scrollTop() > 450 ) {
						$goTop.fadeIn(200);
					} else {
						$goTop.fadeOut(200);
					}
				}
			});
		},

		primaryMenu: function() {
			$primaryMenu.superfish({
				popUpSelector: 'ul,.mega-menu-content',
				delay: 250,
				speed: 350,
				animation: {opacity:'show'},
				animationOut:  {opacity:'hide'},
				cssArrows: false
			});
		},

		menuTrigger: function() {
			var $offCanvasTrigger = $('#off-canvas-trigger'),
				$offCanvas = $('#off-canvas'),
				$primaryMenu = $('#primary-menu'),
				$primaryTrigger = $('#primary-menu-trigger');

			if ( $offCanvas.length > 0 ) {
				$body.addClass('js-ready');
				$offCanvasTrigger.click( function() {
					$offCanvas.toggleClass('is-active');
					$contain.toggleClass('is-active');
					return false;
				});

				$window.on( 'resize', function() {
					if ( $offCanvas.css('display') === 'block' ) {
						$offCanvas.removeClass('is-active');
						$contain.removeClass('is-active');
					}
				});

			} else if ( $primaryMenu.length > 0 ) {
				$primaryTrigger.click( function() {
					$primaryMenu.slideToggle();
					return false;
				});

				$window.on( 'resize', function() {
					if ( $primaryMenu.css('display') === 'none' ) {
						$primaryMenu.css('display', 'block');
					}
				});
			}
		},

		removeEmptyEl: function(selector) {
			$(selector + ':empty').remove();
			$(selector).filter( function() {
				return $.trim( $(this).html() ) == '';
			}).remove();
		},

		paginationButtons: function() {
			if ( $buttonNav.length > 0 ) {
				$buttonNav.addClass('button');
			}
		},

		menuTable: function() {
			var $menuContent 	= $("#menu-toc");
			if ( $menuContent.length > 0 ) {
				var	$menuTitle 		= $(".fl-menu ul > li > div.fl-menu-section > h2"),
					html = "<nav role='navigation' class='table-of-content'><h2 id='toc' class='alt'><i class='fa fa-bars'></i> Menú</h2><ul class='toc-list clearfix'>",
					id,
					list,
					element,
					title,
					link;
				$menuTitle.each( function() {
					element = $(this);
					id 			= $(this).parent('div.fl-menu-section');
					title 	= element.text();
					link 		= "#" + id.attr("id");
					list 		= "<li class='toc-item'><a href='" + link + "'>" + title + "</a></li>";
					html 	 += list;
				});
				html += "</ul></nav>";
				$menuContent.prepend( html );

				var $menuScrollTop 	= $('#menu-toc a, .fl-menu-section h2 a');
				if ( $menuScrollTop.length > 0 ) {
					$menuScrollTop.click(function() {
						$root.animate({
							scrollTop: $( $.attr(this, 'href') ).offset().top
						}, 'slow');
						return false;
					});
				}
			}
		},

		pageTransition: function(){
			if ( ! $body.hasClass('no-transition') ) {
				var animationIn = $body.attr('data-animation-in'),
					animationOut = $body.attr('data-animation-out'),
					durationIn = $body.attr('data-speed-in'),
					durationOut = $body.attr('data-speed-out'),
					loaderStyle = $body.attr('data-loader'),
					loaderColor = $body.attr('data-loader-color'),
					loaderStyleHtml = '<div class="css3-spinner-bounce1"></div><div class="css3-spinner-bounce2"></div><div class="css3-spinner-bounce3"></div>',
					loaderBgStyle = '',
					loaderBorderStyle = '',
					loaderBgClass = '',
					loaderBorderClass = '',
					loaderBgClass2 = '',
					loaderBorderClass2 = '';

				if ( ! animationIn ) { animationIn = 'fadeIn'; }
				if ( ! animationOut ) { animationOut = 'fadeOut'; }
				if ( ! durationIn ) { durationIn = 1500; }
				if ( ! durationOut ) { durationOut = 800; }

				if ( loaderColor ) {
					if ( loaderColor == 'theme' ) {
						loaderBgClass = ' bgcolor';
						loaderBorderClass = ' border-color';
						loaderBgClass2 = ' class="bgcolor"';
						loaderBorderClass2 = ' class="border-color"';
					} else {
						loaderBgStyle = ' style="background-color:'+ loaderColor +';"';
						loaderBorderStyle = ' style="border-color:'+ loaderColor +';"';
					}
					loaderStyleHtml = '<div class="css3-spinner-bounce1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-bounce2'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-bounce3'+ loaderBgClass +'"'+ loaderBgStyle +'></div>'
				}

				if ( loaderStyle == '2' ) {
					loaderStyleHtml = '<div class="css3-spinner-flipper'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
				} else if( loaderStyle == '3' ) {
					loaderStyleHtml = '<div class="css3-spinner-double-bounce1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-double-bounce2'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
				} else if( loaderStyle == '4' ) {
					loaderStyleHtml = '<div class="css3-spinner-rect1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect2'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect3'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect4'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect5'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
				} else if( loaderStyle == '5' ) {
					loaderStyleHtml = '<div class="css3-spinner-cube1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-cube2'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
				} else if( loaderStyle == '6' ) {
					loaderStyleHtml = '<div class="css3-spinner-scaler'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
				} else if( loaderStyle == '7' ) {
					loaderStyleHtml = '<div class="css3-spinner-grid-pulse"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
				} else if( loaderStyle == '8' ) {
					loaderStyleHtml = '<div class="css3-spinner-clip-rotate"><div'+ loaderBorderClass2 + loaderBorderStyle +'></div></div>';
				} else if( loaderStyle == '9' ) {
					loaderStyleHtml = '<div class="css3-spinner-ball-rotate"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
				} else if( loaderStyle == '10' ) {
					loaderStyleHtml = '<div class="css3-spinner-zig-zag"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
				} else if( loaderStyle == '11' ) {
					loaderStyleHtml = '<div class="css3-spinner-triangle-path"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
				} else if( loaderStyle == '12' ) {
					loaderStyleHtml = '<div class="css3-spinner-ball-scale-multiple"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
				} else if( loaderStyle == '13' ) {
					loaderStyleHtml = '<div class="css3-spinner-ball-pulse-sync"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
				} else if( loaderStyle == '14' ) {
					loaderStyleHtml = '<div class="css3-spinner-scale-ripple"><div'+ loaderBorderClass2 + loaderBorderStyle +'></div><div'+ loaderBorderClass2 + loaderBorderStyle +'></div><div'+ loaderBorderClass2 + loaderBorderStyle +'></div></div>';
				}

				$wrapper.animsition({
					inClass : animationIn,
					outClass : animationOut,
					inDuration : Number(durationIn),
					outDuration : Number(durationOut),
					linkElement : '#primary-menu ul li a:not([target="_blank"]):not([href^=#])',
					loading : true,
					loadingParentElement : 'body',
					loadingClass : 'css3-spinner',
					loadingHtml : loaderStyleHtml,
					unSupportCss : [
									 'animation-duration',
									 '-webkit-animation-duration',
									 '-o-animation-duration'
									 ],
					overlay : false,
					overlayClass : 'animsition-overlay-slide',
					overlayParentElement : 'body'
				});
			}
		}
	};

	ANVA.header = {

		init: function() {
			ANVA.header.topsearch();
		},

		topsearch: function() {

			$(document).on( 'click', function(e) {
				if ( ! $(e.target).closest('#top-search').length) {
					$body.toggleClass('top-search-open', false);
				}
				if ( ! $(e.target).closest('#top-cart').length) {
					$topCart.toggleClass('top-cart-open', false);
				}
			});

			$('#top-search-trigger').click( function(e) {

				$body.toggleClass('top-search-open');
				$topCart.toggleClass('top-cart-open', false);

				if ( $body.hasClass('top-search-open') ) {
					$topSearch.find('input').focus();
				}

				e.stopPropagation();
				e.preventDefault();
			});

		}
	};

	ANVA.widget = {
		
		init: function() {
			ANVA.widget.animations();
			ANVA.widget.counter();
			ANVA.widget.wpCalendar();
			// ANVA.widget.instagramPhotos( ANVA.config.instagramID, ANVA.config.instagramSecret );
			ANVA.widget.toggles();
			ANVA.widget.youtubeBgVideo();
			ANVA.widget.extras();
		},

		animations: function() {
			var $dataAnimateEl = $('[data-animate]');
			if ( $dataAnimateEl.length > 0 ){
				if ( $body.hasClass('device-lg') || $body.hasClass('device-md') || $body.hasClass('device-sm') ) {
					$dataAnimateEl.each( function(){
						var element = $(this),
							animationDelay = element.attr('data-delay'),
							animationDelayTime = 0;

						if ( animationDelay ) { animationDelayTime = Number( animationDelay ) + 500; } else { animationDelayTime = 500; }

						if ( ! element.hasClass('animated') ) {
							element.addClass('not-animated');
							var elementAnimation = element.attr('data-animate');
							element.appear(function () {
								setTimeout(function() {
									element.removeClass('not-animated').addClass( elementAnimation + ' animated');
								}, animationDelayTime);
							},{ accX: 0, accY: -120 },'easeInCubic');
						}
					});
				}
			}
		},
		
		counter: function() {
			var $counterEl = $('.counter:not(.counter-instant)');
			if ( $counterEl.length > 0 ){
				$counterEl.each(function(){
					var element = $(this);
					var counterElementComma = $(this).find('span').attr('data-comma');
					if ( !counterElementComma ) {
						counterElementComma = false;
					} else {
						counterElementComma = true;
					}
					if ( $body.hasClass('device-lg') || $body.hasClass('device-md' ) ) {
						element.appear( function() {
							ANVA.widget.runCounter( element, counterElementComma );
						}, { accX: 0, accY: -120 },'easeInCubic');
					} else {
						ANVA.widget.runCounter( element, counterElementComma );
					}
				});
			}
		},

		runCounter: function( counterElement, counterElementComma ){
			if ( counterElementComma == true ) {
				counterElement.find('span').countTo({
					formatter: function (value, options) {
						value = value.toFixed(options.decimals);
						value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
						return value;
					}
				});
			} else {
				counterElement.find('span').countTo();
			}
		},

		masonryThumbs: function(){
			var $masonryThumbsEl = $('.masonry-thumbs');
			if( $masonryThumbsEl.length > 0 ){
				$masonryThumbsEl.each( function(){
					var masonryItemContainer = $(this);
					ANVA.widget.masonryThumbsArrange( masonryItemContainer );
				});
			}
		},

		masonryThumbsArrange: function( element ){
			ANVA.initialize.setFullColumnWidth( element );
			element.isotope('layout');
		},

		wpCalendar: function() {
			if ( $wpCalendar.length > 0 ) {
				$wpCalendar.addClass('table table-bordered table-condensed table-responsive').find('tfoot a').addClass('btn btn-default')
			}
		},

		instagramPhotos: function( c$accessToken, c$clientID ) {
			var $instagramPhotosEl = $('.instagram-photos');
			if ( $instagramPhotosEl.length > 0 ) {
				$.fn.spectragram.accessData = {
					accessToken: c$accessToken,
					clientID: c$clientID
				};

				$instagramPhotosEl.each(function() {
					var element = $(this),
						instaGramUsername = element.attr('data-user'),
						instaGramTag 			= element.attr('data-tag'),
						instaGramCount 		= element.attr('data-count'),
						instaGramType 		= element.attr('data-type');

					if ( !instaGramCount ) {
						instaGramCount = 9;
					}

					if ( instaGramType == 'tag' ) {
						element.spectragram('getRecentTagged',{
							query: instaGramTag,
							max: Number( instaGramCount ),
							size: 'medium',
							wrapEachWith: ' '
						});
					} else if ( instaGramType == 'user' ) {
						element.spectragram('getUserFeed',{
							query: instaGramUsername,
							max: Number( instaGramCount ),
							size: 'medium',
							wrapEachWith: ' '
						});
					} else {
						element.spectragram('getPopular',{
							max: Number( instaGramCount ),
							size: 'medium',
							wrapEachWith: ' '
						});
					}
				});
			}
		},

		toggles: function(){
			var $toggle = $('.toggle');
			if ( $toggle.length > 0 ) {
				$toggle.each( function(){
					var element = $(this),
						elementState = element.attr('data-state');

					if ( elementState != 'open' ){
						element.find('.toggle-content').hide();
					} else {
						element.find('.toggle-ttitle').addClass("toggle-title-a");
					}

					element.find('.toggle-title').click(function(){
						$(this).toggleClass('toggle-title-a').next('.toggle-content').slideToggle(300);
						return true;
					});
				});
			}
		},

		linkScroll: function(){
			$("a[data-scrollto]").click(function(){
				var element = $(this),
					divScrollToAnchor = element.attr('data-scrollto'),
					divScrollSpeed = element.attr('data-speed'),
					divScrollOffset = element.attr('data-offset'),
					divScrollEasing = element.attr('data-easing');

					if ( !divScrollSpeed ) { divScrollSpeed = 750; }
					if ( !divScrollOffset ) { divScrollOffset = ANVA.initialize.topScrollOffset(); }
					if ( !divScrollEasing ) { divScrollEasing = 'easeOutQuad'; }

				$root.stop(true).animate({
					'scrollTop': $( divScrollToAnchor ).offset().top - Number(divScrollOffset)
				}, Number(divScrollSpeed), divScrollEasing);

				return false;
			});
		},

		youtubeBgVideo: function() {
			if ( $youtubeBgPlayerEl.length > 0 ) {
				$youtubeBgPlayerEl.each( function() {
					var element = $(this),
						ytbgVideo = element.attr('data-video'),
						ytbgMute = element.attr('data-mute'),
						ytbgRatio = element.attr('data-ratio'),
						ytbgQuality = element.attr('data-quality'),
						ytbgOpacity = element.attr('data-opacity'),
						ytbgContainer = element.attr('data-container'),
						ytbgOptimize = element.attr('data-optimize'),
						ytbgLoop = element.attr('data-loop'),
						ytbgVolume = element.attr('data-volume'),
						ytbgStart = element.attr('data-start'),
						ytbgStop = element.attr('data-stop'),
						ytbgAutoPlay = element.attr('data-autoplay'),
						ytbgFullScreen = element.attr('data-fullscreen');

					if ( ytbgMute == 'false' ) { ytbgMute = false; } else { ytbgMute = true; }
					if ( !ytbgRatio ) { ytbgRatio = '16/9'; }
					if ( !ytbgQuality ) { ytbgQuality = 'hd720'; }
					if ( !ytbgOpacity ) { ytbgOpacity = 1; }
					if ( !ytbgContainer ) { ytbgContainer = 'self'; }
					if ( ytbgOptimize == 'false' ) { ytbgOptimize = false; } else { ytbgOptimize = true; }
					if ( ytbgLoop == 'false' ) { ytbgLoop = false; } else { ytbgLoop = true; }
					if ( !ytbgVolume ) { ytbgVolume = 1; }
					if ( !ytbgStart ) { ytbgStart = 0; }
					if ( !ytbgStop ) { ytbgStop = 0; }
					if ( ytbgAutoPlay == 'false' ) { ytbgAutoPlay = false; } else { ytbgAutoPlay = true; }
					if ( ytbgFullScreen == 'true' ) { ytbgFullScreen = true; } else { ytbgFullScreen = false; }

					element.mb_YTPlayer({
						videoURL: ytbgVideo,
						mute: ytbgMute,
						ratio: ytbgRatio,
						quality: ytbgQuality,
						opacity: ytbgOpacity,
						containment: ytbgContainer,
						optimizeDisplay: ytbgOptimize,
						loop: ytbgLoop,
						vol: ytbgVolume,
						startAt: ytbgStart,
						stopAt: ytbgStop,
						autoplay: ytbgAutoPlay,
						realfullscreen: ytbgFullScreen,
						showYTLogo: false,
						showControls: false
					});
				});
			}
		},

		extras: function() {
			$('[data-toggle="tooltip"]').tooltip({
				container: 'body'
			});

			$('#wrapper').fitVids();

			if ( ANVA.isMobile.any() ) {
				$body.addClass('device-touch');
			}
		}
	};

	ANVA.isBrowser = {
		any: function() {
			
		}
	};

	ANVA.isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (ANVA.isMobile.Android() || ANVA.isMobile.BlackBerry() || ANVA.isMobile.iOS() || ANVA.isMobile.Opera() || ANVA.isMobile.Windows());
		}
	};

	ANVA.slider = {

		init: function() {
			ANVA.slider.loadOwl();
			ANVA.slider.loadOwlCaption();
			ANVA.slider.loadNivo();
			ANVA.slider.loadFlexSlider();
			ANVA.slider.loadSwiper();
		},

		loadOwl: function() {
			var $ocSlider = $("#oc-slider");
			if ( $ocSlider.length > 0 ) {
				$ocSlider.owlCarousel({
					items: 1,
					nav: true,
					navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
					animateOut: 'slideOutDown',
					animateIn: 'zoomIn',
					smartSpeed: 450,
					loop: true
				});
			}
		},

		loadOwlCaption: function() {
			var $owlCarouselEl = $('.owl-carousel');
			if ( $owlCarouselEl.length > 0 ) {
				$owlCarouselEl.each( function() {
					var element = $(this);
					if ( element.find('.owl-dot').length > 0 ) {
						element.find('.owl-controls').addClass('with-carousel-dots');
					}
				});
			}
		},

		loadCamera: function() {
			var $cameraEle = $('#camera_wrap_1');
			if ( $cameraEle.length > 0 ) {
				$cameraEle.camera({
					thumbnails: true,
					height: '40%',
					loader: 'pie',
					loaderPadding: 1,
					loaderStroke: 5,
					onLoaded: function() {
						$cameraEle.find('.camera_next').html('<i class="fa fa-angle-right"></i>');
						$cameraEle.find('.camera_prev').html('<i class="fa fa-angle-left"></i>');
					}
				});
			}
		},

		loadNivo: function() {
			var $nivoSlider = $('.nivoSlider');
			if ( $nivoSlider.length > 0 ) {
				$nivoSlider.nivoSlider({
					effect: 'random',
					slices: 15,
					boxCols: 12,
					boxRows: 6,
					animSpeed: 500,
					pauseTime: 7000,
					directionNav: true,
					controlNav: true,
					pauseOnHover: true,
					prevText: '<i class="fa fa-angle-left"></i>',
					nextText: '<i class="fa fa-angle-right"></i>',
					afterLoad: function() {
						$('#slider').find('.nivo-caption').addClass('slider-caption-bg');
					}
				});
			}
		},

		loadFlexSlider: function() {
			var $flexSliderEl = $('.fslider').find('.flexslider');
			if ( $flexSliderEl.length > 0 ) {
				$flexSliderEl.each(function() {
					var $flexsSlider 	= $(this),
						flexsAnimation 	= $flexsSlider.parent('.fslider').attr('data-animation'),
						flexsEasing 		= $flexsSlider.parent('.fslider').attr('data-easing'),
						flexsDirection 	= $flexsSlider.parent('.fslider').attr('data-direction'),
						flexsSlideshow 	= $flexsSlider.parent('.fslider').attr('data-slideshow'),
						flexsPause 			= $flexsSlider.parent('.fslider').attr('data-pause'),
						flexsSpeed 			= $flexsSlider.parent('.fslider').attr('data-speed'),
						flexsVideo 			= $flexsSlider.parent('.fslider').attr('data-video'),
						flexsPagi 			= $flexsSlider.parent('.fslider').attr('data-pagi'),
						flexsArrows 		= $flexsSlider.parent('.fslider').attr('data-arrows'),
						flexsThumbs 		= $flexsSlider.parent('.fslider').attr('data-thumbs'),
						flexsHover 			= $flexsSlider.parent('.fslider').attr('data-hover'),
						flexsSheight 		= true,
						flexsUseCSS 		= false;

					if ( ! flexsAnimation ) { flexsAnimation = 'slide'; }
					if ( ! flexsEasing || flexsEasing == 'swing' ) {
						flexsEasing = 'swing';
						flexsUseCSS = true;
					}

					if ( ! flexsDirection ) { flexsDirection = 'horizontal'; }
					if ( ! flexsSlideshow ) { flexsSlideshow = true; } else { flexsSlideshow = false; }
					if ( ! flexsPause ) { flexsPause = 5000; }
					if ( ! flexsSpeed ) { flexsSpeed = 600; }
					if ( ! flexsVideo ) { flexsVideo = false; }
					if ( flexsDirection == 'vertical' ) { flexsSheight = false; }
					if ( flexsPagi == 'false' ) { flexsPagi = false; } else { flexsPagi = true; }
					if ( flexsThumbs == 'true' ) { flexsPagi = 'thumbnails'; } else { flexsPagi = flexsPagi; }
					if ( flexsArrows == 'false' ) { flexsArrows = false; } else { flexsArrows = true; }
					if ( flexsHover == 'false' ) { flexsHover = false; } else { flexsHover = true; }

					$flexsSlider.flexslider({
						selector: ".slider-wrap > .slide",
						animation: flexsAnimation,
						easing: flexsEasing,
						direction: flexsDirection,
						slideshow: flexsSlideshow,
						slideshowSpeed: Number(flexsPause),
						animationSpeed: Number(flexsSpeed),
						pauseOnHover: flexsHover,
						video: flexsVideo,
						controlNav: flexsPagi,
						directionNav: flexsArrows,
						smoothHeight: flexsSheight,
						useCSS: flexsUseCSS,
						start: function( slider ) {
							ANVA.widget.animations();
							slider.parent().removeClass('preloader2');
							$('.flex-prev').html('<i class="fa fa-angle-left"></i>');
							$('.flex-next').html('<i class="fa fa-angle-right"></i>');
						},
					});
				});
			}
		},

		loadSwiper: function() {
			if ( $('.swiper-container').length > 0 ) {
				var mySwiper = new Swiper ('.swiper-container', {
					pagination: '.swiper-pagination',
					nextButton: '#slider-arrow-left',
					prevButton: '#slider-arrow-right',
					slidesPerView: 1,
					paginationClickable: true,
					spaceBetween: 30,
					loop: true,
					onInit: function(swiper) {
						$('[data-caption-animate]').each(function(){
							var $toAnimateElement = $(this);
							var toAnimateDelay = $(this).attr('data-caption-delay');
							var toAnimateDelayTime = 0;
							
							if ( toAnimateDelay ) {
								toAnimateDelayTime = Number( toAnimateDelay ) + 750;
							} else {
								toAnimateDelayTime = 750;
							}

							if ( !$toAnimateElement.hasClass('animated') ) {
								$toAnimateElement.addClass('not-animated');
								var elementAnimation = $toAnimateElement.attr('data-caption-animate');
								setTimeout(function() {
									$toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
								}, toAnimateDelayTime );
							}
					});
				},
				onSlideChangeStart: function(swiper) {
					$('#slide-number-current').html(swiper.activeIndex + 1);
					$('[data-caption-animate]').each(function() {
						var $toAnimateElement = $(this);
						var elementAnimation = $toAnimateElement.attr('data-caption-animate');
						$toAnimateElement.removeClass('animated').removeClass(elementAnimation).addClass('not-animated');
					});
				},
				onSlideChangeEnd: function(swiper) {
						$('#slider').find('.swiper-slide').each(function() {
							if ( $(this).find('video').length > 0) {
								$(this).find('video').get(0).pause();
							}
							if ( $(this).find('.yt-bg-player').length > 0) {
								$(this).find('.yt-bg-player').pauseYTP();
							}
						});

						$('#slider').find('.swiper-slide:not(".swiper-slide-active")').each(function() {
							if ( $(this).find('video').length > 0) {
								if ( $(this).find('video').get(0).currentTime != 0 ) {
									$(this).find('video').get(0).currentTime = 0;
								}
							}
							if ( $(this).find('.yt-bg-player').length > 0) {
								$(this).find('.yt-bg-player').getPlayer().seekTo( $(this).find('.yt-bg-player').attr('data-start') );
							}
						});
						
						if ( $('#slider').find('.swiper-slide.swiper-slide-active').find('video').length > 0 ) {
							$('#slider').find('.swiper-slide.swiper-slide-active').find('video').get(0).play();
						}
						
						if ( $('#slider').find('.swiper-slide.swiper-slide-active').find('.yt-bg-player').length > 0 ) {
							$('#slider').find('.swiper-slide.swiper-slide-active').find('.yt-bg-player').playYTP();
						}

						$('#slider .swiper-slide.swiper-slide-active [data-caption-animate]').each(function(){
							var $toAnimateElement = $(this);
							var toAnimateDelay = $(this).attr('data-caption-delay');
							var toAnimateDelayTime = 0;
							
							if ( toAnimateDelay ) {
								toAnimateDelayTime = Number( toAnimateDelay ) + 300;
							} else {
								toAnimateDelayTime = 300;
							}

							if ( !$toAnimateElement.hasClass('animated') ) {
								$toAnimateElement.addClass('not-animated');
								var elementAnimation = $toAnimateElement.attr('data-caption-animate');
								setTimeout(function() {
									$toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
								}, toAnimateDelayTime );
							}
						});
					}
				});
			}
		}
	};

	ANVA.documentOnReady = {
		
		init: function() {
			ANVA.initialize.init();
			ANVA.header.init();
			ANVA.widget.init();
			ANVA.isBrowser.any();
			ANVA.documentOnReady.windowScroll();	
		},

		windowScroll: function() {
			$window.on( 'scroll', function() {
				ANVA.initialize.goToTopScroll();
			});
		}
	};

	ANVA.documentOnLoad = {
		
		init: function() {
			ANVA.widget.masonryThumbs();
			ANVA.slider.init();
		}

	};

	ANVA.documentOnResize = {
		
		init: function() {
			ANVA.widget.masonryThumbs();
		}

	};

	ANVA.config = {
		instaID: 			'43dd505ce2c04bd1aa2230726e9300e1',
		instaSecret: 	'7eceb8870d854d8b999262f0496906ea',
		flickrID: "",
		flickrSecret: ""
	};

	var $window 				 = $(window),
		$root 						 = $('html, body'),
		$body 						 = $('body'),
		$wrapper 					 = $('#wrapper'),
		$header 					 = $('#header'),
		$topSearch 				 = $('#top-search'),
		$topCart 					 = $('#top-cart'),
		$contain 					 = $('#container'),
		$footer 					 = $('#footer'),
		$goTop						 = $('#gotop'),
		$primaryMenu 	 		 = $('#primary-menu ul.sf-menu'),
		$wpCalendar				 = $('#wp-calendar'),
		$buttonNav				 = $('.next a[rel="next"], .previous a[rel="prev"]'),
		$youtubeBgPlayerEl = $('.yt-bg-player');

	$(document).ready( ANVA.documentOnReady.init );
	$(window).load( ANVA.documentOnLoad.init );
	$(window).on( 'resize', ANVA.documentOnResize.init );

})(jQuery);