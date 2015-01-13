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
