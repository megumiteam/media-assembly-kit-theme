/**
 * Slide Pan Pan
 * Version: 0.7.2.1
 * Author: @Webnist
 * Site: http://webni.st
 * Licensed under the MIT license
 */
(function($){
	var spp = {}, isTouch = ('ontouchstart' in window);

	$.fn.slidePanPan = function( options ) {
		if ( ! $(this)[0] )
			return;

		var defaults = {
			speed : 200
		};
		var setting = $.extend( defaults, options );

		spp.element        = this;
		spp.setting        = setting;
		var box            = $(this);
		var nav            = box.children('nav');
		var navUl          = nav.children('ul');
		var navLi          = navUl.children('li');
		var navLiFirst     = navUl.children('li:first');
		var postsBox       = box.children('div');
		var postsContents  = postsBox.children('div');
		var navUlWidth     = parseInt( 0, 10 );
		var postsZindex    = parseInt( postsContents.length, 10 );
		var postsBoxWidth  = parseInt( 0, 10 );
		var postsBoxHeight = parseInt( 0, 10 );

		navLi.each( function( i ) {
			var navLiWidth = $(this).outerWidth(true);
			navUlWidth  = parseInt( navLiWidth, 10 ) + navUlWidth;
			if ( 0 === i ) {
				$(this).addClass('current');
			}
		});
		navUl.css({
			'width': navUlWidth + 2
		});

		//navUl.append('<i id="current-bar"></i>');
		navLiFirst.addClass('current');
		// currentBar(navLiFirst);

		postsContents.each( function() {
			if ( $(this).innerHeight() > postsBoxHeight ) {
				postsBoxHeight = $(this).innerHeight();
			}
			$(this).css({
				'z-index': postsZindex
			});
			postsZindex = postsZindex - 1;
		});
		postsContents.css({
			'height': postsBoxHeight
		});
		postsBox.css({
			'height': postsBoxHeight,
			'overflow': 'hidden'
		});
		navUl.on({
			'touchstart mousedown': function(e) {
				e.preventDefault();
				this.bodyWidth  = $('body').width();
				this.fw         = parseInt( box.width(), 10 );
				this.navUlWidth = parseInt( navUl.outerWidth(true), 10 );
				this.max        = this.navUlWidth - this.fw;
				this.pageX      = (isTouch ? e.originalEvent.touches[0].clientX : e.pageX);
				this.left       = $(this).position().left;
				this.touched    = true;
				this.move       = false;
			},
			'touchmove mousemove': function(e) {

				if (!this.touched) {
					return;
				}

				e.preventDefault();
				this.move       = true;
				this.left = this.left - (this.pageX - (isTouch ? e.originalEvent.touches[0].clientX : e.pageX) );
				if ( this.bodyWidth < this.navUlWidth ) {
					$(this).css({left:this.left});
				}
				this.accel = ( (isTouch ? e.originalEvent.touches[0].clientX : e.pageX) - this.pageX ) * 5;
				this.pageX = ( isTouch ? e.originalEvent.touches[0].clientX : e.pageX );
			},
			'touchend mouseup resize': function(e) {
				if (!this.touched) {
					return;
				}
				if ( this.bodyWidth < this.navUlWidth ) {
					this.left += this.accel
					$(this).animate({
						left : this.left
					}, setting.speed, 'linear' );
				}
				if ( !this.move ) {
					tapTarget = $(e.target);
					if ( tapTarget.is('li') ) {
						index     = parseInt( tapTarget.index(), 10 );
						var leftContents = parseInt( postsContents.eq(index).prev('div').css( 'left' ), 10 );
						var rightContents = parseInt( postsContents.eq(index).next('div').css( 'left' ), 10 );

						navLi.removeClass('current');
						tapTarget.addClass('current');
						tapTarget.siblings('li').removeClass('next prev current');
						// currentBar( tapTarget, e );
						navCenter( tapTarget );
						if ( isNaN( leftContents ) && isNaN( rightContents ) ) {
							postsContents.eq(index).prevAll('div').stop().animate({
								left:-this.fw
							}, setting.speed, 'linear' );
						} else if ( isNaN( leftContents ) ) {
							postsContents.stop().animate({
								left:0
							}, setting.speed, 'linear' );
						} else if ( -this.fw == leftContents ) {
							postsContents.eq(index).stop().animate({
								left:0
							}, setting.speed, 'linear' );
							postsContents.eq(index).nextAll('div').stop().animate({
								left:0
							}, setting.speed, 'linear' );
						} else {
							postsContents.eq(index).prevAll('div').stop().animate({
								left:-this.fw
							}, setting.speed, 'linear' );
						}
					}
					$('html, body').stop().animate({
						'scrollTop':this.home
					}, 0, 'linear' );
				}
				this.accel = 0;
				if ( this.bodyWidth < this.navUlWidth ) {
					if ( this.left > 0 ) {
						$(this).stop().animate({
							left:0
						}, setting.speed );
					}
					if ( this.left < -this.max) {
						$(this).stop().animate({
							left:-this.max
						}, setting.speed );
					}
				}
				this.touched = false;
			}
		});
		postsContents.on({
			'touchstart mousedown': function(e) {
				//e.preventDefault();
				this.home    = parseInt( box.position().top );
				this.index   = parseInt( $(this).index(), 10 );
				this.pageX   = (isTouch ? e.originalEvent.touches[0].clientX : e.pageX);
				this.pageY   = (isTouch ? e.originalEvent.touches[0].clientY : e.pageY);
				this.left    = $(this).position().left;
				this.top     = $(this).position().top;
				this.touched = true;
			},
			'touchmove mousemove': function(e) {
				var index   = parseInt( $(this).index(), 10 ) + 1;
				postsZindex = parseInt( postsContents.length, 10 );

				if (!this.touched)
					return;

				this.left = this.left - (this.pageX - (isTouch ? e.originalEvent.touches[0].clientX : e.pageX) );
				this.top = this.top - (this.pageY - (isTouch ? e.originalEvent.touches[0].clientY : e.pageY) );
				if ( Math.abs(　this.left ) > Math.abs(　this.top ) ) {
					e.preventDefault();
					if ( ( this.left < 0 ) && postsZindex !== index ) {
						$(this).css({left:this.left});
					}
				}
				this.pageX = (isTouch ? e.originalEvent.touches[0].clientX : e.pageX);
				this.pageY = (isTouch ? e.originalEvent.touches[0].clientY : e.pageY);
			},
			'touchend mouseup resize': function(e) {
				if (!this.touched) {
					return;
				}

				fw = box.width();
				e.preventDefault();
				if ( Math.abs(　this.left ) < Math.abs(　this.top ) ) {
					var navCurrent = box.children('nav').find('li.current');
					setTimeout(function(){
						navCenter( navCurrent );
					}, setting.speed );
				}
				if ( this.left < -50 ) {
					if ( $(this).next('div')[0] ) {
						$(this).stop().animate({
							left:-fw
						}, setting.speed, 'linear' );
						navLi.eq(this.index).next('li').addClass('current');
						navLi.eq(this.index).next('li').siblings('li').removeClass('next prev current');
						// currentBar( navLi.eq(this.index).next('li'), e );
						navCenter( navLi.eq(this.index).next('li') );
						$('html, body').stop().animate({
							'scrollTop':this.home
						}, 0, 'linear' );
					}
				} else if ( this.left > 50 ) {
					if ( $(this).prev('div')[0] ) {
						$(this).prev('div').stop().animate({
							left:0
						}, setting.speed);
						navLi.eq(this.index).prev('li').addClass('current');
						navLi.eq(this.index).prev('li').siblings('li').removeClass('next prev current');
						// currentBar( navLi.eq(this.index).prev('li'), e );
						navCenter( navLi.eq(this.index).prev('li') );
						$('html, body').stop().animate({
							'scrollTop':this.home
						}, 0, 'linear' );
					}
				} else {
					$(this).stop().animate({
						left:0
					}, setting.speed );
				}
				this.touched = false;
			}
		});
		sppResize();
	};

/*
	function currentBar ( el, ev ) {
		var width      = parseInt( el.outerWidth(), 10 );
		var mLeft      = parseInt( el.css('margin-left'), 10 );
		var left       = parseInt( el.position().left, 10 ) + mLeft;
		var currentBar = $('i#current-bar');
		if ( ev ) {
			currentBar.stop().animate({
				width: width,
				left: left
			}, spp.settingspeed, 'linear' );
			el.siblings('li').removeClass('next prev current');
			el.removeClass('next prev');
			el.addClass('current');
			el.next('li').addClass('next');
			el.prev('li').addClass('prev');
		} else {
			currentBar.css({
				width: width,
				left: left
			});
		}
	};
*/

	function navCenter ( el ) {
		var box          = spp.element;
		var boxWidth     = parseInt( box.outerWidth( true ), 10 );
		var boxHalf      = parseInt( boxWidth / 2, 10 );
		var wrap         = el.parent('ul');
		var wrapWidth    = parseInt( wrap.outerWidth( true ), 10 );
		var elWidth      = parseInt( el.outerWidth( true ), 10 );
		var elHalf       = parseInt( elWidth / 2, 10 );
		var elLeft       = parseInt( el.position().left, 10 );
		var elCenter     = elHalf + elLeft;
		var elRight      = elWidth + elLeft;
		var mvCenter     = elCenter - boxHalf;
		var mvHalf       = wrapWidth - elRight;
		var elLast       = wrap.children('li:last');
		var elLastWidth  = parseInt( elLast.outerWidth( true ), 10 );
		var elLastLeft   = parseInt( elLast.position().left, 10 );
		var elLastRight  = elLastWidth + elLastLeft;
		var elEnd        = boxWidth - elLastRight;

		if ( boxHalf >= mvHalf ) {
			wrap.stop().animate({
				left: elEnd
			}, spp.settingspeed, 'linear' );
		}
		else if ( boxHalf <= elCenter ) {
			wrap.stop().animate({
				left: -mvCenter
			}, spp.settingspeed, 'linear' );
		}
		else {
			wrap.stop().animate({
				left: 0
			}, spp.settingspeed, 'linear' );
		}
	};

	function sppResize () {

		$(window).resize(function(){
			var box = spp.element;
			var navCurrent      = box.children('nav').find('li.current');
			var tabContent      = box.children('div');
			var tabContentWidth = parseInt( tabContent.outerWidth( true ), 10 );
			var tabContentChild = tabContent.children('div');
			navCurrent.siblings('li').removeClass('next prev current');
			// currentBar( navCurrent, 'resize' );
			navCenter( navCurrent );
			tabContentChild.each( function() {
				left = parseInt( $(this).css( 'left' ), 10 );
				if ( 0 > left ) {
					$(this).stop().animate({
							left:-tabContentWidth
					}, 0, 'linear' );
				}
			});
		}).resize();
	};

})(jQuery);