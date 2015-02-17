var root = 'http://' + location.hostname + '/wp-json/';
/**
 * ハッシュ監視クラス(static class)
 */
var HashObserve = {
	funcList: [],   // ハッシュ変更時に実行する関数リスト
	prevHash: "",   // 前回のハッシュ
	
	/**
	 * 監視
	 */
	observe: function() {
		// 前回のハッシュと比較
		if (HashObserve.prevHash!==window.location.hash) {
			// 登録されている関数を実行
			for (var i=0; i<HashObserve.funcList.length; ++i) {
				HashObserve.funcList[i](window.location.hash, HashObserve.prevHash);
			}
			// 前回のハッシュを更新
			HashObserve.prevHash=window.location.hash;
		}
	},
	
	/**
	 * ハッシュ変更時に実行する関数を登録
	 * @param {Object} fn
	 */
	addFunc: function(fn) {
		HashObserve.funcList.push(fn);
	}
};

(function($){

window.escapeHTML = function(val) {
	return $('<div>').html(val).text();
};

// ThemeOption
function wpjsonThemeOption() {
	var ThemeOption = {};
	$.ajax({
		type:  "GET",
		url:   root + 'mak_themeoption/',
		async: false
	}).done(function(data, status, xhr) {
		if ( data.length === 0 || data === false ) {
			console.log( 'wpjsonThemeOpt error' );
			return;
		}
		$.each(data, function() {
			if ( this.value === false ) {
				ThemeOption[this.name] = '';
			} else {
				ThemeOption[this.name] = this.value;
			}
			if ( this.name === 'background_image' ) {
				ThemeOption['background_image_url'] = '';
				if ( this.value !== false ) {
					if ( this.value !== '0' && this.value !== '' ) {
						$.ajax({
							type:  "GET",
							url:   root + 'media/' + this.value,
							async: false
						}).done(function(data, status, xhr) {
							ThemeOption['background_image_url'] = data.source;
						}).fail(function(xhr, status, error) {
							console.log( 'background_image fail' );
						});
					}
				}
			}
			if ( this.name === 'background_image_mobile' ) {
				ThemeOption['background_image_url_mobile'] = '';
				if ( this.value !== false ) {
					if ( this.value !== '0' && this.value !== '' ) {
						$.ajax({
							type:  "GET",
							url:   root + 'media/' + this.value,
							async: false
						}).done(function(data, status, xhr) {
							ThemeOption['background_image_url_mobile'] = data.source;
						}).fail(function(xhr, status, error) {
							console.log( 'background_image fail' );
						});
					}
				}
			}
			if ( this.name === 'ogp_image' ) {
				ThemeOption['ogp_image_url'] = '';
				if ( this.value !== false ) {
					if ( this.value !== '0' && this.value !== '' ) {
						$.ajax({
							type:  "GET",
							url:   root + 'media/' + this.value,
							async: false
						}).done(function(data, status, xhr) {
							ThemeOption['ogp_image_url'] = data.source;
						}).fail(function(xhr, status, error) {
							console.log( 'ogp_image fail' );
						});
					}
				}
			}
			if ( this.name === 'favicon_image' ) {
				ThemeOption['favicon_image_url'] = '';
				if ( this.value !== false ) {
					if ( this.value !== '0' && this.value !== '' ) {
						$.ajax({
							type:  "GET",
							url:   root + 'media/' + this.value,
							async: false
						}).done(function(data, status, xhr) {
							ThemeOption['favicon_image_url'] = data.source;
						}).fail(function(xhr, status, error) {
							console.log( 'favicon_image fail' );
						});
					}
				}
			}
			if ( this.name === 'apple_touch_icon_image' ) {
				ThemeOption['apple_touch_icon_image_url'] = '';
				if ( this.value !== false ) {
					if ( this.value !== '0' && this.value !== '' ) {
						$.ajax({
							type:  "GET",
							url:   root + 'media/' + this.value,
							async: false
						}).done(function(data, status, xhr) {
							ThemeOption['apple_touch_icon_image_url'] = data.source;
						}).fail(function(xhr, status, error) {
							console.log( 'apple_touch_icon_image fail' );
						});
					}
				}
			}
		});
	}).fail(function(xhr, status, error) {
		console.log( 'wpjsonThemeOpt fail' );
	});

	// RootObj
	var wpjsonRootObj = $.ajax({
		type:    'GET',
		url:     root,
		async: false
	}).done(function(data, status, xhr) {
		if ( data.length === 0 || data === false ) {
			console.log( 'wpjsonRootObj error' );
			return;
		}
		ThemeOption['site_name']        = data.name;
		ThemeOption['site_description'] = data.description;
		ThemeOption['site_url']         = data.URL + '/';

	}).fail(function(xhr, status, error) {
		console.log( 'wpjsonRootObj fail' );
	});

	return ThemeOption;
}

// MediaAdGet
function wpjsonMediaAdGet() {
	var MediaAdData = {};
	$.ajax({
		type:  "GET",
		url:   root + 'mak_adoption',
		async: false
	}).done(function(data, status, xhr) {
		if ( data.length === 0 || data === false ) {
			console.log( 'wpjsonMediaAdGet error' );
			return;
		}
		$.each(data, function() {
			MediaAdData[this.name] = this.value;
		});
	}).fail(function(xhr, status, error) {
		console.log( 'wpjsonMediaAdGet fail' );
	});
	return MediaAdData;
}

// Date Format
function post_date_format( date ) {
	var toDoubleDigits = function(num) {
		num += "";
		if (num.length === 1) {
			num = "0" + num;
		}
		return num;
	};

	var jdate = date.substr(0,19);
	    jdate = jdate + '+09:00';

	var post_date = new Date( jdate );
	var yyyy = post_date.getFullYear();
	var mm   = toDoubleDigits(post_date.getMonth() + 1);
	var dd   = toDoubleDigits(post_date.getDate());
	var hh   = toDoubleDigits(post_date.getHours());
	var mi   = toDoubleDigits(post_date.getMinutes());

	post_date =  yyyy + '.' + mm + "." + dd + " " + hh + ":" + mi;

	return post_date;
}

// Template : Posts list
function post_list_tml() {

	var imgtml = '';
	if ( thumbnail !== '' ) {
		imgtml = '<p class="thumbnail">' +
			'<a href="' + permalink + '" title="' +  title + '" rel="bookmark">' +
				'<img src="' + thumbnail + '" class="attachment-post-thumbnail wp-post-image" alt="">' +
			'</a>' +
		'</p>';
	}

	var tml = '<article id="post-' + ID + '" class="post hentry ' + entryclass + ' archive-article">' +
		imgtml +
		'<header class="entry-header">' +
			'<p class="posted-in-category color-cat">' + categoryArray + '</p>' +
			'<h1 class="entry-title"><a href="' + permalink + '">' +  title + '</a></h1>' +
			'<p class="entry-date"><time datetime="' + date + '"><a href="' + permalink + '">' + dateja + '</a></time></p>' +
		'</header><!-- .entry-header -->' +
		'<section class="entry-summary trunk8" data-lines="2">' + excerpt +
/* 			'<p title="' + excerpt + '">' + excerpt + '</p>'+ */
		'</section><!-- .entry-summary -->' +
	'</article>';

	return tml;
}

// Template : Posts list mobile
function post_list_tml_mobile() {

	var imgtml = '';
	if ( thumbnail !== '' ) {
		imgtml = '<p class="thumbnail">' +
			'<img src="' + thumbnail + '" class="attachment-post-thumbnail wp-post-image" alt="">' +
		'</p>';
	}

	var tml = '<article id="post-' + ID + '" class="post hentry ' + entryclass + ' archive-article"><a href="' + permalink + '">' +
		imgtml +
		'<header class="entry-header">' +
			'<h1 class="entry-title trunk8" data-lines="3">' +  title + '</h1>' +
			'<p class="entry-date"><time datetime="' + date + '"><a href="' + permalink + '">' + dateja + '</a></time></p>' +
		'</header>' +
	'</a></article>';

	return tml;
}

// Template : Post
function post_tml( objtype ) {
	var imgtml = '';
	if ( thumbnail !== '' ) {
		imgtml = '<div class="thumbnail">' +
			'<a href="' + thumbnailULR + '" class="image-popup">' +
				'<img src="' + thumbnail + '" class="attachment-square-218-image wp-post-image" alt=""><p>写真拡大</p>' +
			'</a>' +
		'</div>';
	}

	var bottom         = '';
	var content_before = '';
	var content_after = '';

	var tml = imgtml + content_before + content + bottom + content_after;

	return tml;
}

// OGP Set
window.ogp_set = function( pagetype, excerpt, tagogps, thumbnailULR ) {

	if ( typeof pagetype === 'undefined' ) {
		pagetype = '';
	}
	if ( typeof excerpt === 'undefined' ) {
		excerpt = '';
	}
	if ( typeof tagogps === 'undefined' ) {
		tagogps = '';
	}
	if ( typeof thumbnailULR === 'undefined' ) {
		thumbnailULR = '';
	}

	var ogtags  = [];

	var ogtitle     = $('title').html();
	var description = ThemeOption.site_description;
	if ( ThemeOption.ogp_description !== "" ) {
		description = ThemeOption.ogp_description;
	}
	var keyword     = ThemeOption.ogp_keyword;
	var ogurl       = location.href;
	var ogimage     = ThemeOption.ogp_image_url;
	var site_name   = ThemeOption.site_name;
	if ( ThemeOption.ogp_title !== "" ) {
		site_name   = ThemeOption.ogp_title;
	}
	var app_id      = ThemeOption.ogp_appid;

	if ( pagetype === 'single' ) {
		
		if ( excerpt.length !== 0 ) {
			excerpt = escapeHTML(excerpt);
			description = excerpt.substring(0, 32) + '&hellip;';
		}
		if ( tagogps.length !== 0 ) {
			tagogps = escapeHTML(tagogps);
			if ( keyword.length !== 0 ) {
				keyword = keyword + ',' + tagogps;
			} else {
				keyword = tagogps;
			}
		}
		if ( thumbnailULR.length !== 0 ) {
			ogimage = thumbnailULR;
		}
	}

	// output
	$("meta[property='og:title']").attr( 'content', ogtitle );

	if ( description.length !== 0 ) {
		$("meta[property='og:description']").attr( 'content', description );
		$("meta[name='description']").attr( 'content', description );
	}
	if ( keyword.length !== 0 ) {
		$("meta[name='keywords']").attr( 'content', keyword );
	}
	$("meta[property='og:url']").attr( 'content', ogurl );
	if ( ogimage.length !== 0 ) {
		$("meta[property='og:image']").attr( 'content', ogimage );
	}
	$("meta[property='og:site_name']").attr( 'content', site_name );
/*
	if ( app_id.length !== 0 ) {
		ogtags.push('<meta property="fb:app_id" content="' + app_id + '">');
	}
*/

/*
	ogtags = ogtags.join("\n");

	$('head').append( ogtags );
*/

	// fbscript
	var appId   = '';
	if ( app_id.length !== 0 ) {
		appId = '&appId=' + app_id;
	}
	var fb_root = '<div id="fb-root"></div>\n<script src="//connect.facebook.net/ja_JP/all.js"></script>\n<script>(function(d, s, id) {\nvar js, fjs = d.getElementsByTagName(s)[0];\nif (d.getElementById(id)) return;\njs = d.createElement(s); js.id = id; js.async = true;\njs.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1' + appId + '&version=v2.0";\nfjs.parentNode.insertBefore(js, fjs);\n}(document, \'script\', \'facebook-jssdk\'));</script>';
	$('#before_body').html(fb_root);

	return;
};

// MediaAdSet
// シングル
function mediaAdSet_Single( ua ) {

	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}
	var ad = "";
	if ( ua === 'mobile' ) {
		ad = '<div class="mad-single-box">' + "\n" +
				'<div class="mad mad-single-bottom">' + MediaAd.mak_ad_mobile_single_bottom + '</div>' + "\n" +
				'</div>' + "\n" +
			'</div>' + "\n";
	} else {
		ad = '<div class="mad-single-box">' + "\n" +
				'<div class="mad mad-single-left">' + "\n" + MediaAd.mak_ad_pc_single_left + '</div>' + "\n" +
				'<div class="mad mad-single-right">' + "\n" + MediaAd.mak_ad_pc_single_right + '</div>' + "\n" +
				'</div>' + "\n" +
			'</div>' + "\n";
	}

	$('#single-ads').writeCapture().html(ad);

	return;
}
// SP ヘッダーバナー
function mediaAdSet_mobile_common_header() {

	var ad = '<div class="mad mad-header-ad">' + MediaAd.mak_ad_mobile_common_header + '</div>';

	$('#mad_mobile_common_header').writeCapture().html(ad);

	return;
}

// アーカイブ
function mediaAdSet_Archive( ua ) {

	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}
	var ad = "";

	if ( ua === 'mobile' ) {
		ad = '<div class="mad mad-halfway">' + MediaAd.mak_ad_mobile_archive_halfway + '</div>';

		var navad = '<div class="mad mad-nav-top">' + MediaAd.mak_ad_mobile_archive_nav_top + '</div>';
		if ( $('#mad-nav-top')[0] ) {
			$('#mad-nav-top').writeCapture().html(navad);
		}

	} else {
		ad = '<div class="mad-halfway-box">' + "\n" +
				'<div class="mad mad-halfway-left">' + "\n" + MediaAd.mak_ad_pc_home_halfway_left + '</div>' + "\n" +
				'<div class="mad mad-halfway-right">' + "\n" + MediaAd.mak_ad_pc_home_halfway_right + '</div>' + "\n" +
				'</div>' + "\n" +
			'</div>' + "\n";
	}

	return ad;
}

