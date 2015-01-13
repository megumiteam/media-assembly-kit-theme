// searchFieldResize
(function($){
window.searchFieldResizeSet = function() {

	var colophon             = $('#footer-search-box');
	var colophonSearchBox    = colophon.children('.search-form');
	var colophonSearch       = colophonSearchBox.children('.search-field');

	colophonSearch.attr( 'placeholder', '気になるワードを入力' );
};

})(jQuery);
