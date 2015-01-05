(function($){
	$(window).load(function() {
		if ( $('div[id$="-image-view"]')[0] ) {
			$('div[id$="-image-view"]').each(function(){
				if ( $(this).children('img')[0] ) {
					$(this).prev('button.delete-button').show();
				} else {
					$(this).prev('button.delete-button').hide();
				}
			});
		}
		if ( $('button.add-button')[0] ) {
			$('button.add-button').each(function(){
				var id = $(this).attr('id');
				$(this).parent('td').addClass(id);
			});
		}
		var custom_uploader;
		var num;
		var id;
		var target;
		var imageBox;
		var deleteButton;
		$('button.add-button').click(function(e) {
			e.preventDefault();
			id           = $(this).attr('id');
			target       = $(this).attr('data-target');
			imageBox     = $(this).parent('td.' + id);
			deleteButton = $(this).next('button.delete-button');
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			custom_uploader = wp.media({
				title: 'Choose Image',
				library: {
					type: 'image'
				},
				button: {
					text: 'Choose Image'
				},
				multiple: false // falseにすると画像を1つしか選択できなくなる
			});

			custom_uploader.on('select', function() {
				var images = custom_uploader.state().get('selection');

				images.each(function(file){
					if ( $('div#' + id + '-image-view')[0] ) {
						$('div#' + id + '-image-view').remove();
					}
					imageBox.append('<div id="' + id + '-image-view"><img src="'+file.toJSON().sizes.full.url+'" style="max-width: 150px; height: auto;" /></div>');
					$('input#' + target).val(file.toJSON().id);
					deleteButton.show();
				});
			});
			custom_uploader.open();
		});
		$('button.delete-button').click(function() {
			var id       = $(this).attr('id');
			var target   = $(this).attr('data-target');
			$(this).nextAll('div').remove();
			$('input#' + target).attr('value', '');
			$(this).hide();
		});

		if ( $( 'input.color-picker' )[0] ) {
			$('input.color-picker').iris({
				hide: true,
				palettes: true
			});
		}
	});
	$(document).ajaxSuccess(function(e, xhr, settings) {
		if ( $( 'input.color-picker' )[0] ) {
			$('input.color-picker').iris({
				hide: true,
				palettes: true
			});
		}
	});
})(jQuery);