// HOME
function mediaAdSet_Home( ua ) {

	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}
	var ad = "";

	if ( ua === 'mobile' ) {
		ad = '<div class="mad mad-halfway">' + MediaAd.mak_ad_mobile_home_halfway + '</div>';

		var navad = '<div class="mad mad-nav-top">' + MediaAd.mak_ad_mobile_home_nav_top + '</div>';
		if ( $('#mad-nav-top')[0] ) {
			$('#mad-nav-top').writeCapture().html(navad);
		}

	} else {
		ad = '<div class="mad-halfway-box">' + "\n" +
				'<div class="mad mad-halfway-left">' + "\n" + MediaAd.mak_ad_pc_home_halfway_left + '</div>' + "\n" +
				'<div class="mad mad-halfway-right">' + "\n" + MediaAd.mak_ad_pc_home_halfway_right + '</div>' + "\n" +
				'</div>' + "\n" +
			'</div>' + "\n";
	}

	return ad;
}

var ThemeOption = wpjsonThemeOption();
var MediaAd = wpjsonMediaAdGet();

// Root
window.wpjsonRoot = function( ua, type ) {
	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}

	var archive = false;
	if ( typeof type === 'undefined' ) {
		archive = true;
	}

	// site
	$('title').each(function(){
		var a = ["sitename", "description"];
		var b = [ThemeOption.site_name, ThemeOption.site_description];
		var txt = $(this).html();
		for(var i=0, len=a.length; i<len; i++){
			txt = txt.replace(a[i], b[i], "g");
			$(this).html( txt.replace(a[i], b[i], "g") );
		}
	});
	$('a.homelink').attr( 'href', ThemeOption.site_url );

	// favicon
	if ( ThemeOption.favicon_image_url !== '' ) {
		$('#shortcut-icon').attr( 'href', ThemeOption.favicon_image_url );
	}
	// apple-touch-icon
	if ( ThemeOption.apple_touch_icon_image_url !== '' ) {
		$('#apple-touch-icon').attr( 'href', ThemeOption.apple_touch_icon_image_url );
	}

	// Google Analytics
	if ( ThemeOption.google_analytics_code !== '' ) {
		$('head').append( ThemeOption.google_analytics_code );
	}

	// copyright
	var copyright        = ThemeOption.copyright;
	var copyright_year   = ThemeOption.copyright_year;
	var mobile_copyright = ThemeOption.mobile_copyright;
	if ( ua !== 'mobile' ) {
		copyright = copyright.replace( "[year]", copyright_year );
		$('#copyright small').html(copyright);
	} else {
		$('#copyright small').html(mobile_copyright);
	}

	// sns(mobile)
	if ( ua === 'mobile' ) {
		var twitter_url   = ThemeOption.twitter_url;
		var twitter_via   = ThemeOption.twitter_via;
		var facebook_url  = ThemeOption.facebook_url;
		var youtube_url   = ThemeOption.youtube_url;
		var pinterest_url = ThemeOption.pinterest_url;
		var socialbox     = [];
		var snsitems      = [];

		if ( twitter_url !=='' ) {
			socialbox.push( '<p class="tweet-button"><a href="http://twitter.com/share?url=' + encodeURI( ThemeOption.site_url ) + '&counturl=' + encodeURI( ThemeOption.site_url ) + '&text=' + encodeURI( ThemeOption.site_name ) + '&via=' + twitter_via + '&related=' + twitter_via + '" target="_blank"><i class="fa fa-twitter"></i>Tweet</a></p>' );
			snsitems.push( '<p class="twitter-page"><a href="' + twitter_url + '" target="_blank"><i class="fa fa-twitter"></i></a></p>' );
		}
		if ( facebook_url !=='' ) {
			socialbox.push( '<p class="share-button"><a href="http://www.facebook.com/share.php?u=' + ThemeOption.site_url + '&t=' + ThemeOption.site_name + '" target="_blank"><i class="fa fa-facebook"></i>Share</a></p>' );
			snsitems.push( '<p class="facebook-page"><a href="' + facebook_url + '" target="_blank"><i class="fa fa-facebook"></i></a></p>' );
		}
		if ( youtube_url !=='' ) {
			snsitems.push( '<p class="youtube-page"><a href="' + youtube_url + '" target="_blank"><i class="fa fa-youtube"></i></a></p>' );
		}
		if ( pinterest_url !=='' ) {
			snsitems.push( '<p class="pinterest-page"><a href="' + pinterest_url + '" target="_blank"><i class="fa fa-pinterest"></i></a></p>' );
		}
		$('#social-box').html(socialbox);
		$('#global-social-button-box').html(snsitems);
		colophonSocialSet();
		searchFieldResizeSet();
	}

	// body background
	var background_output     = '';
	var background_image      = ThemeOption.background_image_url;
	var background_color      = ThemeOption.background_color;
	var background_repeat     = ThemeOption.background_repeat;
	var background_position   = ThemeOption.background_position;
	var background_attachment = ThemeOption.background_attachment;
	if ( ua === 'mobile' ) {
		background_image      = ThemeOption.background_image_url_mobile;
		background_color      = ThemeOption.background_color_mobile;
		background_repeat     = ThemeOption.background_repeat_mobile;
		background_position   = ThemeOption.background_position_mobile;
		background_attachment = ThemeOption.background_attachment_mobile;
	}
	var background_size       = '';
	if ( background_repeat === 'no-repeat' ) {
		background_size = '-webkit-background-size: cover;' + "\n" +
			'-moz-background-size: cover;' + "\n" +
			'-o-background-size: cover;' + "\n" +
			'-ms-background-size: cover;' + "\n" +
			'background-size: cover;' + "\n";
	}

	if ( background_image !== '' ) {
		background_output = '<style id="style-background-image">' + "\n" +
					'body {' + "\n" +
						'background: ' + background_color + ' url(' + background_image + ') ' + background_repeat + ' ' + background_position + ' ' + background_attachment + ';' + "\n" +
						background_size + "\n" +
					'}' + "\n" +
				'</style>' + "\n";
	} else {
		background_output = '<style id="style-background-color">' + "\n" +
					'body {' + "\n" +
						'background: ' + background_color + ';' + "\n" +
					'}' + "\n" +
				'</style>' + "\n";
	}
	$('head').append( background_output );

	// body background link(PC)
	if ( ua !== 'mobile' ) {
		var background_link_output = '';
		var background_link        = ThemeOption.background_link;
		var background_target      = ThemeOption.background_target;
			background_target      = ( background_target === 1 ) ? ' target="_blank"' : '';
		if ( background_link !== '' ) {
			background_link_output = '<div id="background-link"><a href="' + background_link + '"' + background_target + '></a></div>' + "\n";
		}
		$('body').append( background_link_output );
		backgroundLinkSet();
	}

	// Global Menu
	if ( ua !== 'mobile' ) {
		var GlobalMenuBox = $('#global-nav-box');
		var wpjsonGlobalMenuObj = $.ajax({
			type: 'GET',
			url:  root + 'mak_menu/global-menu'
		}).done(function(data, status, xhr) {
			if ( data.content.length === 0 || data.content === false ) {
				GlobalMenuBox.remove();
				return;
			}
			GlobalMenuBox.html(data.content);
			globalNavBoxSet();
		}).fail(function(xhr, status, error) {
			GlobalMenuBox.remove();
		});
	}

	// Footer Menu
	var FooterMenuBox = $('#footer-nav-box');
	var FooterMenuApi = root + 'mak_menu/footer-menu';
	if ( ua === 'mobile' ) {
		FooterMenuApi = root + 'mak_menu/mobile-footer-menu';
	}
	var wpjsonFooterMenuObj = $.ajax({
		type: 'GET',
		url:  FooterMenuApi
	}).done(function(data, status, xhr) {
		if ( data.content.length === 0 || data.content === false ) {
			FooterMenuBox.remove();
			return;
		}
		FooterMenuBox.html(data.content);
	}).fail(function(xhr, status, error) {
		FooterMenuBox.remove();
	});

	// Ad Common
	if ( ua === 'mobile' ) {
		$('head').writeCapture().append(MediaAd.mak_ad_general_mobile_header);
		$('body').writeCapture().append(MediaAd.mak_ad_general_mobile_footer);
		mediaAdSet_mobile_common_header();
	} else {
		$('head').writeCapture().append(MediaAd.mak_ad_general_pc_header);
		$('body').writeCapture().append(MediaAd.mak_ad_general_pc_footer);
		$('#ad-before-footer').writeCapture().html(MediaAd.mak_ad_pc_before_footer);
	}

	return;
};

