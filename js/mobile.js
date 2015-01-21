/*! mobile */
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
	socialTwitter.text('0');
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
	socialFacebook.text('0');
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

// categoryPostsTab(categoryInductionBoxSet)
(function($){
window.categoryInductionBoxSet = function() {

	var categoryPostsTab     = $('#category-posts-tab');
	if ( categoryPostsTab[0] ) {
		categoryPostsTab.imagesLoaded(function(){
			categoryPostsTab.slidePanPan();
		});
	}

};

})(jQuery);

// colophonSocial
(function($){
window.colophonSocialSet = function() {

	var colophonSocial       = $('#colophon').children('div.global-social-button-box');
	var colophonSocialButton = colophonSocial.children('p');
	if ( colophonSocial[0] ) {
		var socialLength = colophonSocialButton.length;
		var socialButtonWidth = ( 100 - ( socialLength - 1 ) ) / socialLength;
		colophonSocialButton.css({
			'width':socialButtonWidth + '%'
		});
	}

};

})(jQuery);

// searchFieldResize
(function($){
window.searchFieldResizeSet = function() {

	var colophon             = $('#footer-search-box');
	var colophonSearchBox    = colophon.children('.search-form');
	var colophonSearch       = colophonSearchBox.children('.search-field');

	colophonSearch.attr( 'placeholder', '気になるワードを入力' );
};

})(jQuery);

// trunk8
(function($){
window.trunk8Set = function() {

	if ( typeof targetname === 'undefined' ) {
		targetname = '.trunk8';
	}

	var trunk8      = $( targetname );
	var trunk8Lines = '';
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

};

})(jQuery);
