(function($) {

	'use strict';

	window.YMotion = function(motionItems, options) {

		var _this = this;

        var opt = {oElems: 'motion-offset', rewind: false, oFixed: false, singly: false, half: false, divide: 2};

        for(var prop in options) {
            opt[prop] = options[prop];
        }

		var motionOffsetElems = [],
			motionOffset = [],
			rewindOffset = [],
			limitOffset,
			tempTl = [],
            sortTl = [],
			motionEnded = [],
			prevScrollTop = win.scrollTop(),
			scrollTop = prevScrollTop,
			winH,
			prevDocH,
			docH = doc.height(),
			docDiff = 0,
			queued = false,
			active = false;

		var	LENGTH = motionItems.length;

		this.initialize = function() {
			this.setMotionOffset();
			this.setElements();
			this.setTimeline();
		};

		this.setMotionOffset = function() {
			$('[data-' + opt.oElems + ']').each(function(i) {
				motionOffsetElems[i] = $(this);
				motionOffsetElems[i].data({offset: motionOffsetElems[i].offset().top, height: parseFloat(motionOffsetElems[i].css('height'), 10)});
			});

			prevDocH = docH;
			docH = doc.height();
			docDiff = docH - prevDocH;
			winH = win.height();
			limitOffset = docH - winH;
			for(var i=0, j=0, tempH; i<motionOffsetElems.length; i++) {
				tempH = opt.half === false ? motionOffsetElems[i].data('height') : motionOffsetElems[i].data('height') / 2;
				motionOffset[i] = tempH > winH / opt.divide ? (motionOffsetElems[i].data('offset') + docDiff) - winH + (winH / opt.divide) : (motionOffsetElems[i].data('offset') + docDiff) - winH + tempH;
				if(typeof motionOffsetElems[i].data('diff') === 'number') motionOffset[i] -= motionOffsetElems[i].data('diff');
				if(motionOffset[i] > limitOffset) {
					motionOffset[i] = limitOffset - motionOffsetElems.length + j;
					j++;
				}
				if(opt.oFixed === true && motionOffset[i] < 0) motionOffset[i] = 0;
				rewindOffset[i] = motionOffset[i];
			}
			motionOffset[motionOffsetElems.length] = limitOffset + 1;
			rewindOffset[motionOffsetElems.length] = limitOffset + 1;
		};

		this.setElements = function() {
			for(var i=0; i<LENGTH; i++) {
				for(var j=0, o; j<motionItems[i].length; j++) {
					o = motionItems[i][j];
                    if(typeof o.method === 'undefined') {
						if(o.el.length === 0) continue;
						if(o.effect === 'text') {
							$(o.el).each(function(k) {
								var _text = $(this).html();
								var html = '';
								var text = _text.replace(/\<br(\s?\/?)\>/g, '^').replace('&amp;', '&');
								for(var l=0; l<text.length; l++) {
									if(text[l] !== '^') html += '<i>'+ text[l] +'</i>';
									else html += '<br>';
								}
								$(this).html(html);
							});
						}
						if(typeof o.set === 'undefined') continue;
                        TweenMax.set(o.el, o.set);
                    } else {
                        switch(o.method) {
                            case 'add':
								if(typeof o.items === 'object') {
	                                for(var k=0; k<o.items.length; k++) {
										if(typeof o.items[k].set === 'undefined' || o.items[k] instanceof TimelineMax === true || o.items[k].el.length === 0) continue;
										TweenMax.set(o.items[k].el, o.items[k].set);
									}
								}
                                break;
                            default:
                                break;
                        }
                    }
				}
			}
		};

		this.setTimeline = function() {
			for(var i=0; i<LENGTH; i++) {
				tempTl[i] = new TimelineMax({paused: true, onComplete: function() {
					if(opt.singly === true) {
						queued = false;
						_this.handler.scroll();
					}
				}, onReverseComplete: function() {
					if(opt.singly === true) {
						queued = false;
						if(opt.oFixed === false) _this.handler.scroll();
						else {
							if(scrollTop <= 0 && scrollTop - prevScrollTop <= 0) {
								prevScrollTop = 0.5;
								_this.scroll();
							}
						}
					} else {
						if(opt.oFixed === true && scrollTop <= 0 && scrollTop - prevScrollTop <= 0) {
							prevScrollTop = 0.5;
							_this.scroll();
						}
					}
				}});
				motionEnded[i] = false;
				for(var j=0, o; j<motionItems[i].length; j++) {
                    o = motionItems[i][j];
					if(typeof o.method === 'undefined' && typeof o.to === 'undefined') continue;
                    if(typeof o.method === 'undefined') {
						if(o.el.length === 0) continue;
						if(o.effect !== 'text') {
							typeof o.t === 'undefined' ? tempTl[i].to(o.el, o.d, o.to) : tempTl[i].to(o.el, o.d, o.to, o.t);
						} else {
							$(o.el).each(function(k) {
								$(this).find('i').each(function(l) {
									if($.trim($(this).text()) !== '') typeof o.t === 'undefined' ? tempTl[i].to($(this), o.d, o.to) : tempTl[i].to($(this), o.d, o.to, l > 0 ? o.t : '+=0');
								});
							});
						}
                    } else {
                        switch(o.method) {
							case 'addLabel':
								tempTl[i][o.method](o.label);
								break;
                            case 'add':
								var a = [];
								if(typeof o.items === 'object') {
									for(var k=0; k<o.items.length; k++) {
										if(o.items[k] instanceof TimelineMax === true || o.items[k].el.length === 0) continue;
										a[k] = TweenMax.to(o.items[k].el, o.items[k].d, o.items[k].to);
									}
								}
								if(typeof o.tl === 'object') a.push(o.tl);
								typeof o.t === 'undefined' ? tempTl[i][o.method](a) : tempTl[i][o.method](a, o.t);
                                break;
							case 'call':
								typeof o.t === 'undefined' ? tempTl[i][o.method](o.fx) : tempTl[i][o.method](o.fx, null, null, o.t);
                            default:
                                break;
                        }
                    }
				}
			}
            for(var i=0; i<motionOffsetElems.length; i++) {
				sortTl[i] = typeof +motionOffsetElems[i].data(opt.oElems) === 'number' ? tempTl[+motionOffsetElems[i].data(opt.oElems) - 1] : '움직이지 않을래';
			}
		};

		this.setHandler = function() {
			win.scroll(this.handler.scroll).resize(this.handler.resize);
		};

        this.handler = {
            scroll: function() {
				prevScrollTop = scrollTop;
				_this.scroll();
            },
            resizeTimer: null,
            resize: function() {
                clearTimeout(_this.handler.resizeTimer);
				_this.handler.resizeTimer = setTimeout(function() {
					_this.setMotionOffset();
					_this.handler.scroll();
				}, 100);
            }
        };

		this.scroll = function() {
			scrollTop = win.scrollTop() >= 0 ? (win.scrollTop() <= limitOffset ? win.scrollTop() : limitOffset) : 0;
			opt.rewind === false ? _this.motion() : scrollTop - prevScrollTop >= 0 ? _this.motion() : _this.rewind();
		};

		this.motion = function() {
			for(var i=0; i<LENGTH; i++) {
				if(scrollTop >= motionOffset[i] && motionEnded[i] === false && typeof sortTl[i] === 'object') {
					if(opt.singly === false) {
						sortTl[i].timeScale(1).play();
						motionEnded[i] = true;
					} else {
						if(i === 0 || sortTl[i - 1].isActive() === false && queued === false) {
							sortTl[i].timeScale(1).play();
							motionEnded[i] = true;
						} else if(i > 0 && sortTl[i - 1].isActive() === true) {
							queued = true;
						}
					}
				}
			}
		};

		this.rewind = function() {
			for(var i=LENGTH - 1; i>-1; i--) {
				if(scrollTop <= rewindOffset[i] && motionEnded[i] === true && typeof sortTl[i] === 'object') {
					if(opt.singly === false) {
						sortTl[i].timeScale(2).reverse();
						motionEnded[i] = false;
					} else {
						if(i === LENGTH - 1 || sortTl[i + 1].isActive() === false && queued === false) {
							sortTl[i].timeScale(2).reverse();
							motionEnded[i] = false;
						} else if(i < LENGTH - 1 && sortTl[i + 1].isActive() === true) {
							queued = true;
						}
					}
				}
			}
		};

		this.activate = function() {
            if(active === false) {
                this.setHandler();
                this.handler.scroll();
                active = true;
            }
		};

		this.disable = function() {
			for(var i=0; i<LENGTH; i++) {
				if(typeof sortTl[i] === 'object') sortTl[i].progress(1);
				motionEnded[i] = true;
			}
		};

		this.reset = function() {
			$('[data-' + opt.oElems + ']').each(function(i) {
				motionOffsetElems[i] = $(this);
				motionOffsetElems[i].data({offset: motionOffsetElems[i].offset().top, height: parseFloat(motionOffsetElems[i].css('height'), 10)});
			});
			for(var i=0; i<LENGTH; i++) {
				if(typeof sortTl[i] === 'object') sortTl[i].pause(0);
				motionEnded[i] = false;
				queued = false;
			}
			this.setMotionOffset();
			this.handler.scroll();
		};

		this.initialize();
	};

}(jQuery));

