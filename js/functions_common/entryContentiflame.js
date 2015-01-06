(function($){
window.entryContentiflameSet = function() {
	var entryContent      = $('section.entry-content');
	var entryContentiflame = entryContent.find('iframe');
	if ( entryContentiflame[0] ) {
		entryContentiflame.wrap('<span class="iframe-wrapper"></span>');
		$('span.iframe-wrapper').fitVids();
	}
};
})(jQuery);
