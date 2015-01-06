// categoryInductionBox
(function($){
window.categoryInductionBoxSet = function() {

	var categoryInductionBox      = $('aside#category-induction');
	var categoryInductionNav      = categoryInductionBox.children('nav#category-induction-nav');
	var categoryInductionClick    = categoryInductionNav.find('li');
	var categoryInductionContents = categoryInductionBox.children('ul.category-induction-content');
	if ( categoryInductionBox[0] ) {
		var categoryLength = categoryInductionClick.length;
		var categoryInductionBoxWidth = categoryInductionBox.width();
		var categoryInductionNavWidth = categoryInductionBoxWidth / categoryLength;
		categoryInductionClick.css({
			width: categoryInductionNavWidth
		});
		categoryInductionClick.on( 'click', function(e) {
			if ( ! $(this).hasClass( 'current') ) {
				var target = $(this).attr( 'data-target' );
				categoryInductionClick.removeClass( 'current' );
				$(this).addClass( 'current' );
				categoryInductionContents.removeClass( 'current' );
				categoryInductionBox.children( 'ul#' + target ).addClass( 'current' );
			}
			trunk8Set();
		});
	}

};

})(jQuery);