// Widget Area
window.wpjsonWidgets = function( wid, pos, ua, pid ) {
	if ( typeof wid === 'undefined' ) {
		wid = 'sidebar-pc';
	}
	if ( typeof pos === 'undefined' ) {
		pos = '#secondary';
	}
	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}
	if ( typeof pid === 'undefined' ) {
		pid = 0;
	}

	var WidgetArea = $( pos );
	var wpjsonWidgetAreaObj = $.ajax({
		type: 'GET',
		url:  root + 'mak_sidebar/' + wid
	}).done(function(data, status, xhr) {

		if ( data.length === 0 || data === false ) {
			WidgetArea.empty();
			return;
		}
		$.writeCapture.html( WidgetArea, data.content, function() {

			// after
			rankingNavSet();
			trunk8Set();
	
		});

	}).fail(function(xhr, status, error) {
		WidgetArea.empty();
	});

	return;
};

// PickUp
/*
window.wpjsonPickup = function() {
	var PickUpArea = $('#pickup-post-box');
	var wpjsonPickUpAreaObj = $.ajax({
		type: 'GET',
		url:  root + 'mak_pickup/'
	}).done(function(data, status, xhr) {
		if ( data.content.length === 0 ) {
			PickUpArea.remove();
			return;
		}
		PickUpArea.html(data.content);

		// after
		trunk8Set();

	}).fail(function(xhr, status, error) {
		PickUpArea.remove();
	});

	return;
};
*/

