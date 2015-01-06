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
				console.log(target);
				rankingNav.removeClass( 'current' );
				$(this).addClass( 'current' );
				rankingList.removeClass( 'current' );
				ranking.children( '#' + target ).addClass( 'current' );
			}
		});
	}
};
})(jQuery);
