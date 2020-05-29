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
            offset = $('.neulbom').offset().top,
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

                if(scrollTop > fixOffset) {$headElems.css({bottom: scrollTop - fixOffset + $headElems.bottom});$headElems.addClass('show');}
                else {$headElems.css({bottom: $headElems.bottom});$headElems.removeClass('show');}

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

            win.on('scroll.scrollHandler_b', scrollHandler).load(scrollHandler);
            scrollHandler();
        }());
		// var qbBot = $('.quick_btns').css('bottom');
		// if(qbBot == '175px'){
		// 	$('.quick_btns').hide();
		// };

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

        var $topElement = $('.header'),
            offset = $('.main_visual').offset().top,
            fixed = false;


        win.scroll(scrollHandler);
        scrollHandler();

        new Swiper($('.pc_visual .swiper-container'),{
            loop: true,
            speed: 500,
                autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.mv_btns.mv_next',
                prevEl: '.mv_btns.mv_prev',
            },
            pagination: {
            	el: '.pc_visual .mv_paging',
            	type: 'bullets',
            	clickable: true,
            	renderBullet: function(index, className){
            		return '<li class="' + className + '"><a href="#none"></a></li>';
            	}
            },
        });

        new Swiper($('.mobile_visual .swiper-container'),{
            loop:true,
            speed: 500,
                autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.mv_btns.mv_next',
                prevEl: '.mv_btns.mv_prev',
            },
            pagination: {
            	el: '.mobile_visual .mv_paging',
            	type: 'bullets',
            	clickable: true,
            	renderBullet: function(index, className){
            		return '<li class="' + className + '"><a href="#none"></a></li>';
            	}
            },
        });
        new Swiper($('.sns_slide.swiper-container'),{
            slidesPerView: 'auto',
            loop: true,
            speed: 300,
                autoplay: {
                delay: 2000,
            },
        });
    });

    (function() {

        // $('.m_iconset').stop().fadeIn(300);

        $('body').on('click', '.iconset_cls', function(e) {
            $('.m_iconset').stop().fadeOut(300);
            e.preventDefault();
        });
    }());
}(jQuery));
