// trunk8
(function($){
window.trunk8Set = function() {

	var trunk8      = $( '.trunk8' );
	var trunk8Lines = '';
	if( trunk8[0] ) {
		trunk8.each( function() {
			trunk8Lines = parseInt( $(this).attr( 'data-lines' ), 10 );
			floatValue = $(this).css( 'float' );

			if ( $(this).hasClass('entry-summary') ) {
				$(this).children('p').trunk8({
					lines: trunk8Lines,
					fill: '&hellip;'
				});
			} else {
				if ( is_browser( 'firefox' ) && floatValue !== 'none' ) {
					trunk8Lines = trunk8Lines + 1;
				}
				$(this).trunk8({
					lines: trunk8Lines,
					fill: '&hellip;'
				});
			}
		});
	}

};

})(jQuery);
