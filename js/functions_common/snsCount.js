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
window.hatenaCount = function() {
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
};
})(jQuery);
