/*! pc */
(function($){



})(jQuery);
(function($){
window.entryContentiflameSet = function() {
	var entryContent      = $('section.entry-content');
	var entryContentiflame = entryContent.find('iframe');
	if ( entryContentiflame[0] ) {
		entryContentiflame.wrap('<span class="iframe-wrapper"></span>');
		$('span.iframe-wrapper').fitVids();
	}
};
})(jQuery);

(function($){
window.imagePopupSet = function() {
	var imagePopup = $('a.image-popup');
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
};
})(jQuery);

(function($){
window.rankingNavSet = function() {
	var side        = $('#secondary');
	var ranking     = side.children('section.widget-ranking');
	var rankingNav  = ranking.find('p');
	var rankingList = ranking.children('ol');
	if ( ranking[0] ) {
		rankingNav.on( 'click', function() {
			if ( ! $(this).hasClass( 'current') ) {
				var target = $(this).attr( 'data-target' );
				rankingNav.removeClass( 'current' );
				$(this).addClass( 'current' );
				rankingList.removeClass( 'current' );
				ranking.children( '#' + target ).addClass( 'current' );
			}
		});
	}
};
})(jQuery);

// SNS count
(function($){
window.twitterCount = function() {
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
};
window.facebookCount = function() {
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
};
})(jQuery);

// Background
(function($){
window.backgroundLinkSet = function() {

	var backgroundLink = $('div#background-link');
	var positionGroup  = $('#masthead, #slide-box, #khm-15, #content, #colophon');
	$(window).resize(function(){
		if( backgroundLink.size() > 0 ) {
			var bodyWidth  = $(window).width();
			var bodyHeight = $(window).height();
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

};
})(jQuery);

// globalNavBox
(function($){
window.globalNavBoxSet = function() {

	var globalNavBox   = $('#global-nav-box');
	var nh             = globalNavBox.outerHeight();
	var menuGlobalNenu = globalNavBox.children('ul');
	var menuList       = menuGlobalNenu.children('li');
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

};
})(jQuery);

// is_browser
function is_browser( browser ) {
	var ua = navigator.userAgent.toLowerCase();
	if ( ua.indexOf( browser ) !== -1 ) {
		return true;
	}
}


(function($){
window.slideBoxSet = function() {
	trunk8Set( '.trunk8slide' );
	var slideBox = $('#slide-box');
	var slide    = slideBox.children('#slide');
	if ( slideBox[0] ) {
		slideSpeed  = parseInt( slide.attr( 'data-speed' ), 10 );
		slidePause  = parseInt( slide.attr( 'data-pause' ), 10 );
		slide.imagesLoaded(function(){
			slideHeight = slide.find('img').height();
			slideBox.css({
				'height': slideHeight
			});
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
};
})(jQuery);

// trunk8
(function($){
window.trunk8Set = function( targetname ) {

	if ( typeof targetname === 'undefined' ) {
		targetname = '.trunk8';
	}

	var trunk8      = $( targetname );
	var trunk8Lines = '';
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
				if ( is_browser( 'firefox' ) && floatValue !== 'none' ) {
					trunk8Lines = trunk8Lines + 1;
				}
				$(this).trunk8({
					lines: trunk8Lines,
					fill: '&hellip;'
				});
			}
		});
	}

};

})(jQuery);