// Related Posts
window.wpjsonRelated = function( ua, id ) {

	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}

	if ( typeof id === 'undefined' ) {
		return;
	}

	var RelatedArea = $('#related-post-box');
	var wpjsonRelatedAreaObj = $.ajax({
		type: 'GET',
		url:  root + 'mak_related/' + id
	}).done(function(data, status, xhr) {
		if ( data.content.length === 0 ) {
			RelatedArea.remove();
			return;
		}
		RelatedArea.html(data.content);

		// after
		trunk8Set();

	}).fail(function(xhr, status, error) {
		RelatedArea.remove();
	});

	return;
};

// Home only (Slide and Carousel)
window.wpjsonHome = function( ua, pagenum ) {

	if ( typeof ua === 'undefined' || ua === '' ) {
		ua = 'pc';
	}
	if ( typeof pagenum === 'undefined' || pagenum === '' ) {
		pagenum = '';
	}

	// OGP
	ogp_set();

	// front only
	var slideBox   = $('#slide-box-out');
	var categoryInductionBox = $('#category-induction-box');
	if ( pagenum === '' ) {

		// Slide
		if ( ua === 'pc' ) {
			var wpjsonSlideObj = $.ajax({
				type: 'GET',
				url:  root + 'mak_slide/'
			}).done(function(data, status, xhr) {
	
				if ( data.content.length === 0 ) {
					slideBox.children('.loading').html( 'error' );
					return;
				}
	
				slideBox.html(data.content);
	
				// after slide start
				slideBoxSet();
	
			}).fail(function(xhr, status, error) {
				slideBox.children('.loading').html( 'error' );
			});
		}

		// Category induction Box
		if ( ua === 'mobile' ) {
			if ( pagenum === '' ) {
				$('#post-box').remove();
			}
			var wpjsonCategoryObj = $.ajax({
				type: 'GET',
				url:  root + 'mak_cat_tab/' + ua
			}).done(function(data, status, xhr) {
				if ( data.content.length === 0 ) {
					categoryInductionBox.remove();
					return;
				}
				categoryInductionBox.html(data.content);
	
				// after
				categoryInductionBoxSet();
	
			}).fail(function(xhr, status, error) {
				categoryInductionBox.remove();
			});
		}
	} else {
		slideBox.remove();
		categoryInductionBox.remove();
	}

	return;
};

