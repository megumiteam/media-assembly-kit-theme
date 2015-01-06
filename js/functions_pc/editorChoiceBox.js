(function($){
// editorChoiceBox
window.editorChoiceBoxSet = function() {

	var editorChoiceBox = $('#editor-choice-box');
	var editorChoice    = editorChoiceBox.children('#editor-choice');
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
};

})(jQuery);
