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
