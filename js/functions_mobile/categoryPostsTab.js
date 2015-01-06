// categoryPostsTab
(function($){
window.categoryPostsTabSet = function() {

	var categoryPostsTab     = $('#category-posts-tab');
	if ( categoryPostsTab[0] ) {
		categoryPostsTab.imagesLoaded(function(){
			categoryPostsTab.slidePanPan();
		});
	}

};

})(jQuery);
