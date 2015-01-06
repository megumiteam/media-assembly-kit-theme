// globalNavBox
(function($){
window.globalNavBoxSet = function() {

	var globalNavBox   = $('#global-nav-box');
	var nh             = globalNavBox.outerHeight();
	var menuGlobalNenu = globalNavBox.children('ul');
	var menuList       = menuGlobalNenu.children('li');
	if ( globalNavBox[0] ) {

		var globalNavLength   = menuList.length;
		var globalNavBoxWidth = globalNavBox.width();
		var menuListWidth     = ( globalNavBoxWidth / globalNavLength );
		menuList.css({
			width: menuListWidth
		});
		var npt = globalNavBox.position().top;
		globalNavBox.headroom({
			offset : npt,
			classes : {
				initial : 'headroom-nav',
				top     : 'nav--top',
				notTop  : 'nav--not-top'
			}
		});
		$(window).scroll(function(e) {
			var $window    = $(e.currentTarget),
			scrollPosition = $window.scrollTop();
			if ( npt < scrollPosition ) {
				if ( !$('div#stopper')[0] ) {
					globalNavBox.after('<div id="stopper"></div>');
					$('div#stopper').css({
						'height': nh
					});
				}
			} else {
				if ( $('div#stopper')[0] ) {
					$('div#stopper').remove();
				}
			}

		});
	}

};
})(jQuery);
