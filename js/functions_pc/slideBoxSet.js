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
