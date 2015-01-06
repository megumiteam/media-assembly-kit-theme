// trunk8
(function($){
window.trunk8Set = function() {

	var trunk8      = $( '.trunk8' );
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