// posts
window.wpjsonPosts = function( ua, tax, slug, page, home ) {

	if ( typeof ua === 'undefined' || ua === '' ) {
		ua = 'pc';
	}

	var archive = true;
	if ( typeof tax === 'undefined' || tax === '' ) {
		tax = '';
		archive = false;
	}
	if ( typeof slug === 'undefined' || slug === '' ) {
		slug = '';
		archive = false;
	}

	if ( typeof page === 'undefined' || page === '' ) {
		page = '';
	}

	if ( typeof home === 'undefined' ) {
		home = false;
	}
	var home_posts_per_page = '';
	if ( home === true ) {
		home_posts_per_page = '?filter[posts_per_page]=' + ThemeOption.home_posts_per_page;
	}
	var apiurl = root + 'posts/' + home_posts_per_page;

	// archive
	if ( archive === true ) {
		if ( tax === 's' ) {
			var stitle = decodeURIComponent( slug );
				stitle = stitle.replace( /\+/g, ' ' );
			$('title').each(function(){
				var txt = $(this).html();
				$(this).html( txt.replace( /search/g, stitle ) );
				ogp_set();
			});
			$( '#khm-15 li.current_item span span' ).html( stitle + 'の検索結果' );
			$('#main .archive-header .archive-title span').html( stitle + 'の検索結果' );
		} else {
			var taxonomy = tax;
			if ( tax === 'tag' ) {
				taxonomy = 'post_tag';
			}
			
			var wpjsonTaxObj = $.ajax({
				type: 'GET',
				url:  root + 'taxonomies/' + taxonomy + '/terms/'
			}).done(function(data, status, xhr) {

				// posts list
				if ( data.length === 0 ) {
					console.log( 'wpjsonTaxObj length 0' );
					return;
				}

				var categoryID   = '';
				var categoryName = '';
				var categoryDesc = '';

				$.each(data, function() {

					if ( slug === this.slug ) {
						categoryID   = this.ID;
						categoryName = this.name;
						categoryDesc = this.description;
					} else {
						return;
					}

					// output
					if ( categoryName !== '' ) {
						$('title').each(function(){
							var txt = $(this).html();
							$(this).html( txt.replace( /[^\s|\s]+(\s\|\s)+(.+)/g, categoryName + " | $2" ) );
							ogp_set();
						});
						$( '#khm-15 li.current_item span span' ).html( categoryName );
						$('#main .archive-header .archive-title span').html( categoryName );
					}
					if ( categoryDesc !== '' ) {
						categoryDesc = categoryDesc.replace(/(\r\n|\r|\n)/g, "<br>");
						categoryDesc = '<div class="description"><p>' + categoryDesc + '</p></div>';

						$('#archive-description').html( categoryDesc );
					}

				});

			}).fail(function(xhr, status, error) {
				console.log( 'wpjsonTaxObj fail' );
				return;
			});
		}

		// next api
		if ( tax === 'category' ) {
			tax = 'category_name';
		}
		apiurl = root + 'posts?filter[' + tax + ']=' + slug;
	}

	var postBox = $('#post-box');

	var pagefilter = '';
	if ( archive === false && ua === 'mobile' ) {
		pagefilter = '?filter[posts_per_page]=5';
		if ( apiurl.indexOf('filter') !== -1 ) {
			pagefilter = '&filter[posts_per_page]=5';
		}
	}
	if ( page !== '' ) {
		pagefilter = '?page=' + page;
		if ( apiurl.indexOf('filter') !== -1 ) {
			pagefilter = '&page=' + page;
		}
	}

	var wpjsonObj = $.ajax({
		type: 'GET',
		url:  apiurl + pagefilter
	}).done(function(data, status, xhr) {

		var items = [];
		// posts list
		if ( data.length < 1 ) {
			postBox.html( 'Not Found' );
			return;
		}

		$.each(data, function( i ) {
			ID         = this.ID;
			title      = this.title;
			date       = this.date;
			date       = date.substr(0,19) + '+09:00';
			permalink  = this.link;
			dateja     = post_date_format( date );
			excerpt    = '';
			if ( this.excerpt != null ) {
				excerpt    = this.excerpt;
			}
			entryclass = 'thumbnail-false';
			thumbnail  = '';
			if ( this.featured_image !== null && this.featured_image.source !== undefined ) {
				entryclass = 'thumbnail-true';
				thumbnail = this.featured_image.source;
				if ( this.featured_image.attachment_meta.sizes !== undefined && this.featured_image.attachment_meta.sizes['post-thumbnail'] !== undefined ) {
					thumbnail = this.featured_image.attachment_meta.sizes['post-thumbnail'].url;
				}
			}
			categoryArray = '';
			if ( this.terms.category !== undefined ) {
				categoryArray = this.terms.category;
				$.each(categoryArray, function( i ) {
					if ( this.parent == null ) {
						categoryColorStyle = "";
						categoryColor = ThemeOption['cat_' + this.ID + '_color'];
						if ( categoryColor !== '' || categoryColor !== undefined ) {
							categoryColorStyle = ' style="background: ' + categoryColor + ';"';
						}
						categoryArray[i] = '<a href="' + this.link + '" title="View all posts in ' + i + this.name + '"' + categoryColorStyle + '>' + this.name + '</a>';
					} else {
						categoryArray[i] = '';
					}
				});
				categoryArray = categoryArray.join("\n");
			}

			// output
			if ( ua === 'mobile' ) {
				items.push( post_list_tml_mobile() );
			} else {
				items.push( post_list_tml() );
			}

			// archive ad
			if ( archive === true || home === true ) {
				var halfway_number = '';
				if ( ua === 'mobile' ) {
					halfway_number = ( ThemeOption.ad_mobile_posts_number.length === 0 ) ? 7 : ThemeOption.ad_mobile_posts_number;
				} else {
					halfway_number = ( ThemeOption.ad_posts_number.length === 0 ) ? 10 : ThemeOption.ad_posts_number;
				}
				halfway_number = halfway_number - 1;
				if ( i === halfway_number ) {
					if ( archive === true ) {
						items.push( '<div id="mad-box-archive"></div>' );
					} else {
						items.push( '<div id="mad-box-archive"></div>' );
					}
				}

			}
		});

		items = items.join("\n");
		postBox.html(items);
		if ( archive === true ) {
			$('#mad-box-archive').writeCapture().html(mediaAdSet_Archive(ua));
		} else {
			$('#mad-box-archive').writeCapture().html(mediaAdSet_Home(ua));
		}

		// page link
		var TotalPages  = xhr.getResponseHeader('X-WP-TotalPages');
		var archivenav    = '';
		if ( TotalPages > 1 ) {
			TotalPages = parseInt(TotalPages);
			if ( page === '' ) {
				page = 1;
			}
			page                 = parseInt(page);
			var archivenext      = '';
			var archiveprev      = '';
			var archivecurrent   = '';
			var archivedotslast  = '';
			var archivedotsfirst = '';
			var archivefirst     = '';
			var archivelast      = '';
			var basepath         = location.href;
			var baehash          = '';
			var searchstr        = '';
			if ( location.href.slice(-1) !== '/' ) {
				basepath         = location.href + '/';
			}
			if ( home === true ) {
				if ( location.hash !== '') {
					basepath = basepath.replace( '/' + location.hash, "" );
				}
				baehash = '#!/';
			} else {
				basepath = basepath.replace( /page\/.*/, "" );
			}

			
			if ( tax === 's' ) {
				searchstr = '/?s=' + slug;
				basepath  = ThemeOption.site_url;
			}

			if ( ua === 'mobile' ) {
				if ( page === 1 ) {
					if ( home === true ) {
						archivenav = '';
					} else {
						archivenav = '<p class="first-next"><a href="' + basepath + 'page/2' + searchstr + '">もっと読む</a></p>';
					}
				} else {
					if ( page < TotalPages ) {
						archivenext = '<p class="next"><a href="' + basepath + 'page/' + ( page + 1 ) + searchstr + '">次のページ<i class="fa fa-chevron-right"></i></a></p>';
					}

					if ( ( page - 1 ) <= 1 ) {
						archiveprev = '<p class="previous"><a href="' + basepath + searchstr + '"><i class="fa fa-chevron-left"></i>前のページ</a></p>';
					} else {
						archiveprev = '<p class="previous"><a href="' + basepath+ 'page/' + ( page - 1 ) + searchstr + '"><i class="fa fa-chevron-left"></i>前のページ</a></p>';
					}
					archivenav = archiveprev + '<p class="go-home"><a href="' + ThemeOption.site_url + '"><span>トップへ</span></a></p>' + archivenext;
				}
			} else { // pc

				if ( page <= TotalPages ) {
					var pagecnt = parseInt(1);
					var nextcnt = parseInt(1);
					while ( pagecnt <= TotalPages ) {

						if ( pagecnt < page ) {
							if ( pagecnt > ( page - 5 ) ) {
								if ( pagecnt === 1 ) {
									archiveprev = archiveprev + '<li><a class="page-numbers" href="' + basepath + searchstr + '">' + pagecnt + '</a></li>';
								} else {
									archiveprev = archiveprev + '<li><a class="page-numbers" href="' + basepath + baehash + 'page/' + pagecnt + searchstr + '">' + pagecnt + '</a></li>';
								}
							}

							if ( page > 7 ) {
									archivedotsfirst = '<li><span class="page-numbers dots">…</span></li>';
								if ( pagecnt === 1 ) {
									archivefirst = archivefirst + '<li><a class="page-numbers" href="' + basepath + searchstr + '">' + pagecnt + '</a></li>';
								} else if ( pagecnt === 2 ) {
									archivefirst = archivefirst + '<li><a class="page-numbers" href="' + basepath + baehash + 'page/' + pagecnt + searchstr + '">' + pagecnt + '</a></li>';
								}
							}

						} else if ( pagecnt === page ) {
							archivecurrent = '<li><span class="page-numbers current">' + pagecnt + '</span></li>';
						} else if ( pagecnt > page ){
							if ( nextcnt < 5 ) {
								archivenext = archivenext + '<li><a class="page-numbers" href="' + basepath + baehash + 'page/' + pagecnt + searchstr + '">' + pagecnt + '</a></li>';
							} else {
								if ( page < ( TotalPages - 6 )) {
									if ( pagecnt === TotalPages || pagecnt === ( TotalPages - 1 ) ) {
										archivedotslast = '<li><span class="page-numbers dots">…</span></li>';
										archivelast = archivelast + '<li><a class="page-numbers" href="' + basepath + baehash + 'page/' + pagecnt + searchstr + '">' + pagecnt + '</a></li>';
									}
								} else {
									if ( nextcnt < 7 ) {
										archivenext = archivenext + '<li><a class="page-numbers" href="' + basepath + baehash + 'page/' + pagecnt + searchstr + '">' + pagecnt + '</a></li>';
									}

								}
							}

							nextcnt ++;
						}
						pagecnt ++;
					}
					archivenav = '<ul class="page-numbers">' + archivefirst + archivedotsfirst + archiveprev + archivecurrent + archivenext + archivedotslast + archivelast + '</ul>';
				}

			}

		}
		// output
		$("#archive-nav").html(archivenav);

		// after
		trunk8Set();
		$( "html,body" ).scrollTop(0);

	}).fail(function(xhr, status, error) {
		postBox.children('.loading').html( 'error' );
	});

	return;
};

