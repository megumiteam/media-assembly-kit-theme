(function($){
// carouselBox
window.carouselBoxSet = function() {

	var carouselBox = $('#carousel-box');
	var carousel    = carouselBox.children('#carousel');
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

};
})(jQuery);

