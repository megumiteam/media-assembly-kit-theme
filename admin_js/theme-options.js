(function($){
	$(window).load(function() {
		if ( $('div#theme-options')[0] ) {
			$('div#theme-options').children('form').children('h3').each( function( i ) {
				var wrapId     = 'theme-option-wrap-' + ( i + 1 );
				var optionName = $(this).text();
				if ( i === 0 ) {
					$('div#theme-options').children('form').before('<ul id="theme-option-nav"><li data-nav="' + wrapId + '" class="current">' + optionName + '</li></ul>');
					$(this).next('table').wrap('<div id="' + wrapId + '" class="theme-option-wrap theme-option-wrap-current"></div>');
				} else {
					$('ul#theme-option-nav').append('<li data-nav="' + wrapId + '">' + optionName + '</li>');
					$(this).next('table').wrap('<div id="' + wrapId + '" class="theme-option-wrap"></div>');
				}
				$(this).prependTo('#' + wrapId);
			});
		}
		if ( $('ul#theme-option-nav')[0] ) {
			$('ul#theme-option-nav').on( 'click', 'li', function() {
				if ( !$(this).hasClass( 'current' ) ) {
					var target = $(this).attr('data-nav');
					$(this).nextAll( 'li' ).removeClass( 'current' );
					$(this).prevAll( 'li' ).removeClass( 'current' );
					$('div#theme-options').children('form').children( '.theme-option-wrap' ).removeClass( 'theme-option-wrap-current' );
					$(this).addClass( 'current' );
					$('div#theme-options').children('form').children( '#' + target ).addClass( 'theme-option-wrap-current' );
				}
			});
		}
	});
})(jQuery);
