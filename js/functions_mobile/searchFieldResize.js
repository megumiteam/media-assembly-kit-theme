// searchFieldResize
(function($){
window.searchFieldResizeSet = function() {

	var headerMeta           = $('#header-meta');
	var search               = headerMeta.children('.search-form');
	var searchField          = search.find('.search-field');
	var socialBox            = headerMeta.children('div.social-box');
	var colophon             = $('#colophon');
	var colophonSearchBox    = colophon.children('.search-form');
	var colophonSearch       = colophonSearchBox.children('.search-field');

	colophonSearch.attr( 'placeholder', '気になるワードを入力' );

	$(window).resize(function(){
		var headerMetaWidth     = headerMeta.width();
		var socialBoxWidth      = socialBox.innerWidth();
		var searchFieldWidth    = headerMetaWidth - socialBoxWidth - 26;
		search.css({
			'width': searchFieldWidth
		});
	}).resize();

};

})(jQuery);
