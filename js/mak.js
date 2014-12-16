(function($){
	var page                      = $('#page');
	var positionGroup             = $('#masthead, #slide-box, #carousel-box, #khm-15, #content, #editor-choice-box, #colophon');

	var search                    = $('.search-foam-box');
	var searchField               = search.find('.search-field');
	var searchToggle              = search.children('.search-toggle');

	var slideBox                  = $('#slide-box');
	var slide                     = slideBox.children('#slide');
	var globalNavBox              = $('#global-nav-box');
	var nh                        = globalNavBox.outerHeight();
	var menuGlobalNenu            = globalNavBox.children('ul');
	var menuList                  = menuGlobalNenu.children('li');
	var carouselBox               = $('#carousel-box');
	var carousel                  = carouselBox.children('#carousel');

	var categoryInductionBox      = $('aside#category-induction');
	var categoryInductionNav      = categoryInductionBox.children('nav#category-induction-nav');
	var categoryInductionClick    = categoryInductionNav.find('li');
	var categoryInductionContents = categoryInductionBox.children('ul.category-induction-content');

	var main                      = $('#primary');
	var mainHeight                = main.innerHeight();

	var side                      = $('#secondary');
	var sidePosition              = side.position().top;
	var sideHeight                = side.innerHeight();
	var sideFixedPosition         = side.children().last();
	var sideFixedPositionHeight   = sideFixedPosition.outerHeight(true);
	var ranking                   = side.children('section.widget-ranking');
	var rankingNav                = ranking.find('p');
	var rankingList               = ranking.children('ol');

	var editorChoiceBox           = $('#editor-choice-box');
	var editorChoice              = editorChoiceBox.children('#editor-choice');

	var footerMenu                = $('nav#footer-nav-box');
	var footerMenuList            = footerMenu.find('li');

	var backgroundLink            = $('div#background-link');
	var trunk8                    = $( '.trunk8' );
	var trunk8Lines               = '';
	var imagePopup                = $('a.image-popup');
	var entryContent         = $('section.entry-content');
	var entryContentiflame   = entryContent.find('iframe');

	var adminBar                  = $('#wpadminbar');
	var adminBarHeight            = 0;
	if ( $('body').hasClass('admin-bar') )
		adminBarHeight = 32;

	function is_browser( browser ) {
		var ua = navigator.userAgent.toLowerCase();
		if ( ua.indexOf( browser ) != -1 ) {
			return true;
		}
	}

	if ( searchToggle[0] ) {
		if ( searchField.val() ) {
			searchField.addClass('search-open');
		} else {
			searchField.addClass('search-close');
		}
		searchToggle.on( 'click', function(e) {
			e.preventDefault();
			if ( searchField.hasClass('search-open') ) {
				searchField.removeClass('search-open').addClass('search-close');
			} else {
				searchField.addClass('search-open').removeClass('search-close');
				searchField.focus();
			}
		});
	}
	if ( slideBox[0] ) {
		slideSpeed = parseInt( slide.attr( 'data-speed' ), 10 );
		slidePause = parseInt( slide.attr( 'data-pause' ), 10 );
		slide.imagesLoaded(function(){
			slide.bxSlider({
				mode: 'fade',
				speed: slideSpeed,
				pager: false,
				controls: false,
				auto: true,
				pause: slidePause,
				autoHover: true
			});
		});
	}
	if ( globalNavBox[0] ) {

		var globalNavLength   = menuList.length;
		var globalNavBoxWidth = globalNavBox.width();
		var menuListWidth     = ( globalNavBoxWidth / globalNavLength );
		menuList.css({
			width: menuListWidth
		});
		var npt = globalNavBox.position().top;
		globalNavBox.headroom({
			offset : npt,
			classes : {
				initial : 'headroom-nav',
				top     : 'nav--top',
				notTop  : 'nav--not-top'
			}
		});
		$(window).scroll(function(e) {
			var $window    = $(e.currentTarget),
			scrollPosition = $window.scrollTop();
			if ( npt < scrollPosition ) {
				if ( !$('div#stopper')[0] ) {
					globalNavBox.after('<div id="stopper"></div>');
					$('div#stopper').css({
						'height': nh
					});
				}
			} else {
				if ( $('div#stopper')[0] ) {
					$('div#stopper').remove();
				}
			}

		});
	}
	if ( carouselBox[0] ) {
		carouselSpeed = parseInt( carousel.attr( 'data-speed' ), 10 );
		carouselPause = parseInt( carousel.attr( 'data-pause' ), 10 );
		carousel.imagesLoaded(function(){
			carousel.bxSlider({
				speed: carouselSpeed,
				pause: carouselPause,
				auto: true,
				autoHover: true,
				pager: false,
				controls: true,
				slideWidth: 290,
				minSlides: 2,
				maxSlides: 3,
				slideMargin: 30,
				nextText: '<i class="fa fa-caret-right"></i>',
				prevText: '<i class="fa fa-caret-left"></i>'
			});
		});
	}
	if ( categoryInductionBox[0] ) {
		var categoryLength = categoryInductionClick.length;
		var categoryInductionBoxWidth = categoryInductionBox.width();
		var categoryInductionNavWidth = categoryInductionBoxWidth / categoryLength;
		categoryInductionClick.css({
			width: categoryInductionNavWidth
		});
		categoryInductionClick.on( 'click', function(e) {
			if ( ! $(this).hasClass( 'current') ) {
				var target = $(this).attr( 'data-target' );
				categoryInductionClick.removeClass( 'current' );
				$(this).addClass( 'current' );
				categoryInductionContents.removeClass( 'current' );
				categoryInductionBox.children( 'ul#' + target ).addClass( 'current' );
			}
			if( trunk8[0] ) {
				trunk8.each( function() {
					trunk8Lines = parseInt( $(this).attr( 'data-lines' ), 10 );
					floatValue = $(this).css( 'float' );

					if ( $(this).hasClass('entry-summary') ) {
						$(this).children('p').trunk8({
							lines: trunk8Lines,
							fill: '&hellip;'
						});
					} else {
						if ( is_browser( 'firefox' ) && floatValue != 'none' ) {
							trunk8Lines = trunk8Lines + 1;
						}
						$(this).trunk8({
							lines: trunk8Lines,
							fill: '&hellip;'
						});
					}
				});
			}
		});
	}
	/*
	if ( side[0] ) {
		$(document).ready( function(){
			if ( mainHeight > sideHeight ) {
				var sTop = nh + 17;
				var spt  = sideFixedPosition.position().top - sTop;
				sideFixedPosition.headroom({
					offset : spt,
					classes : {
						initial : 'side',
						top     : 'side--top',
						notTop  : 'side--not-top'
					}
				});
				$(window).scroll(function(e) {
					var $window    = $(e.currentTarget),
					scrollPosition = $window.scrollTop(),
					ecp    = editorChoiceBox.position().top,
					sfph   = sideFixedPositionHeight + sTop + scrollPosition,
					sfphs  = ecp - sideFixedPositionHeight - sidePosition;
					if ( spt < scrollPosition ) {
						if ( ecp <= sfph ) {
							sideFixedPosition.css({
								'top': sfphs + adminBarHeight,
								'position': 'absolute'
							});
						} else {
							sideFixedPosition.css({
								'top': sTop + adminBarHeight,
								'position': ''
							});
						}
					} else {
						sideFixedPosition.css({
							'top': 0,
							'position': ''
						});
					}
				});
			}
		});
	}
	*/
	if ( ranking[0] ) {
		rankingNav.on( 'click', function() {
			if ( ! $(this).hasClass( 'current') ) {
				var target = $(this).attr( 'data-target' );
				console.log(target);
				rankingNav.removeClass( 'current' );
				$(this).addClass( 'current' );
				rankingList.removeClass( 'current' );
				ranking.children( '#' + target ).addClass( 'current' );
			}
		});
	}
	if ( editorChoiceBox[0] ) {
		editorSpeed = parseInt( editorChoice.attr( 'data-speed' ), 10 );
		editorPause = parseInt( editorChoice.attr( 'data-pause' ), 10 );
		editorChoice.imagesLoaded(function(){
			editorChoice.bxSlider({
				speed: editorSpeed,
				pause: editorPause,
				auto: true,
				autoHover: true,
				pager: false,
				controls: true,
				slideWidth: 290,
				minSlides: 2,
				maxSlides: 3,
				slideMargin: 30,
				nextText: '<i class="fa fa-caret-right"></i>',
				prevText: '<i class="fa fa-caret-left"></i>'
			});
		});
	}
	if ( footerMenu[0] ) {
		footerMenuList.prepend('<i class="fa fa-caret-right"></i>');
	}
	// Background
	$(window).resize(function(){
		if( backgroundLink.size()>0 ) {
			var bodyWidth       = $(window).width();
			var bodyHeight      = $(window).height();
			backgroundLink.css({
				'width': bodyWidth,
				'height': bodyHeight
			});
			positionGroup.css({
				'position': 'relative',
				'z-index': 1
			});
		}
	}).resize();
	// trunk8
	if( trunk8[0] ) {
		trunk8.each( function() {
			trunk8Lines = parseInt( $(this).attr( 'data-lines' ), 10 );
			floatValue = $(this).css( 'float' );

			if ( $(this).hasClass('entry-summary') ) {
				$(this).children('p').trunk8({
					lines: trunk8Lines,
					fill: '&hellip;'
				});
			} else {
				if ( is_browser( 'firefox' ) && floatValue != 'none' ) {
					trunk8Lines = trunk8Lines + 1;
				}
				$(this).trunk8({
					lines: trunk8Lines,
					fill: '&hellip;'
				});
			}
		});
	}
	if ( imagePopup[0] ) {
		imagePopup.magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			},
			zoom: {
				enabled: true,
				duration: 300 // don't foget to change the duration also in CSS
			}
		});
	}
	if ( entryContentiflame[0] ) {
		entryContentiflame.wrap('<span class="iframe-wrapper"></span>');
		$('span.iframe-wrapper').fitVids();
	}
	function twitterCount() {
		var socialBox     = $('.social-entry-box');
		var socialTwitter = $('.twitter-count');
		var url           = socialTwitter.attr( 'data-url' );
		$.ajax({
			url:'http://urls.api.twitter.com/1/urls/count.json?url=' + url,
			type:"get",
			dataType:"jsonp"
		}).then(function(response) {
			if (response) {
				socialTwitter.text(response.count);
			}
		});
	}
	function facebookCount() {
		var socialBox      = $('.social-entry-box');
		var socialFacebook = $('.facebook-count');
		var url            = socialFacebook.attr( 'data-url' );
		$.ajax({
			url:'http://graph.facebook.com/?id=' + url,
			type:"get",
			dataType:"jsonp"
		}).then(function(response) {
			if (response) {
				socialFacebook.text(response.shares);
			}
		});
	}

	function hatenaCount() {
		var socialBox    = $('.social-entry-box');
		var socialHatena = $('.hatena-count');
		var url          = socialHatena.attr( 'data-url' );
		$.ajax({
			url:'http://api.b.st-hatena.com/entry.count?url=' + url,
			type:"get",
			dataType:"jsonp"
		}).then(function(response) {
			if ( 0 <= response ) {
				socialHatena.text(response);
			}
		});
	}
	twitterCount();
	facebookCount();
	hatenaCount();

})(jQuery);