// post
window.wpjson = function( objtype, endpoint, filter, ua ) {

	if ( typeof objtype === 'undefined' ) {
		objtype = 'post';
	}
	if ( typeof endpoint === 'undefined' ) {
		endpoint = '';
	}
	if ( typeof filter === 'undefined' ) {
		filter = '';
	}
	if ( typeof ua === 'undefined' ) {
		ua = 'pc';
	}

	var apiurl = root + endpoint + filter;

	var entryBox = $('#entry-box');

	var wpjsonObj = $.ajax({
		type: 'GET',
		url:  apiurl
	}).done(function(data, status, xhr) {

		if ( data.length === 0 || data === undefined ) {
			entryBox.children('.loading').html( 'error' );
			location.href = ThemeOption.site_url+ '404';
			return;
		}

		var items = [];

		ID           = data.ID;
		title        = data.title;
		date         = data.date;
		date         = date.substr(0,19) + '+09:00';
		dateja       = post_date_format( date );
		link         = data.link;
		excerpt      = data.excerpt;
		content      = data.content;
		thumbnail    = '';
		thumbnailULR = '';
		if ( data.featured_image !== null ) {
			if ( data.featured_image.attachment_meta.sizes['square-218-image'] ) {
				thumbnail = data.featured_image.attachment_meta.sizes['square-218-image'].url;
			} else {
				thumbnail = data.featured_image.source;
			}
			thumbnailULR = data.featured_image.source;
			entryclass   = 'thumbnail-true';
		}

		var catitems = [];
		var catnavs  = [];
		categories   = "";
		if ( data.terms.category !== undefined ) {
			categories = data.terms.category;
		}
		var tagitems = [];
		tags         = '';
		if ( data.terms.post_tag !== undefined ) {
			tags = data.terms.post_tag;
		}

		PrevLink = '';
		NextLink = '';

		if ( 'post' === objtype ) {
			var PrevLinkObj = $.ajax({
				type: 'GET',
				url:  apiurl + '/prev',
				async: false
			}).done(function(data, status, xhr) {
				if (data.prev.length === 0 || data.prev.permalink === undefined ) {
					return;
				}
				PrevLink = data.prev.permalink;
			});
			var NextLinkObj = $.ajax({
				type: 'GET',
				url:  apiurl + '/next',
				async: false
			}).done(function(data, status, xhr) {
				if (data.next.length === 0 || data.next.permalink === undefined ) {
					return;
				}
				NextLink = data.next.permalink;
			});
		}

		// output
		$('title').each(function(){
			var txt = $(this).html();
			if ( 'page' === objtype ) {
				$(this).html( txt.replace( /page/g, data.title ) );
			} else {
				$(this).html( txt.replace( /post/g, data.title ) );
			}
		});
		$( '#khm-15 li.current_item span span' ).html( data.title );
		$('.single-article .entry-title').html( title );
		$('.single-article p.entry-date time').html( dateja );
		$('.single-article p.entry-date time').attr( "datetime", date );

		// sns #social-entry-box
		var snstitle = data.title + ' | ' + ThemeOption.site_name;
		var snsurl   = data.link;

		$( '#social-entry-box p.twitter-button a' ).attr( 'href', 'http://twitter.com/share?url=' + encodeURI( snsurl ).replace('#', '%23') + '&counturl=' + encodeURI( snsurl ).replace('#', '%23') + '&text=' + encodeURI( snstitle ) + '&via=' + ThemeOption.twitter_via + '&related=' + ThemeOption.twitter_via );
		$( '#social-entry-box p.twitter-button .count' ).attr( 'data-url', snsurl.replace('#', '%23') );

		$( '#social-entry-box p.facebook-button a' ).attr( 'href', 'http://www.facebook.com/share.php?u=' + encodeURI( snsurl ).replace('#', '%23') + '&t=' + snstitle );
		$( '#social-entry-box p.facebook-button .count' ).attr( 'data-url', snsurl.replace('#!', '?_escaped_fragment_=') );

		$( '#social-entry-box p.line a' ).attr( 'href', 'http://line.me/R/msg/text/?' + snstitle + '%0D%0A' + snsurl );

		if ( categories ) {
			$.each( categories, function() {
				catitems.push( '<a href="' + this.link + '">' + this.name + '</a>' );
				catnavs.push( '<a class="category" rel="v:url" property="v:title" title="Go to the ' + this.name + ' archives." href="' + this.link + '">' + this.name + '</a>' );
			});
			catitems = catitems.join(", ");
			catnavs  = catnavs.join(", ");
			$( '.entry-meta p.posted-in-category .cats' ).html( catitems );
			$( '#khm-15 li.cat span' ).html( catnavs );
		} else {
			$( '.entry-meta p.posted-in-category' ).remove();
		}

		if ( tags ) {
			$.each( tags, function() {
				tagitems.push( '<a href="' + this.link + '">' + this.name + '</a>' );
			});
			tagitems = tagitems.join(", ");
			$( '.entry-meta p.posted-in-tags .tags' ).html( tagitems );
		} else {
			$( '.entry-meta p.posted-in-tags' ).remove();
		}

		items = post_tml( objtype );
		entryBox.html(items);

		// entryFooter
		entryFooter = '';
		navPrev     = '';
		navNext     = '';
		if ( 'post' === objtype ) {

			$( '#social-share-box p.twitter-button a' ).attr( 'href', 'http://twitter.com/share?url=' + encodeURI( snsurl ).replace('#', '%23') + '&counturl=' + encodeURI( snsurl ).replace('#', '%23') + '&text=' + encodeURI( snstitle ) + '&via=' + ThemeOption.twitter_via + '&related=' + ThemeOption.twitter_via );
			$( '#social-share-box p.facebook-button a' ).attr( 'href', 'http://www.facebook.com/share.php?u=' + encodeURI( snsurl ).replace('#', '%23') + '&t=' + snstitle );
	
			if ( PrevLink !== '' ) {
				navPrev = '<p class="nav-previous"><a href="' + PrevLink + '"><i class="fa fa-chevron-left"></i>前の記事</a></p>' + "\n";
			}
			if ( NextLink !== '' ) {
				navNext = '<p class="nav-next"><a href="' + NextLink + '">次の記事<i class="fa fa-chevron-right"></i></a></p>' + "\n";
			}

			entryFooter = '<nav id="single-nav">' +
				navPrev +
				'<p class="go-home"><a href="' + ThemeOption.site_url + '"><span>トップへ</span></a></p>' + "\n" +
				navNext +
			'</nav>' + "\n";

			$( '#single-nav-box' ).html( entryFooter );
		}

		// after
		imagePopupSet();
		entryContentiflameSet();
		trunk8Set();
		wpjsonRelated( ua, ID );
		mediaAdSet_Single( ua );
		//wpjsonPickup();

		// ogp
		ogp_set( 'single', excerpt, tagitems, thumbnailULR );

		// sns
		twitterCount();
		facebookCount();
		
		// scrollTop
		$('body').scrollTop(0);

	}).fail(function(xhr, status, error) {
		entryBox.children('.loading').html( 'error' );
	});

	return;
};

})(jQuery);