(function($) {
    doc.ready(function() {

        function scrollHandler() {
            var scrollTop = win.scrollTop();
            if(fixed === false && scrollTop >= offset) {
                $topElement.addClass('scroll');
                fixed = true;
            } else if(fixed === true && scrollTop < offset) {
                $topElement.removeClass('scroll');
                fixed = false;
            }
        }

        var $topElement = $('.quick_btns'),
            offset = $('.sub_content').offset().top,
            fixed = false;

        win.scroll(scrollHandler);
        scrollHandler();
    });
}(jQuery));

(function($) {
    doc.ready(function() {

		(function() {
            function scrollHandler() {
                var scrollTop = win.scrollTop(),
                    fixOffset = doc.innerHeight() - win.innerHeight() - $diffElems.height();

                if(scrollTop > fixOffset) $headElems.css({bottom: scrollTop - fixOffset + $headElems.bottom});
                else $headElems.css({bottom: $headElems.bottom});

                if(show === false && scrollTop >= showOffset) {
                    $headElems.addClass('fixed');
                    show = true;
                } else if(show === true && scrollTop < showOffset) {
                    $headElems.removeClass('fixed');
                    show = false;
                }
            }

            var $headElems = $('.quick_btns'),
                $diffElems = $('.footer_wrap');

            $headElems.heigth = parseInt($headElems.css('height'), 10);
            $headElems.bottom = parseInt($headElems.css('bottom'), 10);

            var showOffset = doc.innerHeight() - win.innerHeight() >= 200 ? 200 : 0,
                show = false;

            win.scroll(scrollHandler).load(scrollHandler);
            scrollHandler();
        }());

	});
}(jQuery));

