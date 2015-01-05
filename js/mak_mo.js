(function($){

	var main                 = $('#main');
	var headerMeta           = $('#header-meta');
	var search               = headerMeta.children('.search-form');
	var searchField          = search.find('.search-field');
	var socialBox            = headerMeta.children('div.social-box');

	var slideBox             = $('#slide-box');
	var slide                = slideBox.children('#slide');

	var categoryPostsTab     = $('#category-posts-tab');

	var side                 = $('#secondary');

	var ranking              = side.children('section.widget-ranking');
	var rankingNav           = ranking.find('p');
	var rankingList          = ranking.children('ol');

	var colophon             = $('#colophon');
	var colophonSearchBox    = colophon.children('.search-form');
	var colophonSearch       = colophonSearchBox.children('.search-field');

	var colophonSocial       = colophon.children('div.global-social-button-box');
	var colophonSocialButton = colophonSocial.children('p');

	var trunk8               = $( '.trunk8' );
	var trunk8Lines          = '';
	var imagePopup           = $('a.image-popup');
	var entryContent         = $('section.entry-content');
	var entryContentiflame   = entryContent.find('iframe');

	searchFieldResize();

	if ( slideBox[0] ) {
		speed       = parseInt( slide.attr( 'data-speed' ), 10 );
		pause       = parseInt( slide.attr( 'data-pause' ), 10 );
		slideHeight = slide.find('img').height();
		slideBox.css({
			'height': slideHeight
		});
		slide.imagesLoaded(function(){
			slide.bxSlider({
				mode: 'fade',
				speed: speed,
				pager: false,
				controls: false,
				auto: true,
				pause: pause,
				autoHover: true
			});
		});
	}
	if ( categoryPostsTab[0] ) {
		categoryPostsTab.imagesLoaded(function(){
			categoryPostsTab.slidePanPan();
		});
	}

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
	if ( colophonSocial[0] ) {
		var socialLength = colophonSocialButton.length;
		var socialButtonWidth = ( 100 - ( socialLength - 1 ) ) / socialLength;
		colophonSocialButton.css({
			'width':socialButtonWidth + '%'
		});
	}

	// trunk8
	if( trunk8[0] ) {
		trunk8.each( function() {
			trunk8Lines = $(this).attr( 'data-lines' );
			if ( $(this).hasClass('entry-summary') ) {
				$(this).children('p').trunk8({
					lines: trunk8Lines,
					fill: '&hellip;'
				});
			} else {
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
	function searchFieldResize() {
		$(window).resize(function(){
			var headerMetaWidth     = headerMeta.width();
			var socialBoxWidth      = socialBox.innerWidth();
			var searchFieldWidth    = headerMetaWidth - socialBoxWidth - 26;
			search.css({
				'width': searchFieldWidth
			});
			colophonSearch.attr( 'placeholder', '気になるワードを入力' );

		}).resize();
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