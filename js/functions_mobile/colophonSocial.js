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