(function($) {
    doc.ready(function() {

        function scrollHandler() {
            var scrollTop = win.scrollTop();
            if(fixed === false && scrollTop >= offset) {
                $topElement.addClass('scroll');
                fixed = true;
            } else if(fixed === true && scrollTop < offset) {
                $topElement.removeClass('scroll');
                fixed = false;
            }
        }

        var $topElement = $('.lnb_wrap'),
            offset = $('.lnb_wrap').offset().top,
            fixed = false;

        win.scroll(scrollHandler);
        scrollHandler();

        // new Tabbing($('.store_tab'),$('.store_conts'));
        // new Tabbing($('.ctgr_tab'),$('.view_conts'));
        new Tabbing($('.menu_tab'),$('.menu_conts'));

        new Swiper('.bg_slide .swiper-container',{
            navigation: {
                nextEl: '.view_btns.view_next',
                prevEl: '.view_btns.view_prev',
            },
            pagination: {
                el: '.bg_paging',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<li class="' + className + '"><a href="#none"></a></li>';
                },
            },
            effect: 'fade',
            fadeEffect: {
            	crossFade: true
            },
            speed: 1000,
                autoplay: {
                delay: 5000,
            },
            allowTouchMove: false,
        });

        (function() {
            $(".view_banner").addClass("active");
            var scd = false;
            $('#wrap').on('scroll touchmove mousewheel', function(e) {
                if(!scd){
                    e.preventDefault();
                    e.stopPropagation();
                    scd	= true;
                    var winheight = sub_winh();
                    var pers = parseInt( winheight, 10 ) * 70 / 100;
                    $(".view_banner").css({"height":pers+"px"})
                    $(".view_banner").removeClass("active");
                    $(".view_banner").addClass("scroll_active");
                    return false;
                }
            });

            sub_height_chk = function(){
                var winheight = sub_winh();
                $('.view_banner').css({'height':winheight});
            }
            var sub_winh = function(){
                var testdom	= document.createElement('div');
                testdom.style.position = 'absolute';
                testdom.style.width = '1px';
                testdom.style.left = '0px';
                testdom.style.top = '0px';
                testdom.style.bottom = '0px';
                document.body.appendChild(testdom);
                var winheight = testdom.offsetHeight;
                testdom.parentNode.removeChild(testdom);
                return winheight;
            }
            // sub_height_chk();

            if(typeof SKIP_SUB_INTRO !== 'undefined' && SKIP_SUB_INTRO){
                // $('#wrap').trigger('scroll');
				$('html, body').scrollTop($('.ctgr_wrap').offset().top);
            }else{
                sub_height_chk();
            }
        }());
    });
}(jQuery));
